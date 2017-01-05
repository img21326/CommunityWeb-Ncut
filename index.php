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
include ('Controller/Leave.php');
$s = Auth::check();
if(!$s){
    return redirect('login.php?meg=nonlogin'); //沒有登入的話,跳到登入畫面
}else{
    $Auth = new Auth();
}
if(isset($_POST['button_post'])){
    $post = new Post();
    $re = $post->createPost($_POST);
    if($re){
        redirect('?meg=postfinish');
    }
} //看看是否有新增貼文

if(isset($_POST['button_edit'])){
    $edit = new Post();
    $redit = $edit->editPost($_POST['post_id'],$_POST);
    if($redit){
        redirect('?meg=editfinish');
    }else{
        redirect('?meg=editerror');
    }
}

$title = "首頁-資管人聯絡簿";
?>
<style>
    .layui-layer-dialog{
        top:120px!important;
    }
</style>
<html>
    <?php include_once ('head.php'); ?>
    <body>
    <div class="container">
        <?php include_once ("header.php");?>
        <div class="col-md-offset-2 col-lg-8">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <label>
                        新增貼文
                    </label>
                </div>
                <div class="panel-body">
                    <form method="post">
                        <textarea type="text"  name ="contact" class="form-control"  rows="3" placeholder="請輸入..."></textarea>
                        <input type="submit" name="button_post" id="button" value="送出" class="btn btn-default" style="margin-top: 5px;">
                    </form>
                </div>
            </div>
        </div>
        <div class="row marketing">
            <div class="col-md-offset-2 col-lg-8">
             <?php
                    $posts = Post::showPost(0,50);

                    if($posts){
                        foreach ($posts as $post){ ?>
                            <div class="postbox" id="post-<?php echo $post['post_id'];?>">
                                <div class="panel panel-info">
                                        <div class="panel-heading">
                                            <h4><img src="<?php echo $post['photo'];?>" style='margin-right:5px;max-width: 40px;-webkit-border-radius: 35px;-moz-border-radius: 35px;border-radius: 35px;'>
                                                <?php echo $post['name'];
                                                if(isset($post['gname'])){
                                                    echo "►".$post['gname']." 社團的貼文";
                                                }else{
    //                                        echo " 在 自己 的貼文";
                                                }
                                                ?>
                                            </h4>
                                            <span><?php echo $post['post_time'];?></span>
                                        </div>
                                        <div class="panel-body">
                                            <?php if (Post::check($post['post_id'])){ ?>
                                                <form method="post" id="edit-<?php echo $post['post_id'];?>" class="editor" style="display: none">
                                                    <input type="hidden" name="post_id" value="<?php echo $post['post_id'];?>"><textarea type="text" id="25" name="contact" class="form-control ckeditor" rows="3"><?php echo $post['contact'];?></textarea><input type="submit" name="button_edit" id="button" value="送出" class="btn btn-default" style="margin-top: 5px;"></form>
                                                <div class="btn-group"  style="float: right;">
                                                    <button type="button" class="btn btn-success dropdown-toggle btn-xs" data-toggle="dropdown" aria-expanded="false">選項 <span class="caret"></span></button>
                                                    <ul class="dropdown-menu" role="menu">
                                                        <li><a onclick="editpost(<?php echo $post['post_id']; ?>)">修改</a></li>
                                                        <li><a onclick="deletecheck(<?php echo $post['post_id']; ?>)">刪除</a></li>
                                                    </ul>
                                                </div>

                                            <?php } ?>
                                            <div class="inner"><?php echo $post['contact'];?></div>

                                            <hr>
<!--                                            --><?php // //顯示留言區
//                                                $leaves = Leave::get($post['post_id']);
//                                            ?>
<!--                                                    <ul class="list-group" style="margin-top: 5px; font-size: 8px; width: 60%;">-->
<!--                                                         --><?php
//                                                                foreach ($leaves as $leave){
//                                                        ?>
<!--                                                            <li class="list-group-item">--><?php //echo $leave['name']?><!--:--><?php //echo $leave['contact']?><!--</li>-->
<!---->
<!--                                                            --><?php
//                                                                }
//                                                            ?>
<!--                                                        <li class="list-group-item" >-->
<!--                                                            <form class="leave-form">留言:-->
<!--                                                                <img id="search-ajax-form" src="images/ajax.gif" style="max-height: 16px;margin-left: 30%;display: none;">-->
<!--                                                                <input type="text" id="leave" name="leave">-->
<!--                                                                <input type="hidden" id="post_id" name="post_id">-->
<!--                                                                <button type="submit">送出</button> </form>-->
<!--                                                        </li>-->
<!--                                                    </ul>-->
<!--                                            <form role="form">-->
<!--                                                <div class="form-group">-->
<!--                                                    <label for="exampleInputEmail1">留言</label>-->
<!--                                                    <input type="text" class="form-control" id="leave" placeholder="留言">-->
<!--                                                </div>-->
<!--                                                <button type="submit" class="btn btn-default">送出</button>-->
<!--                                            </form>-->
                                        </div>
                                </div>
                            </div>
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
        CKEDITOR.replace( 'contact' );
        <?php include_once ('script.php');?>
        function deletecheck(post_id) {
            layer.confirm('確定要刪除嗎？', {
                top: '10px',
                btn: ['確定','取消'] //按钮
            },function(){
                location='deletePost.php?id='+post_id+"&page=index.php";
            });
        }

        function editpost(post_id) {
            $("#edit-"+post_id).show();
//            var contact = $("#post-"+post_id+" .panel-body .inner").html();
//            $("#post-"+post_id+" .panel-body").html(html);
        }
        <?php
        $friend = new Friend();
        $resu = $friend->checkInvideFriend();
        if($resu){ ?>
        layer.tips('<?php echo count($resu);?>', '.goodfriend', {
            tips: [4, 'rgba(255, 10, 10, 0.75)']
        });
        <?php } ?>


    </script>

</html>

