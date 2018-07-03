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
        $index = array('auth_c' => 'index','auth_a' => 'index');
        $welcome = array('auth_c' => 'index','auth_a' => 'welcome');
        $logout = array('auth_c' => 'index','auth_a' => 'logout');
        array_push($authorityData,$index,$welcome,$logout);
        foreach ($authorityData as $k => $v) {

            if($v['auth_c'] == $controlName && $v['auth_a'] == $methodName){
                $responseData = array('responseCode'=>'101', 'responseMessage'=>'可以访问');
                return $responseData;
                break;
            }
        }
        $responseData = array('responseCode'=>'100', 'responseMessage'=>'没有权限');
        return $responseData;
    }
}
?>
