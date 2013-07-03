<?php
class Grid {
	// 处理表名
	public $tableName;
	// 查询SQL
	public $selectSql;
	// 主键名称
	public $idField;
	// 使用session更新的域列表
	public $sessionFields=array();
	// 各域对应名称
	public $fieldTitles;
	// 浏览显示域列表
	public $showFields=array();
	// 新增相关域列表
	public $insertFields=array();
	// 更新相关域列表
	public $updateFields=array();
	// 只读域列表
	public $readonlyFields=array();
	// 非空域列表
	public $notNullFields=array();
	// 排列域方式列表
	public $sortFields=array();
	// 数值类型域列表
	public $numberFields=array();
	// 日期类型域列表
	public $dateFields=array();
	// 列表类型域对应显示值列表
	public $listFields=array();
	// textarea显示类型域列表
	public $areaFields=array();
	// 外键类型域列表
	public $refFields=array();
	// 密码类型域列表
	public $pwdFields=array();
	// 多选类型域列表
	public $multiChoiceFields=array();
	// Rich Text类型域列表
	public $richFields=array();
	// 图片类型域列表
	public $imageFields=array();
	// 固定值类型域列表
	public $fixedFields=array();
	// 转换类型域列表
	public $formatFields=array();
	// 默认每页行数
	public $defaultLinePerPage=10;
	// 可选的每页行数
	public $availableLines=array(3,10,20,50,100);
	// 需要显示的操作
	public $showActions=array('view','add','modify','delete');
	// 额外的操作，使用链接
	public $extraActions=array();
	// CHAR域的最大长度，自动从数据库中查询
	private $fieldLens=array();
	// 是否可以搜索
	public $canSearch=true;
	// 当无历史表时，设为array()，默认历史表：h_xxx
	public $historyPrefix=array();
	/**
	 * the interface to show grid
	 *
	 */
	function show() {
		$this->echoHeader();
		if (!isset($this->selectSql)) {
			$this->selectSql="select * from ".$this->tableName;
		}
		if ($this->sortFields==array()) {
			$this->sortFields=array($this->idField=>'desc');
		}
		$this->numberFields=array_merge($this->numberFields,array($this->idField));
		global $db;
		$fieldInfos=$db->tableInfo($this->tableName);
		if ($this->notNullFields==array()) {
			foreach($fieldInfos as $fieldInfo) {
				$flags=$fieldInfo['flags'];
//				debug($fieldInfo);
//				debug(strpos($flags,'primary_key')===false&&strpos($flags,'timestamp')===false);
				if (strpos($flags,'primary_key')===false&&strpos($flags,'timestamp')===false) {
					$field=$fieldInfo['name'];
					if (!(strpos($flags,'not_null')===false)) {
						$this->notNullFields=array_merge($this->notNullFields,array($field));
					}
				}
			}
		}
//		debug($this->notNullFields);
		foreach($fieldInfos as $fieldInfo) {
//			debug($fieldInfo);
			$field=$fieldInfo['name'];
			$fieldType=$fieldInfo['type'];
			if ($fieldType=='string') {
				$this->fieldLens[$field]=$fieldInfo['len']/3;
			} else if ($fieldType=='date' || $fieldType=='datetime' ) {
				$this->dateFields=array_merge($this->dateFields,array($field));
			}
		}
		$do=isset($_GET["do"])?$_GET['do']:'show';
		if ($do=='add') {
			$this->add();
		} else if ($do=='append') {
			$this->append();
		} else if ($do=='delete') {
			$this->delete();
		} else if ($do=='view') {
			$this->view();
		} else if ($do=='modify') {
			$this->modify();
		} else if ($do=='update') {
			$this->update();
		} else {
			$this->search();
		}
	}
	/**
	 * echo all the js script necessary
	 */
	private function echoHeader() {
?>
<link rel="stylesheet" href="/css/grid.css" type="text/css" media="screen" title="Flora (Default)">
<link rel="stylesheet" href="/css/jquery-calendar.css" type="text/css" media="screen" title="Flora (Default)">
<script type="text/javascript" src="/js/jquery.js"></script>
<script type="text/javascript" src="/js/jquery-calendar.js"></script>
<script type="text/javascript" src="/js/jquery-calendar-zh-cn.js"></script>
<script type="text/javascript" src="/admin/fckeditor/fckeditor.js"></script>
<script type="text/javascript" src="/js/grid.js"></script>
<?php
	}
	/**
	 * check id in GET data and return
	 */
	private function getId() {
		if (!isset($_GET[$this->idField])) {
			echo<<<EOT
			<script type="text/javascript">
				alert('没有id值。');
			</script>EOT;
EOT;
			die;
		}
		$id=$_GET[$this->idField];
		return $id;
	}
	/**
	 * show search page 
	 */
	private function search() {
		// check lines per page and current page in POST data
		$linePerPage=isset($_POST["linePerPage"])?$_POST['linePerPage']:$this->defaultLinePerPage;
		if(!ereg("^[0-9]+$",$linePerPage)){
			$linePerPage=$this->defaultLinePerPage;
		}
		$currPage=isset($_POST["currPage"])?$_POST['currPage']:1;
		if(!ereg("^[0-9]+$",$currPage)){
			$currPage=1;
		}
//		debug($linePerPage);
		foreach($_GET as $key=>$value) {
			if (array_key_exists($key, $this->refFields)) {
				$_POST[$key]=$value;
			}
		}
//		debug($_POST);
		global $db;
//		debug($this->selectSql);
		// 添加where为了方便处理SQL
		$showSql='select * from ('.$this->selectSql.') as rawdata where 1=1';
		foreach($this->showFields as $fieldName) {
			if (in_array($fieldName, $this->dateFields)) {
				// 添加搜索日期类型域的SQL，带引号，多值搜索
				$fromValue = isset($_POST[$fieldName.'_from'])?$_POST[$fieldName.'_from']:'';
				$toValue = isset($_POST[$fieldName.'_to'])?$_POST[$fieldName.'_to']:'';
				if ($fromValue!='') {
					$showSql.= ' and '.$fieldName.'>="'.$fromValue.'"';
				}
				if ($toValue!='') {
					$showSql.= ' and '.$fieldName.'<="'.$toValue.'"';
				}
			} else if (in_array($fieldName, $this->numberFields)) {
				// 添加搜索数字类型域的SQL，不带引号，多值搜索
				$fromValue = isset($_POST[$fieldName.'_from'])?$_POST[$fieldName.'_from']:'';
				$toValue = isset($_POST[$fieldName.'_to'])?$_POST[$fieldName.'_to']:'';
				if ($fromValue!='') {
					$showSql.= ' and '.$fieldName.'>='.$fromValue;
				}
				if ($toValue!='') {
					$showSql.= ' and '.$fieldName.'<='.$toValue;
				}
			} else if (array_key_exists($fieldName, $this->listFields)||array_key_exists($fieldName, $this->refFields)) {
				// 添加搜索列表或外键类型域的SQL，form值为逗号分割，多值搜索
//				debug($_POST);
//				debug($fieldName);
				if (isset($_GET[$fieldName])) {
					$_POST[$fieldName]=array($_GET[$fieldName]);
				}
				if (!isset($_POST[$fieldName]) ) {
					$_POST[$fieldName]=array();
				} 
//				debug($_POST[$fieldName]);
				if ($_POST[$fieldName]!=array()) {
					$showSql.= ' and '.$fieldName.' in ('.implode(',',$_POST[$fieldName]).')';
				}
			} else if (array_key_exists($fieldName, $this->multiChoiceFields)) {
				// 处理多选域
				if (!isset($_POST[$fieldName])) {
					$_POST[$fieldName]=array();
				} else {
					if ($_POST[$fieldName]!=array()) {
						$showSql.=' and (';
						foreach($_POST[$fieldName] as $value) {
							$showSql.=$fieldName.' like "%,'.$value.',%" or '; 
						}
						$showSql=substr($showSql,0,-3);
						$showSql.=')';
					}
				}
			} else  {
				// 添加搜索其他类型域的SQL，模糊搜索
				if (!isset($_POST[$fieldName])) {
					$_POST[$fieldName]='';
				}
				$_POST[$fieldName]=trim($_POST[$fieldName]);
				if ($_POST[$fieldName]!='') {
					$showSql.=' and '.$fieldName.' like "%'.$_POST[$fieldName].'%"';
				}
			}
		}
		// 处理排序部分的SQL
		$sortIndex=0;
		//		debug($this->sortFields);
		foreach($this->sortFields as $fieldName => $fieldOrder) {
			if ($sortIndex==0) {
				$showSql.=' order by';
			} else {
				$showSql.=',';
			}
			$sortIndex++;
			$showSql.=" $fieldName $fieldOrder";
		}
		// 处理分页SQL
		$countSql="select count(*) from ($showSql) as counter";
		error($totalLines=$db->getOne($countSql));
		$totalPages = (intval($totalLines/$linePerPage)+1);
		if ($currPage<1) {
			$currPage=1;
		}
		if ($currPage>$totalPages) {
			$currPage=$totalPages;
		}
		$from=($currPage-1)*$linePerPage;
		$showSql.=" limit $from,$linePerPage";
//		debug($from);
//		debug($showSql);
		error($rs=$db->getAll($showSql,null,DB_FETCHMODE_ASSOC ));
		//		debug($rs);
		//		debug($this->showFields);
		echo '<form method="post">';
		echo '<table class="grid"><tr>';
		// 输出新建记录链接
		echo '<th>';
		if (in_array('add',$this->showActions)) {
			echo '<a href="?do=add"><nobr>新建记录</nobr></a>';
		} else {
			echo '&nbsp;';
		}
		echo '</th>';
		$refMaps=array();
		// 输出各域的标题
		foreach($this->showFields as $fieldName) {
			echo "<th><nobr>".$this->getFieldTitle($fieldName)."</nobr></th>";
			if (array_key_exists($fieldName, $this->refFields)) {
				error($ref=$db->getAssoc($this->refFields[$fieldName]));
//				debug($ref);
				$refMaps[$fieldName]=$ref;
//				debug($refMaps);
			}
		}
		echo '</tr>';
		// 输出各行数据
		foreach($rs as $row) {
			// 输出删除和显示链接
			echo '<tr><td>';
			if (in_array('view',$this->showActions)) {
				echo '<a href="?do=view&'.$this->idField.'='.$row[$this->idField].'"><nobr>显示记录</nobr></a><br />';
			}
			if (in_array('modify',$this->showActions)) {
				echo '<a href="?do=modify&'.$this->idField.'='.$row[$this->idField].'"><nobr>修改记录</nobr></a><br />';
			}
			if (in_array('delete',$this->showActions)) {
				echo '<a href="javascript:if (confirm(\'您确定要删除么？\')) window.location=\'?do=delete&'.$this->idField.'='.$row[$this->idField].'\';"><nobr>删除记录</nobr></a><br />';
			}
			foreach($this->extraActions as $eaUrl=>$eaTitle) {
				echo '<a href="'.$eaUrl.'?'.$this->idField.'='.$row[$this->idField].'"><nobr>'.$eaTitle.'</nobr></a><br />';
			}
			echo '</td>';
			// 输出各行内容
			foreach($this->showFields as $fieldName) {
				echo "<td>";
				if (array_key_exists($fieldName, $this->listFields)) {
					// 处理列表类型域
					echo $this->listFields[$fieldName][$row[$fieldName]];
				} else if (array_key_exists($fieldName, $this->multiChoiceFields)) {
					// 处理多选域
					$value=$row[$fieldName];
					if (trim($value)=='') {
						$choices=array();
					} else {
						$choices=explode(',',substr($value,1,-1));
					}
//					debug($this->multiChoiceFields);
					$choiceTitle='';
					$allChoices=$this->multiChoiceFields[$fieldName];
					foreach($choices as $choice) {
						if (isset($allChoices[intval($choice)])) {
							$choiceTitle.=$allChoices[intval($choice)].',';
						}
					}
//					debug($choiceTitle);
					echo substr($choiceTitle,0,-1);
				} else if (array_key_exists($fieldName, $this->refFields)) {
					// 处理外键类型域
					echo $refMaps[$fieldName][$row[$fieldName]];
				} else if (array_key_exists($fieldName, $this->pwdFields)) {
					// 处理密码类型域
					echo '********';
				} else if (array_key_exists($fieldName, $this->imageFields)) {
					// 处理图形类型域
					$value=$row[$fieldName];
					echo $value;
					if (!empty($value)){
						$imageField = $this->imageFields[$fieldName];
						echo '<br><img width="200" src="/upload/'.$imageField['upload'].'/full/'.$value.'">';
					}
				} else if (array_key_exists($fieldName, $this->formatFields)) {
					$format = $this->formatFields[$fieldName];
//					debug($format);
					echo str_replace('{1}',$row[$fieldName],$format);
				} else {
					echo $row[$fieldName];
				}
				echo '</td>';
			}
			echo '</tr>';
		}
		echo '</table>';
		//		debug($totalLines);
		// 显示页数状态和翻页
		echo '当前页：<select name="currPage" onchange="form.submit();">';
		for($i=1;$i<=$totalPages;$i++) {
			echo '<option';
			if ($currPage==$i) {
				echo ' selected';
			}
			echo '>'.$i.'</option>';
		}
		echo '</select>';
		echo ' 总页数：'.$totalPages.' 总记录数：'.$totalLines;
		echo ' 每页显示：<select name="linePerPage" onchange="form.submit();">';
		foreach($this->availableLines as $length) {
			echo '<option';
			if ($length==$linePerPage) {
				echo ' selected';
			}
			echo '>'.$length.'</option>';
		}
		echo '</select>';
		if (!$this->canSearch) { 
			return;
		}
		// 输出搜索表格
		echo '<table class="grid"><tr><th><nobr>域名</nobr></th><th><nobr>查询值</nobr></th></tr>';
		foreach($this->showFields as $fieldName) {
			if (array_key_exists($fieldName,$this->fixedFields)) {
				continue;
			}
			if (!array_key_exists($fieldName, $this->pwdFields)) {
				//处理非密码类型域
				echo '<tr><td><nobr>'.$this->getFieldTitle($fieldName).'</nobr></td><td>';
			}
			if (array_key_exists($fieldName, $this->listFields)) {
				// 处理列表类型域
				foreach($this->listFields[$fieldName] as $key=>$value) {
					echo '<div class="choice"><nobr><input id="'.$fieldName.'_'.$key.'" type="checkbox" name="'.$fieldName.'[]" value="'.$key.'"';
					if (array_key_exists($fieldName,$_POST)&&in_array($key, $_POST[$fieldName])) {
						echo ' checked';
					}
					echo '>';
					echo '<label for="'.$fieldName.'_'.$key.'">'.$value.'</label></nobr> </div>';
				}
			} else if (array_key_exists($fieldName, $this->refFields)) {
				// 处理外键类型域
				foreach($refMaps[$fieldName] as $key=>$value) {
					echo '<div class="choice"><input id="'.$fieldName.'_'.$key.'" type="checkbox" name="'.$fieldName.'[]" value="'.$key.'"';
					if (array_key_exists($fieldName,$_POST)&&in_array($key, $_POST[$fieldName])) {
						echo ' checked';
					}
					echo '>';
					echo '<label for="'.$fieldName.'_'.$key.'">'.$value.'</label> </div>';
				}
			} else if (in_array($fieldName, $this->dateFields)) {
				// 处理日期类型域
				$fromValue = isset($_POST[$fieldName.'_from'])?$_POST[$fieldName.'_from']:'';
				$toValue = isset($_POST[$fieldName.'_to'])?$_POST[$fieldName.'_to']:'';
				echo '从<input name="'.$fieldName.'_from" value="'.$fromValue.'" readonly class="inputdate">';
				echo '到<input name="'.$fieldName.'_to" value="'.$toValue.'" readonly class="inputdate">';
			} else if (in_array($fieldName, $this->numberFields)) {
				// 处理数值类型域
				$fromValue = isset($_POST[$fieldName.'_from'])?$_POST[$fieldName.'_from']:'';
				$toValue = isset($_POST[$fieldName.'_to'])?$_POST[$fieldName.'_to']:'';
				echo '从<input name="'.$fieldName.'_from" value="'.$fromValue.'">';
				echo '到<input name="'.$fieldName.'_to" value="'.$toValue.'">';
			} else if (array_key_exists($fieldName, $this->multiChoiceFields)) {
				// 处理多选类型域
				$choices=$_POST[$fieldName];
				foreach($this->multiChoiceFields[$fieldName] as $key=>$value) {
					echo '<div class="choice"><input id="'.$fieldName.'_'.$key.'" type="checkbox" name="'.$fieldName.'[]" value="'.$key.'"';
					if (in_array($key, $choices)) {
						echo ' checked';
					}
					echo '>';
					echo '<label for="'.$fieldName.'_'.$key.'">'.$value.'</label> </div>';
				}
			} else if (array_key_exists($fieldName, $this->pwdFields)) {
				//处理密码类型域
			} else {
				echo '<input name="'.$fieldName.'" value="'.$_POST[$fieldName].'">';
			}
			echo '</td></tr>';
		}
		echo '</table><input type="submit" value="查询"></form>';
		//		debug($this->listFields);
	}
	/**
	* show input fields for new record 
	*/
	private function add() {
		$this->verifyAction('add');
		echo '<a href="?do=show">返回</a>';
		global $db;
		echo '<form method="post" action="?do=append" enctype="multipart/form-data" onsubmit="return checkForm(this);"><table class="grid"><tr><th><nobr>域名</nobr></th><th><nobr>域值</nobr></th></tr>';
		//		debug($this->insertFields);
		//		debug($this->areaFields);
		error($nextId=$db->nextId($this->tableName));
		echo '<tr><td>'.$this->getFieldTitle($this->idField).'</td><td><input name="'.$this->idField.'" value="'.$nextId.'" readonly></td></tr>';
		foreach($this->insertFields as $fieldName) {
			echo '<tr><td><nobr>'.$this->getFieldTitle($fieldName);
			if (in_array($fieldName,$this->notNullFields)) {
				echo '<span style="color:red">*</span>';
			}
			echo '</nobr></td><td>';
			if (in_array($fieldName, $this->richFields)) {
				// 处理富文本类型域，使用FCKEditor
				echo '<textarea name="'.$fieldName.'"></textarea>';
				echo<<<EOT
					<script type="text/javascript">
						$(document).ready(function () {
							var oFCKeditor = new FCKeditor("$fieldName");
							oFCKeditor.BasePath = "/admin/fckeditor/";
							oFCKeditor.ToolbarSet = 'Simple';
							oFCKeditor.Height = "330";
							oFCKeditor.ReplaceTextarea();
						})
					</script>
					
EOT;
			} else if (in_array($fieldName, $this->areaFields)) {
				// 处理area类型域，使用textarea
				echo '<textarea name="'.$fieldName.'"></textarea>';
			} else if (array_key_exists($fieldName, $this->listFields)) {
				// 处理列表类型域
				echo '<select name="'.$fieldName.'">';
				echo '<option value="">请选择</option>';
				foreach ($this->listFields[$fieldName] as $key=>$value) {
					echo '<option value="'.$key.'">'.$this->listFields[$fieldName][$key].'</option>';
				}
				echo '</select>';
			} else if (array_key_exists($fieldName, $this->refFields)) {
				// 处理外键类型域
				error($rs=$db->getAssoc($this->refFields[$fieldName]));
//				debug($rs);
				echo '<select name="'.$fieldName.'">';
				echo '<option value="">请选择</option>';
				foreach($rs as $key=>$value) {
					echo '<option value="'.$key.'">'.$value.'</option>';
				}
				echo '</select>';
			} else if (array_key_exists($fieldName, $this->multiChoiceFields)) {
				// 处理多选域
				foreach($this->multiChoiceFields[$fieldName] as $key=>$value) {
					echo '<input id="'.$fieldName.'_'.$key.'" type="checkbox" name="'.$fieldName.'[]" value="'.$key.'">';
					echo '<label for="'.$fieldName.'_'.$key.'">'.$value.'</label> ';
				}
			} else if (array_key_exists($fieldName, $this->imageFields)) {
				// 处理图形类型域和缩放图形类型域
				echo '<input name="'.$fieldName.'" type="file" size="62">';
			} else if (array_key_exists($fieldName, $this->pwdFields)) {
				// 处理密码域
				echo '密&nbsp;&nbsp;&nbsp;&nbsp;码:<input name="'.$fieldName.'" type="password"><br />';
				echo '重复密码:<input name="'.$fieldName.'_repeat" type="password">';
			} else {
				echo '<input name="'.$fieldName.'"';
				if (array_key_exists($fieldName,$this->fieldLens)) {
					echo 'maxlength='.$this->fieldLens[$fieldName];
				}
				if (in_array($fieldName, $this->dateFields)) {
					echo ' readonly class="inputdate"';
				}
				echo '>';
			}
			echo '</tr>';
		}
		echo '</table>';
		echo '<input type="submit" value="插入新记录" name="submit"></form>';
		$this->echoValidateJs($this->insertFields);
	}
	/**
	* insert the new record to database
	*/
	private function append() {
		$this->verifyAction('add');
		global $db;
//		debug($_POST);
		$this->uploadFiles();
//		$allData = $_POST;
		$allData[$this->idField]=$_POST[$this->idField];
		foreach($this->insertFields as $fieldName) {
			if (array_key_exists($fieldName,$this->multiChoiceFields)) {
				if (array_key_exists($fieldName,$_POST)) {
					$allData[$fieldName]=','.implode(',',$_POST[$fieldName]).',';
				} else {
					$allData[$fieldName]='';
				}
			} else if (array_key_exists($fieldName,$this->pwdFields)) {
				$pwdFunc=$this->pwdFields[$fieldName];
				$allData[$fieldName]=$pwdFunc($_POST[$fieldName]);
			} else {
				if (array_key_exists($fieldName,$_POST)) {
					$allData[$fieldName]=$_POST[$fieldName];
				}
			}
		}
		// 添加session域值
		foreach($this->sessionFields as $sessionField=>$sessionId) {
			$allData[$sessionField]=$_SESSION[$sessionId];
		}
		// 添加固定值域值
		foreach($this->fixedFields as $fixedField=>$value) {
			$allData[$fixedField]=$value;
		}
		//		debug($allData);
		error($db->autoExecute($this->tableName, $allData,DB_AUTOQUERY_INSERT));
		echo '新增记录成功。<br>';
		$id=$_POST[$this->idField];
		$_GET[$this->idField]=$id;
		$this->saveHistory('insert');
		echo '<a href="?do=view&'.$this->idField.'='.$id.'">显示</a> ';
		echo '<a href="?do=show">返回</a> ';
		echo '<a href="?do=add">继续添加</a>';
	}
	/**
	* delete the record according to record id
	*/
	private function delete() {
		$this->verifyAction('delete');
		$this->saveHistory('delete');
		$id=$this->getId();
		global $db;
		$deleteSql="delete from ".$this->tableName." where ".$this->idField."=?";
//		debug($deleteSql);
		error($db->query($deleteSql, array($id)));
		echo "<script>alert('删除成功。');window.location='?do=show';</script>";
	}
	/**
	* view the record according to record id
	*/
	private function view() {
		$id=$this->getId();
		global $db;
		$viewSql='select * from '.$this->tableName.' where '.$this->idField.' = ?';
		//		debug($viewSql);
		error($row = $db->getRow($viewSql,array($id),DB_FETCHMODE_ASSOC));
		//		debug($row);
		echo '<a href="?do=show">返回</a> ';
		if (in_array('modify',$this->showActions)) {
			echo '<a href="?do=modify&'.$this->idField.'='.$id.'">修改</a> ';
		}
		if (in_array('delete',$this->showActions)) {
			echo '<a href="javascript:if (confirm(\'您确定要删除么？\')) window.location=\'?do=delete&'.$this->idField.'='.$row[$this->idField].'\';">删除</a> ';
		}
		echo '<form><table class="grid"><tr><th><nobr>域名</nobr></th><th><nobr>域值</nobr></th></tr>';
		//			debug($this->insertFields);
		//		debug($this->areaFields);
		foreach($this->updateFields as $fieldName) {
			echo '<tr><td>'.$this->getFieldTitle($fieldName).'</td><td>';
			if (in_array($fieldName, $this->richFields)) {
				// 处理富文本类型域，使用FCKEditor，因为global.php中decode，需要decode
				echo htmlspecialchars_decode($row[$fieldName]);
			} else if (in_array($fieldName, $this->areaFields)) {
				// 处理textarea类型域
				echo $row[$fieldName];
			} else if (array_key_exists($fieldName, $this->listFields)) {
				// 处理列表类型域
				echo $this->listFields[$fieldName][$row[$fieldName]];
			} else if (array_key_exists($fieldName, $this->refFields)) {
				// 处理外键类型域
				error($refs=$db->getAssoc($this->refFields[$fieldName]));
				echo $refs[$row[$fieldName]];
			} else if (array_key_exists($fieldName, $this->multiChoiceFields)) {
				// 处理多选类型域
				$value=$row[$fieldName];
				if (trim($value)=='') {
					$choices=array();
				} else {
					$choices=explode(',',substr($value,1,-1));
				}
				$choiceTitle='';
				foreach($choices as $choice) {
					$choiceTitle.=$this->multiChoiceFields[$fieldName][intval($choice)].',';
				}
				echo substr($choiceTitle,0,-1);
			} else if (array_key_exists($fieldName, $this->pwdFields)) {
				// 处理密码域
				echo '********';
			} else if (array_key_exists($fieldName, $this->imageFields)) {
				// 处理图形类型域
				$value=$row[$fieldName];
				if (!empty($value)){
					$imageField = $this->imageFields[$fieldName];
					echo '<img src="/upload/'.$imageField['upload'].'/full/'.$value.'">';
				}
			} else {
				echo $row[$fieldName];
			}
			echo '</td></tr>';
		}
		echo '</table>';
	}
	/**
	* input new values for existing record according to record id
	*/
	private function modify() {
		$this->verifyAction('modify');
		$id=$this->getId();
		global $db;
		$viewSql='select * from '.$this->tableName.' where '.$this->idField.' = ?';
		error($row = $db->getRow($viewSql,array($id),DB_FETCHMODE_ASSOC));
//				debug($row);
		echo '<a href="?do=show">返回</a> ';
		echo '<a href="?do=view&'.$this->idField.'='.$id.'">取消</a>';
		echo '<form method="post" enctype="multipart/form-data" action="?do=update&'.$this->idField.'='.$id.'" onsubmit="return checkForm(this);"><table class="grid"><tr><th><nobr>域名</nobr></th><th><nobr>域值</nobr></th></tr>';
		//		debug($this->insertFields);
		//		debug($this->areaFields);
		echo '<tr><td>'.$this->getFieldTitle($this->idField).'</td><td>'.$id.'</td></tr>';
		foreach($this->updateFields as $fieldName) {
			if ($fieldName==$this->idField) {
				continue;
			}
			echo '<tr><td><nobr>'.$this->getFieldTitle($fieldName);
			if (in_array($fieldName,$this->notNullFields)&&(!array_key_exists($fieldName,$this->imageFields))) {
				echo '<span style="color:red">*</span></nobr>';
			}
			echo '</td><td>';
			if (in_array($fieldName, $this->richFields)) {
				// 处理富文本类型域，使用FCKEditor，因为global.php中decode，需要decode
				echo '<textarea name="'.$fieldName.'">'.$row[$fieldName].'</textarea>';
				echo<<<EOT
					<script type="text/javascript">
						$(document).ready(function () {
							var oFCKeditor = new FCKeditor("$fieldName");
							oFCKeditor.ToolbarSet = 'Simple';
							oFCKeditor.BasePath = "/admin/fckeditor/";
							oFCKeditor.Height = "330";
							oFCKeditor.ReplaceTextarea();
						})
					</script>
					
EOT;
			} else if (in_array($fieldName, $this->areaFields)) {
				// 处理textarea类型域
				echo '<textarea name="'.$fieldName.'"';
				if (in_array($fieldName, $this->readonlyFields)) {
					echo ' readonly';
				}
				echo '>'.$row[$fieldName].'</textarea>';
			} else if (array_key_exists($fieldName, $this->listFields)) {
				// 处理列表类型域
				if (in_array($fieldName, $this->readonlyFields)) {
					$listField=$this->listFields[$fieldName];
					echo $listField[$row[$fieldName]];
				} else {
					echo '<select name="'.$fieldName.'">';
					echo '<option value="">请选择</option>';
					foreach ($this->listFields[$fieldName] as $key=>$value) {
						echo '<option value="'.$key.'"';
						if ($key==$row[$fieldName]) {
							echo ' selected';
						}
						echo '>'.$this->listFields[$fieldName][$key].'</option>';
					}
					echo '</select>';
				}
			} else if (array_key_exists($fieldName, $this->refFields)) {
				// 处理外键类型域
				error($refRs=$db->getAssoc($this->refFields[$fieldName]));
				if (in_array($fieldName, $this->readonlyFields)) {
					echo $refRs[$row[$fieldName]];
				} else {
					echo '<select name="'.$fieldName.'">';
					foreach($refRs as $key=>$value) {
						echo '<option value="'.$key.'"';
						if ($key==$row[$fieldName]) {
							echo ' selected';
						}
						echo '>'.$value.'</option>';
					}
					echo '</select>';
				}
			} else if (array_key_exists($fieldName, $this->imageFields)) {
				// 处理图形类型域
				if (!in_array($fieldName, $this->readonlyFields)) {
					echo '<input name="'.$fieldName.'" type="file" size="62">';
				}
				$value=$row[$fieldName];
				if (!empty($value)){
					$imageField = $this->imageFields[$fieldName];
					echo '<br><img src="/upload/'.$imageField['upload'].'/full/'.$value.'">';
				}
			} else if (array_key_exists($fieldName, $this->multiChoiceFields)) {
				// 处理多选域
				$choices=explode(',',$row[$fieldName]);
				foreach($this->multiChoiceFields[$fieldName] as $key=>$value) {
					echo '<input id="'.$fieldName.'_'.$key.'" type="checkbox" name="'.$fieldName.'[]" value="'.$key.'"';
					if (in_array($key, $choices)) {
						echo ' checked';
					}
					echo '>';
					echo '<label for="'.$fieldName.'_'.$key.'">'.$value.'</label> ';
				}
			} else if (array_key_exists($fieldName, $this->pwdFields)) {
				// 处理密码域
				echo '新&nbsp;&nbsp;密&nbsp;&nbsp;码:<input name="'.$fieldName.'" type="password"><br />';
				echo '重复新密码:<input name="'.$fieldName.'_repeat" type="password">';
			} else {
//				debug($row);
				echo '<input name="'.$fieldName.'" value="'.$row[$fieldName].'"';
				if (in_array($fieldName, $this->readonlyFields)) {
					echo ' readonly';
				}
				if (array_key_exists($fieldName,$this->fieldLens)) {
					echo 'maxlength='.$this->fieldLens[$fieldName];
				}
				if (in_array($fieldName, $this->dateFields)) {
					echo ' readonly class="inputdate"';
				}
				echo '>';
			}
			echo '</tr>';
		}
		echo '</table>';
		echo '<input type="submit" value="更新记录" name="submit"></form>';
		echo '</form>';
		$this->echoValidateJs($this->updateFields);
	}
	/**
	* update the record according to record id
	*/
	private function update() {
		$this->verifyAction('modify');
		$this->saveHistory('update');
		$id=$this->getId();
		global $db;
		$this->uploadFiles();
//		debug($_POST);
		foreach($this->updateFields as $field) {
			if (!in_array($field,$this->readonlyFields)) {
				if (isset($_POST[$field])) {
					$allData[$field] = $_POST[$field];
				}
			}
		}
		foreach($this->multiChoiceFields as $fieldName=>$choices) {
			if (isset($_POST[$fieldName])) {
				$allData[$fieldName]=','.implode(',',$_POST[$fieldName]).',';
			} else {
				$allData[$fieldName]='';
			}
		}
		foreach($this->readonlyFields as $fieldName) {
			unset($allData[$fieldName]);
		}
		foreach($this->pwdFields as $fieldName=>$pwdFunc) {
			if (array_key_exists($fieldName,$allData)) {
				unset($allData[$fieldName.'_repeat']);
				$allData[$fieldName]=$pwdFunc($allData[$fieldName]);
			}
		}
		//		foreach($this->sessionFields as $sessionField=>$sessionId) {
//			$allData=array_merge($allData, array($sessionField=>$_SESSION[$sessionId]));
//		}
//		debug($allData);
//		die;
		
		error($db->autoExecute($this->tableName, $allData,DB_AUTOQUERY_UPDATE, $this->idField.'='.$id));
		echo '更新记录成功。<br>';
		echo '<a href="?do=view&'.$this->idField.'='.$id.'">显示</a> ';
		echo '<a href="?do=show">返回</a>';
	}
	// 如存在返回域的标题
	private function getFieldTitle($fieldName) {
		return array_key_exists($fieldName,$this->fieldTitles)?$this->fieldTitles[$fieldName]:$fieldName;
	}
	// 上传并缩放图片
	private function uploadFiles() {
		require_once('HTTP/Upload.php');
		$upload = new HTTP_Upload("en");
		// 处理图片类型域
		if (count($this->imageFields)>0) {
			$files = $upload->getFiles();
			foreach($files as $file){
//					debug($file->upload);
				$fieldName=$file->upload['form_name'];
				if (!array_key_exists($fieldName,$this->imageFields)) continue;
				error($file);
				$file->setValidExtensions(array('jpg', 'png', 'gif', 'JPG', 'PNG', 'GIF'), 'accept');
				if ($file->isValid()) {
					$file->setName("uniq");
					$imageField=$this->imageFields[$fieldName];
					$fullPath = $_SERVER['DOCUMENT_ROOT'].'/upload/'.$imageField['upload'].'/full/';
//					debug($fullPath);
					// 移动到相应路径
					$destName = $file->moveTo($fullPath);
//					debug($destName);
					$fullName=$fullPath.$destName;
					$fileType = exif_imagetype($fullName);
					// 判断并处理不同上传类型
					$ext = $file->getProp("ext");
					if (strcasecmp($ext, 'jpg') == 0) {
//						if ($fileType != IMAGETYPE_JPEG) {
//							echo '<script>alert("您上传的JPG文件不是正确的JPG文件");history.back();</script>';
//							die;
//						}
						$src = imagecreatefromjpeg($fullName);
					} elseif (strcasecmp($ext, 'gif') == 0) {
						if ($fileType != IMAGETYPE_GIF) {
							echo '<script>alert("您上传的GIF文件不是正确的GIF文件");history.back();</script>';
							die;
						}
						$src = imagecreatefromgif($fullName);
					} elseif (strcasecmp($ext, 'png') == 0) {
						if ($fileType != IMAGETYPE_PNG) {
							echo '<script>alert("您上传的PNG文件不是正确的PNG文件");history.back();</script>';
							die;
						}
						$src = imagecreatefrompng($fullName);
					} else {
						echo '<script>alert("我们只支持jpg,gif和png格式的图案文件，您上传的图案文件后缀为'.$ext.'");history.back();</script>';
						die;
					}
					// 取图片宽高
					$rect = getimagesize($fullName);
					$width = $rect[0];
					$height = $rect[1];
					if (array_key_exists('y/x',$imageField)) {
						if ($height/$width!=$imageField['y/x']) {
							echo '<script>alert("您上传的文件宽高比不正确，要求宽高比：'.$imageField['y/x'].'。实际宽：'.$width.'，高：'.$height.'");history.go(-1);</script>';
							die;
						}
					}
					if (array_key_exists('zoom',$imageField)) {
						foreach($imageField['zoom'] as $zoomWidth) {
							if ($width<$zoomWidth) {
								echo '<script>alert("您上传的文件宽不正确，要求宽不小于：'.$zoomWidth.'。实际宽：'.$width.'");history.go(-1);</script>';
								die;
							}
							// 等比例缩放
							$new_w = $zoomWidth;
							$new_h = abs($zoomWidth / $width * $height);
							$smallPath = $_SERVER['DOCUMENT_ROOT'].'/upload/'.$imageField['upload'].'/'.$zoomWidth.'/';
							// 按新图片大小生成
							$img = imagecreatetruecolor($new_w, $new_h);
							imagecopyresampled($img, $src, 0, 0, 0, 0, $new_w, $new_h, $width, $height);
							$smallName = $smallPath. $destName;
							// 生成不同类型预览图
							if ($fileType == IMAGETYPE_JPEG) {
								imagejpeg($img,  $smallName);
							} elseif ($fileType == IMAGETYPE_GIF) {
								imagegif($img,  $smallName);
							} elseif ($fileType == IMAGETYPE_PNG) {
								imagepng($img,  $smallName);
							}
						}
					}
					$_POST[$fieldName]=$destName;
				} 
			}
		
		}
	}
	
