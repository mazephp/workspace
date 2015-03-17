<?php
/*
|--------------------------------------------------------------------------
| role.php 角色表
|--------------------------------------------------------------------------
*/
# 定义几个常用的选项
$option = array
(
	1 => '可用',
	2 => '不可用',
);
 
# 获取权限list 建议这里使用匿名函数
$auth = function()
{
	return Load::get('manage/auth.get');
};

//print_r($auth);die;

return array
(
	# 表名
	'name' => 'role',
	# 显示给用户看的名称
	'lang' => '角色',
	# 数据结构
	'struct' => array
	(
		'id' 		=> 'int-11  key',
		'name' 		=> 'char-24  角色名',
		'auth' 		=> 'char-100  权限，多个以逗号隔开',
		'state' 	=> 'int-1 1 state',
		'cdate' 	=> 'int-11  cdate',
	),
	
	# 默认值
	'default' => array
	(
		'col' => 'name,auth,state,cdate',
		'value' => array
		(
			'"系统管理员","all",1,' . time(),
		),
	),
	
	# 索引
	'index' => array
	(
		# 索引名 => 索引id
		'id' => 'id,state',
		
		# 版本号 更改版本号会更新当前表的索引，慎用
		'version' => 1,
	),

	# 管理功能
	'manage' => array
	(
		# 列表
		'list' => array
		(
			array
			(
				'col' => 'id',
				'name' => 'ID'
			),
			array
			(
				'col' => 'name',
				'name' => '角色名'
			),
			array
			(
				'col' => 'auth',
				'name' => '权限',
			),
			array
			(
				'col' => 'cdate',
				'name' => '时间',
				'value' => 'date("Y-m-d H:i:s", {col})'
			),
			array
			(
				'col' => 'manage',
				'name' => '管理',
				# 3和6 对应database类里的配置
				'value' => array(3 => '编辑', 6 => '删除'),
			),
		),
		
		# 更新
		'update' => array
		(
			array
			(
				'col' => 'name',
				'name' => '角色名称',
				'desc' => '请输入角色名称',
				'type' => 'text',
			),

			array
			(
				'col' => 'auth',
				'name' => '权限',
				'desc' => '请选择权限',
				'type' => 'checkbox',
				# 可选项
				'option' => $auth,
				# option的默认值
				'default' => 1,
			),

			array
			(
				'col' => 'state',
				'name' => '状态',
				'desc' => '请选择状态',
				'type' => 'radio',
				# 可选项
				'option' => $option,
				# option的默认值
				'default' => 1,
			),
		),
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
				'id' => '/^([0-9])/',
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
			'col' => '*',
		),

		# all 取所有数据
		'all' => array
		(
			# 匹配的正则或函数 选填项
			'option' => array
			(
				'name' => '/^([A-Za-z0-9])/',
			),
			'type' => 'all',
			'order' => array('id', 'desc'),
			'col' => '*|id',
		),
		
		# update
		'insert' => array
		(
			'type' => 'insert',
			'add' => array
			(
				'name' => '/^([A-Za-z0-9])/',
				'auth' => '/^([A-Za-z0-9])/',
				'state' => 1,
				'cdate' => time()
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
				'auth' => '/^([A-Za-z0-9])/',
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
