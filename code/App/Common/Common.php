<?php

	function p ($arr) {
		echo '<pre>' . print_r($arr,true) . '</pre>';
	}
	
	function replace_phiz($content){
		preg_match_all('/\[.*?\]/is', $content, $arr);
		$pathphiz = '__ROOT__/Public/Img/phiz/';
		if ($arr[0]) {
			$phiz = F('phiz','',CONF_PATH);
			foreach ($arr[0] as $v){
				foreach ($phiz as $key => $value){
					if ($v == '['.$value . ']'){
						$content = str_replace($v,'<img src="' . $pathphiz . $key . '.gif"/>',$content);
					break;
					}
				}
			}
		}
		return $content;
	}
?>