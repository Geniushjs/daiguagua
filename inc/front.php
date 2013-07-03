<?php
//$curIndex,js文件数组
function echoHead($curIndex=0) {
//	debug($curIndex);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>学生科创网</title>
<link href="/css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
<!--
function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}
//-->
</script>
</head>

<body onload="MM_preloadImages('/images/c1_r1_c3.jpg','/images/c1_r1_c4.jpg','/images/c1_r1_c5.jpg','/images/c1_r1_c6.jpg','/images/c1_r1_c8.jpg')">
<table width="778" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="778" height="185" valign="top" background="/images/index_r1_c2.jpg"><table width="778" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="763" height="25" align="right" class="fontwrite12"><a href="/help/aboutus.php" class="white">关于我们</a> | <a href="javascript:window.external.AddFavorite('http://www.pkusast.net/','北大学生科创网')" class="white">收藏夹</a> | <a href="/help/contactus.php" class="white">联系我们</a></td>
        <td width="15" align="right" class="fontwrite12">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
</table>
<table width="778" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="30" align="center" background="/images/index_r3_c2.jpg"><table width="90%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><a href="/" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image63','','/images/c1_r1_c2.jpg',0)"><img src="/images/c<?php if ($curIndex==1) echo 1; else echo 2 ?>_r1_c2.jpg" name="Image63" width="102" height="30" border="0" /></a></td>
        <td><a href="/news/express.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image64','','/images/c1_r1_c3.jpg',1)"><img src="/images/c<?php if ($curIndex==2) echo 1; else echo 2 ?>_r1_c3.jpg" name="Image64" width="102" height="30" border="0" id="Image64" /></a></td>
        <td><a href="/news/notice.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image65','','/images/c1_r1_c4.jpg',1)"><img src="/images/c<?php if ($curIndex==3) echo 1; else echo 2 ?>_r1_c4.jpg" name="Image65" width="102" height="30" border="0" id="Image65" /></a></td>
        <td><a href="/news/download.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image66','','/images/c1_r1_c5.jpg',1)"><img src="/images/c<?php if ($curIndex==4) echo 1; else echo 2 ?>_r1_c5.jpg" name="Image66" width="102" height="30" border="0" id="Image66" /></a></td>
        <td><a href="/news/show.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image67','','/images/c1_r1_c6.jpg',1)"><img src="/images/c<?php if ($curIndex==5) echo 1; else echo 2 ?>_r1_c6.jpg" name="Image67" width="102" height="30" border="0" id="Image67" /></a></td>
        <td><a href="/star" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image68','','/images/c1_r1_c7.jpg',0)"><img src="/images/c<?php if ($curIndex==6) echo 1; else echo 2 ?>_r1_c7.jpg" name="Image68" width="102" height="30" border="0" id="Image68" /></a></td>
        <td><a href="/news/person.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image69','','/images/c1_r1_c8.jpg',1)"><img src="/images/c<?php if ($curIndex==7) echo 1; else echo 2 ?>_r1_c8.jpg" name="Image69" width="102" height="30" border="0" id="Image69" /></a></td>
        </tr>
    </table></td>
  </tr>
</table>
<table width="778" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="4"></td>
  </tr>
</table>
<table width="778" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#F0F4F7">
  <tr>
<?php
}

