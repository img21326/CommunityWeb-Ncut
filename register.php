<?php
/**
 * Created by PhpStorm.
 * User: shien
 * Date: 2016/12/11
 * Time: 上午 10:11
 */
session_start();
include ('Connect/Connect.php');
include ('Controller/Gobal.php');
include('Controller/Auth.php');
$s = Auth::check();
if($s){
    return redirect('index.php'); //沒有登入的話,跳到登入畫面
}else{
    if(isset($_POST['register'])){
        $post = Auth::register($_POST);
        if($post){
            redirect('login.php?meg=register');
        }

    }
}

?>

<html>
<?php include_once ('head.php'); ?>
<body>
<div class="container">
    <div class="header">
        <nav>
            <ul class="nav nav-pills pull-right">
                <li role="presentation"><a href="index.php">首頁</a></li>
                <li role="presentation"><a href="register.php">註冊</a></li>
            </ul>
        </nav>
        <h3 class="text-muted">資管人聯絡簿</h3>
    </div>
    <div class="jumbotron">
        <form class="form-signin" role="form"  style="width: 300px;margin-left: auto;margin-right: auto;" method="post"  enctype="multipart/form-data">
            <input type="hidden" name="register" value="true">
            <h2 class="form-signin-heading">註冊</h2>
            <label for="inputEmail" class="sr-only">帳號</label>
            <div class="input-group">
                <span class="input-group-addon"><img src="images/Gender%20Neutral%20User-64.png" style="max-width: 18px;"> </span>
                <input type="text" id="username" name="username" class="form-control" placeholder="帳號" required="true" autofocus="">
            </div>
            <label for="inputPassword" class="sr-only">密碼</label>
            <div class="input-group">
                <span class="input-group-addon"><img src="images/Password-64.png" style="max-width: 18px;"></span>
                <input type="password" id="inputPassword" name="password" class="form-control" placeholder="密碼" required="true">
            </div>
            <label for="inputPassword" class="sr-only">確認密碼</label>
            <div class="input-group">
                <span class="input-group-addon"><img src="images/Password-64.png" style="max-width: 18px;"></span>
                <input type="password" id="inputPassword" name="checkpassword" class="form-control" placeholder="確認密碼" required="true">
            </div>
            <div class="input-group">
                <span class="input-group-addon"><img src="images/user-name.png" style="max-width: 18px;"></span>
                <input type="text" id="" name="name" class="form-control" placeholder="姓名" required="true">
            </div>
            <div class="input-group">
                <span class="input-group-addon"><img src="images/smartphone.png" style="max-width: 18px;"></span>
                <input type="text" id="" name="phone" class="form-control" placeholder="電話" required="true">
            </div>
            <div class="input-group">
                <span class="input-group-addon"><img src="images/envelope.png" style="max-width: 18px;"></span>
                <input type="text" id="" name="email" class="form-control" placeholder="email" required="true">
            </div>
            <div class="custom_file_upload">
                <div class="file_upload">
                    <input type="file" id="file_upload" name="photo">
                </div>
            </div>
            <button class="btn btn-lg btn-primary btn-block" style="margin-top: 15px;" type="submit">註冊</button>
        </form>
    </div>
    <footer class="footer">
        <?php include_once ('footer.php'); ?>
    </footer>
</div>
</body>
<script>
    <?php if(isset($_GET['meg'])){?>
        <?php if($_GET['meg']=='ckeckerror'){ ?>
        layer.msg('驗證密碼錯誤！', {
            offset: 't',
            anim: 6
        });
         <?php } ?>
        <?php if($_GET['meg']=='usernamerror'){ ?>
        layer.msg('帳號已經有人使用！', {
            offset: 't',
            anim: 6
        });
        <?php } ?>
    <?php } ?>

</script>
</html>
