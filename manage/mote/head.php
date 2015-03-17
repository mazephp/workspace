<?php
/*
|--------------------------------------------------------------------------
| home
|--------------------------------------------------------------------------
*/

$name = '后台管理';

$view

# 定义名称
->fetch('title', 					'<{Config::$global["base"]["name"]}>'. $name)
->fetch(array('meta@content', 1), 	'<{Config::$global["base"]["name"]}>' . $name)
->fetch(array('meta@content', 2), 	'<{Config::$global["base"]["name"]}>' . $name)
->fetch(array('meta@content', 3), 	'<{Config::$global["base"]["name"].Config::$global["base"]["desc"]}>')

# display
->display();
