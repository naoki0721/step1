<?php
//掲示板で使用する関数リスト


function init() {
    
    ini_set("output_buffering", "On");
    ini_set("output_handler", "mb_output_handler");
    ini_set("default_charset", "EUC-JP");
    mb_language("Japanese");
    mb_internal_encoding ("EUC-JP");
    mb_http_input("auto");
    mb_http_output("EUC-JP");
    mb_detect_order("auto");
    mb_substitute_character("none");
    ob_start("mb_output_handler");

    //header("Content-Type: text/html; charset=EUC-JP");
    //セッションの開始
   // session_start();
}

//エラーチェックを行う 
function error_check($name,$message) { 
    //エラーフラグ(0=エラーなし、1=エラーあり)とエラーメッセージを保存する変数 
    $error = 0; 
    $error_mes = ""; 

    //名前のエラーチェック 
    if($name == "") { 
        $error=1; 
        $error_mes .="名前を入力してください。<br>"; 
    } else if(strlen($name) > 25) { 
        $error=1; 
        $error_mes .="名前は25文字以内で入力してください。<br>"; 
    }

    //本文のエラーチェック 
    if($message == "") { 
        $error=1; 
        $error_mes .="本文を入力してください。<br>"; 
    } 
     
    //エラーがあった場合 
    if($error){ 
        //エラーチェックした内容をセッションに保存する。 
        $_SESSION["error_mes"] = $error_mes; 

        //header("Location: form.php"); 
        exit();
    } 

}

    function bbs_write() { 
    //書き込むファイル名（自分の環境に合わせた場所に変更すること)　↓
    $filename = "C:\\data\\bbs\\bbs.sql"; 

    //CSVに書き込む内容に記述されている「"」を「""」に置き換える。 
    $name = str_replace("\"", "\"\"", $_SESSION["name"]); 
    $comment = str_replace("\"", "\"\"", $_SESSION["message"]); 

    //ファイルに書き込む 
    $mes = "\"" . $name . "\",\"" . 
    $comment . "\",\"" .   
    date("Y/m/d H:i") . "\"\n"; 
    $handle = fopen($filename, "w"); 
    @fwrite($handle, $mes); 
    fclose($handle); 
    
    $_SESSION["name"] = ""; 
    $_SESSION["message"] = ""; 
} 


?>