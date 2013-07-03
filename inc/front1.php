<?php
//$curIndex,js文件数组
function echoHead($curIndex=0) {
global $dir;
//	debug($curIndex);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>北京大学学生科创工作平台</title>
<link href="<? echo $dir;?>./css/style.css" rel="stylesheet" type="text/css" />
<style>
	a.acewill {position:relative}
	a.acewill span{display:none}
	a.acewill:hover span{display:block;position:absolute;top:-26px;left:50px;width:160px;border:1px dotted}
	a.acewill:hover {background:#F0F4F7}
</style>
<script language="JavaScript" type="text/javascript">
function SubmitCheck(){
  	if(document.forms[0].username.value==""||document.forms[0].password.value==""){
  	  return false;
    }
  return true;
} 
</script>
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

<body topmargin="0">
<table width="1004" border="0" align="center" cellpadding="0" cellspacing="0" height="110" background="<? echo $dir;?>./images/top_banner.jpg">
  <tr>
    <td></td>
  </tr>
</table>
<?
}
function echoFoot(){
global $dir;
?>
<TABLE WIDTH="1004"  BORDER="0" align="center" CELLPADDING="0" CELLSPACING="0" background="<? echo $dir;?>./images/footer_bg.jpg" style="color:#FFFFFF; height:88px;">
  <TR> 
    <TD align="center"> 
      <DIV CLASS="white12">共青团北京大学委员会<br>
                        北京大学学生课外活动指导中心<br>
                        北京大学“挑战杯”科技工程办公室<br>
     技术支持：<a href="#" target="_blank" style="color:#FFFFFF">北京创捷易通网络科技有限公司</a></DIV>
    </TD>
  </TR>
 </TABLE>
<?
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
?>

