<?php
namespace Vpf\App\Ctrl\Page;
use Vpf;

final class IndexCtrl extends \Vpf\Ctrl
{
	public function index()
	{
        $page = !empty($_GET['page']) ? $_GET['page'] : 'index';
		$this->display('page/'.$page);
	}
    
    public function czk()
	{
        $id = !empty($_GET['id']) ? intval($_GET['id']) : 0;
        $this->assign('addphone',Vpf\U('page@index/addphone'));
        $m_raffle = Vpf\M('raffle');
        $wcuser = $m_raffle->where(array('id'=>$id))->find();
        $this->assign('wcuser',$wcuser);
		$this->display('page/czk');
	}
    
    public function addphone(){
        $m_raffle = Vpf\M('raffle');
        unset($_POST['is_draw'],$_POST['openid'],$_POST['is_enable'],$_POST['prize'],$_POST['date']);
        $m_raffle->create();
        if($m_raffle->update()){
            $this->ajax_return(null,true);
        }else{
            $this->ajax_return(null,false);
        }
    }
}
?>