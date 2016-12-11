<?php
/**
 * Created by PhpStorm.
 * User: shien
 * Date: 2016/12/7
 * Time: 下午 1:45
 */
 //
session_start();
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
            <div class="col-md-offset-3 col-md-2 ko" qw="好朋友">
                <img src="images/user.png" style="max-width: 80px;">
            </div>
            <div class="col-md-2 ko" qw="群組">
                <img src="images/team.png" style="max-width: 80px;">
            </div>
            <div class="col-md-2 ko" qw="訊息">
                <img src="images/networking.png" style="max-width: 80px;">
            </div>
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
                                ?></h4>
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
        $('.ko').mouseenter(function() {
            layer.tips($(this).attr('qw'), this, {
                tips: [3, '#78BA32']
            });
        });
    </script>

</html>

