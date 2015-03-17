<?php
/*
|--------------------------------------------------------------------------
| database.php 后台管理 数据库管理
|--------------------------------------------------------------------------
*/

# 权限控制
Load::get('manage/auth.init');

class Manage_Database
{
	/**
     * project
     *
     * @var string
     */
	private $project;

	/**
     * table
     *
     * @var string
     */
	private $table;

	/**
     * id
     *
     * @var string
     */
	private $id;

	/**
     * config
     *
     * @var array
     */
	private $config;

	/**
     * __construct
     * 
     * @return mixed
     */
	public function __construct()
	{
		$this->project 	= Input::get('key');

		$this->table   	= Input::get('table');

		$this->id 		= Input::get('where_id');
	}

	/**
     * menu 生成左侧的菜单 此处应加上权限来显示是否管理员有该菜单的权限
     * 
     * @return array
     */
	public function menu()
	{
		$project = Load::get('manage/project.get');

		foreach($project as $k => $v)
		{
			$config = $this->config($k);

			foreach($config as $i => $v)
			{
				if(empty($v['manage']))
				{
					unset($config[$i]);
				}
			}
			
			$project[$k]['child'] = $config;
		}

		return $project;
	}

	/**
     * url
     * 
     * @return array
     */
	private function url($key = false, $id = 0)
	{
		$url = array
		(
			0 => Url::get('project/database?key=' . $this->project),
			1 => Url::get('project/database/list?key=' . $this->project . '&table=' . $this->table),
			2 => Url::get('project/database/update?key=' . $this->project . '&table=' . $this->table),
			3 => Url::get('project/database/update?key=' . $this->project . '&table=' . $this->table . '&where_id=' . $id),
			4 => Url::get('database.update_action'),
			5 => Url::get(''),
			6 => Url::get('database.delete_action?key=' . $this->project . '&table=' . $this->table . '&where_id=' . $id),
		);

		if($key >= 0 && isset($url[$key]))
		{
			return $url[$key];
		}

		return $url;
	}

	/**
     * 获得refer 暂时无用了
     * 
     * @return string
     */
	private function refer($type = 0)
	{
		return '';

		switch($type)
		{
			case 0:
				$name = '数据库操作';
				break;
			case 1:
				$name = '数据列表';
				break;
			case 5:
				$name = '项目列表';
				break;
		}

		$name = '返回上一级';

		$url = $this->url($type);
		
		$refer = '-[<a href="'. $url .'">' . $name . '</a>]';

		return $refer;
	}

	/**
     * info 处理一些基本的信息，供mote模板使用
     * 
     * @return array
     */
	public function info()
	{
		$this->config();

		$menu = isset($this->config['lang']) ? $this->config['lang'] : $this->project . '-' . $this->table;

		$display = '';
		if(isset($this->config['manage']['add']) && $this->config['manage']['add'] == false)
		{
			$display = 'display:none';
		}

		$info = array
		(
			'action' 			=> $this->url(4),
			'list' 				=> $this->url(1),
			'add' 				=> 'location.href=\'' . $this->url(2) . '\'',
			'add_state'			=> $display,

			'project' 			=> $this->project,
			'table' 			=> $this->table,
			'id' 				=> $this->id,
			'main' 				=> '数据管理' . $this->refer(5),

			'list_header' 		=> $menu,
			'list_desc' 		=> '数据列表',
			'update_header' 	=> $menu,
			'update_desc' 		=> '新增数据',
		);

		if($this->id > 0)
		{
			$info['update_header'] = $menu . '-更新数据' . $this->refer(1);
		}

		return $info;
	}

	/**
     * config
     * 
     * @return array
     */
	public function config($project = false)
	{
		$this->config = array();

		$table = '';

		if(!$project)
		{
			$project 	= $this->project;
			$table 		= $this->table;
		}
		

		if($project && !$this->config)
		{
			$path = ROBIN_PATH . $project . '/database/';

			$database = scandir($path);

			foreach($database as $k => $v)
			{
				if(strpos($v, '.php') !== false)
				{
					$k = str_replace('.php', '', $v);
					if($table && $table == $k)
					{
						$this->config = include($path . $v);
					}
					else
					{
						$this->config[$k] = include($path . $v);
					}
				}
			}
		}

		return $this->config;
	}

	/**
     * list_thead
     * 
     * @return array
     */
	public function list_thead()
	{
		$this->config();

		$result = array();

		if(isset($this->config['manage']))
		{
			foreach($this->config['manage']['list'] as $k => $v)
			{
				$result[] = $v['name'];
			}
		}

		return $result;
	}

