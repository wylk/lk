<?php
//用户
class UserAudit_controller extends base_controller
{
    //商铺认证列表
    public function shop(){
        // echo 2343;
        $User_audit = D('User_audit')->select();
        foreach ($User_audit as $key => $value) {
           if($value['type']==2){
                $arr[] = $value;
           }
        }
        $this->assign('arr',$arr);
        $this->display();
    }

    //商铺审核通过
    public function change()
    {
            $data = $this->clear_html($_POST);
            $data['update_time'] = time();
            $data['status'] = 1;
            $id = $data['id'];
            unset($data['id']);
            if(D('User_audit')->data($data)->where(array('id' =>$id))->save()){
                $this->dexit(['error'=>0,'msg'=>'审核成功']);
            } else {
                $this->dexit(['error'=>1,'msg'=>'审核失败']);
            }
    }

    //商户审核没通过，反馈信息
    public function feedback()
    {

        $gets = $this->clear_html($_GET);
        $res = D('User_audit')->where(array('id'=>$gets['id']))->find();
        $res = $res['remarks'];
        $this->assign('res',$res);
        $this->assign('gets',$gets);
        if(IS_POST){
            $data = $this->clear_html($_POST);
            if(!$data['status']==1){
                $data['update_time'] = time();
                $id = $data['id'];
                unset($data['id']);
                $data['status']=2;
                if(D('User_audit')->data($data)->where(array('id' =>$id))->save()){
                    $this->dexit(['error'=>0,'msg'=>'反馈成功']);
                } else {
                    $this->dexit(['error'=>1,'msg'=>'反馈失败']);
                }
            }else{
                $this->dexit(['error'=>1,'msg'=>'用户以通过认证，无需反馈']);
            }
        }
        $this->display();
    }

    //店铺详情页
    public function lists()
    {
        $userAudit = D('User_audit')->where(array('id'=>$_GET['id']))->find();
        $this->assign('userAudit',$userAudit);
        $this->display();
    }

    //个人认证
    public function personal()
    {
        $User_audit = D('User_audit')->select();
        foreach ($User_audit as $key => $value) {
           if($value['type']==1){
                $arr[] = $value;
           }
        }
        $this->assign('arr',$arr);
        $this->display();
    }

    //个人审核通过
    public function pchange()
    {
            $data = $this->clear_html($_POST);
            $data['update_time'] = time();
            $data['status'] = 1;
            $id = $data['id'];
            unset($data['id']);
            if(D('User_audit')->data($data)->where(array('id' =>$id))->save()){
                $this->dexit(['error'=>0,'msg'=>'审核成功']);
            } else {
                $this->dexit(['error'=>1,'msg'=>'审核失败']);
            }
    }

    //个人审核没通过，反馈信息
    public function pfeedback()
    {
        $gets = $this->clear_html($_GET);
        $res = D('User_audit')->where(array('id'=>$gets['id']))->find();
        $res = $res['remarks'];
        $this->assign('res',$res);
        $this->assign('gets',$gets);
        if(IS_POST){
            $data = $this->clear_html($_POST);
            if(!$data['status']==1){
                $data['update_time'] = time();
                $id = $data['id'];
                unset($data['id']);
                $data['status']=2;
                if(D('User_audit')->data($data)->where(array('id' =>$id))->save()){
                    $this->dexit(['error'=>0,'msg'=>'反馈成功']);
                } else {
                    $this->dexit(['error'=>1,'msg'=>'反馈失败']);
                }
            }else{
                $this->dexit(['error'=>1,'msg'=>'用户以通过认证，无需反馈']);
            }
        }
        $this->display();
    }

    //软删除认证管理
    public function delete()
    {
        $data = $this->clear_html($_POST);
        if(D('User_audit')->data(['isdelete'=>3])->where(array('id' =>$data['id']))->save()){
            $this->dexit(['error'=>0,'msg'=>'删除成功']);
        } else {
            $this->dexit(['error'=>1,'msg'=>'删除失败']);
        }
    }

    //个人详情页
    public function plists()
    {
        $userAudit = D('User_audit')->where(array('id'=>$_GET['id']))->find();
        $this->assign('userAudit',$userAudit);
        $this->display();
    }
}

