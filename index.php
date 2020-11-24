<?
require('default.php');

//-----------------------------------------------------------
//定数
//-----------------------------------------------------------
$sn = basename($_SERVER['PHP_SELF']);
//$GLOBALS["sn"]
$strOrigTitle="";
if($_GET[act]=="")$strOrigTitle="トップ";
if($_GET[act]=="newSite")$strOrigTitle="サイト更新順";
if($_GET[act]=="allList")$strOrigTitle="登録リスト";
if($_GET[act]=="status")$strOrigTitle="ステータス";
if($_GET[act]=="planList")$strOrigTitle="次回計画";
if($_GET[act]=="newSiteForm")$strOrigTitle="サイト登録";
if($_GET[act]=="newSiteForm")$strOrigTitle="サイト登録";


?><html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <link rel="stylesheet" href="style.css">
<title><?if($strOrigTitle){print $strOrigTitle . "｜";}?>TRNSpeed｜まとめサイトのまとめ</title>
<meta name="description" content="ほかに類を見ない数のまとめサイトのまとめをやっています。更新頻度の高さを自動で判別し最適化。各記事の見出しの検索機能搭載。" />
<meta name="keywords" content="まとめサイトのまとめ,まとめ,TRNSpeed,トランスピード" />
<script language="JavaScript" type="text/JavaScript">
<!--
/****************************************************************
* 機　能： クリップボードにコピー
* 引　数： arg コピー元のオブジェクト
****************************************************************/
function CopyText(str){
    clipboardData.setData("Text", str);
    alert(str + 'をコピーしました');
}
//-->
</script>
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-17563503-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
</head>
<body bgcolor="#FFFFFF">

<script type="text/javascript"><!--
google_ad_client = "pub-1501415478223013";
/* 468x60, TRNSpeedトップ */
google_ad_slot = "0296592789";
google_ad_width = 468;
google_ad_height = 60;
//-->
</script>
<script type="text/javascript"
src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>
<center>
<div id="outline">
  <div class="header">
    <div class="counter"></div>
    <div class="t"><a href="<?=$GLOBALS[sn]?>">TRNSpeed</a><br></div>

    <div class="menu">
    <ul>
      <li><a href="<?=$GLOBALS[sn]?>">TOP</a></li>
      <li><a href="<?=$GLOBALS[sn]?>?act=newSite">NEWS</a></li>
      <li><a href="<?=$GLOBALS[sn]?>?act=allList">LIST</a></li>
      <li><a href="<?=$GLOBALS[sn]?>?act=status">STATUS</a></li>
      <li><a href="<?=$GLOBALS[sn]?>?act=planList">PLAN</a></li>
      <li><a href="<?=$GLOBALS[sn]?>?act=newSiteForm">REGIST</a></li>
      <!--<li><a href="<?=$GLOBALS[sn]?>?act=vipView">VIP</a> </li>-->
      <li><a href="mrtg/">MRTG</a> </li>
    <!--
      <li><a href="link.html">LINK</a></li>
      <li><a href="clap.html">CLAP</a></li>
    -->
    </ul>
    </div>
  </div>

<div id="inline">
<div class="main">
<div class="c">

<?

//-----------------------------------------------------------
//メイン
//-----------------------------------------------------------
if ($_GET[act] == ""){
  $act = $_POST["act"];
}else{
  $act = $_GET["act"];
}
switch ($act)
{
  case "":
    Main();
    break;

  case "status":
    status();
    break;

  case "newSiteForm":
    newSiteForm();
    break;

  case "newSiteConfirm":
    newSiteConfirm();
    break;

  case "newSiteRegist":
    newSiteRegist();
    break;

  case "newSite":
    newSite();
    break;

  case "planList":
    planList();
    break;

  case "allList":
    allList();
    break;

  case "siteAll":
    siteAll();
    break;

  case "vipView":
    vipView();
    break;

  case "wordSearch":
    wordSearch();
    break;

  case "notepad":
    notepad();
    break;

}



//-----------------------------------------------------------
//サブルーチン
//-----------------------------------------------------------