function echoLeft($leftType=2) {
	global $db;
	$sql='select nid,title from e_news where valid=true and newstype=? order by ptime desc limit 7';
	error($notices=$db->getAll($sql,array(NEWS_NOTICE),DB_FETCHMODE_OBJECT));	
	error($downloads=$db->getAll($sql,array(NEWS_DOWNLOAD),DB_FETCHMODE_OBJECT));
	$sql='select sid,picurl from e_star where valid=true order by ptime desc limit 4';	
	error($stars=$db->getAll($sql,array(),DB_FETCHMODE_OBJECT));	
?>
    <td width="200" valign="top">
<?php if ($leftType==1) {?>    
<script language="JavaScript" type="text/javascript">
function SubmitCheck(){
  	if(document.forms[0].username.value==""||document.forms[0].password.value==""){
  	  return false;
    }
  return true;
} 
</script>
    <table width="200" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="28" background="/images/index_r5_c2.jpg">　　<span class="fontwrite">登　陆</span></td>
      </tr>
      <tr>
        <td align="center" valign="top" background="/images/index_r12_c2.jpg">
        <form action="/admin/check_login.php" method="post" onsubmit="return SubmitCheck();">
        <table width="96%" border="0" cellpadding="0" cellspacing="0" bgcolor="#F0F9FD">
          <tr>
            <td height="22" align="center" bgcolor="#73C6EE" class="fontwrite">“挑战杯”系统登陆</td>
          </tr>
         
          <tr>
            <td height="10" align="center" class="font12"></td>
          </tr>
          <tr>
            <td height="25" align="center" class="font12">用户名　
              <input name="username" type="text" id="textfield" style='width:114px' /></td>
          </tr>
          <tr>
            <td height="25" align="center" class="font12">密　码　
              <input name="password" type="password" id="textfield2" style='width:114px' /></td>
          </tr>
          <tr>
            <td height="10" align="center" class="font12"></td>
          </tr>
          <tr>
            <td align="center" class="font12"><input type="submit" value="登陆" />　
              <input type="button" value="注册" onclick='location.href="/reg/register.php"' />　
              <input type="button" value="忘密" onclick='location.href="/reg/getpwd.php"' /></td>
          </tr>
          <tr>
            <td height="10" align="center" class="font12">&nbsp;</td>
          </tr>
        </table>
        </form>
            <table width="96%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td height="22" align="center" bgcolor="#73C6EE" class="fontwrite">“创业计划大赛”系统登陆</td>
            </tr>
            
            <tr>
              <td height="20" align="center" class="font12">&nbsp;</td>
            </tr>
            <tr>
              <td height="25" align="center" class="font12">用户名　
                <input name="textfield3" type="text" id="textfield3" style='width:114px' /></td>
            </tr>
            <tr>
              <td height="25" align="center" class="font12">密　码　
                <input name="textfield3" type="text" id="textfield4" style='width:114px' /></td>
            </tr>
            <tr>
              <td height="10" align="center" class="font12"></td>
            </tr>
            <tr>
              <td align="center" class="font12"><input type="submit" name="button4" id="button4" value="登陆" />
                　
                <input type="submit" name="button4" id="button5" value="注册" />
                　
                <input type="submit" name="button4" id="button6" value="忘密" /></td>
            </tr>
            <tr>
              <td align="center" class="font12" height="10"></td>
            </tr>
 </table>
<table width="90%" border="0" cellspacing="0" cellpadding="0"><tr></tr>
        </table>
         </td>
      </tr>
      <tr>
        <td><img src="/images/index_r13_c2.jpg" width="200" height="6" /></td>
      </tr>
    </table>
<?php } ?>    
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td height="4"></td>
        </tr>
      </table>
      <table width="200" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td height="28" background="/images/index_r8_c2.jpg">　　<span class="fontwrite">最新通知<span class="fontred12">　　　　　　<a href="/news/notice.php">更多</a></span></span></td>
        </tr>
        <tr>
          <td align="center" background="/images/index_r12_c2.jpg"><table width="90%" border="0" cellspacing="0" cellpadding="0">

            <tr>
              <td height="10" colspan="2" align="left" ></td>
              </tr>
<?php
foreach($notices as $row) {
?>
                <tr>
                  <td width="9%" height="25" align="left"><span class="font12"><img src="/images/index_r9_c6.jpg" width="10" height="12" align="absmiddle" /><br />
                  </span></td>
                  <td width="91%" align="left"><span class="font12">
                  <a href="/news/detail.php?id=<?php echo $row->nid ?>"><?php echo mb_strimwidth($row->title, 0, 50, "") ?></a>
                  </span></td>
                </tr>
<?php	
}
?>                  
          </table>
          <span class="font12"></span></td>
        </tr>
        <tr>
          <td><img src="/images/index_r13_c2.jpg" width="200" height="6" /></td>
        </tr>
      </table>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td height="4"></td>
        </tr>
      </table>
      <table width="200" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td height="28" background="/images/index_r8_c2.jpg">　　<span class="fontwrite">资料下载<span class="fontred12">　　　　　　<a href="/news/download.php">更多</a></span></span></td>
        </tr>
        <tr>
          <td align="center" background="/images/index_r12_c2.jpg"><table width="90%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td height="10" colspan="2" align="left" ></td>
            </tr>
<?php
foreach($downloads as $row) {
?>
                <tr>
                  <td width="9%" height="25" align="left"><span class="font12"><img src="/images/index_r9_c6.jpg" width="10" height="12" align="absmiddle" /><br />
                  </span></td>
                  <td width="91%" align="left"><span class="font12">
                  <a href="/news/detail.php?id=<?php echo $row->nid ?>"><?php echo mb_strimwidth($row->title, 0, 26, "") ?></a>
                  </span></td>
                </tr>
<?php	
}
?>                  
          </table></td>
        </tr>
        <tr>
          <td><img src="/images/index_r13_c2.jpg" width="200" height="6" /></td>
        </tr>
      </table>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td height="4"></td>
        </tr>
      </table>
<?php if ($leftType!=3) {?>    
      <table width="200" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td height="28" background="/images/index_r8_c2.jpg">　　<span class="fontwrite">科创之星<span class="fontred12">　　　　　　<a href="/star">更多</a></span></span></td>
        </tr>
        <tr>
          <td align="center" background="/images/index_r12_c2.jpg">
<?php 
foreach($stars as $row) {
	echo "<a style='float:left;padding:4px 12px;' href='/star/detail.php?id=$row->sid'><img src='/upload/star/72/$row->picurl' /></a>";
}
?>			
		  </td>
        </tr>
        <tr>
          <td><img src="/images/index_r13_c2.jpg" width="200" height="6" /></td>
        </tr>
      </table> <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td height="4"></td>
        </tr>
      </table>
<?php } if ($leftType==1) {?>    
      <table width="200" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td height="28" background="/images/index_r8_c2.jpg">　　<span class="fontwrite">赞助单位<span class="fontred12">　　　　　　<a href="/help/supportus.php">更多</a></span></span></td>
        </tr>
        <tr>
          <td align="center" background="/images/index_r12_c2.jpg"><table width="90%" border="0" cellspacing="0" cellpadding="3">
            <tr>
              <td>
              	<div class='links'>
              		<a title='北大科技园' href='http://www.pkusp.com.cn' target='_blank'><img src="/images/support1.jpg" /></a>
              		<a title='北大维信' href='http://www.wpu.com.cn/chinese/' target='_blank'><img src="/images/support2.jpg" /></a>
              	</div>
              </td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td><img src="/images/index_r13_c2.jpg" width="200" height="6" /></td>
        </tr>
      </table> <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td height="4"></td>
        </tr>
    </table>
      <table width="200" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td height="28" background="/images/index_r8_c2.jpg">　　<span class="fontwrite">友情连接<span class="fontred12">　　　　　　<a href="/help/link.php">更多</a></span></span></td>
        </tr>
        <tr>
          <td align="center" background="/images/index_r12_c2.jpg"><table width="90%" border="0" cellspacing="0" cellpadding="3">
            <tr>
              <td>
              	<div class='links'>
              		<a title='首都挑战杯' href='http://www.bjtiaozhanbei.org' target='_blank'><img src="/images/link1.jpg" /></a>
              		<a title='数模竞赛' href='http://mcm.edu.cn' target='_blank'><img src="/images/link2.jpg" /></a>
              		<a title='北大地带' href='http://162.105.78.251:1080' target='_blank'><img src="/images/link3.jpg" /></a>
              		<a title='全国挑战杯' href='http://www.tiaozhanbei.net' target='_blank'><img src="/images/link4.jpg" /></a>
              		<a title='北大团委' href='http://bdtw.pku.edu.cn' target='_blank'><img src="/images/link5.jpg" /></a>
              		<a title='学生课外指导网' href='http://bdtw.pku.edu.cn/dekt' target='_blank'><img src="/images/link6.jpg" /></a>
              	</div>
              </td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td><img src="/images/index_r13_c2.jpg" width="200" height="6" /></td>
        </tr>
      </table>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td height="4"></td>
        </tr>
      </table>
<?php } ?>      
      </td>
    <td width="6" valign="top">&nbsp;</td>
<?php
}

