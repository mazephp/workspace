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
->fetch(array('.am-btn-default@style', 0), '333')
->fetch(array('.am-btn-default@style', 1), 'display:none')
->fetch(array('.am-btn-default@style', 2), 'display:none') 
->fetch(array('.am-btn-default@style', 3), 'display:none')

# 隐藏搜索
->fetch('#search@style', 'display:none')

# 隐藏分页
->fetch('#page-list@style', 'display:none')


# config
->fetch(array('#list-thead th', 0), '名称')
->fetch(array('#list-thead th', 1), '内容')   
->fetch(array('#list-thead th@style', 2), 'display:none')
->fetch(array('#list-thead th@style', 3), 'display:none')     

->fetch
( 
    '#list-tbody tr',
    'manage/config.get',
    array  
    (
		'td|0' => '<{request.name}><br />双击修改<{Config::$global["temp"]["delete"]}>',                  
    
		'td|1' => array
        (
            'href' => '#',
            'class' => 'edit',
            'data-url' => '<{Url::get("config.set?file="+$v.file+"&name="+request.dir+"&md5="+$v.md5+"&key="+$v.key+"")}>', 
            'data-type' => 'textarea',
            'html' => '<{highlight_string($v.content)}><span class="edit-content" style="display:none;"><{$v.content}></span>',
        ),

        'td|2' => array
        (
            'style' => 'display:none;', 
        ),
        
        'td|3' => array
        (
            'style' => 'display:none;', 
        ),
     
    ) 
)

# display
->display();
