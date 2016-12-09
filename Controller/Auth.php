<?php

/**
 * Created by PhpStorm.
 * User: shien
 * Date: 2016/12/7
 * Time: 下午 1:19
 */

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
            if (!$mysqli->query($sql)) {  //讀取錯誤訊息
               printf("Errormessage: %s\n", $mysqli->error);
            }else{
                return '成功';
            }
            unset($sql);
            $mysqli->close();
        }

        public static function login($request){    //登入
            $mysqli = Connect::conn();
            $sql="select * from `member_data` where username='".$request['username']."' and password='".md5($request['password'])."'";
            $result= $mysqli->query($sql);
            if(($result->num_rows)==1){
                $user = $result->fetch_object();
                $_SESSION['sid']=$user->SID;
                $_SESSION['username']=$user->username;
                $_SESSION['name']=$user->name;
                return '成功';
            }else{
                return '登入帳號密碼錯誤';
            }
            $result->close();
            $mysqli->close();
        }

        public static function logout(){    //登出
            $_SESSION['sid'] = "";
            $_SESSION['username']="";
            $_SESSION['name']="";
        }

        public static function check(){  //檢查是否登入
            if(isset($_SESSION['sid']))
            {
                if(($_SESSION['sid']!="")){
                    return true;
                }
            }
            else
            {
                return false;
            }
        }
    }
        /*    註冊方法  */
        //$arr =[
        //    "username" => "user",
        //    "password" => "user",
        //    "name"     => "user",
        //    "phone"    => "0919552148",
        //    "email"    => "test@user.com",
        //];
        //Auth::register($arr);

        /*     登入   */
        //$arr =[
        //    "username" => "user",
        //    "password" => "user",
        //];
        //$s = Auth::login($arr);

        /*   查看登入狀態     */
        //$s = Auth::check();


        /*      登出      */
        //Auth::logout();