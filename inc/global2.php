<?php
// 在php.ini中, 必须设置magic_quotes_runtime = Off, magic_quotes_gpc = Off
require_once('dbconstant.php');
require_once('constant.php');
require_once('DB.php');
require_once('HTML/AJAX/JSON.php');

// 把inc文件夹添加到include_path中
set_include_path( dirname(__FILE__) . PATH_SEPARATOR . get_include_path());

// 启动session
session_start();

// 网页使用utf-8编码
header('content-type: text/html; charset=utf-8');

ini_set('mbstring.internal_encoding', 'UTF-8');
if (get_magic_quotes_gpc()) {
	function stripslashes_deep($value) {
		$value = is_array($value) ? array_map('stripslashes_deep', $value) : stripslashes($value);
		return $value;
	}
	$_POST = array_map('stripslashes_deep', $_POST);
	$_GET = array_map('stripslashes_deep', $_GET);
	$_COOKIE = array_map('stripslashes_deep', $_COOKIE);
	$_REQUEST = array_map('stripslashes_deep', $_REQUEST);
}

// GET, POST和COOKIE传递的值中特殊字符已经被转义
// 单引号(')->&#039; 双引号(")->&quot; 大于号(>)->&gt; 小于号(<)->&lt; 连接符(&)->&amp;
// FCKeditor所涉及的输入域值必须使用 htmlspecialchars_decode解码
if(!isset($bNeedGpcTran) || $bNeedGpcTran) {
	foreach ($_GET as $key=>$value) {
		if (is_string($value)) {
			$_GET[$key] = htmlspecialchars($value, ENT_QUOTES);
		}
	}
	foreach ($_POST as $key=>$value) {
		if (is_string($value)) {
			$_POST[$key] = htmlspecialchars($value, ENT_QUOTES);
		}
	}
	foreach ($_COOKIE as $key=>$value) {
		if (is_string($value)) {
			$_COOKIE[$key] = htmlspecialchars($value, ENT_QUOTES);
		}
	}
}

// 创建全局变量$db, 不要使用$db->disconnect
$db = DB::connect(DATABASEDSN);
error($db);
$db->query('set names utf8');
global $db;

// 设置报错级别
if (DEBUG) {
	error_reporting(E_ALL);
	ini_set('display_errors','1');
} else {
	error_reporting(E_ERROR);
	ini_set('display_errors','0');
}
function isDebug() {
	if (DEBUG) {
		return true;
	}
	if ($_GET['dump']=='debug') {
		return true;
	}
	return false;
	
}
// 调试输出
function debug($msg) {
	if (isDebug()) {
		echo "<pre>";
		// 输出程度调用栈信息
		debug_print_backtrace();
		// 输出变量详细信息
		var_dump($msg);
		echo "</pre>";
	}
}
// 调试输出错误信息
function error($sth) {
	if (PEAR :: isError($sth)) {
		// 如果出错
		if (isDebug()) {
			// 调试模式
			echo '错误：'.$sth->getMessage();
			debug($sth);
		} else {
			// 非调试模式
			if(headers_sent())
				echo '<script>window.location="/errors/contact.php"</script>';
			else
				header("Location: /errors/contact.php");
		}
		die;
	}
}
//用于AJAX请求页面输出错误信息
function ajaxError($sth) {
	if (PEAR :: isError($sth)) {
		// 如果出错
		$result['success']=false;
		if (isDebug()) {
			$result['msg']='错误：'.$sth->getMessage()."<br>调试信息:".print_r(debug_backtrace(),true)."<br>PEAR错误信息:".print_r($sth,true);
		} else {
			$result['msg']='服务器内部错误，请与管理员联系，谢谢';
		}
		echo json_encode($result);
		die;
	}
}
// 设置时区
//date_default_timezone_set('Asia/Shanghai');


if (!function_exists('htmlspecialchars_decode')) {
	function htmlspecialchars_decode ($str) {
		return strtr($str, array_flip(get_html_translation_table(HTML_SPECIALCHARS)));
	}
}
if (!function_exists('json_encode')) {
	function json_encode($data) {
		$jObj = new HTML_AJAX_JSON();
		return $jObj->encode($data);
	}
}