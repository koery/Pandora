<?php
return array(
	'db_host' => '127.0.0.1',
	'db_port' => '3306',
	'db_type' => 'mysql',
	'db_user' => 'root',
	'db_pwd' => 'HVuYP5DCr1',
	'db_name' => 'blog',
	'db_prefix' => 'hd_',

	'db_charset' => 'GBK',
	'default_charset'=>'GBK',
	'template_charset'=>'GBK',

	'APP_GROUP_LIST' => 'Index,Admin',
	'DEFAULT_GROUP' => 'Index',
	'APP_GROUP_MODE' => 1,
	'APP_GROUP_PATH' => 'Modules',
	
	'LOAD_EXT_CONFIG' => 'verify,water',	//不能有空格
	'SESSION_TYPE' => 'Db',					//自定义SESSION数据库存储
	
	'TMPL_TEMPLATE_SUFFIX' => '.html',		// 模板文件后缀名
	'URL_HTML_SUFFIX' => 'html',			// 伪静态
	'URL_MODEL' => 2,						// 如果你的环境不支持PATHINFO 请设置为3
	'URL_ROUTER_ON' => true,				//开启URL路由配置实现超短URL地址 必须放在最外层
	'URL_ROUTE_RULES' => array(
		'c/:id' => 'Index/List/index',
		's' => 'Index/Search/index',
		'/^c_(\d+)$/' => 'Index/List/index?id=:1', //c_更数字正则路由
		':id\d' => 'Index/Show/index'
		),
	
	
	'DEFAULT_FILTER' => 'htmlspecialchars', // 官方已经修改
	'TMPL_VAR_IDENTIFY' => 'array',			// 点语法默认解析 只解析数组 来提高传参速度
	
	'SHOW_PAGE_TRACE' => true,

	//'TMPL_EXCEPTION_FILE' => './Public/Tpl/error.html',	//指定错误页面的模板路径
	
	//'APP_DEBUG' => true,            // 是否开启调试模式
	//'TMPL_SWITCH_ON' => true,        // 启用多模版支持
	//'TMPL_DETECT_THEME' => false,    // 自动侦测模板主题
	//'LANG_SWITCH_ON' => false,       // 多语言包功能
	//'LANG_AUTO_DETECT' => false,     // 是否自动侦测浏览器语言
	//'URL_CASE_INSENSITIVE' => true,  // URL是否不区分大小写 默认区分大小写
	//'DB_FIELDTYPE_CHECK' => true,    // 是否进行字段类型检查
	//'DATA_CACHE_SUBDIR' => true,     // 哈希子目录动态缓存的方式
);
?>