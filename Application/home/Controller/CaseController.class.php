<?php
/*
 *create by roy
 */
namespace home\Controller;
use Think\Controller;
class CaseController extends Controller {
	public function index(){
		$case_model = D("Case");
		$caseclass_model = D("Caseclass");
		$case = $case_model->select();
		$caseclass = $caseclass_model->select();
		$title = "案例展示";
		$this->assign('title',$title);
		$this->assign('case',$case);
		$this->assign('caseclass',$caseclass);
		$this->display("case");
	}
}
