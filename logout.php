<?php
/**
 * Created by PhpStorm.
 * User: shien
 * Date: 2016/12/11
 * Time: 上午 10:27
 */
session_start();
include ('Connect/Connect.php');
include ('Controller/Gobal.php');
include('Controller/Auth.php');
$s = Auth::check();
if(!$s){
    return redirect('login.php'); //沒有登入的話,跳到登入畫面
}else{
        $logout = Auth::logout();
        if($logout){
            return redirect('login.php?meg=logout');
        }
}