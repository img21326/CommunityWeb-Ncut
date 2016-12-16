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
/*  好友欄位AJAX */
$('#searchname').change(function () {
$.ajax({
url: 'searchFriend.php',
type:"POST",
data: { search:this.value},
dataType: "json",
beforeSend: function() {
$('#search-ajax').show();
},
complete: function(){
$('#search-ajax').hide();
},
success: function(data){
if(data.sid!="null"){
$(".search-friend-result").html("");
$.each(data, function(i, item) {
var html = "<li class=\"list-group-item\"><img src=\""+item.photo+"\" style='margin-right:5px;max-width: 40px;-webkit-border-radius: 35px;-moz-border-radius: 35px;border-radius: 35px;'><a href=\"member.php?id="+item.sid+"\">"+item.name+"<\/a><\/li>";
        $(".search-friend-result").append(html);
        });
        $(".search-friend-result .list-group").fadeIn();
        }else{
        $(".search-friend-result").html("");
        $(".search-friend-result .list-group").fadeOut();
        }
        }});
        });

        $('#searchname').blur(function () {
        $(".search-friend-result .list-group").fadeOut();
        });
/*  end-好友欄位AJAX */
        /* 圖標TIP */
        $('.ko').mouseenter(function() {
        layer.tips($(this).attr('qw'), this, {
        tips: [3, '#78BA32']
        });
        });
        /* end圖標TIP */
<?php
$friend = new Friend();
$resu = $friend->checkInvideFriend();
if($resu){ ?>
        layer.tips('<?php echo count($resu);?>', '.goodfriend', {
        tips: [4, 'rgba(255, 10, 10, 0.75)']
        });
<?php } ?>

