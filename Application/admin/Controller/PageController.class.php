<?php
namespace admin\Controller;

use admin\Model\PageModel;
use admin\Common\YuController;

class PageController extends YuController {

    public function _initialize()
    {
        $this->Page = new PageModel();
    }

    public function PageList()
    {
        $this->assign('PageAddUrl',U('PageAdd'));
        $this->assign('PageEditUrl',U('PageEdit','',''));
        $this->assign('PageDelUrl',U('PageDel','',''));

        $this->assign('PageLists',$this->Page->select());
        $this->display();
    }

    public function PageAdd()
    {
        $this->assign('PageSaveUrl',U('PageSave'));
        $this->assign('PageLists',$this->Page->select());
        $this->display();
    }

    public function PageEdit($id)
    {
        $this->assign('PageSaveUrl',U('PageSave'));
        $this->assign('PageInfo',$this->Page->find($id));
	$content = $this->fetch("PageAdd");
        $this->show($content);
    }

    public function PageDel($id)
    {
        if ($this->Page->delete($id)) {
            $this->ajax(U('PageList'));
        }else{
            $this->ajax(U('PageList'),'error','操作失败');
        }
    }

    public function PageSave()
    {
        if ($_POST) {
            $data['p_id']      = I('post.p_id');
            $data['p_title']   = I('post.p_title');
            $data['p_content'] = I('post.p_content');
            $data['p_date']    = time(I('post.p_date'));

            if ($this->Page->add($data,'',TRUE)){
                $type = "success";
                $infomation = "操作成功";
            }else{
                $type = "error";
                $infomation = "操作失败!";
            }

            $json["info"] = $this->getInfomation($type,$infomation);
            $json["url"]  = U('PageList');
            echo $this->ajaxReturn($json);
        }
    }
}
