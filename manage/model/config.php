<?php
/*
|--------------------------------------------------------------------------
| config.php 后台管理 基本配置管理
|--------------------------------------------------------------------------
*/
use Robin\Plad\Security;
# 权限控制
Load::get('manage/auth.init');

class Manage_Config
{
	/**
     * project
     *
     * @var string
     */
	private $project;

	/**
     * dir
     *
     * @var string
     */
	protected $type;

	/**
     * __construct
     * 
     * @return mixed
     */
	public function __construct()
	{
		$this->project 	= Input::get('key');
		$this->type 	= Input::get('type', 'config');
		$type = array('config', 'mote', 'database', 'doc');

		if(!in_array($this->type, $type))
		{
			Helper::out('error');
		}
	}
	
	/**
     * get
     * 
     * @return mixed
     */
	public function get()
	{
		$dir 	= Input::get('dir');
		$name 	= Input::get('name');
		
		if($dir && $name)
		{
			$dir = $dir . '/' . $name;
		}
		else
		{
			$dir = $this->type;
		}

		Input::set('dir', $dir);
		
		$result = $this->read($dir);
		
		return $result;
	}
	
	/**
     * read
     * @param string $dir
     * 
     * @return mixed
     */
	private function read($dir)
	{
		$file	= $this->dir($dir);

		if(is_dir($file))
		{
			$result = scandir($file);
			foreach($result as $k => $v)
			{
				if($v == '.' || $v == '..')
				{
					unset($result[$k]);
				}
			}
			
			return $result;
		}
		elseif(is_file($file))
		{
			Config::$global['temp']['delete'] = '';
			$data_dir = $this->dir($dir, 'data/');
			if(is_file($data_dir))
			{
				$file = $data_dir;
				$name = str_replace(ROBIN_PATH, '', $file);
				$md5 = Security::encode($name);

				$delete = Url::get('config.del?file=' . $name . '&md5=' . $md5);
				Config::$global['temp']['delete'] = '<br /><a href="'.$delete.'" class="oper_6">点此删除</a>';
			}
			else
			{
				$name = str_replace(ROBIN_PATH, '', $file);
				$md5 = Security::encode($name);
			}

			$result[] = array('content' => file_get_contents($file), 'file' => $name, 'md5' => $md5, 'key' => $this->project);
			
			return $result;
		}
	}
	
	/**
     * dir
     * @param string $dir
     * 
     * @return mixed
     */
	private function dir($dir, $path = '')
	{
		if($path)
		{
			return \Helper::path(ROBIN_PATH . $path, $this->project . '/' . $dir);
		}
		return ROBIN_PATH . $this->project . '/' . $dir;
	}

	/**
     * set 将内容写入到配置文件中（备份）
     * 
     * @return string
     */
	public function set()
	{
		$file 	= Input::get('file');
		$value	= Input::get('value');
		$name 	= Input::get('name');
		$md5	= Security::decode(Input::get('md5'));

		if($file == $md5)
		{
			$file = ROBIN_PATH . $file;
			if(is_file($file))
			{
				file_put_contents($this->dir($name, 'data/'), $value);
			}
		}

		highlight_string($value);die;
	}

	/**
     * del 删除后台建立的内容
     * 
     * @return mixed
     */
	public function del()
	{
		$file 	= Input::get('file');
		$md5	= Security::decode(Input::get('md5'));

		if(strpos($file, 'data/') !== false && $file == $md5)
		{
			$file = ROBIN_PATH . $file;
			if(is_file($file))
			{
				@unlink($file);
			}
		}

		Helper::out('yes');
	}
}
