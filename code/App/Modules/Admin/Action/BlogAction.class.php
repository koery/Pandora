<?php
/**
*博文管理
*/
class BlogAction extends CommonAction{

	//博文列表 (回收站del=1)
    public function index(){
		$del = I('del',0,'intval');
		$this->type = $del;
		$where = array('del'=>$del);
		$count = M('blog')->where($where)->count();
		import('Class.Page',APP_PATH);
		$page = new Page($count,30);
		$limit = $page->firstRow . ',' .$page->listRows;
		$this->blog = D('BlogRelation')->getBlogs($where,$limit);
		$this->page = $page->show();
		$this->display();
    }
	
	//添加博文
    public function add(){
		import('Class.Category',APP_PATH);
		$cate = M('cate')->order('sort ASC')->select();
		$this->cate = Category::unlimitedForLevel($cate);
		$this->attr = M('attr')->select();
		$this->display();
    }

    public function addPost() {
		if (!IS_POST) _404('页面不存在',U(GROUP_NAME . '/Blog/index'));
		$data = array(
			'title' => I('title'),
			'content' => I('content'),
			'notes' => I('notes'),  //summary
			'hits' => I('hits'),
			'cid' => I('cid'),
			'time' => time()
		);
		/*
		if (isset($_POST['aid'])) {
			foreach ($_POST['aid'] as $v){
				$data['attr'][] = $v;
			}
		}
		
		D('BlogRelation')->add($data);//关联表清空的bug
		die;*/
		if ($bid = M('blog')->add($data)) {
			if (isset($_POST['aid'])) {
				$sql = 'INSERT INTO ' . C('DB_PREFIX') . 'blog_attr (bid,aid) VALUES';
				foreach ($_POST['aid'] as $v){
					$sql .= '('.$bid.','.$v.'),';
				}
				$sql = rtrim($sql,',');
				echo $sql;
				die;
				M()->query($sql);
			}
			$this->success('添加成功',U(GROUP_NAME . '/Blog/index'));
		} else {
			$this->error('添加失败');
		}
    }
	//
    public function upload() {
		/*
		$config =   array(
        'maxSize'           =>  -1,    // 上传文件的最大值
        'supportMulti'      =>  true,    // 是否支持多文件上传
        'allowExts'         =>  array(),    // 允许上传的文件后缀 留空不作后缀检查
        'allowTypes'        =>  array(),    // 允许上传的文件类型 留空不做检查
        'thumb'             =>  false,    // 使用对上传图片进行缩略图处理
        'imageClassPath'    =>  'ORG.Util.Image',    // 图库类包路径
        'thumbMaxWidth'     =>  '',// 缩略图最大宽度
        'thumbMaxHeight'    =>  '',// 缩略图最大高度
        'thumbPrefix'       =>  'thumb_',// 缩略图前缀
        'thumbSuffix'       =>  '',
        'thumbPath'         =>  '',// 缩略图保存路径
        'thumbFile'         =>  '',// 缩略图文件名
        'thumbExt'          =>  '',// 缩略图扩展名        
        'thumbRemoveOrigin' =>  false,// 是否移除原图
        'thumbType'         =>  1, // 缩略图生成方式 1 按设置大小截取 0 按原图等比例缩略
        'zipImages'         =>  false,// 压缩图片文件上传
        'autoSub'           =>  false,// 启用子目录保存文件
        'subType'           =>  'hash',// 子目录创建方式 可以使用hash date custom
        'subDir'            =>  '', // 子目录名称 subType为custom方式后有效
        'dateFormat'        =>  'Ymd',
        'hashLevel'         =>  1, // hash的目录层次
        'savePath'          =>  '',// 上传文件保存路径
        'autoCheck'         =>  true, // 是否自动检查附件
        'uploadReplace'     =>  false,// 存在同名是否覆盖
        'saveRule'          =>  'uniqid',// 上传文件命名规则
        'hashType'          =>  'md5_file',// 上传文件Hash规则函数名
        );
		$upoload = new UploadFile($config);
		*/
		
		import('ORG.Net.UploadFile');
		$upoload = new UploadFile();
		$upoload->autoSub = true;
		$upoload->subType = 'date';
		$upoload->dateFormat = 'Ym';
		//$upoload->savePath = './Uploads/';
		if ($upoload->upoload('./Uploads/')) {
			$info = $upoload->getUploadFileInfo();
			//import('ORG.Util.Image');
			//image::water('./Uploads/'.$info[0]['savename'],'./Data/logo.png');
			import('Class.Image',APP_PATH);
			image::water('./Uploads/'.$info[0]['savename']);
			echo json_encode(array(
				'url' => $info[0]['savename'],
				'title' => htmlspecialchars($_POST['pictitle'], ENT_QUOTES),
				'original' => $info[0]['name'],
				'state' => 'SUCCESS'
			));
		} else {
			echo json_encode(array(
				'state' => $upload->getErrorMsg()
			));
		}

    }
	
