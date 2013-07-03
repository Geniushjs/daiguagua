
<?php
	require_once("./inc/global.php");
	require_once("./inc/myfront.php");
	
	if (isset($_GET['do']))
		$do = $_GET['do'];
	else
	if (isset($_POST['do']))
		$do = $_POST['do'];
	else
		$do = 'main';

	if (isset($_GET['cid']))
		$cid = $_GET['cid'];
	else
	if (isset($_POST['cid']))
		$cid = $_POST['cid'];
	else
		$cid = 1;
	
	if (isset($_GET['sid']))
		$sid = $_GET['sid'];
		
	if (isset($_GET['search']))
		$search = $_GET['search'];
	else
	if (isset($_POST['search']))
		$search = $_POST['search'];
	
	if ($do == 'deadlink') {
		error($db->query("update soft set deadlink=1 where sid=?", array($sid)));
		echo "<script>alert('报告成功，谢谢您的支持！')</script>";
		echo "<script>window.location.href='.';</script>";
		$do = 'main';
	}
	echoHeader();
?>
<style type="text/css">
<!--
.bgbanner {
	background-color: #0099ff;
	height: 262px;
	position:relative;
}
.bgbody {
	position:absolute;
}
-->
</style>


<table width="921" align="center" border="0" cellpadding="0" cellspacing="0">
  <tr> 
  	<td width="206" valign="top">
		<?php echoLeft(); ?>
	</td>
	<td width="715" valign="top">
		<table width="100%" border="0" cellpadding="0" cellspacing="0">
			<tr><td width="100%" valign="top" colspan="3">
				<?php echoHead(); ?>
			</td></tr>
			<tr>
				<td width="5%"></td>
				<td width="90%" valign="top">
					<?php
						if ($do == 'search') {
							echo "<script>document.form.search.value=";
							echo $search;
							echo ";</script>";
							echoSearch($search);
						}
						else
						if ($do == 'class')
							echoClass();
						else
						if ($do == 'news')
							echoNews();
						else
							echoMain($cid);
					?>
				</td>
				<td width="5%"></td>
			</tr>
		</table>
	</td>
  </tr>
</table>
<?php
	echoEmpty(200);
	echoFooter();
?>