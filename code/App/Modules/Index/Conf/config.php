<?php
return array(
	'TMPL_PARSE_STRING' => array(
		'__PUBLIC__' => __ROOT__ . '/' . APP_NAME . '/' . C('APP_GROUP_PATH') . '/' . GROUP_NAME. '/Tpl/Public'
		),
	'URL_HTML_SUFFIX'=>'',
	
	'APP_AUTOLOAD_PATH' => '@.TagLib',
	'TAGLIB_BUILD_IN' => 'Cx,Hd',
	
	'HTML_CACHE_ON' => true,	//开启静态缓存
	'HTML_CACHE_RULES' => array(
		'Show:index' => array('{:module}_{:action}_{id}',60),
	),

	//动态缓存方式
	'DATA_CACHE_TYPE' => 'File',  //静态缓存用 File   动态缓存指定为 Memcache 或 Redis
	//当设为Memcache 数据缓存函数S无效 即使加上文件参数需要加缓存方式参数S('Newest_List', $NewList, 60, 'File');
	'DATA_CACHE_SUBDIR'=>true,//对于File方式缓存下的缓存目录下面因为缓存数据过多而导致存在大量的文件问题，ThinkPHP也给出了解决方案，可以启用哈希子目录缓存的方式
	'DATA_PATH_LEVEL'=>0, //还可以设置哈希目录的层次

	'MEMCACHE_HOST' => '127.0.0.1',
	'MEMCACHE_PORT' => 11211,

	'REDIS_HOST' => '127.0.0.1',
	'REDIS_PORT' => 6379, //默认值 可以不配
	
	);
?>