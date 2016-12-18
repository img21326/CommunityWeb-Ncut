<?php
/**
 * Created by PhpStorm.
 * User: shien
 * Date: 2016/12/18
 * Time: 上午 8:10
 */

include ('Connect/Connect.php');
include ('Controller/Gobal.php');
include('Controller/Auth.php');
include ('Controller/Group.php');
session_start();
$Group = new Group($_GET['id']);
$ret = $Group->delelte();
if($ret['status']){
    return redirect($_GET['page']);
}else{
    return redirect($_GET['page']."?meg=deleteGroupError");
}