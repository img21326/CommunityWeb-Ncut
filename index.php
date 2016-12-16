<?php
/**
 * Created by PhpStorm.
 * User: shien
 * Date: 2016/12/7
 * Time: 下午 1:45
 */
 //
session_start();
include ('Connect/Connect.php');
include ('Controller/Auth.php');
include ('Controller/Gobal.php');
include ('Controller/Friend.php');
include ('Controller/Post.php');
$s = Auth::check();
if(!$s){
    return redirect('login.php?meg=nonlogin'); //沒有登入的話,跳到登入畫面
}else{
    $Auth = new Auth();
}
if(isset($_POST['button_post'])){
    $post = new Post();
    $post->createPost($_POST);
} //看看是否有新增貼文

if(isset($_POST['button_edit'])){
    $edit = new Post();
    $edit->editPost($_POST['post_id'],$_POST);
}
?>

<html>
    <?php include_once ('head.php'); ?>
    <body>
    <div class="container">
        <?php include_once ("header.php");?>
        <div class="col-md-offset-3 col-lg-7">
            <label>
                新增貼文:
            </label>

            <form method="post">
                <textarea type="text"  name ="contact" class="form-control"  rows="3" placeholder="請輸入..."></textarea>
                <input type="submit" name="button_post" id="button" value="送出" class="btn btn-default" style="margin-top: 5px;">
            </form>
            <hr>
        </div>
        <div class="row marketing">
            <div class="col-md-offset-3 col-lg-7">
             <?php
                    $posts = Post::showPost(0,10);

                    if($posts){
                        foreach ($posts as $post){ ?>
                            <div class="postbox" id="post-<?php echo $post['post_id'];?>">
                                <h4><img src="<?php echo $post['photo'];?>" style='margin-right:5px;max-width: 40px;-webkit-border-radius: 35px;-moz-border-radius: 35px;border-radius: 35px;'><?php echo $post['name'];
                                    if(isset($post['gname'])){
                                        echo "►".$post['gname']." 社團的貼文";
                                    }else{
//                                        echo " 在 自己 的貼文";
                                    }
                                    ?>


                                    <?php if (Post::check($post['post_id'])){ ?>
                                        <div class="btn-group"  style="float: right;">
                                            <button type="button" class="btn btn-success dropdown-toggle btn-xs" data-toggle="dropdown" aria-expanded="false">選項 <span class="caret"></span></button>
                                            <ul class="dropdown-menu" role="menu">
                                                <li><a onclick="editpost(<?php echo $post['post_id']; ?>)">修改</a></li>
                                                <li><a onclick="deletecheck(<?php echo $post['post_id']; ?>)">刪除</a></li>
                                            </ul>
                                        </div>

                                    <?php } ?>
                                </h4>
                                <span><?php echo $post['post_time'];?></span>
                                <p><?php echo $post['contact'];?></p>
                            </div>
                            <hr>
                <?php   }
                    }


                ?>


            </div>
        </div>

        <footer class="footer">
            <?php include_once ('footer.php'); ?>
        </footer>
    </div>
    </body>
    <script>
        <?php include_once ('script.php');?>
        function deletecheck(post_id) {
            layer.confirm('確定要刪除嗎？', {
                btn: ['確定','取消'] //按钮
            }, function(){
                location='deletePost.php?id='+post_id+"&page=index.php";
            });
        }
        function editpost(post_id) {
            var html = "<form method=\"post\"><input type='hidden' name='post_id' value='"+post_id+"'><textarea type=\"text\"  name =\"contact\" class=\"form-control\"  rows=\"3\">"+$("#post-"+post_id+" p").html()+"</textarea><input type=\"submit\" name=\"button_edit\" id=\"button\" value=\"送出\" class=\"btn btn-default\" style=\"margin-top: 5px;\"></form>"
            $("#post-"+post_id+" p").html(html);
        }



    </script>

</html>

