<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>RSS取得</title>
</head>
<body bgcolor="#FFFFFF">
<?
require('default.php');

//-----------------------------------------------------------
//定数
//-----------------------------------------------------------
$sn = basename($_SERVER['PHP_SELF']);
//$GLOBALS["sn"]

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
}



//-----------------------------------------------------------
//サブルーチン
//-----------------------------------------------------------


function Main(){


require('SQLConnect.php');
$sql = "SELECT * FROM `rsstool` Where(rst_nextdatetime = '0000-00-00 00:00:00') Order By rst_id LIMIT 0,1;";
//$sql = "SELECT * FROM `rsstool` Where(rst_id = '140') Order By rst_id LIMIT 0,1;";

//print $sql;
//SQL文を実行する
$rs = mysql_db_query($dbName,$sql);
$rsCount = mysql_num_rows($rs);		//レコード数
if ($rsCount){ //次回がひとつでもあればそこから
  $row = @mysql_fetch_array($rs);
  $rst_id = $row[rst_id];
  $rst_rss = $row[rst_rss];
  $rst_url = $row[rst_url];
  print $row[rst_title] . "を取得します。<br>";
  print $rst_rss . "<br><br>";
  require('SQLClose.php');
}else{//次回がひとつもなければ次回予定の一番若い奴
  require('SQLClose.php');
  require('SQLConnect.php');
  $sql = "SELECT * FROM `rsstool` Where(rst_nextdatetime <> '0000-00-00 00:00:00') Order By rst_nextdatetime LIMIT 0,1;";
  // $sql = "SELECT * FROM `rsstool` Where(rst_id = 	214) Order By rst_nextdatetime LIMIT 0,1;";
  //print $sql;
  //SQL文を実行する
  $rs = mysql_db_query($dbName,$sql);
  $rsCount = mysql_num_rows($rs);		//レコード数
  $row = @mysql_fetch_array($rs);
  $rst_id = $row[rst_id];
  $rst_rss = $row[rst_rss];
  $rst_url = $row[rst_url];
  print $row[rst_title] . "を取得します。<br>";
  print "取得予定：". $row[rst_nextdatetime] . "<br>";
  print $rst_rss . "<br><br>";
  require('SQLClose.php');


}

  //最大の時間を取得
  $bntime = 0;
  require('SQLConnect.php');
  $sql = "SELECT * FROM `rssdata` Where(rsd_rstid = '" . $rst_id . "') Order By rsd_datetime DESC, rsd_id DESC Limit 0,1;";
  print $sql . "<br>";
  //SQL文を実行する
  $rs = mysql_db_query($dbName,$sql);
  $rsCount = mysql_num_rows($rs);		//レコード数
  if ($rsCount){
    $row = @mysql_fetch_array($rs);
    print $row[rsd_datetime] . "<br>";
    $bntime = strToTime($row[rsd_datetime]);
  }
  require('SQLClose.php');


  //取得して比較
  $iCount = 0;
  $datas = Array();
  $file = @file($rst_rss) or errorNotConnect($rst_id);
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
    if (($value["dc:date"]=="") && ($value["pubDate"]=="")) continue;
    if ($value[title]=="") continue;
    if ($value[link]=="") continue;
    if ($value[link]==$rst_url) continue;
    if ($value["dc:date"]=="") $value["dc:date"] = $value["pubDate"];
    $cTime = strToTime($value["dc:date"]);
    //var_dump($datas);
    //print $bntime . " : " . $cTime . "<br>";
    if ($bntime >= $cTime)continue;
    if($cTime > time())continue;


    print $value["dc:date"] . "<br>";
    print $cTime . "<br>";
    print $value[title] . "<br>";
    print $value[link] . "<br>";
    //以前取得したか確認
    require('SQLConnect.php');
    $sql = "SELECT * FROM `rssdata` Where(rsd_url = '" . $value[link] . "');";
    print $sql;
    //SQL文を実行する
    $rs = mysql_db_query($dbName,$sql);
    $rsCount = mysql_num_rows($rs);		//レコード数
    if ($rsCount !=0){
      print "すでに取り込み済み<br>";
      continue;
    }else{
      print "新規取り込み<br>";
    }
    require('SQLClose.php');


    $_POST[rsd_datetime] = date( 'Y-m-d H:i:s', $cTime );
    $_POST[rsd_rstid] = $rst_id;
    $_POST[rsd_title] = $value[title];
    $_POST[rsd_url] = $value[link];
    if(!preg_match('@更新停止のお知らせ@ui', $_POST[rsd_title])){
      print DataInsertString("rssdata") . "<br>";
      DataInsert("rssdata");
      print "記録しました<br>";
    }else{
      print "関係無いもの排除<br>";
    }
    $dataCount++;
    print "<br><br><br>";
  }



  require('SQLConnect.php');
  $sql = "SELECT count(*) as rsd_count FROM `rssdata` Where(rsd_rstid = '" . $rst_id . "');";
  //print $sql;
  //SQL文を実行する
  $rs = mysql_db_query($dbName,$sql);
  $rsCount = mysql_num_rows($rs);		//レコード数

  $row = @mysql_fetch_array($rs);
  $rsd_count = $row[rsd_count];
  require('SQLClose.php');

  //最大の時間を取得
  $bntime = 0;
  require('SQLConnect.php');
  $sql = "SELECT * FROM `rssdata` Where(rsd_rstid = '" . $rst_id . "') Order By rsd_datetime DESC, rsd_id DESC Limit 0,1;";
  //print $sql;
  //SQL文を実行する
  $rs = mysql_db_query($dbName,$sql);
  $rsCount = mysql_num_rows($rs);		//レコード数
  if ($rsCount){
    $row = @mysql_fetch_array($rs);
    $rst_lastdatetime = $row[rsd_datetime];
    $rst_nextsec = strToTime(DateNow(0)) - strToTime($row[rsd_datetime]);
    print $rst_nextsec . "秒前に取得したので";
    $rst_nextsec = abs(floor($rst_nextsec / 2));
    print $rst_nextsec . "秒後に取得に行きます。<br>";

    $rst_nextdatetime = DateNow($rst_nextsec);
    print "次回は" . $rst_nextdatetime . "予定<br>";
  }
  require('SQLClose.php');



  require('SQLConnect.php');
  $sql = "UPDATE `rsstool` SET `rst_updatetime` = '" . DateNow(0) . "', `rst_lastnum` = '" . $dataCount . "', `rst_num` = '" . $rsd_count . "', `rst_lastdatetime`='" . $rst_lastdatetime . "', rst_nextdatetime = '" . $rst_nextdatetime . "' WHERE (`rst_id` =" . $rst_id . ");";
  print $sql . "<BR><BR>";
  $c_hit = mysql_db_query($dbName,$sql) or die('UPDATE error: '.mysql_errno().', '.mysql_error());

