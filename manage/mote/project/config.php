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
->fetch(array('#list-thead th', 0), '类型')
->fetch(array('#list-thead th', 1), '名称')   
->fetch(array('#list-thead th@style', 2), 'display:none')
->fetch(array('#list-thead th@style', 3), 'display:none')     

->fetch
( 
    '#list-tbody tr',
    'manage/config.get',
    array  
    (
		'td|0' => '<{if(strstr($v,\'.\')){$config = "file";echo "文件";}else{$config = "config";echo "目录";}}>', 
    
		'td|1' => '<a href="<{Url::get("project/".$config."?key=".Input::get(\'key\')."&dir=".Input::get(\'dir\')."&name=$v")}>"><{$v}></a>',

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
