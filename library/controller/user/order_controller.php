<?php
//用户
class order_controller extends base_controller
{
    public function index(){
        import('user_page');
        $orders = D('Orders')->select();
        $num=count($orders);
        $page = new Page(count($orders),2);
        $order = D('Orders')->order('`id` DESC')->limit("$page->firstRow, $page->listRows")->select();
        $this->assign('page', $page->show());
        $this->assign('order',$order);
        $this->assign('num',$num);
        $this->display();
    }
    //搜索
    public function index_to(){
      $onumber=$_POST['onumber'];
      $status=$_POST['status'];
      if($status!=''){
         $res=D('Orders')->where(array('status' =>$status))->select();
         foreach($res as $key=>$value){
            $res[$key]['create_time'] = date('Y-m-d H:i:s', $value['create_time']);
         }
         if($res){
           $this->dexit(['error'=>2,'data'=>$res]);
         }
      }
      if($onumber){
          $aa=D('Orders')->where(array('onumber' =>$onumber))->find();
          $aa['create_time'] = date('Y-m-d H:i:s', $aa['create_time']);
          if(empty($aa['onumber'])){
             $this->dexit(['error'=>1,'msg'=>'订单号不存在']);
            }else{
              $this->dexit(['error'=>0,'data'=>$aa]);
            }
      }
  }

    //添加页面
    public function add()
    {

        $this->display();
    }

    //显示页面
    public function edit()
    {
        $this->display();
    }

    //启用 禁用
    public function change()
    {
    }

    //删除
    public function delete()
    {
    }
}

