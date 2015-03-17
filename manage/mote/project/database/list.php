<?php
/*
|--------------------------------------------------------------------------
| home
|--------------------------------------------------------------------------
*/

$view

# 小标题
->fetch('#list-name', '/database.info#list_header') 
->fetch('#list-desc', '/database.info#list_desc')  

# 新增的链接 @代表属性
->fetch('#list-add@onclick', '/database.info#add')


# 设置按钮状态
->fetch(array('.am-btn-default@style', 0), '/database.info#add_state')
->fetch(array('.am-btn-default@style', 1), 'display:none')
->fetch(array('.am-btn-default@style', 2), 'display:none') 
->fetch(array('.am-btn-default@style', 3), 'display:none')
 

# 数据列表的标题 
->fetch('#list-thead th', '/database.list_thead')  

# 数据列表
->fetch('#list-tbody tr','/database.list_tbody')

# 分页
->fetch('#page','<{Helper::page("current")}>')   
 
# 总数据
->fetch('#total','<{Helper::total("current")}>')

# 将上边fetch的都显示出来
->display();
