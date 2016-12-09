<?php
/**
 * Created by PhpStorm.
 * User: shien
 * Date: 2016/12/7
 * Time: 下午 1:45
 */
include ('Connect/Connect.php');
include ('Controller/Gobal.php');
include ('Controller/Auth.php');
include ('Controller/Friend.php');

session_start();
$arr =[
    "username" => "user",
    "password" => "user",
];
$s = Auth::login($arr);

$s = Friend::checkInvideFriend();
var_dump($s);




