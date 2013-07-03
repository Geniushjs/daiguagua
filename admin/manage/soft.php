<?php
	require_once("../../inc/global.php");
	require_once("../../inc/common.php");
	
	checkId();
	
	global $db;
	global $TYPE_NAME;

	if (isset($_GET['do']))
		$do = $_GET['do'];
	else
	if (isset($_POST['do']))
		$do = $_POST['do'];
	else
		$do = 'show';
	
	if (isset($_GET['sid']))
		$sid = $_GET['sid'];
		
	if (isset($_GET['cid']))
		$cid = $_GET['cid'];
		
	if ($do=="deadlink") {
		$do = "show";
		error($db->query("update soft set deadlink=0 where sid=?", array($sid)));
	}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Language" content="en">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"><title>呆瓜瓜</title>
<link href="../../css/style.css" rel="stylesheet" type="text/css" />

<script language="JavaScript" type="text/javascript">
<!--
	function SubmitCheck(){
		if(document.softform.name.value=="") {
			window.alert("名称不能为空");
			return false;
		}
		if(document.softform.url.value=="") {
			window.alert("版本不能为空");
			return false;
		}
		if(document.softform.url.value=="") {
			window.alert("下载地址不能为空");
			return false;
		}
		if(document.softform.pageurl.value=="") {
			window.alert("主页地址不能为空");
			return false;
		}
		if(document.softform.sortorder.value=="") {
			window.alert("优先级不能为空");
			return false;
		}
	  return true;
	}
	
	function delete_confirm(sid)
	{
		var r = confirm("你确定删除么?");
		if (r)
			window.location.href='soft.php?do=delete&sid='+sid;
	}
	
	function classFilter()
	{
		var sel = document.getElementsByName("cid");
		if (sel[0].value>=0)
			document.location.href = "soft.php?do=show&cid="+sel[0].value;
		else
			document.location.href = "soft.php";
	}
	
-->
</script>

</head>

<body>

