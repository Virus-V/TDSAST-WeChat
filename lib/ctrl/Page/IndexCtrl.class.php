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
        if(empty($_SESSION['auth_result']) || $_SESSION['auth_result'][0] != true){
            $this->assign('info', "<h1>认证失败！</h1><p>非常抱歉，你的信息认证失败了，请确保你现在是通达的学生，或者手动访问正方教务系统查看是否可以正常登录，是否填写教师评价等。</p>");
            $this->display('wechat_page/tips');
            exit;
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

        $this->assign('info', "<h1>认证成功！</h1><p>{$_SESSION['auth_response']['xsgrxx']['realname']}同学，你已认证成功，认证成功后不需要再次认证。</p><p>请关掉该页面后再次开门。</p>");
        $this->display('wechat_page/tips');
    }
}
?>
