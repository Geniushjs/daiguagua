<?php
require_once("inc/common.php");

function echoEmpty($height)
{
	echo "<table border='0' cellpadding='0' cellspacing='0'><tr><td height='".$height."'></td></tr></table>";
}

function echoHeader()
{
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>呆瓜软件分享站</title>
<link href="./css/style.css" rel="stylesheet" type="text/css" />

<style type="text/css">
<!--
.bar1 {
	background-image: url(images/index/bar1_bg.gif);
	background-repeat: no-repeat;
	background-position: center;
    height: 78px;
}
.bar2 {
	background-image: url(images/index/bar2_bg.gif);
	background-repeat: no-repeat;
	background-position: center;
    height: 78px;
}
.bar3 {
	background-image: url(images/index/bar3_bg.gif);
	background-repeat: no-repeat;
	background-position: center;
    height: 78px;
}
.bar4 {
	background-image: url(images/index/bar4_bg.gif);
	background-repeat: no-repeat;
	background-position: center;
    height: 78px;
}
.bar_blue{
	background-image: url(images/index/bar_blue_bg.gif);
	background-repeat: no-repeat;
	background-position: left;
    height: 78px;
	font-size: 12px;
	font-style: normal;
	line-height: 15px;
	color: #fff;
	font-weight:bold;
	font-family: Arial, Helvetica, sans-serif;
	text-align: left;
}

.login {
	background-image: url(images/index/login_bg.jpg);
	background-position: top;
	width:219;
}
-->
</style>

<script language="javascript">
<!--
	function searchEngine()
	{
		window.open(
			"http://soft.gougou.com/search?search="
			+ document.form.search.value);
	}
	function SubmitCheck()
	{
		if (document.login.username.value=="" ||
			document.login.password.value=="") {
			window.alert("用户名和密码不能为空");
			return false;
		}
  		return true;
	}
	function Register()
	{
		window.location.href
			= "register.php";
	}
-->
</script>
</head>
<body>

<?php
}

function echoLeft() {
	global $db;
	global $TYPE_NAME;
?>
<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="f9f9f9">
	<tr>
	<td width="3" background="images/index/lefeSide_bg_left.gif"></td>
	<td>
	<table width="200" border="0" cellpadding="0" cellspacing="0">
		<tr>
			<td height=262>
				<a href=".">
					<img src = "images/index/button_home.gif" border="0"/>
				</a>
			</td>
			<td height=262>
				<a href="index.php?do=class">
					<img src = "images/index/button_all.gif" border="0"/>
				</a>
			</td>
		</tr>
	</table>
	
	<table width="200" border="0" cellpadding="0" cellspacing="0">
	<tr>
	<td valign="top">
	<?php
		for ($typeIndex = 0; $typeIndex < TYPE_NUMBERS; $typeIndex++)
		{
	?>
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td class="bar<?php echo $typeIndex+1;?>" align="center">
					<span class="fontwrite">
						<?php //echo $TYPE_NAME[$typeIndex] ?>
					</span>
				</td>
			</tr>
			
			<tr>
				<td align="center">
					<table width="90%" border="0" cellspacing="0" cellpadding="0" align="center">
					<tr>
					<?php
					$sql = "select * from class where type=? order by sortorder limit 20";
					error($rows = $db->getAll($sql, array($typeIndex+1), DB_FETCHMODE_OBJECT));
					
					$index = 0;
					foreach($rows as $row)
					{
						$index ++;
					?>
							<td width="15%" height="25" align="center">
								<span class="font12">
									<img src="./images/index_r9_c6.jpg" width="10" height="12" align="absmiddle" />
									<br />
								</span>
							</td>
							<td width="35%" align="left">
								<span class="font12">
									<a href="./index.php?cid=<?php echo $row->cid ?>">
										<?php
											echo mb_strimwidth($row->name, 0, 50, "")
										?>
									</a>
								</span>
							</td>
							
					<?php	
						if ($index%2 == 0)
							echo "</tr><tr>";
					}
					?>
						</tr>
					</table>
				</td>
			</tr>
		</table>
		<?php
		}
		?>
	</td>
	</tr>
	<tr><td height=20></td></tr>
	</table>

	</td>
	<td width="3" background="images/index/lefeSide_bg_right.gif"></td>
</tr>
<tr>
	<td></td>
	<td height="3" background="images/index/lefeSide_bg_bottom.gif"></td></tr>
	<td></td>
</table>
<?php	
}
?>


