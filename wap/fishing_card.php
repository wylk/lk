<?php
require_once dirname(__FILE__).'/global.php';
if(empty($wap_user)) redirect('./login.php?referer='.urlencode($_SERVER['REQUEST_URI']));

$action =  isset($_GET['action'])?$_GET['action']:'index';
if(IS_POST){
	switch ($action) {
		case 'ren':
				$data = clear_html($_POST);
				$datas['uid'] = $wap_user['userid'];
				$datas['card_id'] = $data['card_id'];
				$datas['num'] = $data['num'];
				$datas['len_meg'] = $data['len_meg'];
				if(D('Fishing_card')->data($datas)->add()){
					dexit(['error'=>0,'msg'=>'操作成功']);
				}else{
					dexit(['error'=>1,'msg'=>'操作失败']);
				}
				
			break;
		case 'index':
				
			break;
		default:
			# code...
			break;
	}
}
$Card_package_list = D('')->table("Card_package as a")->join('Card as b ON a.card_id=b.card_id','LEFT')
							-> where('a.uid='.$wap_user['userid'].' and a.type="offset" and b.c_id=1')
							-> field("a.*,b.val")
							-> select();
include display('fishing_card');
echo ob_get_clean();