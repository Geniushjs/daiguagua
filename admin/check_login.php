<?php
require_once("../inc/global.php");
require_once("../inc/common.php");
$sql='select * from user where valid=1 and name=? and password=md5(?)';
error($rs=$db->getAll($sql,array($_POST['username'],$_POST['password']),DB_FETCHMODE_OBJECT));
if (count($rs)!=1) {
	echo "<script type='text/javascript'>alert('您输入的用户名或密码不正确，请重试。');history.back();</script>";
	die;
}
setLoginSession($rs[0]);
?>
<script>
top.location='.';
</script>