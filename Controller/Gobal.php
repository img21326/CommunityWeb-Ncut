<?php

/**
 * Created by PhpStorm.
 * User: shien
 * Date: 2016/12/9
 * Time: 下午 11:43
 */
    function redirect($url, $permanent = false)
    {
        if (headers_sent() === false)
        {
            header('Location: ' . $url, true, ($permanent === true) ? 301 : 302);
        }

        exit();
    }