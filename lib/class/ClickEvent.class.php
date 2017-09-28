<?php
namespace Vpf\App\Ctrl\Wechat;
use Vpf;

/* 点击事件处理类 */
class ClickEvent{
    private $weObj = null;
    
    public function __construct(&$weObj = null){
        if(!is_null($weObj)){
            $this->weObj = $weObj;
        }else{
            Vpf\halt('ClickEvent need weObj!');
        }
    }
    
    /* 传入一个未定义的key，则调用这个 */
    public function _default(){
        return $this->weObj->text(Vpf\L('UNKNOW_ACTION'))->reply();
    }
    
    /* 英语提高 */
    public function to_answer(){
        $news = array(
            array(
                'Title'=>'答你MMP',
                'Description'=> 'http:'.__APP__ . Vpf\U('Index/print_arames'),
                'PicUrl'=>'https://ss0.bdstatic.com/5aV1bjqh_Q23odCf/static/superman/img/logo/bd_logo1_31bdc765.png',
                'Url'=> 'http:'.__HOST__ . Vpf\U('Index/print_arames'),
            ),
	    );
        return $this->weObj->news($news)->reply();
    }
    
    /* 联系我们 */
    public function contact_us(){
        $aboutus = "南京邮电大学科学与技术协会\n网络部：3447950359\n电子部：\n计算机部：";
        return $this->weObj->text($aboutus)->reply();
    }
}
?>