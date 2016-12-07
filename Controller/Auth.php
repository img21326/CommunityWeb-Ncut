<?php

/**
 * Created by PhpStorm.
 * User: shien
 * Date: 2016/12/7
 * Time: 下午 1:19
 */
class Auth
{
    public static function register($request){ //註冊
        $sql="INSERT INTO `contact` (`SID`, `num_txt`, `password`, `name`, `phone`, `email`, `FID`, `group_id`, `sday`, `status`) VALUES ('".$request['SID']."', '".$request['numtxt']."', '".$request['password']."','".$request['name']."', '".$request['phone']."', '".$request['FID']."', '".$request['group_id']."', '".$request['sday']."', '".$request['status']."');";
        if(mysqli_query($sql)){
            return '成功';
        }else{
            return '失敗';
        }
    }

    public function login($request){    //登入

    }
}