<?php
function echoHead()
{
?>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
<tr><td valign="top">

	<table width="100%" height="224" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td width="462" background="images/index/topBanner.jpg"></td>
		<td class="login">
			<table width="100%" border="0" cellpadding="0" cellspacing="0">
			<tr>
				<td height="100" class="font12" align="center">
					<table width="100%" border="0" cellpadding="0" cellspacing="0">
						<tr><td align="center" height="80"><font color="white" size="3"><b>呆瓜软件分享站</b></font></td></tr>
						<tr><td align="center"><font color="white">注册用户可在本站分享您喜欢的软件</font></td></tr>
						<tr><td align="center" class="fontgray">
							<b><a href="index.php?do=news"><font color="white">查看更新日志</font></a></b>
						</td></tr>
					</table>
				</td>
			</tr>
			<tr>
				<td align="center" class="font12">
				<?php
				if (!isset($_SESSION['uid'])) {
				?>
				<form name="login" action="admin/check_login.php" method="POST" onSubmit="return SubmitCheck();">
					<font color=white>用户名</font> <input type="text" name="username" size="10" 
						style="
						width: 80px;
						background-image:url(images/index/input_user_bg.gif);
						border-color: #FFFFFF; 
						border-style: solid; 
						border-top-width: 0px;
						border-right-width: 0px; 
						border-bottom-width: 1px;
						border-left-width: 0px" ><br/>
					<font color=white>密　码</font> <input type="password" name="password" size="10"
						style="
						width: 80px;
						background-image:url(images/index/input_password_bg.gif);
						border-color: #FFFFFF; 
						border-style: solid; 
						border-top-width: 0px;
						border-right-width: 0px; 
						border-bottom-width: 1px;
						border-left-width: 0px" ><br/><br/>
					<input type="image" src="images/index/button_login_new.gif"/>　　
					<input type="image" src="images/index/button_reg_new.gif" onClick="Register(); return false;" />
				</form>
				<?php
				}
				else {
				?>
				</br>
				<a href="/admin/index.php"><b><font color="white">进入后台</font></b></a>
				<a href="/admin/logout.php"><b><font color="white">退出登录</font></b></a>
				<?php
				}
				?>
				</td>
			</tr>
			</table>
		</td>
		<td width="34"></td>
	</tr>
	</table>
	
	<table width="100%" border="0" cellpadding="0" cellspacing="0">
		<tr>
			<td height="7"></td>
			<td width="287" height="38" rowspan="2" background="images/index/login_bg_bottom.gif"></td>
		</tr>
		<tr>
			<td align="center" valign="middle">
				<form action="index.php" method="get" name="form">
					<input type="hidden" name="do" value="search">
					<input type="text" name="search" size="20"
						style="background-image:url(images/index/search_bg.gif);
							background-repeat:no-repeat;
							height:21px;
							padding-left:10px;
							padding-right:15px;
							padding-top:7px;
							border:0px"
					/>
					<input type="submit" class="button" value="" align="absmiddle" 
						style="background-image:url(images/index/button_search1.gif);
							background-repeat:no-repeat;
							background-position: center;
							height:28px;
							width:82px;
							border:0px;"
					/>
					<input type="button" class="button" value="" align="absmiddle" onClick="searchEngine()"
						style="background-image:url(images/index/button_search2.gif);
							background-repeat:no-repeat;
							background-position:center;
							height:28px;
							width:82px;
							border:0px;"
					/>
				</form>
			</td>
		</tr>
	</table>
	</td>
	</tr>
</table>
<?php
}
?>


