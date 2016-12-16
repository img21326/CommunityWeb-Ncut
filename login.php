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
    if(isset($_POST['login'])){
        $post = Auth::login($_POST);
        if($post){
            return redirect('index.php');
        }else{
           // return redirect('login.php?meg=error');
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
        <form class="form-signin" role="form"  style="width: 300px;margin-left: auto;margin-right: auto;" method="post">
            <input type="hidden" name="login" value="true">
            <h2 class="form-signin-heading">登入</h2>
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
            <button class="btn btn-lg btn-primary btn-block" style="margin-top: 15px;" type="submit">Sign in</button>
        </form>
    </div>
    <footer class="footer">
        <?php include_once ('footer.php'); ?>
    </footer>
</div>
</body>
<script>
    <?php include_once ('script.php');?>

</script>
</html>