	// 保存历史记录，用于historyPrefix不为NULL
	private function saveHistory($action) {
		global $db;
		$id=$this->getId();
		if (count($this->historyPrefix)!=0) {
			foreach($this->historyPrefix as $hPrefix=>$hComment) {
				$sql = 'select * from '.$this->tableName.' where '.$this->idField.'=?';
				error($oldRow=$db->getRow($sql,array($id),DB_FETCHMODE_ASSOC));
				$oldRow=array_merge($oldRow,array($hComment=>'user:'.$_SESSION['id'].',action:'.$action));
		//		debug($oldRow);
				error($db->autoExecute($hPrefix.substr($this->tableName,1), $oldRow,DB_AUTOQUERY_INSERT));
			}
		}
	}
	// 输出验证用JS
	private function echoValidateJs($fields) {
?>
<script type="text/javascript">
<!--
function checkForm(form) {
<?php
		// 输出非空域判断的JS
		foreach($this->notNullFields as $fieldName) {
			if (in_array($fieldName,$fields)) {
				if (!in_array($fieldName,$this->richFields) && !array_key_exists($fieldName,$this->multiChoiceFields)) {
					echo 'if ($.trim(form.'.$fieldName.'.value)=="") {alert("'.$this->getFieldTitle($fieldName).'域不能为空。");form.'.$fieldName.'.focus();return false;}'."\n";
				}
			}
		}
		// 输出域长度判断的JS
		foreach($this->fieldLens as $fieldName) {
			if (in_array($fieldName,$fields)) {
				echo 'if (form.'.$fieldName.'.value.length>'.$this->fieldLens[$fieldName].') {alert("'.$this->getFieldTitle($fieldName).'域不能超过'.$this->fieldLens[$fieldName].'个字符。");form.'.$fieldName.'.focus();return false;}'."\n";;
			}
		}
		// 输出密码域判断的JS
		foreach($this->pwdFields as $fieldName=>$func) {
			if (in_array($fieldName,$fields)) {
				echo 'if ($.trim(form.'.$fieldName.'_repeat.value)=="") {alert("重复输入'.$this->getFieldTitle($fieldName).'域不能为空。");form.'.$fieldName.'_repeat.focus();return false;}'."\n";
				echo 'if ($.trim(form.'.$fieldName.'.value)!=$.trim(form.'.$fieldName.'_repeat.value)) {alert("重复输入'.$this->getFieldTitle($fieldName).'域不相同。");form.'.$fieldName.'.focus();return false;}'."\n";
			}
		}
?>
	form.submit.disabled=true;
}
-->
</script>
<?php
	}

	private function verifyAction($action) {
		if (!in_array($action, $this->showActions)) {
			echo "<script>window.location='/errors/contact.php';</script>";
		}
	}
}

?>