<?php

/**
 * Created by PhpStorm.
 * User: shien
 * Date: 2016/12/7
 * Time: 下午 1:19
 */
class Auth
    {

        public $sid;
        public $username;
        public $name;
        public $photo;
        public function __construct()
        {
            if(self::check()){
                $this->photo = $_SESSION['photo'];
                $this->name = $_SESSION['name'];
                $this->username = $_SESSION['username'];
                $this->sid = $_SESSION['sid'];

            }

        }

        public static function register($request){ //註冊
            $mysqli = Connect::conn();
            if($request['password']!=$request['checkpassword']){
                return redirect('register.php?meg=ckeckerror');
            }elseif(!self::checkusername($request['username'])){
                return redirect('register.php?meg=usernamerror');
            }
            $photopath = self::uploadPhoto($_FILES['photo'],$request['username']);
            $sql="INSERT INTO `member_data` (`SID`, `username`, `password`, `name`, `phone`, `email`,`photo`, `sday`, `status`) VALUES (NULL, '";
            $sql=$sql.$request['username']."', '".md5($request['password'])."','".$request['name']."','".$request['phone']."', '".$request['email']."','".$photopath."',";
            $sql=$sql." CURRENT_TIMESTAMP,1)";
            echo $sql;
            if (!$mysqli->query($sql)) {  //讀取錯誤訊息
               printf("Errormessage: %s\n", $mysqli->error);
            }else{
                return true;
            }
            unset($sql);
            $mysqli->close();
        }

        public static function login($request){    //登入
            $mysqli = Connect::conn();
            $sql="select * from `member_data` where username='".$request['username']."' and password='".md5($request['password'])."'";
            echo $sql;
            $result= $mysqli->query($sql);
            if(($result->num_rows)==1){
                $user = $result->fetch_object();
                $_SESSION['sid']=$user->SID;
                $_SESSION['username']=$user->username;
                $_SESSION['name']=$user->name;
                $_SESSION['photo']=$user->photo;
                return true;
            }else{
                return false;
            }
            $result->close();
            $mysqli->close();
        }

        public static function logout(){    //登出
            $_SESSION['sid'] = "";
            $_SESSION['username']="";
            $_SESSION['name']="";
            return true;
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

        public static function checkusername($username){
            $mysqli = Connect::conn();
            $sql="select * from `member_data` where username='".$username."'";
            echo $sql;
            $result= $mysqli->query($sql);
            if(($result->num_rows)==1){
                return false;
            }else{
                return true;
            }
            $result->close();
            $mysqli->close();
        }


        public static function uploadPhoto($file,$name){
            $uploaddir = 'images/';
            $uploadfile = $uploaddir . basename(rand(1111, 9999).$file['name']);
            if (move_uploaded_file($file['tmp_name'], $uploadfile)) {
                return $uploadfile;
            } else {
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