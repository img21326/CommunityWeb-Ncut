<?php
/**
 * Created by PhpStorm.
 * User: shien
 * Date: 2017/1/5
 * Time: 下午 8:39
 */
session_start();
include ('Connect/Connect.php');
include ('Controller/Auth.php');
include ('Controller/Gobal.php');
include ('Controller/Friend.php');
include ('Controller/Mail.php');
$mail = new Mail();
$mail->send($_POST['name'],$_POST['subject'],$_POST['body'],$_POST['email']);