function echoHelpLeft() {
?>
<td width="200" valign="top"><table width="100%" cellspacing="1" cellpadding="0" border="0" bgcolor="#efecda">
      <tbody><tr>
        <td valign="middle" height="25" bgcolor="#f7f5ec" background="/images/yk_banner.gif" align="left" class="font12">　<img width="24" height="14" align="absmiddle" src="/images/arrow2.gif"/>　<a href='/help/aboutus.php'>关于我们</a></td>
      </tr>
      
      <tr>
        <td valign="middle" height="25" bgcolor="#f7f5ec" background="/images/yk_banner.gif" align="left" class="font12">　<img width="24" height="14" align="absmiddle" src="/images/arrow2.gif"/>　<a href='/help/supportus.php'>赞助单位</a></td>
      </tr>
      
      <tr>
        <td valign="middle" height="25" bgcolor="#f7f5ec" background="/images/yk_banner.gif" align="left" class="font12">　<img width="24" height="14" align="absmiddle" src="/images/arrow2.gif"/>　<a href='/help/link.php'>友情链接</a></td>
      </tr>
      <tr>
        <td valign="middle" height="25" bgcolor="#f7f5ec" background="/images/yk_banner.gif" align="left" class="font12">　<img width="24" height="14" align="absmiddle" src="/images/arrow2.gif"/>　<a href='/help/contactus.php'>联系我们</a></td>
      </tr>
    </tbody></table>
    <table width="100%" cellspacing="0" cellpadding="0" border="0">
        <tbody><tr>
          <td height="4"/>
        </tr>
      </tbody></table>
      <p> </p></td>
<td width="6" valign="top"> </td>
<?php
}
function echoFoot() {
?>
  </tr>
</table>
<table width="778" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="4"></td>
  </tr>
</table>
<table width="778" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="25" align="center" valign="middle" bgcolor="#5794CD" class="fontwrite12"><a href="/help/aboutus.php" class="white">关于我们</a> | <a href="/help/supportus.php" class="white">赞助单位</a> | <span class="white"><a href="/help/link.php" class="white">友情链接</a></span> | <span class="white"><a href="/help/contactus.php" class="white">联系我们</a></span></td>
  </tr>
</table>
<table width="778" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="25" align="center" valign="middle" bgcolor="#5794CD" class="fontwrite12"><table width="778" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td height="25" align="center" valign="middle" bgcolor="#5794CD" class="fontwrite12"><table width="778" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td height="80" align="center" valign="middle" bgcolor="#F0F4F7" class="font12">共青团北京大学委员会<br />
北京大学学生课外活动指导中心<br />
北京大学“挑战杯”科技工程办公室</td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
<?php
}


