<?php

return array
(
	//'my/([0-9]+)/test/([a-zA-Z0-9]+).html' => 'project.database?id=$1&page=$2',
	
	# 数据库操作
	'project-database-([a-zA-Z0-9]+)' => 'project/database?key=$1',
	'project-database-([a-zA-Z0-9]+)-([a-zA-Z0-9]+)-list' => 'project/database/list?key=$1&table=$2',
	'project-database-([a-zA-Z0-9]+)-([a-zA-Z0-9]+)-list-([0-9]+)' => 'project/database/list?key=$1&table=$2&page=$3',
	'project-database-([a-zA-Z0-9]+)-([a-zA-Z0-9]+)-update' => 'project/database/update?key=$1&table=$2',
	'project-database-([a-zA-Z0-9]+)-([a-zA-Z0-9]+)-update-([a-zA-Z0-9]+)' => 'project/database/update?key=$1&table=$2&where_id=$3',

	# 数据更新
	'update_action' => 'database.update_action',
	
	# 登录
	'login-(.*?)' => 'login?refer=$1',

);
