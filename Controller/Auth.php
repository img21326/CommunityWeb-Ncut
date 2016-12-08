<?php

/**
 * Created by PhpStorm.
 * User: shien
 * Date: 2016/12/7
 * Time: 下午 1:19
 */

namespace Auth;
use Connect\Connect;

    class Auth
    {
        public function __construct()
        {

        }

        public static function register($request){ //註冊
            $mysqli = Connect::conn();
            $sql="INSERT INTO `member_data` (`SID`, `username`, `password`, `name`, `phone`, `email`, `FID`, `group_id`, `sday`, `status`) VALUES (NULL, '";
            $sql=$sql.$request['username']."', '".md5($request['password'])."','".$request['name']."','".$request['phone']."', '".$request['email']."',";
            $sql=$sql."NULL, NULL, CURRENT_TIMESTAMP,1)";
            echo $sql;
            if (!$mysqli->query($sql)) {  //讀取錯誤訊息
               printf("Errormessage: %s\n", $mysqli->error);
            }
    /*$sql="INSERT INTO `contact` (`SID`, `num_txt`, `password`, `name`, `phone`, `email`, `FID`, `group_id`, `sday`, `status`) VALUES ('".$request['SID']."', '".$request['numtxt']."', '".$request['password']."','".$request['name']."', '".$request['phone']."', '".$request['FID']."', '".$request['group_id']."', '".$request['sday']."', '".$request['status']."');";
    if($mysqli->query($sql)){
        return '成功';
    }else{
        return '失敗';
    }*/
        }

        public static function login($request){    //登入
            $mysqli = Connect::conn();
            $sql="select * from `member_data` where username='".$request['username']."' and password='".md5($request['password'])."'";
            $result= $mysqli->query($sql);
            if(($result->num_rows)==1){
                $_SESSION['SID']=$request['ID']*1;
                $_SESSION['Snum']=$request['username'];
                $_SESSION['Sname']=$request['name'];
                return '成功';
            }else{
                return '登入帳號密碼錯誤';
            }
        }
    }
