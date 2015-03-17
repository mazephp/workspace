<?php
/*
|--------------------------------------------------------------------------
| admin.php 管理员表
|--------------------------------------------------------------------------
*/
# 定义几个常用的选项
$option = array
(
	1 => '普通',
	2 => '封禁',
);

$role = function()
{
	return Load::get('manage/role-all');
};

return array
(
	# 表名
	'name' => 'admin',
	# 显示给用户看的名称
	'lang' => '管理员',
	# 数据结构
	'struct' => array
	(
		'id' 		=> 'int-11  key',
		'username' 		=> 'char-24  管理员名',
		'password' 		=> 'varchar-32  密码',
		'role' 		=> 'int-11  角色id',
		'state' 	=> 'int-1 1 state',
		'cdate' 	=> 'int-11  cdate',
	),
	
	# 默认值
	'default' => array
	(
		'col' => 'username,password,role,state,cdate',
		'value' => array
		(
			'"admin","'. md5('admin123') . '",1, 1,' . time(),
		),
	),
	
	# 索引
	'index' => array
	(
		# 索引名 => 索引id
		//'id' => 'id,state',
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
				'col' => 'username',
				'name' => '管理员账号'
			),
			array
			(
				'col' => 'role',
				'name' => '角色',
				'option' => $role,
			),
			array
			(
				'col' => 'state',
				'name' => '状态',
				'option' => $option,
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
				'col' => 'username',
				'name' => '管理员名称',
				'desc' => '请输入管理员名称',
				'type' => 'text',
			),

			array
			(
				'col' => 'password',
				'name' => '管理员密码',
				'desc' => '请输入管理员密码',
				'type' => 'password',
			),
			
			array
			(
				'col' => 'role',
				'name' => '角色',
				'desc' => '请选择角色',
				'type' => 'select',
				# 可选项
				'option' => $role,
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

		# 新增 仅仅只是开始新增按钮，默认为true
		'add' => true
	),
	
	# request 请求接口定义
	'request' => array
	(
		# one 根据用户名和密码取一条数据
		'user' => array
		(
			# 匹配的正则或函数 必填项
			'where' => array
			(
				'username' => '/^([A-Za-z0-9])/',
			),
			'type' => 'one',
		),
		# one 根据id取一条数据
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
				'username' => '/^([A-Za-z0-9])/',
			),
			'type' => 'all',
			'order' => array('id', 'desc'),
			//'limit' => array(100, 0),
			'page' => array(10, 'list'),
			'col' => '*',
		),
		
		# update
		'insert' => array
		(
			'type' => 'insert',
			'add' => array
			(
				'name' => 'is_string',
				'uri' => 'is_string',
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
				'name' => 'is_string',
				'uri' => 'is_string',
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
