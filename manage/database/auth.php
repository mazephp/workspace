<?php
/*
|--------------------------------------------------------------------------
| auth.php 权限表
|--------------------------------------------------------------------------
*/

return array
(
	# 表名
	'name' => 'auth',
	# 显示给用户看的名称
	'lang' => '权限',
	# 数据结构
	'struct' => array
	(
		'id' 		=> 'int-11  key',
		'name' 		=> 'char-24  权限名',
		'project' 	=> 'char-24  权限所属项目',
		'table' 	=> 'char-24  权限所属表',
		'type' 		=> 'int-1 1 权限类型1页面浏览2数据库直接操作3模型操作',
		'uri' 		=> 'char-100  权限uri'
	),

	# 权限类型
	'type' => array
	(
		1 => '页面浏览',
		2 => '数据库直接操作',
		3 => '模型操作',
	),
	
	# 索引
	'index' => array
	(
		# 索引名 => 索引id
	),
	
	# request 请求接口定义
	'request' => array
	(
		# one 取一条数据
		'one' => array
		(
			# 匹配的正则或函数 必填项
			'where' => array
			(
				'uri' => '/^([A-Za-z0-9])/',
			),
			'type' => 'one',
		),
		# list 取多条数据
		'list' => array
		(
			# 匹配的正则或函数 选填项
			'option' => array
			(
				'name' => '/^([A-Za-z0-9])/',
			),
			'type' => 'all',
			'order' => array('id', 'desc'),
			//'limit' => array(100, 0),
			'page' => array(10, 'list'),
			'col' => '*|id',
		),
		
		# update
		'insert' => array
		(
			'type' => 'insert',
			'add' => array
			(
				'name' => '/^([A-Za-z0-9])/',
				'uri' => '/^([A-Za-z0-9])/',
				'project' => '/^([A-Za-z0-9])/',
				'table' => '/^([A-Za-z0-9])/',
				'type' => '/^([0-9])/',
			),
		),
		
		# update
		'update' => array
		(
			'type' => 'update',
			'where' => array
			(
				'id' => '/^([0-9])/',
			),
			'set' => array
			(
				'name' => '/^([A-Za-z0-9])/',
				'uri' => '/^([A-Za-z0-9])/',
				'project' => '/^([A-Za-z0-9])/',
				'table' => '/^([A-Za-z0-9])/',
				'type' => '/^([0-9])/',
			),
		),
		
		# delete 删除
		'delete' => array
		(
			# 匹配的正则或函数 必填项
			'where' => array
			(
				'id' => '/^([0-9])/',
			),
			'type' => 'delete',
		),
	),
);