function Main(){



?>
<form method="GET" action="<?=$GLOBALS["sn"]?>">
<input type=hidden name="act" value="wordSearch">
<input type=text name="word" value="<?=$_GET[word]?>">
<input type=submit value="検索">
</form>


更新新しい順
<a href="#" onClick="javascript:_gaq.push(['_trackPageview', '/yahoo.html']);" alt="" id="btnFax">yahoo</a>
<?

require('SQLConnect.php');
$sql = "SELECT * FROM `rsstool` Order By rst_lastdatetime DESC Limit 0,20;";
//print $sql;
//SQL文を実行する
$rs = mysql_db_query($dbName,$sql);
$rsCount = mysql_num_rows($rs);		//レコード数

for ($i=0; $i<=$rsCount-1; $i++){

  $row = @mysql_fetch_array($rs);
  ?>
  <h2><a href="<?=$GLOBALS[sn]?>?act=siteAll&rst_id=<?=$row[rst_id]?>" target="_blank"><?=$row[rst_title]?></a> <a href="<?=$row[rst_url]?>" target="_blank">[Site]</a></h2>

  <?
  $sql2 = "SELECT * FROM `rssdata` Where(rsd_rstid = '" . $row[rst_id] . "') Order By rsd_datetime DESC Limit 0,5;";
  //print $sql2;
  //SQL文を実行する
  $rs2 = mysql_db_query($dbName,$sql2);
  $rsCount2 = mysql_num_rows($rs2);		//レコード数

  for ($j=0; $j<=$rsCount2-1; $j++){
    $row2 = @mysql_fetch_array($rs2);
    if(preg_match('@在日韓国人だけど@ui', $row2[rsd_title]))continue(1);

    ?>
  　　<a href="<?=$row2[rsd_url]?>" target="_blank"><?=$row2[rsd_title]?></a><br>
  <table border=0 cellpadding=3 cellspacing=1>
  <tr>
  <td>
    <span class="sub">-(<?=$row2[rsd_datetime]?>)<a href="<?=$row2[rst_url]?>" target="_blank"><?=$row2[rst_title]?></a></span><br>
  </td>
  <td>
  <?barGraph($row2[rsd_datetime])?>
  </td></tr>
  </table>

  <br>

    <?
  }


}
require('SQLClose.php');


?>

<?



}//End Function

function notepad(){


?>
<form method="GET" action="<?=$GLOBALS["sn"]?>">
<input type=hidden name="act" value="wordSearch">
<input type=text name="word" value="<?=$_GET[word]?>">
<input type=submit value="検索">
</form>


更新新しい順
<?

require('SQLConnect.php');
$sql = "SELECT * FROM `rsstool` Order By rst_lastdatetime DESC Limit 0,20;";
//print $sql;
//SQL文を実行する
$rs = mysql_db_query($dbName,$sql);
$rsCount = mysql_num_rows($rs);		//レコード数

for ($i=0; $i<=$rsCount-1; $i++){

  $row = @mysql_fetch_array($rs);
  ?>
  <br>
  ◆<a href="<?=$GLOBALS[sn]?>?act=siteAll&rst_id=<?=$row[rst_id]?>" target="_blank"><?=$row[rst_title]?></a> <a href="<?=$row[rst_url]?>" target="_blank">[Site]</a><br><br><?
  $sql2 = "SELECT * FROM `rssdata` Where(rsd_rstid = '" . $row[rst_id] . "') Order By rsd_datetime DESC Limit 0,10;";
  //print $sql2;
  //SQL文を実行する
  $rs2 = mysql_db_query($dbName,$sql2);
  $rsCount2 = mysql_num_rows($rs2);		//レコード数

  for ($j=0; $j<=$rsCount2-1; $j++){
    $row2 = @mysql_fetch_array($rs2);
    ?>　　<a href="<?=$row2[rsd_url]?>" target="_blank"><?=$row2[rsd_title]?></a><br><?
  }


}
require('SQLClose.php');


?>

<?


}//End function
function newSite(){

?>

<?
require('SQLConnect.php');
$sql = "SELECT rst_id, rst_title, rst_url, rsd_datetime, rsd_title, rsd_url FROM rsstool LEFT JOIN rssdata ON rst_id = rsd_rstid Order By rsd_datetime DESC Limit 0,300";
//print $sql;
//SQL文を実行する
$rs = mysql_db_query($dbName,$sql);
$rsCount = mysql_num_rows($rs);		//レコード数

for ($i=0; $i<=$rsCount-1; $i++){
  $row = @mysql_fetch_array($rs);
  ?>
  <a href="<?=$row[rsd_url]?>" target="_blank"><?=$row[rsd_title]?></a>
   -   <a href="<?=$GLOBALS[sn]?>?act=siteAll&rst_id=<?=$row[rst_id]?>" target="_blank"><?=$row[rst_title]?></a> <a href="<?=$row[rst_url]?>" target="_blank">[Site]</a>

  <br>
  <table border=0 cellpadding=3 cellspacing=1>
  <tr>
  <td>
    <span class="sub">-(<?=$row[rsd_datetime]?>)</span><br>
  </td>
  <td>
  <?barGraph($row[rsd_datetime])?>
  </td></tr>
  </table>
  <br>
  <?
}
require('SQLClose.php');
}//End function


