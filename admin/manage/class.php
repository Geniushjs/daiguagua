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
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Language" content="en">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>分类管理</title>
<link href="../../css/style.css" rel="stylesheet" type="text/css" />

<script language="JavaScript" type="text/javascript">
function SubmitCheck(){
  	if(document.classform.name.value=="") {
		window.alert("名称不能为空");
		return false;
	}
  	if(document.classform.sortorder.value=="") {
		window.alert("优先级别不能为空");
		return false;
	}
  return true;
}
function delete_confirm(cid)
{
	var r = confirm("你确定删除么?");
	if (r)
		window.location.href='class.php?do=delete&cid='+cid;
}

</script>

</head>

<body>

<?php
	if ($do == 'show')
	{
		$sql = "select * from class order by type,sortorder";
		error($rows = $db->getAll($sql, array(), DB_FETCHMODE_OBJECT));
?>

<table border="0" width=100%>
	<tr bgcolor="#5794CD" class="fontwrite">
		<th height=30>编号</th>
		<th>分类名称</th>
		<th>图片地址</th>
		<th>优先级别</th>
		<th>所属类型</th>
		<th>
			<input type="button" value="添加" onclick="window.location.href='class.php?do=add'" />
		</th>
	</tr>
<?php
		$index = 0;
		foreach ($rows as $row)
		{
			$index++;
?>
		<tr bgcolor="#F0F4F7" class="font12" align="center">
			<td height=15>
				<?php echo $index ?>
			</td>
			<td>
				<?php
					echo $row->name;
					$sql = "select count(sid) total from label where label.cid = ?";
					error($temp = $db->getAll($sql, array($row->cid), DB_FETCHMODE_OBJECT));
					echo "(".$temp[0]->total.")";
				?>
			</td>
			<td>
				<?php echo $row->image ?>
			</td>
			<td>
				<?php echo $row->sortorder ?>
			</td>
			<td>
				<?php echo $TYPE_NAME[$row->type-1];?>
			</td>
			<td align="center" class="fontred">
				<input type="button" value="编辑" onclick="window.location.href='class.php?do=edit&cid=<?php echo $row->cid ?>'" />
				<input type="button" value="删除" onclick="delete_confirm(<?php echo $row->cid ?>)" />
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
<form action="class.php" method="get" onSubmit="return SubmitCheck();" name="classform" >
	<input type="hidden" name="do" value="addinfo" /> 
<table border="0">
	<tr bgcolor="#5794CD" class="fontwrite">
		<th colspan=2 height="30">添加新分类</th>
	</tr>
	<tr bgcolor="#F0F4F7" class="font12">
		<th>分类名称<font color=red>*</font></th><td><input type=text size=25 name="name"/></td>
	</tr>
	<tr bgcolor="#F0F4F7" class="font12">
		<th>图片地址<font color=red>*</font></th><td><input type=text size=20 name="image" value="default.gif"/></td>
	</tr>
	<tr bgcolor="#F0F4F7" class="font12">
		<th>优先级别<font color=red>*</font></th><td><input type=text size=10 name="sortorder" value="100"/></td>
	</tr>
	<tr bgcolor="#F0F4F7" class="font12">
		<th>所属类型<font color=red>*</font></th>
		<td>
		<select name="type">
		<?php
			for ($typeIndex = 0; $typeIndex < TYPE_NUMBERS; $typeIndex++)
				echo "<option value=".($typeIndex+1).">".$TYPE_NAME[$typeIndex]."</option>"
		?>
		</select>
		</td>
	</tr>
	<tr bgcolor="#F0F4F7" class="font12">
		<th>软件列表</th><td><table><tr>
		<?php
			$sql = "select * from soft order by name";
			error($rows = $db->getAll($sql, array(), DB_FETCHMODE_OBJECT));
			$index = 0;
			foreach ($rows as $row)
			{
				$index ++;
		?>
				<td>
				<input type="checkbox" name="<?php echo "sid".$row->sid ?>">
		<?php 
				echo $row->name;
				echo "</td>";
				if ($index % 6 == 0) echo "</tr><tr>";
			}
		?>
		</tr></table></td>
	</tr>
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
		$data = array(
				'name'		=>$_GET['name'],
				'image'		=>$_GET['image'],
				'sortorder'	=>$_GET['sortorder'],
				'type'		=>$_GET['type'],
			);
		error($db->autoExecute('class', $data, DB_AUTOQUERY_INSERT));
			
		$sql = "select max(cid) cid from class";
		error($rows = $db->getAll($sql, array(), DB_FETCHMODE_OBJECT));
		$cid = $rows[0]->cid;
			
		$sql = "select sid from soft";
		error($rows = $db->getAll($sql, array(), DB_FETCHMODE_OBJECT));
			
		foreach ($rows as $row) {
			if (isset($_GET['sid'.$row->sid])) {
				$data = array('cid' => $cid, 'sid' => $row->sid);
				error($db->autoExecute('label', $data, DB_AUTOQUERY_INSERT));
			}
		}
?>
		<script>window.location.href="class.php";</script>
<?php
	}
	else
	if ($do == 'edit')
	{
		$sql = "select * from class where cid=?";
		error($rows=$db->getAll($sql, array($_GET['cid']), DB_FETCHMODE_OBJECT));
		$row = $rows[0];
?>
<form action="class.php" method="get" onSubmit="return SubmitCheck();" name="classform" >
	<input type="hidden" name="do" value="save" /> 
	<input type="hidden" name="cid" value="<?php echo $row->cid ?>" /> 
<table border="0">
	<tr bgcolor="#5794CD" class="fontwrite">
		<th colspan=2 height="30">编辑内容</th>
	</tr>
	<tr bgcolor="#F0F4F7" class="font12">
		<th>分类名称<font color=red>*</font></th><td><input type=text size=25 name="name" value="<?php echo $row->name ?>"/></td>
	</tr>
	<tr bgcolor="#F0F4F7" class="font12">
		<th>图片地址<font color=red>*</font></th><td><input type=text size=20 name="image" value="<?php echo $row->image ?>"/></td>
	</tr>
	<tr bgcolor="#F0F4F7" class="font12">
		<th>优先级别<font color=red>*</font></th><td><input type=text size=10 name="sortorder" value="<?php echo $row->sortorder ?>"/></td>
	</tr>
	<tr bgcolor="#F0F4F7" class="font12">
		<th>所属类型<font color=red>*</font></th>
		<td>
		<select name="type">
		<?php
			for ($typeIndex = 0; $typeIndex < TYPE_NUMBERS; $typeIndex++)
				if ($row->type == $typeIndex+1)
					echo "<option value=".($typeIndex+1)." selected=selected>".$TYPE_NAME[$typeIndex]."</option>";
				else
					echo "<option value=".($typeIndex+1).">".$TYPE_NAME[$typeIndex]."</option>"
		?>
		</select>
		</td>
	</tr>
	<tr bgcolor="#F0F4F7" class="font12">
		<th>软件列表</th><td><table><tr>
		<?php
			$sql = "select * from soft order by name";
			error($rows = $db->getAll($sql, array(), DB_FETCHMODE_OBJECT));
			$index = 0;
			foreach ($rows as $row)
			{
				$index ++;
		?>
				<td>
				<input
					type="checkbox"
					name="<?php echo "sid".$row->sid ?>"
					<?php
						$sql = "select * from label where cid=? and sid=?";
						error($temp = $db->getAll($sql, array($_GET['cid'], $row->sid), DB_FETCHMODE_OBJECT));
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
	<tr>
		<td bgcolor="#F0F4F7" align="center" colspan="2">
			<input type="submit" value="保存"/>
			<input type="button" value="取消" onClick="window.location.href='class.php'"/>
		</td>
	</tr>
</table>
</form>
<?php
	}
	else
	if ($do == 'save')
	{
		$data = array(
				'name'		=>$_GET['name'],
				'image'		=>$_GET['image'],
				'sortorder'	=>$_GET['sortorder'],
				'type'		=>$_GET['type'],
			);
		error($db->autoExecute('class', $data, DB_AUTOQUERY_UPDATE, 'cid='.$_GET['cid']));
		
		// 删除掉原来的标记
		error($db->query("delete from label where cid=?", array($_GET['cid']))); 
		
		// 再添加新的标记
		$sql = "select sid from soft";
		error($rows = $db->getAll($sql, array(), DB_FETCHMODE_OBJECT));
		
		foreach ($rows as $row) {
			if (isset($_GET['sid'.$row->sid])) {
				$data = array('cid' => $_GET['cid'], 'sid' => $row->sid);
				error($db->autoExecute('label', $data, DB_AUTOQUERY_INSERT));
			}
		}
?>
		<script>window.location.href="class.php";</script>
<?php
	}
	else
	{
		$sql = "delete from class where cid=?";
		error($db->query($sql, array($_GET['cid'])));
?>
		<script>window.alert("删除成功"); window.location.href="class.php";</script>
<?php
	}
?>

</body>
</html>