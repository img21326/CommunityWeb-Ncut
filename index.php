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
?>

<html>
    <?php include_once ('head.php'); ?>
    <body>
    <div class="container">
        <div class="header">
            <div class="input-group right" style="width: 20%;">
                <span class="input-group-addon">@</span>
                <input type="text" class="form-control" placeholder="Username">
            </div>
            <nav>
                <ul class="nav nav-pills pull-right">
                    <li role="presentation"><a href="logout.php">登出</a></li>
                </ul>
            </nav>
            <h3 class="text-muted">資管人聯絡簿</h3>
        </div>
        <div class="jumbotron">
            <div class="photo">
                <img style="max-width: 400px;-webkit-border-radius: 10px;-moz-border-radius: 10px;border-radius: 10px;" src="<?php echo $Auth->photo ;?>">

            </div>


            <div class="clear"></div>
            <div class="">

            </div>
            <?php include_once ('ko.php');?>
        </div>
        <div class="col-md-offset-3 col-lg-7">
            <label>
                新增貼文:
            </label>

            <form method="post">
                <textarea type="text"  name ="contact" class="form-control"  rows="3" placeholder="請輸入..."></textarea>
                <input type="submit" name="button" id="button" value="送出" class="btn btn-default" style="margin-top: 5px;">
                <?php
                if(isset($_POST['button'])){
                $post = new Post();
                $post->createPost($_POST);
                } //看看是否有新增貼文
                ?>
            </form>
            <hr>
        </div>
        <div class="row marketing">
            <div class="col-md-offset-3 col-lg-7">
             <?php
                    $posts = Post::showPost(0,10);
                    if($posts){
                        foreach ($posts as $post){ ?>
                            <h4><?php echo $post['name'];
                                if(isset($post['gname'])){
                                    echo " 在 ".$post['gname']." 社團的貼文";
                                }else{
                                    echo " 在 自己 的貼文";
                                }
                                ?>
                                <div class="btn-group"  style="float: right;">
                                    <button type="button" class="btn btn-success dropdown-toggle btn-xs" data-toggle="dropdown" aria-expanded="false">選項 <span class="caret"></span></button>
                                    <ul class="dropdown-menu" role="menu">
                                        <li><a href="#">修改</a></li>
                                        <li><a href="#">刪除</a></li>
                                    </ul>
                                </div>
                            </h4>
                            <span><?php echo $post['post_time'];?></span>
                            <p><?php echo $post['contact'];?></p>
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
        <?php if(isset($_GET['meg'])){?>


        <?php } ?>
        $('.ko').mouseenter(function() {
            layer.tips($(this).attr('qw'), this, {
                tips: [3, '#78BA32']
            });
        });

        function deletecheck(post_id) {
            layer.confirm('您是如何看待前端开发？', {
                btn: ['重要','奇葩'] //按钮
            }, function(){
                location='deletePost.phpd?i='+post_id;
            }
            });
        }
    </script>

</html>

