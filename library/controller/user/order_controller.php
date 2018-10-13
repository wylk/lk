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
      $pice=$_POST['pice'];
      $num=$_POST['num'];
      if($onumber){
          $aa=D('Orders')->where(array('onumber' =>$onumber))->find();
          $aa['create_time'] = date('Y-m-d H:i:s', $aa['create_time']);
          if(empty($aa['onumber'])){
             $this->dexit(['error'=>1,'msg'=>'订单号不存在']);
            }else{
              $this->dexit(['error'=>0,'data'=>$aa]);
            }
      }
      if($num){
          if($num=='1'){
            $o_num=D('Orders')->where('number<50')->select();
             foreach($o_num as $key=>$value){
                $o_num[$key]['create_time'] = date('Y-m-d H:i:s', $value['create_time']);
             }
             $this->dexit(['error'=>3,'data'=>$o_num]);
          }else{
            $o_num=D('Orders')->where('number>50')->select();
              foreach($o_num as $key=>$value){
                $o_num[$key]['create_time'] = date('Y-m-d H:i:s', $value['create_time']);
             }
             $this->dexit(['error'=>3,'data'=>$o_num]);
          }
      }

      if($pice){
          if($pice=='3'){
            $o_pice=D('Orders')->where('prices<50')->select();
             foreach($o_pice as $key=>$value){
               $o_pice[$key]['create_time'] = date('Y-m-d H:i:s', $value['create_time']);
             }
             $this->dexit(['error'=>4,'data'=>$o_pice]);
          }else{
            $o_pice=D('Orders')->where('prices>50')->select();
              foreach($res as $key=>$value){
                $o_pice[$key]['create_time'] = date('Y-m-d H:i:s', $value['create_time']);
             }
             $this->dexit(['error'=>4,'data'=>$o_pice]);
          }
      }

      if($status!=''){
           $res=D('Orders')->where(array('status' =>$status))->select();
           foreach($res as $key=>$value){
              $res[$key]['create_time'] = date('Y-m-d H:i:s', $value['create_time']);
           }
           if($res){
             $this->dexit(['error'=>2,'data'=>$res]);
           }
      }

  }
    //订单详情
  public function oderlists()
  {
    $id=$_GET['id'];
    $res=D('Orders')->where(array('id'=>$id))->find();
    $sell_id=$res['sell_id'];
    $buy_id=$res['buy_id'];
    $sell_name=D('User')->where(array('id'=>$sell_id))->find();
    $buy_name=D('User')->where(array('id'=>$buy_id))->find();
    $this->assign('sell_name',$sell_name);
    $this->assign('buy_name',$buy_name);
    $this->display();
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

