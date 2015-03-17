<?php
/*
 * 安装composer
 */

class Setup
{
    protected static $_instance;
    
    public static function getInstance()
    {
        if(self::$_instance === null)
        {
            self::$_instance = new self();
        }
        return self::$_instance;
    }
    
    public static function init()
    {
    	//$HOME
		$composer = '/bin/composer';
		
		$shell = 'sudo curl -sS https://getcomposer.org/installer | sudo php -d detect_unicode=Off';
		system($shell);
		
		$shell = 'sudo mv composer.phar ' . $composer;
		system($shell);
		
		$shell = 'sudo chmod +x ' . $composer;
		system($shell);

		$shell = 'composer install';
		system($shell);
	}
	
	public static function update()
    {
		$shell = 'composer update';
		system($shell);
	}

    public static function git()
    {
        $shell = 'sudo apt-get install git-core';
        system($shell);
    }

    public static function laravel()
    {
    	$shell = 'composer create-project laravel/laravel --prefer-dist';
    	system($shell);
    }
}

echo "请输入命令以执行相应操作：\ninit:初始化\nupdate:更新\ngit:安装git\nlaravel:安装laravel\n在输入命令之后按回车键\n";
$stdin = fopen('php://stdin','r');
$shell = trim(fgets($stdin,100));

switch($shell)
{
	case 'init':
		Setup::init();
		break;
	case 'update':
		Setup::update();
		break;
	case 'git':
		Setup::git();
		break;
	case 'laravel':
		Setup::laravel();
		break;
	default:
		echo "未定义的方法";
		break;
}
