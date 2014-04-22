<?php
/*
 *create by roy
 */
namespace home\Controller;
use Think\Controller;
class IndexController extends Controller {
	public function index(){
		$FriendModel = D("Friend");
		$Friends = $FriendModel->order('f_sort DESC')->select();
		$this->assign('Friends',$Friends);
		$ContactModel = D("Contact");
		$Contact = $ContactModel->where('con_istop = 1')->find();
		$this->assign('Contact',$Contact);

		$CaseModel = D("Case");
		$Cases = $CaseModel->order('c_id DESC')->limit(3)->select();
		$PageModel = D("Page");
		$Pages = $PageModel->order('p_id DESC')->limit(3)->select();
		$this->assign('Cases',$Cases);
		$this->assign('Pages',$Pages);
		$this->assign('IndexUrl',U("Index/index","",""));
		$this->assign('CaseUrl',U("Case/index","",""));
		$this->assign('PageUrl',U("Page/index","",""));
		$this->assign('ContactUrl',U("Contact/index","",""));
		$this->assign('BlogUrl',U("Blog/index","",""));

		$this->assign('PageDetailUrl',U("Page/detail","",""));
		$this->assign('AboutUrl',U("About/index","",""));
		$this->display("index");
	}
}