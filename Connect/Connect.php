<?php

/**
 * Created by PhpStorm.
 * User: shien
 * Date: 2016/12/7
 * Time: 下午 2:56
 */

class Connect
{
    public static function conn(){
        $config = parse_ini_file('conn.ini');
        $mysqli = new mysqli($config['host'], $config['username'], $config['password'], $config['dbname']);     //主機,帳號,密碼,資
        if ($mysqli->connect_errno) {   //失敗時出現的錯誤狀況
            printf("Connect failed: %s\n", $mysqli->connect_error);
        }
        $mysqli->set_charset("utf8");
        return $mysqli;
    }
//  使用sql時將 $mysqli->query
//  SQL程式碼輸入於("")中
//  example:
//  $mysqli->query("CREATE TEMPORARY TABLE myCity LIKE City")
//  SELECT語法用法
//  $result = $mysqli->query("SELECT Name FROM City LIMIT 10")
//  參考網址：http://php.net/manual/en/class.mysqli.php
}