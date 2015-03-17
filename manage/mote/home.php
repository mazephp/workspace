<?php
/*
|--------------------------------------------------------------------------
| home
|--------------------------------------------------------------------------
*/


$view

# config
->fetch(array('#project-thead th', 0), '项目名')
->fetch(array('#project-thead th', 1), '路径')
->fetch(array('#project-thead th', 2), '访问地址')
->fetch(array('#project-thead th', 3), '操作')     

->fetch
( 
    '#project-tbody tr',
    'manage/project.get',
    array
    (
        'td|0' => array
        (
            'href' => '#',
            'class' => 'edit',
            'data-url' => '<{Url::get("project.set?key=$k")}>', 
            'html' => '<{$v["lang"]}>',
        ),

        'td|1' => '<{$v["path"]}>',   

        'td|2' => '<a href="<{Url::get("$k", true)}>" target="_blank"><{Url::get("$k", true)}></a>',
        
        'td|3' => array
        (
            'a|0' => array
            (
                'href' => '<{Url::get("project/config?key=$k")}>',
                'title' => '<{$v["lang"]}>-基本配置',
                'html' => '基本配置',
            ),

            'a|1' => array
            (
                'href' => '<{Url::get("project/database?key=$k")}>',     
                'title' => '<{$v["lang"]}>-数据库管理',
                'html' => '数据库管理',
            ),

            'a|2' => array
            (
                'href' => '<{Url::get("project/mote?key=$k")}>',
                'title' => '<{$v["lang"]}>-模板列表',
                'html' => '模板列表',
            ),
           
            'a|3' => array
            (
                'href' => '<{Url::get("project/model?key=$k")}>',
                'title' => '<{$v["lang"]}>-业务模型',
                'html' => '业务模型',   
            ),
        ),
     
    )
)


# display
->display();
