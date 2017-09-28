<?php
namespace Vpf\App\Ctrl;
use Vpf;

final class IndexCtrl extends \Vpf\Ctrl
{
	public function index(){
		$wechat_obj = new \vpfwchat();
		Vpf\P($wechat_obj->getMenu());
		// $listedSyllabus = array();
		// $html = new \simple_html_dom();
		// $html->load_file('http:'.__APP__.'/kebiao.html');
		// /* 课程表 */
		// $syllabus = $html->find('table#Table1', 0);
		// $allClasses = $syllabus->find('td[rowspan]');
		// foreach($allClasses as $classes){
		// 	if(isset($classes->align) && strtolower($classes->align) == 'center'){
		// 		//解析当前课程
		// 		$classInfo = $this->parseClassInfo($classes->innertext);
		// 		$listedSyllabus[$classInfo[1][0]][] = $classInfo;
		// 	}
		// }
		// Vpf\P($listedSyllabus);
		// $html->clear();
	}
	
	/* 这里处理的数据一定要是utf-8格式的，否则不保证正确性 */
	private function parseClassInfo($classInfo){
		$classInfo = explode('<br>', $classInfo);
		foreach($classInfo as $key=>$info){
			$classInfo[$key] = trim($info);
		}
		/* Array
        (
            [0] => 计算机组成与结构
            [1] => 周三第1,2节{第1-18周}
            [2] => 张少白
            [3] => 扬教1310
        ) */
		$time_tmp[0] = mb_substr($classInfo[1],1,1,'utf-8');
		switch($time_tmp[0]){
			case '日':
				$time_tmp[0] = 0;
			break;
			case '一':
				$time_tmp[0] = 1;
			break;
			case '二':
				$time_tmp[0] = 2;
			break;
			case '三':
				$time_tmp[0] = 3;
			break;
			case '四':
				$time_tmp[0] = 4;
			break;
			case '五':
				$time_tmp[0] = 5;
			break;
			case '六':
				$time_tmp[0] = 6;
			break;
		}
		$time_tmp[1] = preg_replace('/[^0-9\,\-\{\}]/us', '', $classInfo[1]);
		$classInfo[1] = $time_tmp;
		return $classInfo;
	}
	
    //生成微信端按钮
    public function editmenu(){
		$wechat_menu = array(
			'button' => array(
				array(
					'type' => 'click',
					'name' => '我要答题',
					'key' => 'TO_ANSWER',
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