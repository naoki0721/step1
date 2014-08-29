 <?php
//関数ファイルを読み込む
require_once("function.php");

//初期設定関数の呼び出し
init();

//書き込むデータを保存


if(isset($_POST["name"])){$_SESSION["name"] = $_POST["name"];}
if(isset($_POST["message"])){$_SESSION["message"] = $_POST["message"];}

//エラーチェック関数に入力した値を引数で呼び出す。
error_check($_POST["name"],$_POST["message"]);


//表示用データ保持する    
$view_name = htmlspecialchars($_SESSION["name"],ENT_QUOTES);
$check_message = htmlspecialchars($_SESSION["message"],ENT_QUOTES);
$view_body = nl2br($check_body);

// HTMLを出力する（確認画面部分)
print <<<EOF
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html" charset="EUC-JP"> 

<title>掲示板書き込み確認</title>
<style type="text/css">
    * { margin: 0px; padding: 0px; }
    body { margin-left: 10%;  margin-right: 10%; padding-bottom: 1em; color: #333333;  background-color: #E0E0E0;}
    h1 { padding: 10px; border: 1px solid  #BDBDBD;  font-size: 1.2em; color: #545454; background-color: #FFFFFF; }
    hr { display: none; }
    table { margin-bottom: 1em;  }
    dt { clear: left; float: left; width: 5em;  margin-bottom: 5px; }
    dd { margin-bottom: 5px; }
    form {margin-bottom: 1em; padding: 10px;  border-left: 1px solid #BDBDBD; border-bottom: 1px solid #BDBDBD;  border-right: 1px solid #BDBDBD; color: #333333;  background-color: #EAEAEA; }
    #name { width: 15em; }
    #submit { font-size: 1em;  margin-left: 5em; }
    .comment { padding: 10px; margin-bottom: 1em;  border: 1px solid #CBCBCB; color: #333333;  background-color: #F9F9F9;}
    .msg-label { color: #666666; background-color: transparent; }
    .msg-message {margin-left: 5em; }
    #navigation { text-align: right; }
</style>
</head>
<body>
<h1>掲示板投稿確認</h1>
<form action="add.php" method="post">
<dl class="comment">
        <dt class="msg-label">名前</dt>
        <dd class="msg-name">$view_name</dd>
        <dt class="msg-label">本文ト</dt>
        <dd class="msg-message">$view_message</dd>
</dl>
<input type="submit" value="書き込む"> 
<input type="button"  value="" onclick="location.href='form.php'">
</form>
</body>
</html>

EOF;
?>