function status(){

require('SQLConnect.php');
$sql = "SELECT * FROM `rsstool` Order By `rst_updatetime` DESC LIMIT 0,10;";
//print $sql;
//SQL文を実行する
$rs = mysql_db_query($dbName,$sql);
$rsCount = mysql_num_rows($rs);		//レコード数

for ($i=0; $i<=$rsCount-1; $i++){
  $row = @mysql_fetch_array($rs);
  ?>
  <?=$row[rst_updatetime]?>
   - <a href="<?=$row[rst_url]?>" target="_blank"><?=$row[rst_title]?></a>より<?=$row[rst_lastnum]?>個のデータの取得を完了しました。
   <a href="<?=$row[rst_rss]?>" target="_blank">[RSS]</a>
   <br><br>
  <?
}
require('SQLClose.php');

?>

<?
}//End function


function newSiteForm(){

?>
<h2>サイト登録</h2>
以下に登録したいサイト情報を入れてください<br>

<form method="POST" action="<?=$GLOBALS["sn"]?>">
<input type=hidden name="act" value="newSiteConfirm">
<table border=0 cellpadding=3 cellspacing=1>

<tr>
  <td>サイトURL</td>
  <td><input type=text name="rst_url" value="http://" size=70></td>
</tr>

<tr>
  <td>サイトRSS(あれば)</td>
  <td><input type=text name="rst_rss" value="http://" size=70></td>
</tr>


<tr>
  <td><input type=submit value="取得テスト"></td>
</tr>
</table>




</form>




<?
}//End function

