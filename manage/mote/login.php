<?php
/*
|--------------------------------------------------------------------------
| home
|--------------------------------------------------------------------------
*/

$view

# 定义名称
->fetch('#name', '<{Config::$global["base"]["name"]."<br />".Config::$global["base"]["desc"]}>')  

# 定义尾部
->fetch('#footer', '<{Config::$global["base"]["copyright"]}>')

# 定义refer
->fetch('#refer@value', '/auth.config#refer')

# display
->display();