<?php
function ShowInList($rows, $curIndex)
{
?>
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td width="100%" class="bar_blue">
				<?php echo $curIndex ?>
			</td>
		</tr>
	</table>

	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="font12">
		<?php if (count($rows) != 0) { ?>
		<tr class="fontgray">
			<th height="25"></th>
			<th>软件名称</th>
			<th>版本号</th>
			<th>最后更新</th>
			<th>官方主页</th>
			<th>下载地址</th>
			<th>报告死链</th>
		</tr>
		<tr>
			<td colspan=7 height="7" align="left" background="./images/index_30.gif"></td>
		</tr>
		<?php
		} else {
		?>
			<tr class="fontgray">
				<th height=25 align="left">
					抱歉，没有找到您想要的软件，欢迎
					<a href="mailto:hjs2006@163.com">
						<span class="fontwrite"><font color="pink">反馈</font></span>
					</a>
					最新软件信息
				</th> 
			</tr>
		<?php
		}
		?>
		<?php
		$count = count($rows);
		$index = 0;
		foreach ($rows as $row)
		{
			$index ++;
		?>
			<tr align="center" onMouseOver="this.style.background='#F0F0F0'" onmouseout="this.style.background=''">
				<td height=15>
					<img src="./images/soft/<?php echo $row->image ?>" width="15" height="15" border="0" align="absmiddle" />
				</td>
				<td>
					<?php echo $row->name ?>
				</td>
				<td>
					<?php echo $row->version ?>
				</td>
				<td>
					<?php
						$date = explode(" ", $row->updatetime);
						echo $date[0];
					?>
				</td>
				<td>
					<a href="<?php echo $row->pageurl ?>" target="_blank">
						进入
					</a>
				</td>
				<td>
					<a href="<?php if(LINK_TO_PAGE) echo $row->pageurl; else echo $row->url;?>">
						<img src="./images/down.gif" align="absmiddle" border="0" />
					</a>
				</td>
				<td>
					<a href="index.php?do=deadlink&sid=<?php echo $row->sid ?>">
						<span class="fontgray">报告</span>
					</a>
				</td>
			</tr>
			<?php
			if ($index != count($rows))
			{
			?>
			<tr>
				<td colspan=7 height="7" align="left" background="./images/index_30.gif"></td>
			</tr>
<?php		
			}
		}
?>
	</table>
<?php
}
?>


<?php
function ShowInIcon($rows, $curIndex)
{
?>
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td width="100%" class="bar_blue">
				<?php echo $curIndex ?>
			</td>
		</tr>
	</table>
	
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<?php if (count($rows) != 0) { ?>
		<tr class="fontgray">
			<th height=25 align="left">
				迅雷用户，可使用“右键->使用迅雷下载全部链接”一次下载该页面所有软件
			</th>
		</tr>
		<?php
		} else {
		?>
		<tr class="fontgray">
			<th height=25 align="left">
				抱歉，没有找到您想要的软件，欢迎
				<a href="mailto:hjs2006@163.com">
					<span class="fontwrite"><font color="pink">反馈</font></span>
				</a>
				最新软件信息
			</th> 
		</tr>
		<?php
		}
		?>
	</table>
	
	<table width="100%" border="0" cellpadding="0" cellspacing="0">
		<tr><td>
			<table width="100%" border="0" cellpadding="0" cellspacing="0">
				<tr><td height="10"></td></tr>
				<tr>
				<?php
				$col = $index = 0;
				$count = count($rows);
				foreach ($rows as $row)
				{
					$col = $col % ITEMS_IN_ROW +1;
					$index ++;
				?>
				<td width="<?php echo 100/ITEMS_IN_ROW ?>%" align="left" class="font12">
					<table width="100%" align="left" border="0">
						<tr>
							<td width="30">
								<a href="<?php echo $row->pageurl ?>" target="_blank">
								<img src="./images/soft/<?php echo $row->image ?>" width="30" height="30" border="0" align="absmiddle" />
								</a>
							</td>
							<td><font size=-1>
								<?php echo $row->name ?><br/>
								版本: <?php echo $row->version ?><br/>
								<a href="<?php if(LINK_TO_PAGE) echo $row->pageurl; else echo $row->url; ?>">
									<img src="./images/down.gif" align="absmiddle" border="0" />
								</a>
								<a href="index.php?do=deadlink&sid=<?php echo $row->sid ?>">
									<span class="fontgray">报告死链</span>
								</a>
							</font></td>
						</tr>
					</table>
				</td>
				<?php
					if ($index == $count || $col == ITEMS_IN_ROW)
					{
						echo "</tr>";
						if ($index != $count) {
				?>
						<tr>
							<td colspan=<?php echo ITEMS_IN_ROW ?> height="7" align="left" background="./images/index_30.gif">
							</td>
						</tr>
						<tr><td height="10"></td></tr>
				<?php		
						}
						echo "<tr>";
					}
				}
				?>
				</tr>
			</table>
		</td></tr>
	</table>
<?php
}
?>