function newSiteConfirm(){

  //URLからタイトル、RSSを割り出す
  $file = @file($_POST[rst_url]) or die("notConnected");
  $datas = join("",$file);
  //$datas = mb_convert_encoding($datas,"UTF-8",mb_detect_encoding($datas));
  $datas = mb_convert_encoding($datas,"UTF-8","ASCII,JIS,UTF-8,EUC-JP,SJIS");
  //print $datas;
  if (preg_match("/<title[^>]*>([^<]+)/i", $datas, $reg)){
    $_POST[rst_title] = $reg[1];
    print $_POST[rst_title] . "<br>";
  }else{
    die("タイトルが発見できませんでした");
  }
  if($_POST[rst_rss]){
    $isRss = true;
  }else{
    $isRss = false;
    if (!$isRss && (preg_match('/title="RSS" href="([^"]+)/i', $datas, $reg))){
      $isRss = true;
      $_POST[rst_rss] = $reg[1];
    }

    if (!$isRss && (preg_match('/<link rel="alternate" +href="([^"]+)/i', $datas, $reg))){
      $isRss = true;
      $_POST[rst_rss] = $reg[1];
    }

    if (!$isRss && (preg_match('/href="([^"]+)" title="rss"/i', $datas, $reg))){
      $isRss = true;
      $_POST[rst_rss] = $reg[1];
    }

    if (!$isRss && (preg_match('/<link [^h]+href="([^"]+)"/i', $datas, $reg))){
      $isRss = true;
      $_POST[rst_rss] = $reg[1];
    }

  }


  if (!$isRss) die("RSSが発見できませんでした");

  //$datas = preg_replace("/</","&lt;", $datas);
  //$datas = preg_replace("/>/","&gt;", $datas);


  //print $datas;


  //Request PHP
//print "POST:<BR>";
//foreach($_POST as $key => $value){
//  print $key . "：" .  $value . "<BR>" ;
//}

require('SQLConnect.php');
$sql = "SELECT * FROM `rsstool` Where(rst_title = '" . $_POST[rst_title] .  "' or rst_url = '" . $_POST[rst_url] . "' or rst_rss = '" . $_POST[rst_rss] . "');";
//print $sql;
//SQL文を実行する
$rs = mysql_db_query($dbName,$sql);
$rsCount = mysql_num_rows($rs);		//レコード数
if($rsCount){
  $row = @mysql_fetch_array($rs);
    foreach ($row as $key => $value){
      if (is_numeric($key) == False)
      {print $key . " " . $value . "<BR>\n";}
    }
    print "<BR><BR>";
  die("以上の件がかぶってます");
}
require('SQLClose.php');





  if (preg_match("/blogwatcher\.pi\.titech\.ac\.jp/", $_POST[rst_rss])) die("なんでもRSS禁止");



  //取得して比較
  $iCount = 0;
  $datas = Array();
  $file = @file($_POST[rst_rss]) or die("notConnected");

  foreach( $file as $value){
    //print htmlspecialchars($value) . "<br>";
    if (preg_match("/<item/", $value)){
      $iCount++;
      //print "---------------" . $iCount . "---------------<br>";
      continue;
    }
    if (preg_match("/<([^!>]+)>([^<]+)<\/[^>]+>/", $value, $reg)){
      $name = $reg[1];
      //print $reg[1] . " → ";
      //print $reg[2] . "<br>";
      $datas[$iCount][$name] = $reg[2];
    }
  }

  $dataCount = 0;
  foreach ($datas as $key => $value){
    //foreach ($value as $key2 => $value2){
    //  print $key2 . " : " . $value2 . "<br>";
    //}
    //print "<hr>";

    if (($value["dc:date"]=="") && ($value["pubDate"]=="")) continue;
    if ($value[link] == $_POST[rst_url])continue(1);
    if ($value[title]=="") continue;
    if ($value[link]=="") continue;
    if ($value[link]==$rst_url) continue;
    if ($value["dc:date"]=="") $value["dc:date"] = $value["pubDate"];
    $cTime = strToTime($value["dc:date"]);
    //print $bntime . " : " . $cTime;
    if ($bntime >= $cTime)continue;
    print "国際時間：" . $value["dc:date"] . "<br>";
    print "日本時間：" . date( 'Y-m-d H:i:s', $cTime ) . "<br>";
    print "タイトル：" . $value[title] . "<br>";
    print "リンク：<a href='" . $value[link] . "' target=_blank>" . $value[link] . "</a><br>";

    $dataCount++;
    print "<br><br><br>";
  }

  if($dataCount == 0 ) die("正常に取得できませんでした");
  print $dataCount . "件取得できました<br>";
  ?>
  時間などを見て、問題がないようならば登録を押下してください<br>
  <form method="POST" action="<?=$GLOBALS["sn"]?>">
  <input type=hidden name="act" value="newSiteRegist">
  <input type="hidden" name="rst_title" value="<?=$_POST[rst_title]?>">
<input type="hidden" name="rst_url" value="<?=$_POST[rst_url]?>">
<input type="hidden" name="rst_rss" value="<?=$_POST[rst_rss]?>">
<input type=submit value="登録">

  </form>

  <?

?>

<?
}//End function


function newSiteRegist(){
$_POST[rst_registdatetime] = DateNow(0);

//print DataInsertString("rsstool");
DataInsert("rsstool");

?>
登録しました<br>



<a href="<?=$GLOBALS[sn]?>?act=newSiteForm">戻る</a><br>

<IFRAME src="crawl.php" width=600 height=300 name="log" frameborder="1"></IFRAME>

<?



}//End function



