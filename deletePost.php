<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2016/12/12
 * Time: 下午 02:24
 */
include ('Connect/Connect.php');
include ('Controller/Auth.php');
include ('Controller/Post.php');
$post = new Post();
echo $post->deletePost($_GET['id']);
