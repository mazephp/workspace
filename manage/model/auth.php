<?php
/*
|--------------------------------------------------------------------------
| auth.php 后台管理 权限管理
|--------------------------------------------------------------------------
*/

use Robin\Plad\Save;
use Robin\Plad\Security;

class Manage_Auth
{	
	/**
     * save
     *
     * @var Robin\Plad\Save
     */
    private $save;
    
	/**
     * __construct
     * 
     * @return mixed
     */
	public function __construct()
	{
		$this->save = new Save();
	}
	
	/**
     * login
     * 
     * @return mixed
     */
	public function login()
	{
        $param['where_username'] = Input::get('username');
        
        $param['where_password'] = md5(Input::get('password'));

		$user = Load::get('manage/admin-user', $param);
		
		if($user)
		{
			$this->save->add('admin', $user);
			$refer = Input::get('refer');
			
			if($refer)
			{
                $url = parse_url(Security::decode($refer));
                $url['path'] = preg_replace('/^\//', '', $url['path']);
				$refer = Url::get($url['path'] . '?' . $url['query']);
				Helper::out($refer);
			}
			else
			{
				Helper::out(Url::get('home'));
			}
		}
		else
		{
			Helper::error('登录失败');
		}
	}
	
	/**
     * config
     * 
     * @return mixed
     */
	public function config()
	{
        $param['refer'] = Input::get('refer');
        
        return $param;
	}
	
	/**
     * location_login
     * 
     * @return mixed
     */
	public function location_login()
	{
		$refer = Security::encode(Url::get());
		return Url::location(Url::get('login?refer=' . $refer));
	}
	
	/**
     * init
     * 
     * @return mixed
     */
	public function init()
	{
        $this->check(Config::$global['uri']);

        $admin = $this->save->get('admin');
        if(!$admin)
        {
			return $this->location_login();
        }

        $param['where_uri'] = Config::$global['uri'];
        $data = Load::get('manage/auth-one', $param);
        
        if(!$data)
        {
            $update['add_uri']      = $update['add_name'] = $param['where_uri'];
            $update['add_type']     = $this->type($update['add_uri']);
            $update['add_project']  = Input::get('key', ROBIN_PROJECT_NAME);
            $update['add_table']    = Input::get('table', 'other');
            $data['id'] = Load::get('manage/auth-insert', $update);
        }

        $role = Load::get('manage/role-one', array('where_id' => $admin['role']));
        
        if($role && $role['auth'])
        {
            if($role['auth'] == 'all')
            {
                return;
            }
            
            $role['auth'] = explode(',', $role['auth']);
            
            if(!in_array($data['id'], $role['auth']))
            {
                Helper::error('您没有操作权限');
            }
        }
        else
        {
            Helper::error('您没有操作权限');
        }
	}

    /**
     * check
     * 
     * @return mixed
     */
    private function check($uri)
    {
        if(strpos($uri, '.html') !== false)
        {
            Helper::error('您没有操作权限');
        }
    }

    /**
     * 获取当前uri的类型
     *
     * @param uri string
     * @return mixed
     */
    public function type($uri)
    {
        if(strpos($uri, '.') !== false)
        {
            $type = 3;
        }
        elseif(strpos($uri, '-') !== false)
        {
            $type = 2;
        }
        else
        {
            $type = 1;
        }
        return $type;
    }

    /**
     * 获取所有权限列表，并进行统计处理
     * 
     * @return mixed
     */
    public function get()
    {
        $auth = Load::get('manage/auth-list');

        $project = Load::get('manage/project.get');

        $result = array();

        $url = 'manage/';
        foreach($auth as $k => $v)
        {
            if(isset($project[$v['project']]['lang']))
            {
                $result[$v['project']]['data'][$k] = $v;
                $result[$v['project']]['name'] = $project[$v['project']]['lang'];
                $result[$v['project']]['url'] = $url;
            }
        }

        # 1为多维数组
        $result['state'] = 1;

        return $result;
    }
}
