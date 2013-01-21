<?php
date_default_timezone_set('Asia/Shanghai');
include("db.inc.php");

$month = idate("m");
$day = idate("d");
$date = $month . "-" . $day;
$checkTime = date("G");
//设置最晚订餐时间, 24h
$deadline = 11;
//设置项目ID, 上海: 21
$projectId = 21;

if(isset($_POST["name"]) && isset($_POST["staffId"])) {
  $name = dealRemark($_POST["name"]);
	$staffId = dealRemark($_POST["staffId"]);
	$date = $_POST["bDate"];
	$remark = $_POST["remark"];
	$remark = dealRemark($remark);
	$place = $_POST["place"];
	$sql = "SELECT * FROM supper WHERE staffId = '" . $staffId . "' AND bDate = '" . $date . "'";
	$result = mysql_query($sql);
	$num = mysql_num_rows($result);
	if($num > 0) {
		echo "<script>alert('你今天已经定过了!');</script>";
	} else if ($checkTime >= $deadline) {
		echo "<script>alert('超过" . $deadline . "点不可订餐!');</script>";
	} else {
		$query = "INSERT INTO supper (id, name, staffId, place, remark, bDate) ";
		$query .= "VALUES ('', '" . $name . "', '" . $staffId . "', " . $place . ", '" . $remark . "', '" . $date . "')";
		mysql_query("SET NAMES 'utf8'"); 
		$e = mysql_query($query);
		echo "<script>alert('" . $name . "(" . $staffId . ")订餐成功! 取消订单需要输入工号, 请牢记!');</script>";
	}
} else if (isset($_POST['canId']) && isset($_POST['canName'])) {
	$id = trim($_POST['canId']);
	$name = trim($_POST['canName']);
	$nowtime = date("G");
	if ($nowtime >= $deadline) {
		$flag = false;
	} else {
		$checkSql = "SELECT * FROM supper WHERE staffId = '" . $id . "' AND name = '" . $name . "' AND bDate = '" . $date . "'";
		mysql_query("SET NAMES 'utf8'"); 
		$result = mysql_query($checkSql);
		$flag = true; //取消订单成功
		$num = mysql_num_rows($result);
		if ($num > 0) {
			$cancelSql = "DELETE FROM supper WHERE staffId = '" . $id . "' AND bDate = '" . $date . "'";
			mysql_query("SET NAMES 'utf8'"); 
			mysql_query($cancelSql);
		} else {
			$flag = false;
		}
	}
	
	if ($flag) {
		echo "<script>alert('取消订餐成功! ');</script>";
	} else {
		echo "<script>alert('取消订餐失败, 请检查您输入的工号, 姓名.已经超过可以取消订餐的时间!');</script>";
	}
}

$placeSql = "SELECT * FROM supperplace WHERE project_id = " . $projectId;

function dealRemark ($str) {
	$keyword_arr = array ('<' => '&lt;', '>' => '&gt;', "'" => "&apos;");
	$str = strtr($str, $keyword_arr);
	return $str;
}
?>

<!DOCTYPE html
PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" 
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
	<meta http-equiv="content-Type" content="text/html; charset=utf-8">
	<link rel="stylesheet" type="text/css" href="supperMain.css" />
    <title>天道酬饭</title>
</head>
<body background='bg.png'>
<div class="logoDiv">
	<img src="fan.gif" alt="加班订餐系统" />
