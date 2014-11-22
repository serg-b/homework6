<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns="http://www.w3.org/1999/html">
<head>
    <meta content="text/html; charset=utf-8" http-equiv="Content-Type">
    <title>GeekHub - отримай практичні знання в сфері IT</title>
    <meta name="description"
          content="GeekHub надає можливість отримати практичні знання та навички в сфері розробки програмного забезпечення">
    <meta name="keywords" content="GeekHub, ГікХаб, Черкаси, Cherkassy">


    <link href="style.css" type="text/css" rel="stylesheet"/>
    <link rel="stylesheet" href="./css/flipclock.css">
    <link rel="stylesheet" href="/wp-content/plugins/arzamath_17th/css/jcarousel.basic.css" />
    <script type="text/javascript" src="http://userapi.com/js/api/openapi.js?34"></script>
    <script type="text/javascript" src="//vk.com/js/api/openapi.js?115"></script>
    <?php wp_head(); ?>

</head>
<body class="inner">
<div id="wrap">
    <div id="header">
        <h1><a href="/">GeekHub</a></h1>
        <?php
        $main_menu = array('container' => '', 'menu_class' => '', 'items_wrap' => '<ul class="nav">%3$s</ul>');
        wp_nav_menu($main_menu);
        ?>
        <ul class="links">
            <li class="fb"><a href="http://www.facebook.com/pages/GeekHub/158983477520070">facebook</a></li>
            <li class="vk"><a href="http://vkontakte.ru/geekhub">Вконтакте</a></li>
            <li class="tw"><a href="http://twitter.com/#!/geek_hub">twitter</a></li>
            <li class="yb"><a href="http://www.youtube.com/user/GeekHubchannel">youtube</a></li>
        </ul>
        <span class="line"></span>
    </div>

    <?php
    if (function_exists('echo_slider')) { ?>
    <div id="slider">
    <?php echo_slider() ; ?>
    </div>
    <?php } ?>

    <!-- header -->


