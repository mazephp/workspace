<?php
/*
|--------------------------------------------------------------------------
| home
|--------------------------------------------------------------------------
*/

# 项目列表中的管理选项：
# 数据库基本配置与数据管理、模板列表与生成、项目基本配置与管理等

$view

# 基本功能
//->fetch(array('.sidebar li', 0), '项目列表')


# 项目数据库管理
->fetch
(
    '.admin-parent',
    'manage/database.menu',  
    array
    ( 
        
        'a' => array    
		(
            'data-am-collapse' => '{target: \'#collapse-nav-<{$k}>\'}',
		),
        
        '.admin-name' => array
        (
            'html' => '<{$v["lang"]}>',
        ),
        

        /*
        ul的内容还可以这样写，但是拼写太痛苦
        'ul' => array
        (
            'id' => '#collapse-nav-<{$k}>',
            'html' => '<{foreach($v["child"] as $i => $j){echo \'<li><a href="admin-user.html" class="am-cf"><span class="am-icon-check"></span> \' . $j["lang"] . \' </a></li>\';}}>',
        ),
        */

        'ul' => array
        (
            'id' => 'collapse-nav-<{$k}>',
            # 此处实际上是个例子，处理多个classname的问题
            'class--' => ' am-in', 
            # 第一个默认打开 
            //'class++' => ' <{Helper::first("am-in", $i)}>', 
            'class++' => ' am-in', 
   
            'li' => array
            (
                 # 数据处理
                '{data}' => '$v["child"]',   
                'a' => array
                (
                    'href' => '<{Url::get("project/database/list?key=$k&table=$i")}>', 
                    'html' => '<{$j["lang"]}>',
                )
            ),
        ),
    )
)
# display
->display();