function echoNews($newsType,$subType=null) {
	global $db;
	global $C_NewsTypes;
	global $C_DownloadTypes;
	if (!isset($_GET['id'])) {
		$id=1;
	} else {
		$id=$_GET['id'];
	}
	$linePerPage=20;
	if (isset($subType)) {
		$sql = 'select nid, title, ptime from e_news where valid=true and newstype=? and subtype=? order by ptime desc limit ?,?';
		error($rs=$db->getAll($sql, array($newsType, $subType, ($id-1)*$linePerPage,$linePerPage), DB_FETCHMODE_OBJECT));
	} else {
		$sql = 'select nid, title, ptime from e_news where valid=true and newstype=? order by ptime desc limit ?,?';
		error($rs=$db->getAll($sql, array($newsType, ($id-1)*$linePerPage,$linePerPage), DB_FETCHMODE_OBJECT));
	}
?>
    <td valign="top">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="25" background="/images/index_r50_c4.jpg">　　<span class="fontwrite">
		<?php echo $C_NewsTypes[$newsType];?></span>
<?php
if (isset($subType)) {
	echo '<span class="fontwrite12"> --> '.$C_DownloadTypes[$subType].'</span>';
}
?>
        </td>
      </tr>
    </table>
      <table width="100%" border="0" cellspacing="1" bgcolor="#AACCEF">
        <tr>
          <td align="center" valign="top" bgcolor="#FFFFFF" class="font12"><br />
<?php
if ($newsType==NEWS_DOWNLOAD) {
?>
<a style="float:left" href="download.php">“挑战杯”——五四青年科学奖竞赛</a>
<a style="float:right" href="download2.php">学生创业计划大赛</a><br />
<a style="float:left" href="download3.php">“江泽涵杯”数学建模与计算机应用竞赛</a>
<a style="float:right" href="download4.php">其他资料</a><br /><br />
<?php } ?>
            <table width="94%" border="0" cellspacing="0" cellpadding="0">
<?php
foreach($rs as $row) {
?>
              <tr>
                <td align="left" class="font12">
                <span style="float:right"><?php echo $row->ptime ?></span>
                <img src="/images/arrow.gif" width="9" height="9" border="0" align="absmiddle" />
                <a href="/news/detail.php?id=<?php echo $row->nid ?>"><?php echo $row->title ?></a></td>
              </tr>
              <tr>
                <td height="7" align="left" background="/images/index_30.gif" class="font12"></td>
              </tr>

<?php	
}
?>                  
<tr><td class="font12">
<?php
error($countNews=$db->getOne('select count(*) from e_news where valid=true and newstype=?',array($newsType)));
$totalPages=floor(($countNews-1)/$linePerPage+1);
if ($id<$totalPages) {
	echo '<div style="float:right">';
	echo '<a href="'.$_SERVER['PHP_SELF'].'?id='.($id+1).'">下一页</a> ';
	echo '<a href="'.$_SERVER['PHP_SELF'].'?id='.$totalPages.'">末页</a>';
	echo '</div>';
}
if ($id>1) {
	echo '<div style="float:left">';
	echo '<a href="'.$_SERVER['PHP_SELF'].'">首页</a> ';
	echo '<a href="'.$_SERVER['PHP_SELF'].'?id='.($id-1).'">上一页</a>';
	echo '</div>';
}
?>
</td></tr>
              </table>
			</td>
		 </tr>
      </table>
      </td>
<?php
}

