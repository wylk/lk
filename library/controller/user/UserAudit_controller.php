<?php
//用户
class userAudit_controller extends base_controller
{
    //商铺认证列表
    public function shop(){
        import('user_page');
        $User_audit = D('User_audit')->where(array('type'=>2,'isdelete' =>0))->select();
        $num=count($User_audit);
        $page = new Page(count($User_audit),2);
        $res = D('User_audit')->where(array('type'=>2))->order('`id` DESC')->limit("$page->firstRow, $page->listRows")->select();
        $s_id=D('Shopclass')->select();
        $this->assign('page', $page->show());
        $this->assign('res',$res);
        $this->assign('num',$num);
        $this->assign('s_id',$s_id);
        $this->display();
    }
   //商铺搜索
    public function index_to(){
      $enterprise=$_POST['enterprise'];
      $s_id=$_POST['s_id'];
      if($enterprise){
      $res=D('User_audit')->where("enterprise LIKE '%$enterprise%'")->select();

      foreach($res as $key=>$value){
            $res[$key]['create_time'] = date('Y-m-d H:i:s', $value['create_time']);
            $res[$key]['update_time'] = date('Y-m-d H:i:s', $value['update_time']);
         }
      if($res[$key]['isdelete']==0){
         $this->dexit(['error'=>0,'data'=>$res]);
        }else{
         $this->dexit(['error'=>1,'msg'=>'企业不存在']);
        }
      }
      if($s_id){
        $rea=D('User_audit')->where(array('s_id'=>$s_id,'isdelete' =>0))->select();
        foreach($rea as $key=>$value){
            $rea[$key]['create_time'] = date('Y-m-d H:i:s', $value['create_time']);
            $rea[$key]['update_time'] = date('Y-m-d H:i:s', $value['update_time']);
         }
      if($rea){
         $this->dexit(['error'=>0,'data'=>$rea]);

        }else{
         $this->dexit(['error'=>2,'msg'=>'还没有此类店铺']);
        }

      }
    }
     //个人搜索
    public function index_too(){
      $name=$_POST['name'];
      $res=D('User_audit')->where("name LIKE '%$name%'")->select();
      foreach($res as $key=>$value){
            $res[$key]['create_time'] = date('Y-m-d H:i:s', $value['create_time']);
            $res[$key]['update_time'] = date('Y-m-d H:i:s', $value['update_time']);
         }
      if($res[$key]['isdelete']==0){
         $this->dexit(['error'=>0,'data'=>$res]);
        }else{
         $this->dexit(['error'=>1,'msg'=>'用户不存在']);
        }

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
    public function back()
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
        // $userAudit = D('User_audit')->where(array('id'=>$_GET['id']))->find();
        $userAudit = D('User_audit')->where(array('id'=>$_GET['id']))->find();
        $res=D('Shopclass')->where(array('id'=>$userAudit['s_id']))->find();
        $this->assign('res',$res);
        $this->assign('userAudit',$userAudit);
        $this->display();
    }

    //个人认证
    public function personal()
    {
        import('user_page');
        $User_audit = D('User_audit')->where(array('type'=>1,'isdelete' =>0))->select();
        $num=count($User_audit);
        $page = new Page(count($User_audit),2);
        $res = D('User_audit')->where(array('type'=>1))->order('`id` DESC')->limit("$page->firstRow, $page->listRows")->select();
        $this->assign('page', $page->show());
        $this->assign('res',$res);
        $this->assign('num',$num);
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
    public function pback()
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
    // 店铺比例修改
    public function ratioModify(){
        if(IS_POST){
            $ratio = (int)$_POST['ratio'];
            $auditId = $_POST['auditId'];

            if(strlen($ratio) <= 3 && $ratio <= 100 && $ratio >0)  $ratio .= '%';
            else dexit(['res'=>1,'msg'=>'数据不对','data'=>$ratio]);

            $res = D("User_audit")->data(['ratio'=>$ratio])->where(['id'=>$auditId])->save();
            if(!$res) dexit(['res'=>1,'msg'=>'修改失败','data'=>$res,'d'=>$ratio]);
            dexit(['res'=>0,'msg'=>'修改成功','data'=>$res,'d'=>$ratio]);
        }
        $ratioRes = D("User_audit")->field('ratio')->where(['id'=>$_GET['id']])->find();
        // $this->assign('ratio',$ratioRes['ratio']);
        include display();
    }
    // 企业认证
    public function enterprise(){
        import('user_page');
        $num = D('User_audit')->where(array('type'=>3,'isdelete' =>0))->count();
        $page = new Page($num,2);
        $res = D('User_audit')->where(array('type'=>3))->order('`id` DESC')->limit("$page->firstRow, $page->listRows")->select();
        $s_id=D('Shopclass')->select();
        $this->assign('page', $page->show());
        $this->assign('res',$res);
        $this->assign('num',$num);
        $this->assign('s_id',$s_id);
        $this->display();
    }
}


