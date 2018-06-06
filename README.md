---------数据库操作-----------------
1.添加: 例(D('Aaep_wxmenu')->data($data)->add());
2.修改: 例(D('Store')->data($data)->where(array('store_id' =>1))->save());
3.删除: 例(D('Store')->where(array('store_id' =>1))->delete());
3.查: 

例(D('Store')->where(array('store_id' =>1))->find());
例(D('Store')->where(array('store_id' =>1))->select());
链表 例D('')->table(array('Product'=>'p','Order_product'=>'op'))->field('*,p.supplier_id AS wholesale_supplier_id')->where("`op`.`order_id`='$order_id' AND `op`.`product_id`=`p`.`product_id`")->order('`op`.`pigcms_id` ASC')->select();
model 文件操作
M('User')->getCoupon($where);
例$data = $this->db->where(array('key' => 1))->find();
具体可看/source/class/mysql.class.php 文件


-----------引入第三方类文件-----------------------------
import('source.class.test'); / import('test');


-----------文件传输处理------------------------------
1, $this->clear_html($_POST);   
2, $this->json 传输 dexit(['error'=>0,'msg'=>'ttt']);
注意：在wap里不用$this-> 

----------