function DateDiff($preTime, $nowTime){

$results = "+";
$timeData = strToTime($nowTime) - strToTime($preTime);
if(floor($timeData/(60*60*24)) != 0){
  $results .= floor($timeData/(60*60*24)) . "日";
  $timeData = $timeData%(60*60*24);
}
if(floor($timeData/(60*60)) != 0){
  $results .= floor($timeData/(60*60)) . "時間";
  $timeData = $timeData%(60*60);
}

if(floor($timeData/(60)) != 0){
  $results .= floor($timeData/(60)) . "分";
  $timeData = $timeData%(60*60);
}

//return $timeData;
return $results;

}//End function

function DateHour($preTime, $nowTime){

$results = "+";
$timeData = strToTime($nowTime) - strToTime($preTime);
$timeData = floor($timeData/(60*60));

return $timeData;

}//End function

function barGraph($hour){

$hour = DateHour($hour, DateNow(0));
$hourColor = hourToColor($hour);
//print $hour . "<br>";
//print $hourColor . "<br>";
$hour2 = $hour;
if ($hour>500)$hour2 =500;
?>
  <table border=0 cellpadding=0 cellspacing=0 margin=0>
  <tr>
  <td width="<?=$hour2+2?>" bgcolor="#FFFFFF" height=3></td>
  <td rowspan=3 valign=bottom>&nbsp;<?=$hour?>H</td>
  </tr>
  <tr>
  <td width="<?=$hour2+2?>" bgcolor="<?=$hourColor?>" height=3></td>
  </tr>
  <tr>
  <td width="<?=$hour2+2?>" bgcolor="#FFFFFF" height=3></td>
  </tr>
  </table>
<?

}//End function


function hourToColor($timeData){

//$timeData = 256-$timeData;
if ($timeData >=240){
  return "f0f0f0";
}else{

  $timeData = base_convert($timeData, 10, 16);
  $timeDataStr = "#" . $timeData . $timeData . $timeData . $timeData . $timeData . $timeData;
  return $timeDataStr;
}

}//End function

function planList(){

?>

<a href="https://px.a8.net/svt/ejp?a8mat=2TC9WD+75ACQ+D8Y+C4DVL" target="_blank" rel="nofollow">
<img border="0" width="120" height="60" alt="" src="https://www25.a8.net/svt/bgt?aid=170213917012&wid=004&eno=01&mid=s00000001717002036000&mc=1"></a>
<img border="0" width="1" height="1" src="https://www16.a8.net/0.gif?a8mat=2TC9WD+75ACQ+D8Y+C4DVL" alt=""><br>
<a href="https://px.a8.net/svt/ejp?a8mat=2TC5YU+5YXKH6+35XE+60WN5" target="_blank" rel="nofollow">
<img border="0" width="234" height="60" alt="" src="https://www28.a8.net/svt/bgt?aid=170208822361&wid=004&eno=01&mid=s00000014765001012000&mc=1"></a>
<img border="0" width="1" height="1" src="https://www11.a8.net/0.gif?a8mat=2TC5YU+5YXKH6+35XE+60WN5" alt="">
<h2>１．次回更新日が決まっていないもの</h2>
<?
require('SQLConnect.php');
$sql = "SELECT * FROM `rsstool` Where(rst_nextdatetime = '0000-00-00 00:00:00') Order By rst_id;";
//print $sql;
//SQL文を実行する
$rs = mysql_db_query($dbName,$sql);
$rsCount = mysql_num_rows($rs);		//レコード数
if($rsCount){
  for ($i=0; $i<=$rsCount-1; $i++){
    $row = @mysql_fetch_array($rs);
    ?>
    <?=$i+1?>．<a href="<?=$row[rst_url]?>"><?=$row[rst_title]?></a><br>
    <?
  }
}else{
  print "ないみたいです<br><br>";
}

require('SQLClose.php');
?>
<h2>２．次回更新日順</h2>
※次回更新日は<br>
（（クロールした時間 － 最後に更新された時間）÷ ２） ＋ クロールした時間<br>
で決まります。<br>
ほとんど更新されない記事ほど更新の頻度は下がり<br>
頻繁に更新される記事ほど更新の頻度が上がります。
<br><br>
<?
require('SQLConnect.php');
$sql = "SELECT * FROM `rsstool` Where(rst_nextdatetime <> '0000-00-00 00:00:00') Order By rst_nextdatetime;";
//print $sql;
//SQL文を実行する
$rs = mysql_db_query($dbName,$sql);
$rsCount = mysql_num_rows($rs);		//レコード数

for ($i=0; $i<=$rsCount-1; $i++){
  $row = @mysql_fetch_array($rs);
  ?>
  <?=$i+1?>．<a href="<?=$row[rst_url]?>"><?=$row[rst_title]?></a> (<?=$row[rst_nextdatetime]?>)<br>
  <?
}
require('SQLClose.php');


?>


<?
}//End function

