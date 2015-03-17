<?php
/*
|--------------------------------------------------------------------------
| home
|--------------------------------------------------------------------------
*/


$view

# config
->fetch('.page-header',  'manage/database.info#main')
->fetch(array('.item th', 0), '功能')
->fetch(array('.item th', 1), '结构')
->fetch(array('.item th', 2), '索引')
->fetch(array('.item th', 3), '操作')

# data
->fetch
(
    '.content tr',
    'manage/database.config',
    array
    (
        'td|0' => '<{isset($v["lang"]) ? $v["lang"] : $k}>',

        'td|1' => array 
        (
            'html' => '<a href="#">点此查看</a>', 
            'modal' => 'create struct|<{Helper::table(array("[col]","[info]",""), $v["struct"])}>', 
        ),

        'td|2' => array 
        (
            'html' => '<a href="#">点此查看</a>', 
            'modal' => 'create struct|<{Helper::table(array("[name]","[value]",""), $v["index"])}>', 
        ),
        
        'td|3' => array
        (
            'a|0' => array
            (
                'html' => '数据列表',
                'href' => '<{Url::get("project/database/list?key=".Input::get(\'key\')."&table=$k")}>', 
                'title' => 'data-list',
            ),
            'a|1' => array
            (
                'html' => '新增数据',
                'href' => '<{Url::get("project/database/update?key=".Input::get(\'key\')."&table=$k")}>', 
                'title' => 'data-update',
            ),
            'a|2' => array
            (
                'style' => 'display:none;',
            ),
            'a|3' => array
            (
                'style' => 'display:none;',
            ),
        ),
    )
)


# display
->display();
