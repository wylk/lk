<?php
/**
 * 基础类
 *
 */
class base_controller extends controller{
	public $user_session;
	public $store_session;
    public $allow_store_drp; //是否允许排他分销
    public $allow_platform_drp; //是否允许全网批发
    private $enabled_drp; //是否开启分销
	public function __construct()
    {
		parent::__construct();
        if (!$_SESSION["admin"]) {
            // $this->dexit(['status'=>1,'msg'=>'请先登录']);
            redirect('?c=public&a=login');
        }
        $res = $_SERVER["QUERY_STRING"];
        $res = str_replace(array("c=","a="),"",$res);
        $arr = explode('&',$res);
        $controlName = $arr[0];
        $methodName = $arr[1];
        $id = $_SESSION["admin"]["id"];
        $authorityData = D('')->table(array('RoleAdmin'=>'p','Access'=>'t','Auth'=>'y'))->field('*')->where("`p`.`admin_id`= $id AND `p`.`role_id`=`t`.`role_id` AND `t`.`auth_id`=`y`.`id`")->order('`y`.`id` ASC')->select();
        // dump($authorityData);
        // dump($controlName);dump($methodName);
        $returnData = $this->judgeAuthority($controlName, $methodName, $authorityData);
        if($_SESSION['admin']['name']=='admin'){
            $returnData['responseCode'] == '101';
        }elseif($returnData['responseCode'] == '100'){
            if(IS_AJAX){
                dexit(['error'=>1,'msg'=>'没有权限']);
            }else{
                die("<h1 style='color:red;margin-left:300px;'>没有权限</h1>");
            }
        }
	}

    private function judgeAuthority($controlName, $methodName, $authorityData){
        $auth_c = ['index','config'];
        $auth_a = ['index'=>['index','welcome','logout'],'config'=>['uploadFile']];
        foreach ($authorityData as $k => $v) {
            if(!in_array($v['auth_c'],$auth_c))
                $auth_c[] = $v['auth_c'];
            if(!in_array($v['auth_a'],$auth_a[$v['auth_c']]))
                $auth_a[$v['auth_c']][] = $v['auth_a'];
        }
        if(in_array($controlName,$auth_c) && in_array($methodName,$auth_a[$controlName])){
            $responseData = array('responseCode'=>'101', 'responseMessage'=>'可以访问');
            return $responseData;
            break;
        }
        $responseData = array('responseCode'=>'100', 'responseMessage'=>'没有权限');
        return $responseData;
    }
}
?>