	/**
     * list_thead
     * 
     * @return array
     */
	public function list_tbody()
	{
		$this->config();

		$result = array();

		$method = $this->project . '/' . $this->table . '-list';

		$data = Load::get($method);

		//print_r($data);die;
		//print_r(Helper::page("current"));die;

		if($data && isset($this->config['manage']))
		{
			foreach($data as $k => $v)
			{
				$result[$k] = '<tr>';

				foreach($this->config['manage']['list'] as $ki => $vi)
				{
					if(isset($v[$vi['col']]) && $v[$vi['col']])
					{
						if(isset($vi['value']))
						{
							$eval = '$value = ' . str_replace('{col}', $v[$vi['col']], $vi['value']) . ';';

							eval($eval);

							if($value) $v[$vi['col']] = $value;
						}
						elseif(isset($vi['modal']))
						{
							$v[$vi['col']] = '<a href="#" data-am-modal="{target: \'#robin_modal\'}" onclick="$(\'#robin_modal_body\').html($(this).next().html())">' . $vi['modal'] . '</a><div style="display:none;">' . $v[$vi['col']] . '</div>';
						}
						elseif(isset($vi['option']))
						{
							# 验证option是否是匿名函数
							$vi['option'] = $this->option($vi['option']);
							if(isset($vi['option'][$v[$vi['col']]]) && is_array($vi['option'][$v[$vi['col']]]))
							{
								$v[$vi['col']] = $vi['option'][$v[$vi['col']]]['name'];
							}
							else
							{
								$v[$vi['col']] = $vi['option'][$v[$vi['col']]];
							}
						}

						$result[$k] .= '<td>' . $v[$vi['col']] . '</td>';
					}
					elseif($vi['col'] == 'manage' && isset($vi['value']) && is_array($vi['value']))
					{
						$result[$k] .= '<td>';

						foreach($vi['value'] as $kj => $vj)
						{
							$h = '<span class="am-icon-pencil-square-o"></span>';
							if($vj == '删除')
							{
								$h = '<span class="am-icon-trash-o"></span>';
							}
							$result[$k] .= '<a href="' . $this->url($kj, $v['id']) . '" class="oper_' . $kj . '"><button class="am-btn am-btn-default am-btn-xs am-text-secondary">' . $h . $vj . '</button></a>&nbsp;&nbsp;';
						}
						$result[$k] .= '</td>';
						
					}
				}

				$result[$k] .= '</tr>';
			}
		}

		return $result;
	}

	/**
     * update
     * 
     * @return array
     */
	public function update()
	{
		$this->config();

		$result = array();

		$prefix = 'add';

		if($this->id > 0)
		{
			$data = $this->load();

			$prefix = 'set';
		}

		//print_r($data);die;

		foreach($this->config['manage']['update'] as $k => $v)
		{
			$result[$k] = '<div class="am-g am-margin-top">';

			if(isset($v['name']))
			{
				$result[$k] .= '<div class="am-u-sm-4 am-u-md-2 am-text-right">' . $v['name'] . '<br />' . $v['col'] . '</div>';
			}

			if(isset($v['type']))
			{
				$v['value']= '';
				if(isset($data[$v['col']]))
				{
					$v['value'] = $data[$v['col']];
				}

				$v['name'] = $prefix . '_' . $v['col'];

				$method = 'html_' . $v['type'];

				# 验证option是否是匿名函数
				if(isset($v['option']))
				{
					$v['option'] = $this->option($v['option']);
				}
				
				$result[$k] .= $this->{$method}($v);

				if(isset($v['desc']) && ($v['type'] == 'text' || $v['type'] == 'password'))
				{
					$result[$k] .= '<div class="am-hide-sm-only am-u-md-6">' . $v['desc'] . '</div>';
				}
			}

			

			$result[$k] .= '</div>';
		}

		//print_r($result);die;

		return $result;
	}

	/**
     * update_action
     * 
     * @return array
     */
	public function update_action()
	{
		//print_r($_POST);die;
		$method = 'insert';

		if($this->id > 0)
		{
			$method = 'update';
		}

		$this->load($method);

		Helper::out('yes');
	}

	/**
     * delete_action
     * 
     * @return array
     */
	public function delete_action()
	{
		$this->load('delete');

		//$this->url(1)

		Helper::out('yes');
	}


	/**
     * load
     * 
     * @return mixed
     */
	private function load($method = 'one')
	{
		return Load::get($this->project . '/' . $this->table . '-' . $method);
	}


	/**
     * html 
     * 
     * @return string
     */

	/**
     * html_textarea
     * 
     * @return string
     */
	private function html_textarea($param)
	{
		return '<div class="am-u-sm-8 am-u-md-4 am-u-end"><textarea class="am-input-sm" name="' . $param['name'] . '">' . $param['value'] . '</textarea></div>';
	}

	/**
     * html_image
     * 
     * @return string
     */
	private function html_image($param)
	{
		return '<div class="am-u-sm-8 am-u-md-4"><input type="file" class="am-input-sm"value="' . $param['value'] . '" name="' . $param['name'] . '"/></div>';
	}

