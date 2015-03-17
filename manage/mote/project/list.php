<?php
/*
|--------------------------------------------------------------------------
| home
|--------------------------------------------------------------------------
*/


$view

# 小标题
->fetch('#list-name', '项目管理')
->fetch('#list-desc', '对项目进行线上管理')  

# 新增的链接 @代表属性
->fetch('#list-add@onclick', 'ttt')


# 设置按钮状态
->fetch(array('.am-btn-default@style', 0), 'display:none')
->fetch(array('.am-btn-default@style', 1), 'display:none')
->fetch(array('.am-btn-default@style', 2), 'display:none') 
->fetch(array('.am-btn-default@style', 3), 'display:none')

# 隐藏搜索
->fetch('#search@style', 'display:none')

# 隐藏分页
->fetch('#page-list@style', 'display:none')


# config
->fetch(array('#list-thead th', 0), '项目名')   
->fetch(array('#list-thead th', 1), '路径')
->fetch(array('#list-thead th', 2), '访问地址')
->fetch(array('#list-thead th', 3), '操作')     

->fetch
( 
    '#list-tbody tr',
    'manage/project.get',
    array  
    (
        'td|0' => array
        (
            'href' => '#',
            'class' => 'edit',
            'data-url' => '<{Url::get("project.set?key=$k")}>', 
            'data-content' => '<{$v["lang"]}>', 
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
                'href' => '<{Url::get("project/config?key=$k&type=database")}>',     
                'title' => '<{$v["lang"]}>-数据库管理',
                'html' => '数据库管理',
            ),

            'a|2' => array
            (
                'href' => '<{Url::get("project/config?key=$k&type=mote")}>',
                'title' => '<{$v["lang"]}>-模板列表',
                'html' => '模板列表',
            ),
           
            'a|3' => array
            (
                'href' => '<{Url::get("project/config?key=$k&type=doc")}>',
                'title' => '<{$v["lang"]}>-说明文档',
                'html' => '说明文档',   
            ),
        ),
     
    )
)

# display
->display();
