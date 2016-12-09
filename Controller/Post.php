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
    }


    public static function showPost($start,$val){ //從哪裡開始,取幾筆
        $mysqli = Connect::conn();
        $sql = "SELECT * FROM `post` ORDER by `post_time` DESC LIMIT ".$start.",".$val;
        $result= $mysqli->query($sql);
        while ($row = $result->fetch_array()){
            $posts[] = $row;
        }
        echo json_encode($posts);  //json 取出

    }

    public static function deletePost($post_id){  //刪除
        $mysqli = Connect::conn();
        $check = self::check($post_id);
        if($check){
            $sql = "DELETE FROM `post` WHERE `post`.`post_id` = ". $post_id;
            if (!$mysqli->query($sql)) {  //讀取錯誤訊息&&傳送資料
                printf("Errormessage: %s\n", $mysqli->error);
            }else {
                return "成功";
            }
        }else{
            return '權限不符';
        }

        unset($sqlsid);
        unset($sql);
        $mysqli->close();
    }



    public static function editPost($post_id,$request){  //修改
        $mysqli = Connect::conn();
        $check = self::check($post_id);
        if($check){
            $contact = $request['contact'];
            $sql = "UPDATE `post` SET `contact` = '".$contact."' WHERE `post`.`post_id` =".$post_id;
            if (!$mysqli->query($sql)) {  //讀取錯誤訊息&&傳送資料
                printf("Errormessage: %s\n", $mysqli->error);
            }else {
                return "成功";
            }
        }else{
            return '權限不符';
        }

        unset($sqlsid);
        unset($sql);
        $mysqli->close();
    }



    public static function check($post_id){   //查看是否為作者
        $mysqli = Connect::conn();
        $sql = "SELECT * FROM `post` WHERE `post_id` =". $post_id;
        $result= $mysqli->query($sql);
        $user = $result->fetch_object();
        if($_SESSION['sid']==$user->SID){
            return true;
        }else{
            return false;
        }
        unset($sql);
        $result->close();
        $mysqli->close();
    }
}
/*          新增文章    */
//        $post = new Post();
//        $arr = [
//            "contact" => "hi~",
//            "group" =>  "1",
//        ];
//        $post->createPost($arr);
/*          修改文章    */
//$arr =[
//'contact' => 'ne1w one',
//];
//$s = Post::editPost(2,$arr);
/*          刪除文章    */
//Post::deletePost(2);
/*          讀取文章    */
//Post::showPost($a,$b);從哪裡開始,取幾筆