<?php
	if ($do == 'show')
	{
		if (!isset($sort))
			$sort = "updatetime desc";
		
		if (!isset($cid))
		{
			$sql = "select * from soft order by ".$sort;
			error($rows = $db->getAll($sql, array(), DB_FETCHMODE_OBJECT));
		}
		else
		if ($cid < 100)
		{
			$sql = "select soft.sid, soft.name, soft.version, soft.image, soft.sortorder, soft.updatetime, soft.deadlink
					from soft,class,label
					where class.cid=? and label.cid=class.cid and label.sid=soft.sid
					order by ".$sort;
			error($rows = $db->getAll($sql, array($cid), DB_FETCHMODE_OBJECT));
		}
		else
		{
			$sql = "select soft.sid, soft.name, soft.version, soft.image, soft.sortorder, soft.updatetime, soft.deadlink
					from soft, class, label
					where class.cid = label.cid and label.sid = soft.sid and class.type = ?
					order by ".$sort;
			error($rows = $db->getAll($sql, array($cid-100), DB_FETCHMODE_OBJECT));
		}
?>

<table border="0" width=100%>
	<tr bgcolor="#5794CD" class="fontwrite">
		<th height=30><a href="soft.php?sort=sid">
			<font class="fontwrite">
				编号	</font>
		</a></th>
		<th><a href="soft.php?sort=name">
			<font class="fontwrite">
				软件名称</font>
		</a></th>
		<th><a href="soft.php?sort=version">
			<font class="fontwrite">
				版本信息</font>
		</a></th>
		<th><a href="soft.php?sort=image">
			<font class="fontwrite">
				图片地址</font>
		</a></th>
		<th><a href="soft.php?sort=url">
			<font class="fontwrite">
				下载地址</font>
		</a></th>
		<th><a href="soft.php?sort=pageurl">
			<font class="fontwrite">
				主页地址</font>
		</a></th>
		<th><a href="soft.php?sort=sortorder">
			<font class="fontwrite">
				优先级别</font>
		</a></th>
		<th>
			<select onChange="classFilter()" name="cid">
			<option value="-1" <?php if (!isset($cid) || $cid==0) echo "selected=selected"?>>所有分类</option>
		<?php 
			$sql = "select * from class order by type,sortorder";
			error($arrays=$db->getAll($sql, array(), DB_FETCHMODE_OBJECT));
			for ($typeIndex=0; $typeIndex<TYPE_NUMBERS; $typeIndex++)
			{
				if ($cid == $typeIndex+100)
					echo "<option value='".($typeIndex+100)."' selected=selected>【".$TYPE_NAME[$typeIndex]."】</option>";
				else
					echo "<option value='".($typeIndex+100)."'>【".$TYPE_NAME[$typeIndex]."】</option>";
				foreach ($arrays as $row)
				{
					if ($row->type != $typeIndex) continue;
					if ($cid == $row->cid)
						echo "<option value='".$row->cid."' selected=selected>----".$row->name."</option>";
					else
						echo "<option value='".$row->cid."'>----".$row->name."</option>";
				}
			}
		?>
			</select>
		</th>
		<th><a href="soft.php">
			<font class="fontwrite">
				更新时间</font>
		</a></th>
		<th><a href="soft.php?sort=deadlink">
			<font class="fontwrite">
				是否死链</font>
		</a></th>
		<th>
			<input type="button" value="添加" onclick="window.location.href='soft.php?do=add'" />
		</th>
	</tr>
<?php
		$index = 0;
		foreach ($rows as $row)
		{
			$index++;
?>
		<tr bgcolor="#F0F4F7" class="font12" align="center" >
			<td height=15>
				<?php echo $index ?>
			</td>
			<td>
				<?php echo $row->name ?>
			</td>
			<td>
				<?php echo $row->version ?>
			</td>
			<td>
				<?php echo "<img width=20 height=20 src='../../images/soft/".$row->image."'/>" ?>
			</td>
			<td>
				****** <?php //echo $row->url ?>
			</td>
			<td>
				****** <?php //echo $row->pageurl ?>
			</td>
			<td>
				<?php echo $row->sortorder ?>
			</td>
			<td>
				<?php 
					$sql = "select class.cid cid, name from class, label where label.sid=? and label.cid=class.cid";
					error($temp = $db->getAll($sql, array($row->sid), DB_FETCHMODE_OBJECT));
					$i = 0;
					foreach ($temp as $tmp)
					{
						if ($i >= 3) break;
						$i++;
						echo "<a href='soft.php?do=show&cid=".$tmp->cid."'>".$tmp->name."</a> ";
					}
					if (count($temp) > 3) echo "...";
				?>
			</td>
			<td>
				<?php 
					$date = explode(" ", $row->updatetime);
					echo $date[0];
				?>
			</td>
			<td>
				<?php 
					if ($row->deadlink==0)
						echo "<font color=gray>否</font>";
					else
						echo "<a href='soft.php?do=deadlink&sid=".$row->sid."'><font color=red>激活</font></a>";
				?>
			</td>
			<td align="center" class="fontred">
				<input type="button" value="编辑" onclick="window.location.href='soft.php?do=edit&sid=<?php echo $row->sid ?>'" />
				<input type="button" value="删除" onclick="delete_confirm(<?php echo $row->sid ?>)" />
			</td>
		</tr>
<?php
		}
?>
</table>
<?php
	}
	else
	if ($do == 'add')
	{
?>
<form enctype="multipart/form-data" action="soft.php" method="post" onSubmit="return SubmitCheck();" name="softform" >
	<input type="hidden" name="do" value="addinfo" /> 
<table border="0">
	<tr bgcolor="#5794CD" class="fontwrite">
		<th colspan=2 height="30">添加新软件</th>
	</tr>
	<tr bgcolor="#F0F4F7" class="font12">
		<th>软件名称<font color=red>*</font></th><td><input type=text size=20 maxlength=20 name="name"/></td>
	</tr>
	<tr bgcolor="#F0F4F7" class="font12">
		<th>版本信息<font color=red>*</font></th><td><input type=text size=15 maxlength=15 name="version"/></td>
	</tr>
	<tr bgcolor="#F0F4F7" class="font12">
		<th>图片地址</th>
		<td>
			<input type=file size=50 name="userfile"/><br/>
			<input type="text" size=10 name="image" value="default.gif" />
			如果已经在images/soft文件夹下，可直接输入图片名称
		</td>
	</tr>
	<tr bgcolor="#F0F4F7" class="font12">
		<th>下载地址<font color=red>*</font></th><td><input type=text size=100 name="url"/></td>
	</tr>
	<tr bgcolor="#F0F4F7" class="font12">
		<th>主页地址<font color=red>*</font></th><td><input type=text size=50 name="pageurl"/></td>
	</tr>
	<tr bgcolor="#F0F4F7" class="font12">
		<th>优先级别<font color=red>*</font></th>
		<td><table>
		<tr>
			<td rowspan="2">
			<input type=text size=10 name="sortorder" value="100"/><br/>
			</td>
			<td>
				<b>级别1</b>-置顶软件（同类产品中最常用的）
			</td>
			<td>
				<b>级别2</b>-拥有较多的用户群
			</td>
			<td>
				<b>级别3</b>-拥有一定的用户群
			</td>
		</tr>
		<tr>
			<td>
				<b>级别4</b>-拥有少量的用户群
			</td>
			<td>
				<b>级别5</b>-不知名软件
			</td>
			<td>
				<b>级别100</b>-暂时不定，置底
			</td>
		</tr>
		</table></td>
	</tr>
	
<?php
	for ($typeIndex = 0; $typeIndex < TYPE_NUMBERS; $typeIndex++)
	{
?>
	<tr bgcolor="#F0F4F7" class="font12">
		<th><?php echo $TYPE_NAME[$typeIndex] ?></th><td><table><tr>
		<?php
			$sql = "select * from class where type=? order by sortorder";
			error($rows = $db->getAll($sql, array($typeIndex+1), DB_FETCHMODE_OBJECT));
			$index = 0;
			foreach ($rows as $row)
			{
				$index ++;
		?>
				<td width="100" align="left">
				<input type="checkbox" name="<?php echo "cid".$row->cid ?>">
		<?php 
				echo $row->name;
				echo "</td>";
				if ($index % 6 == 0) echo "</tr><tr>";
			}
		?>
		</tr></table></td>
	</tr>
<?php
	}
?>
	<tr>
		<td bgcolor="#F0F4F7" align="center" colspan="2">
			<input type="submit" value="提交"/>
			<input type="reset" value="重置"/>
		</td>
	</tr>
</table>
</form>
<?php
	}
	else
	if ($do == 'addinfo')
	{
		if (isset($_FILES['userfile']))
		{
			$image = $_FILES['userfile']['name'];
			$upload = "../../images/soft/".$image;
			if (!move_uploaded_file($_FILES['userfile']['tmp_name'],$upload))
				$image = $_POST['image'];
		}
		else
			$image = $_POST['image'];
			
		$sql = "select * from soft";
		error($rows = $db->getAll($sql, array(), DB_FETCHMODE_OBJECT));
		
		$result = array();
		foreach ($rows as $row) {
			if (similary($row->name, $_POST['name']))
				$result[] = $row;
		}
		
		$data = array(
				'name'		=>$_POST['name'],
				'version'	=>$_POST['version'],
				'image'		=>$image,
				'url'		=>$_POST['url'],
				'pageurl'	=>$_POST['pageurl'],
				'sortorder'	=>$_POST['sortorder']
			);
				
		error($db->autoExecute('soft', $data, DB_AUTOQUERY_INSERT));
			
		$sql = "select max(sid) sid from soft";
		error($rows = $db->getAll($sql, array(), DB_FETCHMODE_OBJECT));
		$sid = $rows[0]->sid;
			
		$sql = "select cid from class";
		error($rows = $db->getAll($sql, array(), DB_FETCHMODE_OBJECT));
			
		foreach ($rows as $row) {
			if (isset($_POST['cid'.$row->cid])) {
				$data = array('sid' => $sid, 'cid' => $row->cid);
				error($db->autoExecute('label', $data, DB_AUTOQUERY_INSERT));
			}
		}

		if (count($result) > 0)	{
?>
			<table border="0" width="100%">
			<tr bgcolor="#FFCC33" class="fontred">
				<th colspan=9 align="left" height="30">
					系统为您找到如下类似软件, 取消添加请点击
					<input type="button" value="删除" onclick="window.location.href='soft.php?do=delete&sid=<?php echo $sid ?>'" />
					否则请
					<a href="soft.php">确认添加</a>
				</th>
			</tr>
			<tr bgcolor="#5794CD" class="fontwrite">
				<th height="20">软件名称</th>
				<th>版本信息</th>
				<th>图片地址</th>
				<th>下载地址</th>
				<th>主页地址</th>
				<th>优先级别</th>
				<th>所属分类</th>
				<th>更新时间</th>
			</tr>
		<?php
				foreach ($result as $row)
				{
		?>
				<tr bgcolor="#F0F4F7" class="font12" align="center">
					<td height="15">
						<?php echo $row->name ?>
					</td>
					<td>
						<?php echo $row->version ?>
					</td>
					<td>
						<?php echo $row->image ?>
					</td>
					<td>
						****** <?php //echo $row->url ?>
					</td>
					<td>
						****** <?php //echo $row->pageurl ?>
					</td>
					<td>
						<?php echo $row->sortorder ?>
					</td>
					<td>
						<?php 
							$sql = "select name from class, label where label.sid=? and label.cid=class.cid";
							error($temp = $db->getAll($sql, array($row->sid), DB_FETCHMODE_OBJECT));
							$i = 0;
							foreach ($temp as $tmp)
							{
								if ($i >= 3) break;
								$i++;
								echo $tmp->name." ";
							}
							if (count($temp) > 3) echo "...";
						?>
					</td>
					<td>
						<?php
							$date = explode(" ", $row->updatetime);
							echo $date[0];
						?>
					</td>
				</tr>
		<?php
				}
			echo "</table>";
		}
		else {
?>
			<script>window.location.href="soft.php";</script>
<?php
		}
	}
	else
	if ($do == 'edit')
	{
		$sql = "select * from soft where sid=?";
		error($rows=$db->getAll($sql, array($_GET['sid']), DB_FETCHMODE_OBJECT));
		$row = $rows[0];
?>
<form enctype="multipart/form-data" action="soft.php" method="post" onSubmit="return SubmitCheck();" name="softform" >
	<input type="hidden" name="do" value="save" /> 
	<input type="hidden" name="sid" value="<?php echo $row->sid ?>" /> 
<table border="0">
	<tr bgcolor="#5794CD" class="fontwrite">
		<th colspan=2 height=30>编辑内容</th>
	</tr>
	<tr bgcolor="#F0F4F7" class="font12">
		<th>软件名称<font color=red>*</font></th><td><input type=text size=20 maxlength=20 name="name" value="<?php echo $row->name ?>"/></td>
	</tr>
	<tr bgcolor="#F0F4F7" class="font12">
		<th>版本信息<font color=red>*</font></th><td><input type=text size=15 maxlength=15 name="version" value="<?php echo $row->version ?>"/></td>
	</tr>
	<tr bgcolor="#F0F4F7" class="font12">
		<th>图片地址</th><td><input type=file size=50 name="userfile" /><br/>
		<input type=text name="image" value="<?php echo $row->image ?>"> 直接修改文件名 </td>
	</tr>
	<tr bgcolor="#F0F4F7" class="font12">
		<th>下载地址<font color=red>*</font></th><td><input type=text size=100 name="url" value="<?php echo $row->url ?>"/></td>
	</tr>
	<tr bgcolor="#F0F4F7" class="font12">
		<th>主页地址<font color=red>*</font></th><td><input type=text size=50 name="pageurl" value="<?php echo $row->pageurl ?>"/></td>
	</tr>
	<tr bgcolor="#F0F4F7" class="font12">
		<th>优先级别<font color=red>*</font></th><td><input type=text size=10 name="sortorder" value="<?php echo $row->sortorder ?>"/></td>
	</tr>
<?php
	for ($typeIndex = 0; $typeIndex < TYPE_NUMBERS; $typeIndex++)
	{
?>
	<tr bgcolor="#F0F4F7" class="font12">
		<th><?php echo $TYPE_NAME[$typeIndex]?></th><td><table><tr>
		<?php
			$sql = "select * from class where type=? order by sortorder";
			error($rows = $db->getAll($sql, array($typeIndex+1), DB_FETCHMODE_OBJECT));
			$index = 0;
			foreach ($rows as $row)
			{
				$index ++;
		?>
				<td width="100" align="left">
				<input
					type="checkbox"
					name="<?php echo "cid".$row->cid ?>"
					<?php
						$sql = "select * from label where sid=? and cid=?";
						error($temp = $db->getAll($sql, array($_GET['sid'], $row->cid), DB_FETCHMODE_OBJECT));
						if (count($temp) != 0)
							echo "checked='checked'";
					?>
				/>
		<?php 
				echo $row->name;
				echo "</td>";
				if ($index % 6 == 0) echo "</tr><tr>";
			}
		?>
		</tr></table></td>
	</tr>
<?php
	}
?>
	<tr>
		<td bgcolor="#F0F4F7" align="center" colspan="2">
			<input type="submit" value="保存"/>
			<input type="button" value="取消" onClick="window.location.href='soft.php'"/>
		</td>
	</tr>
</table>
</form>
<?php
	}
	else
	if ($do == 'save')
	{
		if (isset($_FILES['userfile']))
		{
			$image = $_FILES['userfile']['name'];
			$upload = "../../images/soft/".$image;
			if (!move_uploaded_file($_FILES['userfile']['tmp_name'],$upload))
				$image = $_POST['image'];
		}
		else
			$image = $_POST['image'];
	
		// 更新soft的信息
		$data = array(
				'name'		=>$_POST['name'],
				'version'	=>$_POST['version'],
				'image'		=>$image,
				'url'		=>$_POST['url'],
				'pageurl'	=>$_POST['pageurl'],
				'sortorder'	=>$_POST['sortorder']
			);
		error($db->autoExecute('soft', $data, DB_AUTOQUERY_UPDATE, 'sid='.$_POST['sid']));
		
		// 删除掉原来的标记
		error($db->query("delete from label where sid=?", array($_POST['sid']))); 
		
		// 再添加新的标记
		$sql = "select cid from class";
		error($rows = $db->getAll($sql, array(), DB_FETCHMODE_OBJECT));
		
		foreach ($rows as $row) {
			if (isset($_POST['cid'.$row->cid])) {
				$data = array('sid' => $_POST['sid'], 'cid' => $row->cid);
				error($db->autoExecute('label', $data, DB_AUTOQUERY_INSERT));
			}
		}
?>
		<script>window.location.href="soft.php";</script>
<?php
	}
	else
	{
		$sql = "delete from soft where sid=?";
		error($db->query($sql, array($_GET['sid'])));
		
		$sql = "delete from label where sid=?";
		error($db->query($sql, array($_GET['sid'])));		
?>
		<script>window.location.href="soft.php";</script>
<?php
	}
?>

</body>
</html>