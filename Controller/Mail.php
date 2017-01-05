<?php

/**
 * Created by PhpStorm.
 * User: shien
 * Date: 2017/1/5
 * Time: 下午 8:14
 */
class Mail
{
    public function send($fromName,$subject,$body,$email){

        require_once('PHPMailer/PHPMailerAutoload.php'); //
        $mail= new PHPMailer(); //建立新物件
        $mail->IsSMTP(); //設定使用SMTP方式寄信
        $mail->SMTPAuth = true; //設定SMTP需要驗證
        $mail->SMTPSecure = "ssl"; // Gmail的SMTP主機需要使用SSL連線
        $mail->Host = "smtp.gmail.com"; //Gamil的SMTP主機
        $mail->Port = 465; //Gamil的SMTP主機的埠號(Gmail為465)。
        $mail->CharSet = "utf-8"; //郵件編碼
        $mail->Username = "img21326@gmail.com"; //Gamil帳號
        $mail->Password = "nini0920"; //Gmail密碼
        $mail->From = "img21326@gmail.com"; //寄件者信箱
        $mail->FromName = $fromName; //寄件者姓名
        $mail->Subject =$subject; //郵件標題
        $mail->Body =$body; //郵件內容
        $mail->IsHTML(true); //郵件內容為html
        $mail->AddAddress("$email"); //收件者郵件及名稱
        $mail->AddBCC(" "); //設定 密件副本收件者
        if(!$mail->Send()){
            echo "Error: " . $mail->ErrorInfo;
        }else{
            echo true;
        }

    }
}