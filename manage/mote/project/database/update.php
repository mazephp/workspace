<?php
/*
|--------------------------------------------------------------------------
| home
|--------------------------------------------------------------------------
*/

$view

# 小标题
->fetch('#list-name', 'manage/database.info#update_header')
->fetch('#list-desc', 'manage/database.info#update_desc')

# form表单
->fetch('.form1@action',	'manage/database.info#action')

# 基本配置
->fetch('#key@value',		'manage/database.info#project')
->fetch('#table@value',		'manage/database.info#table') 
->fetch('#where_id@value',	'manage/database.info#id')
->fetch('#url@value',		'manage/database.info#list')

# 渲染数据
->fetch('.am-tabs-bd .am-margin-top','manage/database.update') 
 
# display
->display();