	/**
     * html_upload
     * 
     * @return string
     */
	private function html_upload($param)
	{
		return '<div class="am-u-sm-8 am-u-md-4"><input type="file" class="am-input-sm" value="' . $param['value'] . '" name="' . $param['name'] . '"/></div>';
	}

	/**
     * html_editor
     * 
     * @return string
     */
	private function html_editor($param)
	{
		return '<div class="am-u-sm-12 am-u-md-10"><textarea id="container" name="' . $param['name'] . '" rows="8" >' . $param['value'] . '</textarea></div>';
	}

	/**
     * html_radio
     * 
     * @return string
     */
	private function html_radio($param, $type = '')
	{
		$html = '';

		if(isset($param['option']))
		{
			if(isset($param['option']['state']) && $param['option']['state'] = 1)
			{
				$param['value'] = explode(',', $param['value']);
				# 处理比较复杂的多维数组
				unset($param['option']['state']);

				foreach($param['option'] as $k => $v)
				{
					$check = '';
					//{check}
					$html .= '<input class="checkbox-checkall" type="' . $param['type'] . '" name="temp[]" value="' . $k . '"/> ' . $v['name'] . ' &nbsp;&nbsp;<br />';

					$span = array('','');

					if(isset($v['data']) && $v['data'])
					{
						foreach($v['data'] as $ki => $vi)
						{
							if(isset($v['url']))
							{
								$span = array('<span class="edit" data-url="'.Url::get($v['url'] . '?id=' . $vi['id']).'">', '</span>');
							}
							if((in_array($ki, $param['value'])) || (empty($param['value']) && isset($param['default']) && (in_array($ki, $param['default']))))
							{
								$check = 'checked';
							}

							$html .= '<input class="checkbox-checkall-' . $k . '" type="' . $param['type'] . '" name="' . $param['name'] . '[]" value="' . $ki . '" '.$check.'/> ' . $span[0] . $vi['name'] . $span[1]  . '[' . $vi['id'] . ']&nbsp;&nbsp;';
						}

						$html .= '<br />';
					}

					$html .= '<br />';
				}
			}
			else
			{
				foreach($param['option'] as $k => $v)
				{
					$check = '';

					if(($param['value'] == $k) || (empty($param['value']) && isset($param['default']) && $param['default'] == $k))
					{
						$check = 'checked';
					}

					if(is_array($v))
					{
						$value = $v['name'];
					}
					else
					{
						$value = $v;
					}
					$html .= '<input type="' . $param['type'] . '" name="' . $param['name'] . '" value="' . $k . '" '.$check.'/> ' . $value . ' &nbsp;&nbsp;';
				}
			}
		}
		return '<div class="am-btn-group" >' . $html . '</div>';
	}

	/**
     * html_select
     * 
     * @return string
     */
	private function html_select($param)
	{
		$html = '<div class="am-u-sm-8 am-u-md-4"><select data-am-selecteds="{btnSize: \'sm\'}" name="' . $param['name'] . '">';

		if(isset($param['option']))
		{
			foreach($param['option'] as $k => $v)
			{
				$check = '';

				if(($param['value'] == $k) || (empty($param['value']) && isset($param['default']) && $param['default'] == $k))
				{
					$check = 'selected';
				}

				if(is_array($v))
				{
					$value = $v['name'];
				}
				else
				{
					$value = $v;
				}

				$html .= '<option value="' . $k . '" '.$check.'>' . $value . '</option>';
			}
		}

		$html .= '</select></div>';
		return $html;
	}


	/**
     * html_radio
     * 
     * @return string
     */
	private function html_checkbox($param)
	{
		return $this->html_radio($param);
	}

	/**
     * html_text
     * 
     * @return string
     */
	private function html_text($param)
	{
		return '<div class="am-u-sm-8 am-u-md-4"><input type="' . $param['type'] . '" class="am-input-sm" value="' . $param['value'] . '" name="' . $param['name'] . '" /></div>';
	}

	/**
     * html_password
     * 
     * @return string
     */
	private function html_password($param)
	{
		return $this->html_text($param);
	}

	/**
     * html_time
     * 
     * @return string
     */
	private function html_time($param)
	{
		return '<div class="am-u-sm-8 am-u-md-10"><div class="am-form-group am-form-icon"><i class="am-icon-calendar"></i><input type="text" value="' . $param['value'] . '" name="' . $param['name'] . '" class="am-form-field am-input-sm"/></div></div>';
	}

	/**
     * __call
     *
     * @return object
     */
    public function __call($method, $param)
    {
    	if(strpos($method, 'html_') !== false)
    	{
    		return $this->html_text($param);
    	}

    	return $this;
    }

    /**
     * html_time
     * 
     * @return string
     */
    private function option($option)
    {
    	if(is_object($option))
    	{
    		$function = $option;
			$option = $function();
    	}

    	return $option;	
    }
}
