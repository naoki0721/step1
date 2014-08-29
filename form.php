 <?php
 //参考サイト　http://php.dori-mu.net/session.html
 //pho manual http://php.net/manual/ja/index.php
 //



//関数ファイルを読み込む
require_once("function.php");

//初期設定関数の呼び出し
init();

//エラーで戻ってきた場合、保存していた値をフォームに表示する
$name = htmlspecialchars($_SESSION["name"],ENT_QUOTES);
$comment = htmlspecialchars($_SESSION["comment"],ENT_QUOTES);

//エラー情報をクリアする
$error_mes = $_SESSION["error_mes"];
$_SESSION["error_mes"] = "";


/*$mysqli = new mysqli('localhost', 'root', '19930721', 'bbs');
//エラーが発生したら
if ($mysqli->connect_error){
  print("接続失敗：" . $mysqli->connect_error);
  exit();
}*/


/*if($_SERVER['SERVER_NAME'] == "localhost") {
    //ローカルの接続設定
    $mysqli = new mysqli('localhost', 'root', '19930721', 'bbs');
} else {
    */
    //XREAサーバの接続設定
    $mysqli = new mysqli('s601.xrea.com', 'naokibbs', 'am3xp5FHVER4', 'bbs');
//}





$stmt = $mysqli->prepare("INSERT INTO datas (name, message) VALUES (?, ?)");

$stmt->bind_param('ss', $_POST["name"], $_POST["message"]);

$stmt->execute();


$result = $mysqli->query("SELECT * FROM datas ORDER BY created DESC");
if($result){
  //1行ずつ取り出し
  while($row = $result->fetch_object()){
    //エスケープして表示
    $name = htmlspecialchars($row->name);
    $message = htmlspecialchars($row->message);
    $created = htmlspecialchars($row->created);
    print("$name : $message ($created)<br>");
  }
}




// HTMLを出力する（フォーム）
print <<<EOF
 <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html"
charset="EUC-JP">
<title>掲示板書き込みフォーム</title>
<style type="text/css">
    * { margin: 0px; padding: 0px; }
    body { margin-left: 10%; margin-right: 10%; 
padding-bottom: 1em; color: #333333; background-color: #E0E0E0;}
    h1 { padding: 10px; border: 1px solid #BDBDBD; 
font-size: 1.2em; color: #545454; background-color: #FFFFFF; }
    hr { display: none; }
    table { margin-bottom: 1em;  }
    dt { clear: left; float: left; width: 5em; 
margin-bottom: 5px; }
    dd { margin-bottom: 5px; }
    form {margin-bottom: 1em; padding: 10px; 
border-left: 1px solid #BDBDBD; border-bottom: 1px solid #BDBDBD; 
border-right: 1px solid #BDBDBD; color: #333333; 
background-color: #EAEAEA; }
    #name, { width: 15em; }
    #submit { font-size: 1em; margin-left: 5em; }
    .comment { padding: 10px; margin-bottom: 1em; 
border: 1px solid #CBCBCB; color: #333333; 
background-color: #F9F9F9;}
    .msg-label { color: #666666; background-color: transparent; }
    .msg-body {margin-left: 5em; }
    #navigation { text-align: right; }
</style>
</head>
<body>
<h1>掲示板</h1>
<form action="conf.php" method="post">
<dl>
    <dd><font color="#FF0000">$error_mes</font></dd>
</dl>
<dl>
    <dt><label for="name">名前</label></dt>
    <dd><input type="text" id="name" name="name" value="$name">
</dd>
   
    <dt><label for="body">本文</label></dt>
    <dd><textarea id="body" name="body" cols="40" rows="10">$body
</textarea></dd>
</dl>
<input type="submit" id="submit" value="確認">
</form>
EOF;



// HTML出力する（表示）
for($i=0;$i<10;$i++){

$data[$i]["name"] 
  = htmlspecialchars($data[$i]["name"],ENT_QUOTES);
$data[$i]["message"] 
  = nl2br(htmlspecialchars($data[$i]["message"],ENT_QUOTES));

print <<<EOF
<hr>
<dl class="comment">
        <dt class="msg-label">投稿日時</dt>
        <dd class="msg-date">{$data[$i]["date"]}</dd>
        <dt class="msg-label">名前</dt>
        <dd class="msg-name">{$data[$i]["name"]}</dd>
        <dt class="msg-label">本文</dt>
        <dd class="msg-body">{$data[$i]["message"]}</dd>
</dl>


EOF;
}

print "<hr>\n";





//100件の
    if($page["next"]) {
    print "<a href=\"./form.php?p={$page["next"]}\">過去の100件を見る</a>";
   
    for($i=0;$i<100;$i++){
    $data[$i]["name"] 
      = htmlspecialchars($data[$i]["name"],ENT_QUOTES);
    $data[$i]["message"] 
      = nl2br(htmlspecialchars($data[$i]["message"],ENT_QUOTES));
}

}



// HTMLを出力する（終わり）
print <<<EOF
</body>
</html>
EOF;

?>