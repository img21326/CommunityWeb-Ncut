<div class="header">
    <div class="input-group right" style="width: 20%;">
        <span class="input-group-addon">@</span>
        <input type="text" class="form-control" placeholder="名子或信箱" id="searchname">
    </div>
    <div class="search-friend-result right">
        <img id="search-ajax" src="images/ajax.gif" style="max-height: 16px;margin-left: 30%;display: none;">
        <ul class="list-group" style="display: none;">

        </ul>
    </div>
    <nav>
        <ul class="nav nav-pills pull-right">
            <li role="presentation"><a href="logout.php">登出</a></li>
        </ul>
    </nav>

    <h3 class="text-muted"><a href="index.php">資管人聯絡簿</a></h3>

</div>
<div class="jumbotron" style="width: 900px;">
    <div class="photo">
        <img style="max-width: 400px;-webkit-border-radius: 10px;-moz-border-radius: 10px;border-radius: 10px;" src="<?php echo $Auth->photo ;?>">

    </div>


    <div class="clear"></div>
    <div class="">

    </div>
    <?php include_once ('ko.php');?>
</div>