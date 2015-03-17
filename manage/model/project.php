<?php
/*
|--------------------------------------------------------------------------
| project.php 后台管理 项目管理
|--------------------------------------------------------------------------
*/

use Robin\Cute\Project;

# 权限控制
Load::get('manage/auth.init');

class Manage_Project
{
	/**
     * get
     * 
     * @return string
     */
	public function get()
	{
		$list = Project::read();
		
		//unset($list['manage']);

		return $list;
	}
	
	/**
     * set
     * 
     * @return string
     */
	public function set()
	{
		$config = $this->get();
		$key 	= Input::get('key');
		$index 	= 'lang';
		$value	= Input::get('value');
		
		Project::update($key, $index, $value);
	}
}