function allList(){
?>
<h2>登録リスト</h2>

<table border=1 cellpadding=3 cellspacing=1 bgcolor=#888888>
<tr class=menu>
  <td nowrap>頻度<br>(時間/個数)</td>
  <td>取得個数</td>
  <td>タイトル</td>
  <td>URL</td>
  <td>RSS</td>
  <td>巡回日</td>
  <td>最終更新日</td>
  <td>次回更新日</td>
</tr>


<?

require('SQLConnect.php');
//$sql = "SELECT * FROM `rsstool` order by rst_num DESC;";
//$sql = "SELECT truncate(timediff( now( ) , `rst_registdatetime` ) / rst_num / (60*60),2)  AS freq, rsstool . *  FROM rsstool ORDER BY freq";
$sql = "SELECT truncate(TIME_TO_SEC(timediff( now( ) , `rst_registdatetime` )) /rst_num /(60*60), 2 )  AS freq,  rsstool . *  FROM rsstool ORDER BY freq";
//print $sql;
//SQL文を実行する
$rs = mysql_db_query($dbName,$sql);
$rsCount = mysql_num_rows($rs);		//レコード数

for ($i=0; $i<=$rsCount-1; $i++){
  $row = @mysql_fetch_array($rs);
  ?>
  <tr class=cont>
    <td nowrap align=right>
    <?
    if ($row[freq] <= 24){
      print $row[freq] . "時間/個";
      print "<br>";
      print round(24 / $row[freq]) . "個/日";
    }else{
      print number_format($row[freq]/24,2) . "日/個";
    }
    ?>
    </td>
    <td nowrap><?=$row[rst_num]?></td>
    <td nowrap><a href="<?=$GLOBALS[sn]?>?act=siteAll&rst_id=<?=$row[rst_id]?>"><?=$row[rst_title]?></a></td>
    <td nowrap><a href="<?=$row[rst_url]?>" target="_blank">[URL]</a></td>
    <td nowrap><a href="<?=$row[rst_rss]?>" target="_blank">[RSS]</td>
    <td nowrap><?=$row[rst_updatetime]?></td>
    <td nowrap><?=$row[rst_lastdatetime]?></td>
    <td nowrap><?=$row[rst_nextdatetime]?></td>
  </tr>

  <?
}
require('SQLClose.php');

?>
</table>

<?

}//End function

function siteAll(){

require('SQLConnect.php');
$sql = "SELECT * FROM `rsstool` Where(rst_id = " . $_GET[rst_id] . ");";
//print $sql;
//SQL文を実行する
$rs = mysql_db_query($dbName,$sql);
$rsCount = mysql_num_rows($rs);		//レコード数

for ($i=0; $i<=$rsCount-1; $i++){

  $row = @mysql_fetch_array($rs);
  ?>
  <h2><a href="<?=$row[rst_url]?>" target="_blank"><?=$row[rst_title]?></a></h2>

  <?
  $sql2 = "SELECT * FROM `rssdata` Where(rsd_rstid = '" . $row[rst_id] . "') Order By rsd_datetime DESC;";
  //print $sql2;
  //SQL文を実行する
  $rs2 = mysql_db_query($dbName,$sql2);
  $rsCount2 = mysql_num_rows($rs2);		//レコード数

  for ($j=0; $j<=$rsCount2-1; $j++){
    $row2 = @mysql_fetch_array($rs2);
    ?>
  　　<a href="<?=$row2[rsd_url]?>" target="_blank"><?=$row2[rsd_title]?></a><br>
  <table border=0 cellpadding=3 cellspacing=1>
  <tr>
  <td>
    <span class="sub">-(<?=$row2[rsd_datetime]?>)<a href="<?=$row2[rst_url]?>" target="_blank"><?=$row2[rst_title]?></a></span><br>
  </td>
  <td>
  <?barGraph($row2[rsd_datetime])?>
  </td></tr>
  </table>

  <br>

    <?
  }


}
require('SQLClose.php');



}//End function

