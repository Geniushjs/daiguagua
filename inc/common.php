<?php
require_once "constant.php";

function setLoginSession($row) {
	$_SESSION['uid']=$row->uid;
	$_SESSION['name']=$row->name;
	$_SESSION['level']=$row->level;
}

function checkId(){
	if (!isset($_SESSION['level']) || $_SESSION['level'] > 1) 
	{
?>
		<script type="text/javascript">
		<!--
			window.alert("您未登录或连接超时，请重新登录");
			top.location='../index.php';
		//-->
		</script>
<?php
		die;
	}
} 

function checkAdmin($url){
	if (!isset($_SESSION['level']) || $_SESSION['level'] >= 1) 
	{
?>
		<script type="text/javascript">
		<!--
			window.alert("您没有权限");
			top.location=<?php echo $url ?>;
		//-->
		</script> 
<?php 
		die;
	}
} 

function qsort(&$a, $l, $r)
{
	if ($l >= $r) return;
	$k = $a[($l+$r-($l+$r)%2)/2];
	$i = $l; $j = $r;
	while ($i < $j)
	{
		while ($a[$i]->sortorder < $k->sortorder) $i++;
		while ($a[$j]->sortorder > $k->sortorder) $j--;
		if ($i <= $j)
		{
			$t = $a[$i]; $a[$i] = $a[$j]; $a[$j] = $t;
			$i ++; $j --;
		}
	}
	if ($l < $j) qsort($a, $l, $j);
	if ($i < $r) qsort($a, $i, $r);
}

function uppercase($a)
{
	return ($a >= 'A' && $a <= 'Z');
}

function uppertolower(&$a)
{
	for ($i=0; $i<strlen($a); $i++)
		if (uppercase($a[$i]))
			$a[$i] = chr(ord($a[$i])-ord('A')+ord('a'));
}
 
function like($a, $b)
{
	uppertolower($a);
	uppertolower($b);
	if ($b==NULL || $b=="") return true;
	return strstr($a, $b);
}

function isletter($a)
{
	return ($a >= 'a' && $a <= 'z' || $a >= 'A' && $a <= 'Z');
}

function isdigit($a)
{
	return ($a >= '0' && $a <= '9');
}

function ProcessChinese(&$la, &$a)
{
	for ($i = 0; $i < $la; $i++) $str[$i] = "";
	
	$index = 0; $flag = 0;
	for ($i = 0; $i < $la; $i++)
		if (ord($a[$i]) >= 224) {
			if ($flag) $index++;
			$flag = 0;
			if (ord($a[$i] < 240)) {
				$str[$index++] = $a[$i].$a[$i+1].$a[$i+2];
				$i += 2;
			}
			else {
				$str[$index++] = $a[$i].$a[$i+1].$a[$i+2].$a[$i+3];
				$i += 3;
			}
		}
		else {
			$flag = 1;
			$str[$index] = $str[$index].$a[$i];
		}
	if ($flag) $index++;
	
	$la = $index;
	$a = $str;
}

function highlight($a, $p, $i, $j)
{
	if ($p[$i][$j] == 0) 
	{
		$str = "";
		for ($index = 0; $index < $i; $index ++)
			$str .= $a[$index];
		return $str;
	}
	else
	if ($p[$i][$j] == 1)
		return highlight($a, $p, $i-1,$j).$a[$i-1];
	else
	if ($p[$i][$j] == 2)
		return highlight($a, $p, $i,$j-1);
	else {
		return highlight($a, $p, $i-1, $j-1)."<b style='background-color:yellow'>".$a[$i-1]."</b>";
	}
}

function similary(&$a, $b)
{
	if ($a == NULL || $b == NULL || strlen($a)==0 || strlen($b)==0)
		return false;
		
	$la = strlen($a);
	$lb = strlen($b);

	ProcessChinese($la, $a);
	ProcessChinese($lb, $b);
	
	$tempa = $a;
	
	for ($i = 0; $i < $la; $i++)
		uppertolower($a[$i]);	
	for ($i = 0; $i < $lb; $i++)
		uppertolower($b[$i]);
	
	for ($i = 0; $i <= $la; $i++)
		for ($j = 0; $j <= $lb; $j++)
			$f[$i][$j] = $p[$i][$j] = 0;
	
	///  最长公共子序列  用来求2个字符串的相似度
	for ($i = 1; $i <= $la; $i++)
		for ($j = 1; $j <= $lb; $j++)
		{
			if ($f[$i-1][$j] > $f[$i][$j-1]) {
				$f[$i][$j] = $f[$i-1][$j];
				$p[$i][$j] = 1;
			}
			else {
				$f[$i][$j] = $f[$i][$j-1];
				$p[$i][$j] = 2;
			}
			
			if ($a[$i-1] == $b[$j-1])
			{
				if (isletter($a[$i-1][0]) || isdigit($a[$i-1][0]))
					$score = 2;
				else
					$score = 1;
				
				if ($f[$i][$j] < $f[$i-1][$j-1] + $score) {
					$f[$i][$j] = $f[$i-1][$j-1] + $score;
					$p[$i][$j] = 3;
				}
			}
		}
	
	$newStr = highlight($tempa, $p, $la, $lb);
	$a = $newStr;

	return ($f[$la][$lb] >= 2);
}

//排序和分页的SQL	
function sortLimitSql() {
	$sql='';
	if(isset($_POST['sort'])) {
		$sql.=' order by '.$_POST['sort'].' '.$_POST['dir'];
	}
	if(isset($_POST['limit'])) {
		$sql.=' limit '.$_POST['start'].','.$_POST['limit'];
	} else {
		$sql.=' limit 0,20';
	}
	return $sql;
	
}