	//修改博文
    public function edit(){
		$id = I('id',0,'intval');
		$blog = M('blog')->where(array('id' => $id))->select();
		if (!$blog) _404('博文不存在',U(GROUP_NAME . '/Blog/index'));
		$blog = $blog[0];
		import('Class.Category',APP_PATH);
		$cate = M('cate')->order('sort ASC')->select();
		$this->cate = Category::unlimitedForLevel($cate);
		$allattr = M('attr')->select();
		$blogattr = M('blog_attr')->where('bid='.$id)->order('aid ASC')->select();
		foreach ($allattr as $key=>$a){
			$allattr[$key]['checked']=0;
			foreach ($blogattr as $b){
				if ($b['aid']==$a['id']) {$allattr[$key]['checked']=1; break;}
			}
		}
		//p($allattr);
		//die;
		$this->attr = $allattr;
		$this->blog = $blog;
		$this->display();
    }

    public function editPost() {
		if (!IS_POST) _404('页面不存在',U(GROUP_NAME . '/Blog/index'));
		$id = I('id');
		$data = array(
			'id' => $id,
			'title' => I('title'),
			'content' => I('content'),
			'hits' => I('hits'),
			'cid' => I('cid'),
			'time' => time()
		);
		
		if (M('blog')->save($data)) {
			if (isset($_POST['aid'])) {
				M('blog_attr')->where('bid='.$id)->delete();
				$sql = 'INSERT INTO ' . C('DB_PREFIX') . 'blog_attr (bid,aid) VALUES';
				foreach ($_POST['aid'] as $v){
					$sql .= '('.$id.','.$v.'),';
				}
				$sql = rtrim($sql,',');
				M()->query($sql);
			}
			$this->success('保存成功',U(GROUP_NAME . '/Blog/index'));
		} else {
			$this->error('保存失败');
		}

    }

	//删除到回收站 / 还原
    public function totrach(){
		$update =array(
			'id' => I('id',0,'intval'),
			'del' => I('type',0,'intval')
			);
		$msg = ($update['del']==1) ? '删除到回收站' :'还原';
		if (M('blog')->save($update)) {
			$this->success($msg . '成功',U(GROUP_NAME . '/Blog/index'));
		} else {
			$this->error($msg . '失败');
		}
    }

	//彻底删除博文
    public function delete(){
		$id = I('id',0,'intval');
		if (M('blog')->where(array('id' => $id))->delete()) {
			M('blog_attr')->where(array('bid' => $id))->delete();
			$this->success('彻底删除成功',U(GROUP_NAME . '/Blog/index'));
		} else {
			$this->error('彻底删除失败');
		}
    }
	
	//清空回收站
    public function deletetrach(){
		$where = array('del' => 1);
		$db = M('blog')->field('id')->where($where)->select();
		foreach ($db as $v){
			$ids[] = $v['id'];
		}
		if (M('blog')->where(array('del' => 1))->delete()) {
			M('blog_attr')->where(array('bid' => array('IN',$ids)))->delete();
			$this->success('清空回收站成功',U(GROUP_NAME . '/Blog/index'));
		} else {
			$this->error('清空回收站失败');
		}
    }
}
?>