</div>
<div class="main">
	<div class='leftPart'>
	<div class='order'>
	<?php
		$nowTime = date("G");
		if ($nowTime >= $deadline) {
			echo "<p align='center'>今日订餐统计已结束!</p>";
		} else {
	?>
    <form action='' method='post' name='today' id='today'>
		<table>
			<tr>
				<td>姓名:</td>
				<td><input type='text' name='name' id='staffName' /></td>
			</tr>
			<tr>
				<td>员工号:</td>
				<td><input type='text' name='staffId' id='staffId' /></td>
			</tr>
			<tr>
				<td>工作地:</td>
				<td>
				<select id='placeSel'>
					<?php
						//查询订餐地点和名称
						
						mysql_query("SET NAMES 'utf8'");
						$placeResult = mysql_query($placeSql);
						if (mysql_num_rows($placeResult) > 0) {
							while ($row = mysql_fetch_array($placeResult)) {
								echo "<option value='" . $row['place_id'] . "'>" . $row['place_name'] . "</option>";
							}
						} else {
							echo "<option value='98' selected>上海CRM项目</option>";
						}
					?>
					
				</select>
				</td>
			</tr>
			<tr>
				<td>备注:</td>
				<td><input type='text' name='remark' id='remark' /></td>
			</tr>
		</table>
		<?php
			echo "<input type='hidden' name='bDate' value='" . $date . "'/>";
		?>
		<input type='hidden' name='place' id='place'/>
		<input type='button' value='我发誓我会加班到凌晨!' onclick='subOrd();'/>
    </form>
	注: 请在每天11:00之前填写!
	<?php
		}
	?>
	</div>
	</div>
	<div class='ordList'>
	<?php
		echo $month . "月" . $day . "日订餐情况统计:";
	?>
		<table class="ordTable" border="1">
			<tr>
				<td width="100">总计:</td>
				<td align="center">共 <b>
				<?php
					$countSql = "SELECT count(*) as c FROM supper WHERE bDate = '" . $date . "' AND place in (SELECT place_id FROM supperplace WHERE project_id = " . $projectId . ")";
					$c1 = mysql_query($countSql);
					$count1 = mysql_result($c1, 0, "c");
					echo $count1;
				?>
				</b>份
				</td>
			</tr>
			<tr>
			<?php
				$totalSql = "SELECT COUNT(*) AS t1 FROM supper WHERE bDate = '" . $date . "' AND place in (SELECT place_id FROM supperplace WHERE project_id = " . $projectId . " and group_id = 88)";
				$tr = mysql_query($totalSql);
				$t1 = mysql_result($tr, 0, "T1");
				echo "<td></td>统计<td>88号楼共" . $t1 . "份. ";
				$totalSql = "SELECT COUNT(*) AS T1 FROM supper WHERE bDate = '" . $date . "' AND place in (SELECT place_id FROM supperplace WHERE project_id = " . $projectId . " and group_id = 56)";
				$tr = mysql_query($totalSql);
				$t1 = mysql_result($tr, 0, "T1");
				echo "56号楼共" . $t1 . "份.</td>";
			?>
			</tr>
			
			<?php
				$placeResult = mysql_query($placeSql);
				if (mysql_num_rows($placeResult) > 0) {
					while ($row = mysql_fetch_array($placeResult)) {
						$aSql = "SELECT * FROM supper WHERE bDate = '" . $date . "' AND place = " . $row['place_id'] . " ORDER BY id DESC";
						$aResult = mysql_query($aSql);
						//echo $aSql;
						echo "<tr><td>" . $row['place_name'] . "<br>共";
						echo mysql_num_rows($aResult);
						echo "份</td>";
						echo "<td><table class='ordTable' border='1'><tr><td width='70'>工号</td>";
						echo "<td width='130'>姓名</td><td width='150'>备注</td></tr>";
						while(mysql_num_rows($aResult) > 0 && $aRow = mysql_fetch_array($aResult)) {
							echo "<tr><td>*****</td><td class='tdName'>" . $aRow['name'] . "</td><td class='tdRemark'>" . $aRow['remark'] . "</td></tr>";
						}
						echo "</table></td></tr>";
					}
				}

			?>
		</table>
		<p align="right"><a href="#nogo" onclick="openFAQ();">常见问题</a></p>
		<div id="faqDiv" style="display:none;">
			如果您认为数据或页面存在问题, 请按如下建议操作:<br>
			1. 请F5刷新页面;<br>
			2. 请Ctrl+F5刷新页面;<br>
			3. 请重启浏览器;<br>
			4. 请更换浏览器;<br>
			5. 请重启电脑;<br>
			6. 请重装系统;<br>
			7. 请使用其他人的电脑, 如果还有问题, 重复1~7;
		</div>
	</div>
	<div id='footer'>
	<span style="float:right;">
	<font size="1">©2012 lazureys</font>
	</span>
	</div>
</div>
<div class= "menu">
	<!--<a href="HisOrd.php">历史查询</a><br>-->
	<!--<a href="StaffStat.php">加班统计</a><br>-->
	<a href="#nogo" onclick="cancelOrd();">取消订单</a><br>
	<!--<a href="words.php">问题反馈</a><br><br>-->
	<img src="stopie_80x15.gif" title="请使用非IE浏览器获取最佳使用效果" />
</div>


<div id="cancelOrdDiv" style="display:none;">
	<table><tr><td align="center">
	取消订单:<br>
	<form  action='' method='post' name='cOrd' id='cOrd'>
		工号: <input id="canId" type="text" name="canId" /> <br>
		姓名: <input id="canName" type="text" name="canName" /> <br>
		<input type="button" value="提交" onclick="canOrd();">&nbsp;&nbsp;
		<input type="button" value="取消" onclick="canClose();">
	</form>
	</td></tr></table>
</div>

</body>
<script type='text/javascript'>

function subOrd() {
	var name = document.getElementById("staffName").value;
	var id = document.getElementById("staffId").value;
	if (name == null || name == '' || name.length <= 0) {
		alert("请填写姓名!");
		return;
	} else if (name.length > 14) {
		alert("对不起, 请填写您的简称!");
	}
	if (id == null || id == '' || id.length <= 0) {
		alert("请填写您的工号!");
		return;
	}
	var reg = /^\d+(\.\d+)?$/
	if (!reg.test(id)) {
		alert("请填写有效工号!");
		return;
	}
	var regChn = /^[\u4e00-\u9fa5]|[\uFE30-\uFFA0]{1,}$/
	if (!regChn.test(name)) {
		alert("请填写您的中文名字, 谢谢!");
		return;
	}
	var remark = document.getElementById("remark").value;
	var placeList = document.getElementById("placeSel");
	var place = placeList.options[placeList.selectedIndex].value;
	document.getElementById("place").value = place;
	document.today.submit();
}

function ErrInfo() {
	alert("功能建设中...");
	return;
}

function cancelOrd() {
	var status = document.getElementById("cancelOrdDiv").style.display;
	if (status == "block") {
		document.getElementById("cancelOrdDiv").style.display = "none";
	} else {
		document.getElementById("cancelOrdDiv").style.display = "block";
	}
}

function openFAQ() {
	var status = document.getElementById("faqDiv").style.display;
	if (status == "block") {
		document.getElementById("faqDiv").style.display = "none";
	} else {
		document.getElementById("faqDiv").style.display = "block";
	}
}

function canClose() {
	document.getElementById("cancelOrdDiv").style.display = "none";
}

function canOrd() {
	var name = document.getElementById("canName").value;
	var id = document.getElementById("canId").value;
	if (name.length <= 0 || id.length <= 0) {
		alert("请填写姓名和工号!");
		retrun;
	}
	document.cOrd.submit();
}
</script>
</html>
