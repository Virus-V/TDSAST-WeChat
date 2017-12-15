<?php
namespace Vpf\App\Ctrl\Page;
use Vpf;

final class IndexCtrl extends \Vpf\Ctrl
{
	public function index(){
        $page = !empty($_GET['page']) ? $_GET['page'] : 'index';
		$this->display('page/'.$page);
	}
    
    // 认证
    public function do_auth() {
        // 判断是否存在openid参数
        if(empty($_GET['oi'])){
            Vpf\halt('Bad open id!');
        }
        session_start();
        // 装入openid和认证回调地址
        //TODO:小心这儿会不会有漏洞
        $_SESSION['openId'] = $_GET['oi'];
        $_SESSION['auth_callback'] = Vpf\U('THIS@THIS/add_info');
        // 认证跳转
        Vpf\redirect(Vpf\U('Authenticate/index'));
    }
    
    // 添加认证信息
    public function add_info(){
        /* 打开session */
        if(!isset($_SESSION)){
            session_start();
            session_write_close();
        }
        if($_SESSION['auth_result'][0] != true){
            echo '认证失败';
        }
        // 插入到acl table
        $m_acl = Vpf\M('acl_table');
        $acl_data = array(
            'openid' => $_SESSION['openId'],
            'stu_id' => $_SESSION['auth_response']['xsgrxx']['stu_id']
        );
        $m_acl->create($acl_data);
        $m_acl->insert(true);   // 插入新纪录或者替换原记录
        // 插入到student_info
        $m_student_info = Vpf\M('student_info');
        /* 插入个人信息 */
        $m_student_info->create($_SESSION['auth_response']['xsgrxx']);
        $m_student_info->insert(true);
        echo '认证成功，请再次开门';
    }
}
?>