<?php
function echoMain($class_id=1)
{
	global $db;
	
	if (LINK_TO_PAGE)
		$sql = "
			select soft.sid, name, image, version, pageurl url, pageurl, updatetime
			from soft, label
			where soft.sid=label.sid and cid = ?
			order by sortorder
		";
	else
		$sql = "
			select soft.sid, name, image, version, url, pageurl, updatetime
			from soft, label
			where soft.sid=label.sid and cid = ?
			order by sortorder
		";

	//$sql = "select name from class where cid=?";
	//error($rows = $db->getAll($sql, array(2), DB_FETCHMODE_OBJECT));
	//echo count($rows)."<br>";

	error($rows = $db->getAll($sql, array($class_id), DB_FETCHMODE_OBJECT));
	//echo "Soft Count - ".count($rows)."<br>";
	
	$sql = "select name from class where cid=?";
	error($curIndexRow = $db->getAll($sql, array($class_id), DB_FETCHMODE_OBJECT));
	//echo "Class Count - ".$class_id." : ".count($curIndexRow)."<br>";
	
	$curIndex = "　　　　　".$curIndexRow[0]->name;
	
	if (MAIN_SHOW_TYPE == "list")
		ShowInList($rows, $curIndex);
	else
		ShowInIcon($rows, $curIndex);
}
?>

<?php
function echoSearch($str)
{
	global $db;
	
	$sql = "select * from soft";
	error($arrays = $db->getAll($sql, array(), DB_FETCHMODE_OBJECT));
	
	$rows = array();
	foreach ($arrays as $row)
	{
		if (!like($row->name, $str) && !like($row->version, $str)) continue;
		similary($row->name, $str);
		similary($row->version, $str);
		
		$sql = "select min(sortorder) sortorder from class, label where label.cid=class.cid and label.sid=?";
		error($scores = $db->getAll($sql, array($row->sid), DB_FETCHMODE_OBJECT));
		
		$row->sortorder = $scores[0]->sortorder * 100 + $row->sortorder;
		$rows[] = $row;
	}

	qsort($rows, 0, count($rows)-1);
	
	$curIndex = "　　共找到 <font color=pink>".count($rows)."</font> 个搜索结果";
	
	if (SEARCH_SHOW_TYPE == "list")
		ShowInList($rows, $curIndex);
	else
		ShowInIcon($rows, $curIndex);		
}
?>

