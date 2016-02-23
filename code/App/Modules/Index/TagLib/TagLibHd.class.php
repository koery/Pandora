<?php
//import('TagLib');新版本不用
Class TagLibHd extends TagLib{

	Protected $tags =array(
		'nav' => array('attr' => 'limit,order','close' => 1),
		'hot' => array('attr' => 'limit','close' => 1),
		'new' => array('attr' => 'limit','close' => 1)
		);

	Public function _nav ($attr,$content) {
		$attr = $this->parseXMLAttr($attr);
		$str = <<<str
<?php
		\$_nav_cate = M('cate')->order("{$attr['order']}")->select();
		import('Class.Category',APP_PATH);
		\$_nav_cate = Category::unlimitedForLayer(\$_nav_cate);
		foreach (\$_nav_cate as \$_nav_cate_v) :
			extract(\$_nav_cate_v);
?>
str;
		$str .= $content;
		$str .= '<?php endforeach;?>';
		return $str;
	}

	Public function _hot ($attr,$content) {
		$attr = $this->parseXMLAttr($attr);
		$limit = $attr['limit'];
		$str = <<<str
<?php
		\$field = array('id','title','hits');
		\$_hot_blog = M('blog')->field(\$field)->limit({$limit})->order('hits DESC')->select();
		foreach (\$_hot_blog as \$_hot_value) :
			extract(\$_hot_value);
			\$url = U('/'.\$id);
?>
str;
		$str .= $content;
		$str .= '<?php endforeach;?>';
		return $str;
	}

	Public function _new ($attr,$content) {
		$attr = $this->parseXMLAttr($attr);
		$limit = $attr['limit'];
		$str = <<<str
<?php
		\$field = array('id','title','time','hits');
		\$_hot_blog = M('blog')->field(\$field)->limit({$limit})->order('time DESC')->select();
		foreach (\$_hot_blog as \$_hot_value) :
			extract(\$_hot_value);
			\$url = U('/'.\$id);
?>
str;
		$str .= $content;
		$str .= '<?php endforeach;?>';
		return $str;
	}

}
?>