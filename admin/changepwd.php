<?php
require_once ('../inc/global.php');
require_once ('../inc/common.php');

checkId();

if ($_POST==array())
{
?>

	<p>修改密码</p>
	<p>用户<strong><?php echo $_SESSION['name'];?></strong>，您好!如果您的缺省密码还未修改，请尽早修改！</p>

	<form method="POST">
		输入新密码：<input type="password" name="newpwd"><br>
		重复新密码：<input type="password" name="reppwd"><br>
		<input type="submit" value="修改">
	</form>
 
<?php
	die;
}

if ($_POST['newpwd']==''||$_POST['reppwd']==''){
	die('输入信息不能为空！<br><a href="changepwd.php">请返回重新输入。</a>');
}
if ($_POST['newpwd']!=$_POST['reppwd']) {
	die('两次输入密码不相同！<br><a href="changepwd.php">请返回重新输入。</a>');
}

$sql='update user set password=md5(?) where uid=?';
error($db->query($sql,array($_POST['newpwd'],$_SESSION['uid'])));
echo '密码修改成功！';
?>