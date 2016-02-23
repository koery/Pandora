<?php

Class Category {

	//组合一维数组
	Static Public function unlimitedForLevel( $cate, $html = '--', $pid = 0, $level = 0){
		$arr = array();
		foreach ($cate as $v) {
			if ($v['pid'] == $pid) {
				$v['level'] = $level + 1;
				$v['html'] = str_repeat($html,$level);
				$arr[] = $v; 
				$arr = array_merge($arr, self::unlimitedForLevel($cate, $html, $v['id'], $level + 1));
			}
		}
		return $arr;
	}

	//组合多维数组
	Static Public function unlimitedForLayer ($cate, $name = 'child', $pid = 0) {
		$arr = array();
		foreach ($cate as $v) {
			if ($v['pid'] == $pid) {
				$v[$name] = self::unlimitedForLayer($cate, $name, $v['id']);
				$arr[] = $v; 
			}
		}
		return $arr;
	}

	//传递一个子分类返回所有的父级Id
	Static Public function getParentsId ($cate, $id) {
		$arr = array();
		foreach ($cate as $v) {
			if ($v['id'] == $id) {
				$arr[] = $v['id'];
				$arr = array_merge(self::getParentsId($cate, $v['pid']), $arr);
			}
		}
		return $arr;
	}

	//传递一个子分类返回所有的父级分类
	Static Public function getParents ($cate, $id) {
		$arr = array();
		foreach ($cate as $v) {
			if ($v['id'] == $id) {
				$arr[] = $v;
				$arr = array_merge(self::getParents($cate, $v['pid']), $arr);
			}
		}
		return $arr;
	}

	//传递一个父级分类返回所有的子级Id
	Static Public function getChildrenId ($cate, $pid) {
		$arr = array();
		foreach ($cate as $v) {
			if ($v['pid'] == $pid) {
				$arr[] = $v['id'];
				$arr = array_merge($arr, self::getChildrenId($cate, $v['id']));
			}
		}
		return $arr;
	}

	//传递一个父级分类返回所有的子级分类
	Static Public function getChildren ($cate, $pid) {
		$arr = array();
		foreach ($cate as $v) {
			if ($v['pid'] == $pid) {
				$arr[] = $v;
				$arr = array_merge($arr, self::getChildrenId($cate, $v['id']));
			}
		}
		return $arr;
	}
	

}
?>