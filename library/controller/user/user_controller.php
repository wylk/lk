<?php
//用户
class user_controller extends base_controller
{
    public function index(){
        $user = D('User')->where()->select();
        $this->assign('user',$user);
        $this->display();
    }

    //添加页面
    public function add()
    {
        // var_dump($_POST);
        if(IS_POST){
            $_POST['timestamp'] = time();
            $_POST['upwd'] = md5($_POST['upwd']);
            $data = $this->clear_html($_POST);
            unset($data['pass']);
            if(D('User')->data($data)->add()){
                $this->dexit(['error'=>0,'msg'=>'添加成功']);
            }else{
                $this->dexit(['error'=>1,'msg'=>'添加失败']);
            }
        }
        $this->display();
    }

    //显示页面
    public function edit()
    {
        $id = $_GET['id'];
        $user = D('User')->where(array('id' =>$id))->find();
        $this->assign('user',$user);
        $this->display();
    }

    //启用 禁用
    public function change()
    {
        // $_GET['status'] = ($request->input(key:'status')==1) ? 0 : 1;
       $data = $this->clear_html($_GET);
        $data['status'] = $data['status'] ? 0 : 1;
        if(D('User')->data(['status'=>$data['status']])->where(array('id' =>$data['id']))->save()){
            $arr=['status'=>0,'msg'=>'修改成功'];
        }else{
            $arr=['status'=>1,'msg'=>'修改失败'];
        }
        $this->dexit($arr);
    }

    //删除
    public function delete()
    {
        $data = $this->clear_html($_POST);
        // (D('User')->data($data)->where(array('id' =>$data['id']))->save());

        if(D('User')->data(['isdelete'=>3])->where(array('id' =>$data['id']))->save()) {
            $arr=['status'=>0,'msg'=>'删除成功'];
        } else{
            $arr=['status'=>1,'msg'=>'删除失败'];
        }
        $this->dexit($arr);
    }
}

