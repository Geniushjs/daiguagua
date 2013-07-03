<?php
require_once('../inc/global.php');
?>
<p>用户<strong><?php echo $_SESSION['name'];?></strong>，您好!</p>
<a href="javascript:top.location='logout.php'">登出</a>