<?php
function echoClass()
{
	global $db;
	global $TYPE_NAME;
	
	$curIndex = "　　　　　所有分类";
	$colwidth = 100 / TYPE_ITEMS_IN_ROW;
?>
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td class="bar_blue">
				<?php echo $curIndex ?>
			</td>
		</tr>
	</table>
	
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td align="center" valign="top" class="font12">
			<br/>
			<table width="94%" border="0" cellspacing="0" cellpadding="0">
		<?php
			
		for ($typeIndex = 0; $typeIndex < TYPE_NUMBERS; $typeIndex++)
		{
			$sql = "select cid, name from class where type=? order by sortorder";
			error($rows = $db->getAll($sql, array($typeIndex+1), DB_FETCHMODE_OBJECT));
		?>
			<tr>
				<th colspan=<?php echo TYPE_ITEMS_IN_ROW ?> height="20" align="left">
					<?php echo $TYPE_NAME[$typeIndex] ?>
				</th>
			</tr>
			<tr>
				<td colspan=<?php echo TYPE_ITEMS_IN_ROW ?> height="7" align="left" background="./images/index_30.gif">
				</td>
			</tr>
		<?php
			
			$col = $index = 0;
			$count = count($rows);
			foreach ($rows as $row)
			{
				$col = $col % TYPE_ITEMS_IN_ROW +1;
				$index ++;
				if ($col == 1)
					echo "<tr>";
			?>
				<td width="<?php echo $colwidth ?>%" align="left" class="font12">
					<font size=-1>
						<a href="index.php?cid=<?php echo $row->cid ?>"><?php echo $row->name ?></a>
					</font>
				</td>
			<?php
				if ($index == $count || $col == TYPE_ITEMS_IN_ROW)
					echo "</tr>";
				
				if ($index == $count)
				{
			?>
					<tr>
						<td height="20"></td>
					</tr>
			<?php
				}
			}
		}
?>
			</table>
			</td>
		</tr>
	</table>
<?php
}

function echoNews()
{
?>	
	<table align="left" class="font12">
	<tr><td height="20"></td></tr>
	<tr><td>
	<ul>
		<li>
			2009-10-12 14:21 官方页面在新窗口打开，下载不新开窗口。后台左边栏背景换了。
		</li>
		<li>
			2009-10-5 16:37 增加报告死链的功能
		</li>
		<li>
			2009-10-5 15:19 完成界面更新！
		</li>
		<li>
			2009-8-29 22:52 更改搜索结果显示背景
		</li>
		<li>
			2009-8-29 14:36 完善后台———所属分类可以超链
		</li>
		<li>
			2009-8-29 14:36 更改搜索结果的排序算法，和搜素结果的显示方式
		</li>
		<li>
			2009-8-29 13:30 后天分类管理增加管理哪些软件属于该分类的功能
		</li>
		<li>
			2009-8-28 15:54 后台软件管理增加按各个域排序的功能，按分类筛选的功能
		</li>
		<li>
			2009-8-28 12:04 后台分类按照大类别进行排序，相同的按照小类别的优先级排序，软件按照更新时间进行排序
		</li>
		<li>
			2009-8-28 12:00 数据库去掉recommend属性，将装机必备作为一个分类。新建“概念性分类”的大分类，和娱乐软件，办公软件等小分类
		</li>
		<li>
			2009-8-27 23:40 后台管理增加上传图片功能
		</li>
		<li>
			2009-8-27 17:21 增加“迅雷搜索”按钮。搜索之后仍然保留搜索框内的内容。
		</li>
		<li>
			2009-8-27 12:36 优化左边栏代码，更改“更多”链接为所有分类，去掉装机必备和所有分类的链接，搜索框居中
		</li>
		<li>
			2009-8-26 23:19 增加查看所有分类功能，“更多”链接有效
		</li>
		<li>
			2009-8-26 17:20 实现模糊搜索功能，大小写不在敏感
		</li>
		<li>
			2009-8-26 14:20 修正添加软件的模糊查找功能
		</li>
	</ul>
	</td></tr>
</table>
<?php
}

function echoFooter()
{
?>
	</body>
	</html>
<?php
}
?>