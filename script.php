<?php if(isset($_GET['meg'])){?>
    <?php if($_GET['meg']=='error'){ ?>
        layer.msg('帳號密碼錯誤', {
        offset: 't',
        anim: 6
        });
    <?php }elseif($_GET['meg']=='logout'){ ?>
        layer.msg('登出成功', {
        offset: 't',
        anim: 6
        });
    <?php }elseif($_GET['meg']=='register'){ ?>
        layer.msg('註冊成功,馬上登入~', {
        offset: 't',
        anim: 6
        });
    <?php }elseif($_GET['meg']=='nonlogin'){ ?>
        layer.msg('必須先登入,才能進入系統', {
        offset: 't',
        anim: 6
        });
    <?php }elseif($_GET['meg']=='deletefinish'){ ?>
        layer.msg('刪除成功！', {
        offset: 't',
        anim: 6
        });
    <?php }elseif($_GET['meg']=='deleterror'){ ?>
        layer.msg('出現問題！', {
        offset: 't',
        anim: 6
        });
    <?php } ?>

<?php } ?>