function echoShow($showType) {
	global $C_ShowTypes;
?>
  <div id="volunteer">首页 > <a href="volunteer.php">志愿者风采</a> > <?php echo $C_ShowTypes[$showType] ?></div>

  <div id="content"><ul>
<?php
if (!isset($_GET['id'])) {
	$id=1;
} else {
	$id=$_GET['id'];
}
$linePerPage=30;
$sql = 'select sid, title, ptime from e_show where valid=true and showtype=? order by ptime desc limit ?,?';
global $db;
error($rs=$db->getAll($sql, array($showType,($id-1)*$linePerPage,$linePerPage), DB_FETCHMODE_OBJECT));
$selfs=explode('.',$_SERVER['PHP_SELF']);
foreach($rs as $row) {
	echo '<li><div style="float:right">'.$row->ptime.'</div><a href="detail.php?id='.$row->sid.'">'.mb_strimwidth($row->title, 0, 90, "").'</a></li>';
}
?>

	</ul>
  </div>
  <div id="page">
<?php
error($countShows=$db->getOne('select count(*) from e_show where valid=true and showtype=?',array($showType)));
$totalPages=floor(($countShows-1)/$linePerPage+1);
if ($id<$totalPages) {
	echo '<div style="float:right">';
	echo '<a href="'.$_SERVER['PHP_SELF'].'?id='.($id+1).'">下一页</a></div>';
}
if ($id>1) {
	echo '<div style="float:left">';
	echo '<a href="'.$_SERVER['PHP_SELF'].'?id='.($id-1).'">上一页</a></div>';
}
?>

</div>
<?php
}

function checkLength($str,$min,$max,$mode="mb") {
	if($mode == "mb") {
		$len = mb_strlen($str);
	} else {
		$len = strlen($str);
	}
	if($len < $min || $len >$max)
		return false;
	else
		return true;
}
function errorPmt($str,$href='') {
	if(empty($href))
		echo "<script type='text/javascript'>alert(\"$str\");history.back();</script>";
	else
		echo "<script type='text/javascript'>alert(\"$str\");location.href='$href';</script>";
	die;
}
function _trimArray(&$value,$key) {
	if(is_array($value)) {
		array_walk($value,'_trimArray');
	} else if(is_string($value)) {
		$value = trim($value);
	}
}
function setLoginSession($row) {
	$_SESSION['uid']=$row->uid;
	$_SESSION['name']=$row->name;
	$_SESSION['role']=substr($row->roles,1,strlen($row->roles)-2);
}

function sendmail($recipient,$subject,$body) {
	require_once 'Mail.php';
	require_once 'PEAR.php';

	$headers['Content-Type']  = 'text/html; charset=gbk';
	$headers['From'] = SMTP_USERNAME;
	$headers['To'] = $recipient;

	$headers['Subject'] = mb_convert_encoding($subject,'gbk','utf8');
	$body = mb_convert_encoding($body,'gbk','utf8');

	//以SMTP的方式发送邮件
	$smptPar["host"] = SMTP_HOST;
	$smptPar["port"] = SMTP_PORT;
	$smptPar["auth"] = true;
	$smptPar["username"] = SMTP_USERNAME;
	$smptPar["password"] = SMTP_PASSWORD;
	$objMail =& Mail::factory("smtp", $smptPar);

	return $objMail->send($recipient, $headers, $body);
}

//得到$text的加密字符串
function getCryptText($text) {
    $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
    $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
    return base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, CRYPTKEY, $text, MCRYPT_MODE_ECB, $iv));
}
//得到$text的解密字符串
function getDecryptText($text) {
    $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
    $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
	$decryptext = mcrypt_decrypt(MCRYPT_RIJNDAEL_256,CRYPTKEY,base64_decode($text),MCRYPT_MODE_ECB,$iv);
    $index0 = strpos($decryptext,chr(0));
    if($index0 !== false) $decryptext = substr($decryptext,0,$index0);
	return $decryptext;
}
