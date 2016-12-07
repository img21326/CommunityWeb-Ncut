<?php
/**
 * Created by PhpStorm.
 * User: shien
 * Date: 2016/12/7
 * Time: 下午 1:45
 */
include('Controller/Auth.php');

$arr =[
    "username" => "user",
    "password" => "user",
    "name"     => "user",
    "phone"    => "0919552148",
    "email"    => "test@user.com",
];
Auth::register($arr);



