<?php
/**
 * Created by PhpStorm.
 * User: shien
 * Date: 2016/12/7
 * Time: 下午 1:45
 */

$mysqli = new mysqli("localhost", "root", "g46292177", "team1");     //主機,帳號,密碼,資料庫
include('Controller/Auth.php');
Auth::register();



