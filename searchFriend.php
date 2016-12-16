<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2016/12/15
 * Time: 下午 03:36
 */
session_start();
include ('Connect/Connect.php');
include('Controller/Auth.php');
include ('Controller/Gobal.php');
include ('Controller/Friend.php');
$s = Auth::check();
if(!$s){
   echo "notlogin"; //沒有登入的話,跳到登入畫面
    exit();
}else{
    $f = new Friend();
    $search = $_POST;
    $result = $f->find($search);
    if($result){
        echo json_encode($result);
    }
}
