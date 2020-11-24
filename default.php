<?
function DataInsert($tableName){



  $fields = array();
  //接続文読み込み
  require('SQLConnect.php');
  
  $sql1 = "";
  $sql2 = "";
  
  $rs = mysql_list_fields("jspeed",$tableName,$dbHandle);
  for ($i = 0; $i < mysql_num_fields($rs); $i++){
    //print mysql_fieldname($rs, $i);
    $fldname = mysql_fieldname($rs, $i);
    $sql1 .= "`" .$fldname . "`,";
    $sql2 .= "'". mysql_real_escape_string($_POST[$fldname]) . "',";
    
    //print mysql_fieldname($rs, $i) . " ";
  }
  //切断文読み込み
  require('SQLClose.php');


  
  $sql1 = Substr($sql1,0,-1);
  $sql2 = Substr($sql2,0,-1);
  $sql = "insert into `" . $tableName . "` (" . $sql1 . ")" . " VALUES (" . $sql2 . ")";
  //print $sql . "<BR><BR>";
  require('SQLConnect.php');
  //sql文を実行する
  $c_hit = mysql_db_query("jspeed",$sql) or die('error: '.mysql_errno().', '.mysql_error());
  
  //mysql_close($dbHandle);
  


}//End function

function DataInsertString($tableName){



  $fields = array();
  //接続文読み込み
  require('SQLConnect.php');
  
  $sql1 = "";
  $sql2 = "";
  
  $rs = mysql_list_fields("jspeed",$tableName,$dbHandle);
  for ($i = 0; $i < mysql_num_fields($rs); $i++){
    //print mysql_fieldname($rs, $i);
    $fldname = mysql_fieldname($rs, $i);
    $sql1 .= "`" .$fldname . "`,";
    $sql2 .= "'". mysql_real_escape_string($_POST[$fldname]) . "',";
    
    //print mysql_fieldname($rs, $i) . " ";
  }


  
  $sql1 = Substr($sql1,0,-1);
  $sql2 = Substr($sql2,0,-1);
  $sql = "insert into `" . $tableName . "` (" . $sql1 . ")" . " VALUES (" . $sql2 . ")";
  //print $sql . "<BR><BR>";
  return $sql;


}//End function



function DataUpdate($tableName){

  $Names = Array();
  foreach($_POST as $key => $value){
    array_push($Names,$key);
  }

  //接続文読み込み
  require('SQLConnect.php');
  
  $sql = "UPDATE `" . $tableName . "` SET ";
  
  $rs = mysql_list_fields("jspeed",$tableName,$dbHandle);
  $idName = mysql_fieldname($rs, 0);
  for ($i = 1; $i < mysql_num_fields($rs); $i++){
    //print mysql_fieldname($rs, $i);
    $fldname = mysql_fieldname($rs, $i);
    if (array_search($fldname,$Names) != ""){
      //$sql .= " `" . $fldname . "` = '" . mysql_real_escape_string($_POST[$fldname]) . "', ";
      $sql .= " `" . $fldname . "` = '" . addslashes($_POST[$fldname]) . "', ";
    }
    
  }
  //切断文読み込み
  require('SQLClose.php');
  $sql = substr($sql,0,-2);
  $sql .= " WHERE " . $idName . " = '" . $_POST[$idName] . "'";

  require('SQLConnect.php');
  //sql文を実行する
  //print $sql . "<BR><BR>";
    $c_hit = mysql_db_query("jspeed",$sql)
      or die('error: '.mysql_errno().', '.mysql_error());
  
  //mysql_close($dbHandle);
  


}//End function


function DataUpdateString($tableName){

  $Names = Array();
  foreach($_POST as $key => $value){
    array_push($Names,$key);
  }

  //接続文読み込み
  require('SQLConnect.php');
  
  $sql = "UPDATE `" . $tableName . "` SET ";
  
  $rs = mysql_list_fields("jspeed",$tableName,$dbHandle);
  $idName = mysql_fieldname($rs, 0);
  for ($i = 1; $i < mysql_num_fields($rs); $i++){
    //print mysql_fieldname($rs, $i);
    $fldname = mysql_fieldname($rs, $i);
    if (array_search($fldname,$Names) != ""){
      //$sql .= " `" . $fldname . "` = '" . mysql_real_escape_string($_POST[$fldname]) . "', ";
      $sql .= " `" . $fldname . "` = '" . addslashes($_POST[$fldname]) . "', ";
    }
    
  }
  $sql = substr($sql,0,-2);
  $sql .= " WHERE " . $idName . " = '" . $_POST[$idName] . "'";
  
  return $sql;
  


}//End function



function DataDelete($tableName){


  //接続文読み込み
  require('SQLConnect.php');
  
  
  $rs = mysql_list_fields("jspeed",$tableName,$dbHandle);
  $idName = mysql_fieldname($rs, 0);
  //切断文読み込み
  require('SQLClose.php');
  $sql = substr($sql,0,-2);
  $sql = "DELETE FROM `" . $tableName . "` WHERE `" . $idName . "` = '" . $_POST[$idName] . "';";

  require('SQLConnect.php');
  //sql文を実行する
  //print $sql . "<BR><BR>";
    $c_hit = mysql_db_query("jspeed",$sql)
      or die('error: '.mysql_errno().', '.mysql_error());
  
  mysql_close($dbHandle);
  


}//End function

function DataDeleteString($tableName){


  //接続文読み込み
  require('SQLConnect.php');
  
  
  $rs = mysql_list_fields("jspeed",$tableName,$dbHandle);
  $idName = mysql_fieldname($rs, 0);
  //切断文読み込み
  require('SQLClose.php');
  $sql = substr($sql,0,-2);
  $sql = "DELETE FROM `" . $tableName . "` WHERE `" . $idName . "` = '" . $_POST[$idName] . "';";

  require('SQLConnect.php');
  return $sql;
  


}//End function

Function DateNow($timeplus){

  $date_array = getdate(time()+$timeplus);
  return $date_array["year"] . "/" .
         substr ("00" . $date_array["mon"],-2) . "/" .
         substr ("00" . $date_array["mday"],-2) . " " .
         substr ("00" . $date_array["hours"],-2) . ":" .
         substr ("00" . $date_array["minutes"],-2) . ":" .
         substr ("00" . $date_array["seconds"],-2);

}//End Function

Function DateNowBar($timeplus){

  $date_array = getdate(time()+$timeplus);
  return $date_array["year"] . "_" .
         substr ("00" . $date_array["mon"],-2) . "_" .
         substr ("00" . $date_array["mday"],-2) . "_" .
         substr ("00" . $date_array["hours"],-2) . "_" .
         substr ("00" . $date_array["minutes"],-2) . "_" .
         substr ("00" . $date_array["seconds"],-2);

}//End Function


Function DateOnlyNow($timeplus){

  $date_array = getdate(time()+$timeplus);
  return $date_array["year"] . "/" .
         substr ("00" . $date_array["mon"],-2) . "/" .
         substr ("00" . $date_array["mday"],-2);

}//End Function


?>