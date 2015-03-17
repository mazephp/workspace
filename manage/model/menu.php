<?php
/*
|--------------------------------------------------------------------------
| menu.php 后台管理 左侧菜单管理
|--------------------------------------------------------------------------
*/

# 权限控制
Load::get('manage/auth.init');

class Manage_Menu
{
	/**
     * __construct
     * 
     * @return mixed
     */
	public function __construct()
	{
		
	}

	/**
     * database
     * 
     * @return array
     */
	public function database()
	{
		$this->config();

		$result = array();

		$method = $this->project . '/' . $this->table . '-list';

		$data = Load::get($method);

		//print_r($data);die;
		//print_r(Helper::page("current"));die;

		if($data)
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
							$v[$vi['col']] = '<a href="#" data-toggle="modal" data-target="#robin_modal" onclick="$(\'#robin_modal_body\').html($(this).next().html())">' . $vi['modal'] . '</a><div style="display:none;">' . $v[$vi['col']] . '</div>';
						}
						elseif(isset($vi['option']))
						{
							$v[$vi['col']] = $vi['option'][$v[$vi['col']]];
						}

						$result[$k] .= '<td>' . $v[$vi['col']] . '</td>';
					}
					elseif($vi['col'] == 'manage' && isset($vi['value']) && is_array($vi['value']))
					{
						$result[$k] .= '<td>';
						foreach($vi['value'] as $kj => $vj)
						{
							$result[$k] .= '<a href="' . $this->url($kj, $v['id']) . '" class="oper_' . $kj . '">' . $vj . '</a>';
						}
						$result[$k] .= '</td>';
						
					}
				}

				$result[$k] .= '</tr>';
			}
		}

		return $result;
	}
}