mysql_close($dbHandle);




  print $dataCount . "件のデータを作成しました<br><br>";




//vipGet();


//zone();




}//End Function

function errorStr($str){

$_POST[rse_error] = $str;
print DataInsertString("rsserror") . "<br>";
DataInsert("rsserror") . "<br>";


exit;

}//End function

function errorNotConnect($rst_id){
print $rst_id;

//UPDATE
require('SQLConnect.php');
//24時間後にまたどうぞ
$sql = "UPDATE `rsstool` SET `rst_nextdatetime` = '" . DateNow(60*60*24) . "' WHERE (`rst_id` = " . $rst_id . ");";
print $sql . "<BR><BR>";
  $c_hit = mysql_db_query($dbName,$sql) or die('UPDATE error: '.mysql_errno().', '.mysql_error());

mysql_close($dbHandle);
exit;
}//End function

function zone(){
//現在のIPを確認
$datas = @file("http://hpguild.com/yourip.php") or die("Not Get IP");
$newip = Trim($datas[0]);
print "今のIP：" . $newip . "<br>" ;

//記録しているIPをチェック
$fp = fopen("myip.txt", "r");
$oldip = "";
while (!feof($fp)) {
    $oldip .= fgets($fp, 1024);
}
fclose ($fp);
print "記録されたIP：" . Trim($oldip) . "<br>";

if(strcmp($oldip,$newip)==0) die("同じでした");

//違ったら更新

print "違いましたので取得します。";

$URL[] = "http://dynamic.zoneedit.com/auth/dynamic.html?host=bokenote.com";
$URL[] = "http://dynamic.zoneedit.com/auth/dynamic.html?host=*.bokenote.com";
$URL[] = "http://dynamic.zoneedit.com/auth/dynamic.html?host=www.bokenote.com";
$USERNAME =  "MSasaki4";
$PASSWORD = "ugeuge";

$buf = "";
foreach($URL as $value){
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $value);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_USERPWD, $USERNAME . ":" . $PASSWORD);
  curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
  $buf .= curl_exec($ch) . "\n";
  print $buf . "<br>";
  curl_close($ch);
}
//ログ更新
$fp = fopen("ipchange.txt", "a"); // 追加モードで開く
@fwrite( $fp, $buf , strlen($buf) ); // ファイルへの書き込み
fclose($fp);