function vipView(){

require('SQLConnect.php');
$sql = "SELECT * FROM `respeed` Where(res_status = 1) Order By res_per DESC Limit 0,50;";
//print $sql;
//SQL文を実行する
$rs = mysql_db_query($dbName,$sql);
$rsCount = mysql_num_rows($rs);		//レコード数

for ($i=0; $i<=$rsCount-1; $i++){
  $row = @mysql_fetch_array($rs);
  $url = "http://takeshima.2ch.net/test/read.cgi/news4vip/" . $row[res_thread_id] . "/";
  ?>
  <a href="<?=$url?>" target="_blank"><?=$row[res_title]?></a>
  (<?=$row[res_last_number]?>)
  <a href="#" onClick="CopyText('<?=$url?>')">【コピー】</a><br>

  <table border=0 cellpadding=0 cellspacing=0 margin=0>
  <tr>
  <td width="<?=$row[res_per]*8?>" bgcolor="#FFFFFF" height=3></td>
  <td rowspan=3 valign=bottom>&nbsp;<?=$row[res_per]?>res/10min</td>
  </tr>
  <tr>
  <td width="<?=$row[res_per]*8?>" bgcolor="#CCCCCC" height=3></td>
  </tr>
  <tr>
  <td width="<?=$row[res_per]*8?>" bgcolor="#FFFFFF" height=3></td>
  </tr>
  </table>


  <?

}
require('SQLClose.php');



?>

<?
}//End function


function wordSearch(){

?>
<form method="GET" action="<?=$GLOBALS["sn"]?>">
<input type=hidden name="act" value="wordSearch">
<input type=text name="word" value="<?=$_GET[word]?>">
<input type=submit value="検索">
</form>

<?

if(!$_GET[word]) die("ワードを入力してください");
require('SQLConnect.php');
$sql = "SELECT * FROM `rssdata` Where(rsd_title Like '%" . $_GET[word] . "%') Order By rsd_datetime DESC;";
//print $sql;
//SQL文を実行する
$rs = mysql_db_query($dbName,$sql);
$rsCount = mysql_num_rows($rs);		//レコード数
if(!$rsCount) die("該当はありませんでした");
?>
「<b><?=$_GET[word]?></b>」の検索結果：
<b><?=$rsCount?></b>件ヒットしました<br><br>
<?
for ($i=0; $i<=$rsCount-1; $i++){
  $row = @mysql_fetch_array($rs);
    ?>
  　　<a href="<?=$row[rsd_url]?>" target="_blank"><?=$row[rsd_title]?></a><br>
  <table border=0 cellpadding=3 cellspacing=1>
  <tr>
  <td>
    <span class="sub">-(<?=$row[rsd_datetime]?>)<a href="<?=$row[rst_url]?>" target="_blank"><?=$row[rst_title]?></a></span><br>
  </td>
  <td>
  <?barGraph($row[rsd_datetime])?>
  </td></tr>
  </table>

  <br>

    <?
}
require('SQLClose.php');



?>

<?
}//End function


?>
<br><br><br><br><br><br><br>
  <div class="boushi">
    <div class="copy">
    copyright (何がコピーライトだ) <?=substr(Datenow(0), 0, 4)?> TRNS All Rights reserved.
    </div>
  </div>

</div>
</div>
</div>
</div>

</body>
</html>
