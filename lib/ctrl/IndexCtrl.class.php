<?php
namespace Vpf\App\Ctrl;
use Vpf;

final class IndexCtrl extends \Vpf\Ctrl
{
	public function index(){
		//$wechat_obj = new \vpfwchat();
		//Vpf\P($wechat_obj->getMenu());
		$this->display('pc_page/index');
		
	}
	
    //生成微信端按钮
    public function editmenu(){
		$wechat_menu = array(
			'button' => array(
				array(	// 开门按钮
					'type' => 'click',
					'name' => '芝麻开门！',
					'key' => 'OPEN_THE_EXT_DOOR',
				),
				array(
					'name' => '关于我们',
					'sub_button' => Array(
						array(
							'type' => 'view',
							'name' => '数据中心',
							'url' => 'http://139.129.19.29/',
						),
						array(
							'type' => 'click',
							'name' => '联系科协',
							'key' => 'CONTACT_US',
						)
					)
				)
			)
		);
		Vpf\P($wechat_menu);
		//exit;
		$weObj = new \vpfwchat();
		Vpf\P($weObj->getMenu());
		//exit;
		if($weObj->createMenu($wechat_menu)){
			echo 'success';
		}else{
			echo 'failed';
		}
	}
	
	public function print_arames(){
		Vpf\P($_GET);
		Vpf\P($_POST);
		Vpf\P($_COOKIE);
		$auth = new \vpfwechatauth();
		Vpf\P($auth->wxuser);
		Vpf\P($auth->open_id);
	}
}
?>