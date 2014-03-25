<?php
/*
 *create by roy
 */
namespace admin\Controller;
use Think\Controller;
class CaseController extends \admin\Controller\AdminController {
	public function index(){
		//echo 111;
		//$nav_model = \admin\Model\NavModel();
		$nav_model = D("Nav");
		$nav = $nav_model->order("n_sort")->select();
		//var_dump($nav);
		$this->assign('nav',$nav);
		$view = $this->display("index");
	}

	public function caseClass($page=1){
		$caseclass_model = D("Caseclass");
		$url = "/index.php/admin/Case/caseClass";

		$rowNum = $caseclass_model->count();
		$pageSize = 12;
		$pages = ceil($rowNum/$pageSize);
		if($page > $pages)
			$page = $pages;
		if($page < 1)
			$page = 1;
		$curPage = $page ?: 1;
		$offset = ($curPage-1)*$pageSize;
		$caseclass_list = $caseclass_model->order("c_sort")->limit($offset, $pageSize)->select();
		$pagination = $this->getPagination($curPage, $pages, $url);
		$this->assign('page',$page);
		$this->assign('caseclass_list',$caseclass_list );
		$this->assign('pagination',$pagination);
		$content = $this->fetch("caseClass_list");
		$this->show($content);
		//$this->display("login");
	}

	public function edit_caseclass($page=1, $c_id=0){
		$caseclass_model = D("Caseclass");
		$url = "/index.php/admin/Case/caseClass";

		$rowNum = $caseclass_model->count();
		$pageSize = 12;
		$pages = ceil($rowNum/$pageSize);
		if($page > $pages)
			$page = $pages;
		if($page < 1)
			$page = 1;
		$curPage = $page ?: 1;
		$offset = ($curPage-1)*$pageSize;
		$caseclass_list = $caseclass_model->order("c_sort")->limit($offset, $pageSize)->select();
		$pagination = $this->getPagination($curPage, $pages, $url);
		$caseclass = $caseclass_model->where("c_id = ".$c_id)->find();
		$this->assign('page',$page);
		$this->assign('caseclass_list',$caseclass_list);
		$this->assign('caseclass',$caseclass);
		$this->assign('pagination',$pagination);
		$content = $this->fetch("caseClass_list");
		$this->show($content);
	}

	public function caseclass_save($page=1){
		$post = $_POST;
		if($post){
			$c_id = $post["c_id"];
			unset($post["submit"]);
			unset($post["c_id"]);
			$caseclass_model = D("Caseclass");
			if($c_id){
				if($id=$caseclass_model->where("c_id = ".$c_id)->save($post)){
					$type = "success";
					$infomation = "修改成功!";
				}
				else{
					$type = "error";
					$infomation = "修改失败!";
				}
			}
			else{
				if($id=$caseclass_model->data($post)->add()){
					$type = "success";
					$infomation = "添加成功!";
				}
				else{
					$type = "error";
					$infomation = "添加失败!";
				}
			}
			
			$json["info"] = $this->getInfomation($type, $infomation);
			$json["value"] = $post["n_path"] ;
			$json["url"] = "/index.php/admin/Case/caseClass/page/".$page;
			$json["path"] = "101010";
			echo json_encode($json);
		}
	}

	public function delete($page=1, $c_id = 0){
		$caseclass_model = D("Caseclass");
		//$nav = $nav_model->where("n_id = ".$n_id)->find();
		//if($nav_model->where("n_path like '".$nav["n_path"]."%'")->delete()){
		if($caseclass_model->where("c_id = ".$c_id)->delete()){
			$type = "success";
			$infomation = "删除成功!";
		}
		else{
			$type = "error";
			$infomation = "删除失败!";
		}
		$json["info"] = $this->getInfomation($type, $infomation);
		$json["url"] = "/index.php/admin/Case/caseClass/page/".$page;
		$json["path"] = "101010";
		echo json_encode($json);
	}

	public function batch($page=1){
		$post = $_POST;
		$caseclass_model = D("Caseclass");
		if($post["choose"]=='delete'){
			unset($post["choose"]);
			foreach($post as $key=>$value){
				$c_ids[] = $key;
			}
			$delete_num = count($c_ids);
			if($caseclass = $caseclass_model->where("c_id in (".implode(",",$c_ids).")")->delete()){
				$type = "success";
				$infomation = "删除成功".$delete_num."条!";
			}
			else{
				$type = "error";
				$infomation = "删除失败!";
			}
		}
		$json["info"] = $this->getInfomation($type, $infomation);
		$json["url"] = "/index.php/admin/Case/caseClass/page/".$page;
		$json["path"] = "101010";
		echo json_encode($json);
	}

	public function caselist($page=1, $cs_id=0){
		$caseclass_model = D("Caseclass");
		$caseclasses = $caseclass_model->order("c_sort")->select();
		foreach($caseclasses as $value){
			$caseclass[$value["c_id"]] = $value["c_title"];
		}
		$case_model = D("Case");
		$url = "/index.php/admin/Case/caselist";

		$rowNum = $case_model->count();
		$pageSize = 12;
		$pages = ceil($rowNum/$pageSize);
		if($page > $pages)
			$page = $pages;
		if($page < 1)
			$page = 1;
		$curPage = $page ?: 1;
		$offset = ($curPage-1)*$pageSize;
		$case_list = $case_model->order("cs_sort")->limit($offset, $pageSize)->select();
		$pagination = $this->getPagination($curPage, $pages, $url);
		$this->assign('page',$page);
		$this->assign('caseclass',$caseclass);
		if($cs_id){
			$case = $case_model->where("cs_id = ".$cs_id)->find();
			$this->assign('case',$case);
		}
		$this->assign('case_list',$case_list);
		$this->assign('pagination',$pagination);
		$content = $this->fetch("case_list");
		$this->show($content);
		//$this->display("login");
	}

	public function case_save($page=1){
		$post = $_POST;
		if($post){
			$cs_id = $post["cs_id"];
			unset($post["submit"]);
			unset($post["cs_id"]);
			$post["cs_time"] = date("Y-m-d H:m:s");
			$case_model = D("Case");
			if($cs_id){
				if($id=$case_model->where("cs_id = ".$cs_id)->save($post)){
					$type = "success";
					$infomation = "修改成功!";
				}
				else{
					$type = "error";
					$infomation = "修改失败!";
				}
			}
			else{
				if($id=$case_model->data($post)->add()){
					$type = "success";
					$infomation = "添加成功!";
				}
				else{
					$type = "error";
					$infomation = "添加失败!";
				}
			}
			
			$json["info"] = $this->getInfomation($type, $infomation);
			$json["url"] = "/index.php/admin/Case/caselist/page/".$page;
			$json["path"] = "101011";
			echo json_encode($json);
		}
	}
}