//IP変化更新
$fp = fopen("myip.txt", "w"); // 上書きモードで開く
@fwrite( $fp, $newip , strlen($newip) ); // ファイルへの書き込み
fclose($fp);

print "記録が完了しました。";





}//End function

function vipGet(){

//まず古いデータを削除
require('SQLConnect.php');
$sql = "UPDATE `respeed` SET `res_status` = '9' Where(`res_status`='1' and res_last_updatetime < '" . DateNow(-60*60) . "');";
print $sql . "<BR><BR>";
  $c_hit = mysql_db_query($dbName,$sql) or die('UPDATE error: '.mysql_errno().', '.mysql_error());

mysql_close($dbHandle);

$lines = @file('http://takeshima.2ch.net/news4vip/subject.txt'); //ファイルの内容を配列に格納。


require('SQLConnect.php');


// 配列の内容をHTMLソースに変換表示し、行番号もつけます。
foreach( $lines as $line_num => $line ) {
  $line = mb_convert_encoding($line, "UTF-8", "SJIS");
  $line = Trim($line);
  if(preg_match("/^([0-9]+)\.dat<>(.+)\(([0-9]+)\)$/", $line, $reg)){
    print $reg[1] . "<br>";
    print $reg[2] . "<br>";
    print $reg[3] . "<br>";
    print "<br>";
  }

  $sql = "SELECT * FROM `respeed` Where(res_thread_id = '" . $reg[1] . "');";
  print $sql;
  //SQL文を実行する
  $rs = mysql_db_query($dbName,$sql);
  $rsCount = mysql_num_rows($rs);		//レコード数
  if($rsCount){//ある場合は更新
    $row = @mysql_fetch_array($rs);
    $_POST[res_id] = $row[res_id];
    $_POST[res_status] = "1";
    unset ($_POST[res_thread_id]);
    unset($_POST[res_title]);
    $_POST[res_count] = $row[res_count] + 1;
    $difNum = $reg[3]*1 - $row[res_last_number];
    print "dif:" . $difNum . "<br>";
    $_POST[res_last_number] = $reg[3];
    $_POST[res_sum] = $row[res_sum] + $difNum;
    $_POST[res_per] = $_POST[res_sum] / $_POST[res_count];
    $_POST[res_detail] = $row[res_detail] . "," . $reg[3];
    $_POST[res_last_updatetime] = DateNow(0);
    print DataUpdateString("respeed") . "<br>";
    DataUpdate("respeed");

  }else{       //無い場合は新規
    $_POST[res_status] = "1";
    $_POST[res_id] = "";
    $_POST[res_thread_id] = $reg[1];
    $_POST[res_title] = mysql_escape_string($reg[2]);
    $_POST[res_count]=0;
    $_POST[res_last_number] = $reg[3];
    $_POST[res_sum] = 0;
    $_POST[res_per] = 0;
    $_POST[res_detail] = $reg[3];
    $_POST[res_last_updatetime] = DateNow(0);
    print DataInsertString("respeed");
    DataInsert("respeed");
  }


  //echo "{$line_num} : " . htmlspecialchars( $line ) . "<br>\n";
}


require('SQLClose.php');


}//End function

?>


</body>
</html>
