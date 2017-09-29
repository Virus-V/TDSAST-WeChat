<?php
namespace Vpf\App\Ctrl\Wechat;
use Vpf;

final class IndexCtrl extends \Vpf\Ctrl
{
    private $weObj = null;
    
	public function index()
	{
        $this->weObj = new \vpfwchat();
		$ret = $this->weObj->valid();
        if (!$ret) {
            Vpf\Log::record('valid failed');
            exit;
        }
        /* 被动接口必须调用 */
        $this->weObj->getRev();
        
        /* 获得消息类型 */
        $msgType = $this->weObj->getRevType();

        switch($msgType) {
            
            case \Wechat::MSGTYPE_TEXT:
                $this->parseText();
                break;

            case \Wechat::MSGTYPE_EVENT:
                $this->parseEvent();
                break;
                
            case \Wechat::MSGTYPE_IMAGE:
            
            case \Wechat::MSGTYPE_LOCATION:
                $this->parseLocation();
                break;
            
            case \Wechat::MSGTYPE_LINK:
                
            case \Wechat::MSGTYPE_MUSIC:
            
            case \Wechat::MSGTYPE_NEWS:
            
            case \Wechat::MSGTYPE_VOICE:
            
            case \Wechat::MSGTYPE_VIDEO:
            default:
                $this->weObj->text(Vpf\L('UNKNOW_MSGTYPE'))->reply();
        }
	}
    
    /* 处理文字信息函数 */
    private function parseText(){
        $content = $this->weObj->getRevContent();
        $this->weObj->text(Vpf\L('HELLO'))->reply();        
    }
    
    /* 处理发来的图片 */
    private function parseImage(){
        //todo
        // aa
    }
    
    /* 处理发来的位置信息 */
    private function parseLocation(){
        
    }
    
    /* 处理发来的链接 */
    private function parseLink(){
        
    }
    
    /* 处理事件 */
    private function parseEvent(){
        $eventInfo = $this->weObj->getRevEvent();
        
        switch($eventInfo['event']){
            /* 按钮点击事件，转发到点击事件处理服务中处理 */
            case \Wechat::EVENT_MENU_CLICK:
                $click_actn = strtolower($eventInfo['key']);
                $click_handle = new ClickEvent($this->weObj);
                /* 调用点击事件处理类中的名为小写的key的方法，否则调用默认方法 */
                if(method_exists($click_handle, $click_actn)){
                    $click_handle->$click_actn();
                }else{
                    $click_handle->_default();
                }
                
            break;
            /* 当新用户关注的时候 */
            case \Wechat::EVENT_SUBSCRIBE:
                $openId = $this->weObj->getRevFrom();
                $userInfo = $this->weObj->getUserInfo($openId);
                /* 发送欢迎信息 */
                /**
                 * 这个是关注就推送的新闻页，可以放多个新闻
                 */
				$reply = array(
                  	array(
                  		'Title'=> $userInfo['nickname'] . '，欢迎关注通达科协公众号！',
                  		'Description'=>'终于等到你，还好没放弃！',
                  		'PicUrl'=> 'http:'.__APP__.'/public/waiting_for_you.jpeg',
                  		'Url'=>'http://www.tdsast.cn'
                  	),
                );
                $this->weObj->news($reply)->reply();
            break;
            
            default: break;
        }
        
    }
    
    
    
    /* 处理发来的音乐 */
    private function parseMusic(){
        
    }
    
    /* 处理发来的图文消息 */
    private function parseNews(){
        
    }
    
    /* 处理发来的声音 */
    private function parseVoice(){
        
    }
    
    /* 处理发来的视频 */
    private function parseVideo(){
        
    }
}
?>