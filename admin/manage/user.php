<?php
	require_once("../../inc/global.php");
	require_once("../../inc/common.php");
	
	checkAdmin("../index.php");
	
	global $db;
	
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
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"><title>呆瓜瓜</title>
<link href="../../css/style.css" rel="stylesheet" type="text/css" />

<script language="JavaScript" type="text/javascript">
function SubmitCheck(){
  	if(document.userform.name.value=="") {
		window.alert("名称不能为空");
		return false;
	}
  	if(document.userform.level.value=="") {
		window.alert("权限级别不能为空");
		return false;
	}
  	if(document.userform.password.value=="") {
		window.alert("密码不能为空");
		return false;
	}
  	if(document.userform.repeat.value=="") {
		window.alert("请再输入一遍密码");
		return false;
	}
	if(document.userform.password.value != document.userform.repeat.value) {
		window.alert("两次密码输入不一致");
		return false;
	}
	return true;
}

function delete_confirm(uid)
{
	var r = confirm("你确定删除么?");
	if (r)
		window.location.href='user.php?do=delete&uid='+uid;
}

</script>

</head>

<body>

<?php
	if ($do == 'show')
	{
		$sql = "select * from user order by uid";
		error($rows = $db->getAll($sql, array(), DB_FETCHMODE_OBJECT));
?>

<table border="0" width=100%>
	<tr bgcolor="#5794CD" class="fontwrite">
		<th height=30>编号</th>
		<th>用户名称</th>
		<th>权限级别</th>
		<th>是否有效</th>
		<th>密码</th>
		<th>
			<input type="button" value="添加" onclick="window.location.href='user.php?do=add'" />
		</th>
	</tr>
<?php
		$index = 0;
		foreach ($rows as $row)
		{
			if ($row->level==0) continue;
			$index++;
?>
		<tr bgcolor="#F0F4F7" class="font12" align="center">
			<td height=15>
				<?php echo $index ?>
			</td>
			<td>
				<?php echo $row->name ?>
			</td>
			<td>
				<?php echo $row->level ?>
			</td>
			<td>
				<?php echo $row->valid?"是":"否" ?>
			</td>
			<td>
				******
			</td>
			<td align="center" class="fontred">
				<input type="button" value="编辑" onclick="window.location.href='user.php?do=edit&uid=<?php echo $row->uid ?>'" />
				<input type="button" value="删除" onclick="delete_confirm(<?php echo $row->uid ?>)" />
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
<form action="user.php" method="get" onSubmit="return SubmitCheck();" name="userform" >
	<input type="hidden" name="do" value="addinfo" /> 
<table border="0">
	<tr bgcolor="#5794CD" class="fontwrite">
		<th colspan=2 height="30">添加新用户</th>
	</tr>
	<tr bgcolor="#F0F4F7" class="font12">
		<th>用户帐号<font color=red>*</font></th><td><input type=text size=25 name="name"/></td>
	</tr>
	<tr bgcolor="#F0F4F7" class="font12">
		<th>权限级别<font color=red>*</font></th><td><input type=text size=5 name="level" value="1"/></td>
	</tr>
	<tr bgcolor="#F0F4F7" class="font12">
		<th>是否有效<font color=red>*</font></th>
		<td>
		<select name="valid">
			<option value="0">否</option>
			<option value="1" selected="selected">是</option>
		</select>
		</td>
	</tr>
	<tr bgcolor="#F0F4F7" class="font12">
		<th>新密码<font color=red>*</font></th><td><input type=password size=15 name="password"/></td>
	</tr>
	<tr bgcolor="#F0F4F7" class="font12">
		<th>确认密码<font color=red>*</font></th><td><input type=password size=15 name="repeat"/></td>
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
				'level'		=>$_GET['level'],
				'valid'		=>$_GET['valid'],
				'password'	=>md5($_GET['password']),
			);
		error($db->autoExecute('user', $data, DB_AUTOQUERY_INSERT));
?>
		<script>window.alert("添加成功"); window.location.href="user.php";</script>
<?php
	}
	else
	if ($do == 'edit')
	{
		$sql = "select * from user where uid=?";
		error($rows=$db->getAll($sql, array($_GET['uid']), DB_FETCHMODE_OBJECT));
		$row = $rows[0];
?>
<form action="user.php" method="get" onSubmit="return SubmitCheck();" name="userform" >
	<input type="hidden" name="do" value="save" /> 
	<input type="hidden" name="uid" value="<?php echo $row->uid ?>" /> 
<table border="0">
	<tr bgcolor="#5794CD" class="fontwrite">
		<th colspan=2 height="30">编辑内容</th>
	</tr>
	<tr bgcolor="#F0F4F7" class="font12">
		<th>用户名称<font color=red>*</font></th><td><input type=text size=25 name="name" value="<?php echo $row->name ?>"/></td>
	</tr>
	<tr bgcolor="#F0F4F7" class="font12">
		<th>权限级别<font color=red>*</font></th><td><input type=text size=5 name="level" value="<?php echo $row->level ?>"/></td>
	</tr>
	<tr bgcolor="#F0F4F7" class="font12">
		<th>是否有效<font color=red>*</font></th>
		<td>
		<select name="valid">
			<option value="0" <?php if ($row->valid==0) echo "selected='selected'"?>>否</option>
			<option value="1" <?php if ($row->valid==1) echo "selected='selected'"?>>是</option>
		</select>
		</td>
	</tr>
	<tr bgcolor="#F0F4F7" class="font12">
		<th>新密码<font color=red>*</font></th><td><input type=password size=15 name="password" value="<?php echo $row->password ?>"/></td>
	</tr>
	<tr bgcolor="#F0F4F7" class="font12">
		<th>确认密码<font color=red>*</font></th><td><input type=password size=15 name="repeat" value="<?php echo $row->password ?>"/></td>
	</tr>
	<tr>
		<td bgcolor="#F0F4F7" align="center" colspan="2">
			<input type="submit" value="保存"/>
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
				'level'		=>$_GET['level'],
				'valid'		=>$_GET['valid'],
				'password'	=>md5($_GET['password']),
			);
		error($db->autoExecute('user', $data, DB_AUTOQUERY_UPDATE, 'uid='.$_GET['uid']));
?>
		<script>window.location.href="user.php";</script>
<?php
	}
	else
	{
		$sql = "delete from user where uid=?";
		error($db->query($sql, array($_GET['uid'])));
?>
		<script>window.alert("删除成功"); window.location.href="user.php";</script>
<?php
	}
?>

</body>
</html>