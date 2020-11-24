<?
//DBへ接続開始 サーバー名--localhost ユーザー名--root パスワード--root
  //過去
  $dbHandle = @mysql_connect("localhost","user","password");
//DBの接続に失敗した場合はエラー表示をおこない処理中断
if ($dbHandle == False) {
	print ("現在、調整中です。申し訳ありません。\n");
	exit;
}
$dbName ="trnspeed";
mysql_query("SET NAMES utf8", $dbHandle);


?>
