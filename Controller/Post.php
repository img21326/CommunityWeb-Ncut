<?php

/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2016/12/8
 * Time: 下午 03:16
 */
class Post
{
    public $sid;
    public function __construct()
    {
        $this->sid = $_SESSION['sid'];
    }

    public function createPost($requset){   // 新增動態消息
        $mysqli = Connect::conn();
        $contact = $requset['contact'];
        $group = (isset( $requset['group'])) ? ( $requset['group']) : ("NULL");
        $sql = "INSERT INTO post (post_id, SID, contact, post_time, group_id)";
        $sql = $sql . " VALUES (NULL, '".$this->sid."', '".$contact."', CURRENT_TIMESTAMP, '".$group."');";
        if (!$mysqli->query($sql)) {  //讀取錯誤訊息&&傳送資料
            printf("Errormessage: %s\n", $mysqli->error);
        }else{
            return '成功';
        }
        unset($sql);
        $mysqli->close();
//        $post = new Post();
//        $arr = [
//            "contact" => "hi~",
//            "group" =>  "1",
//        ];
//        $post->createPost($arr);
    }

    public static function deletePost($id){
        $sql = SELECT * FROM `post` WHERE `SID` = $id
        $sql = "DELETE FROM `post` WHERE `post`.`post_id` = 6";
    }
}