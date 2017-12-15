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
    
    /* 打开科协大门 */
    public function open_the_ext_door(){
        // 获得当前用户的openid
        $openId = $this->weObj->getRevFrom();
        // 先进行权限认证
        $m_acl = Vpf\M('acl_table');
        $permit_info = $m_acl->getInfo($openId);
        if(is_null($permit_info)){  // 还没进行权限认证，发送权限认证链接
            // 获得昵称
            $userInfo = $this->weObj->getUserInfo($openId);
            // Vpf\P();
            $reply = array(
                  array(
                      'Title'=> $userInfo['nickname'] . '，获得开门权限请先认证！',
                      'Description' => '只有科协的现任部员才能获得开门权限噢',
                      'PicUrl' => 'http:' . __APP__ . '/public/renzheng.jpeg',
                      // 认证URL
                      'Url' => 'http:' . __APP__ . Vpf\U('page@index/do_auth', 'oi='.$openId)
                  ),
            );
            return $this->weObj->news($reply)->reply();
        }else{
            if($permit_info['permit'] == 1){  // 已进行权限认证
                // 认证不成功返回认证页面
                Vpf\import('phpMQTT');
                $mqtt_broker_cfg = Vpf\C('MQTT_CFG');
                $mqtt = new \Bluerhinos\phpMQTT($mqtt_broker_cfg['mqtt_broker_ip'], $mqtt_broker_cfg['mqtt_broker_port'], $mqtt_broker_cfg['client_id']);
    
                if ($mqtt->connect(true, NULL, $mqtt_broker_cfg['username'], $mqtt_broker_cfg['password'])) {
                    $mqtt->publish("td_cloud/tdsast/ext_door", "Lock ON", 0);
                    $mqtt->close();
                    $reply = "新世界的大门已打开～";
                } else {
                    $reply = "请求超时。。";
                }
            }else{
                $reply = "没有权限，请联系你部长代开或者联系管理员。";
            }
            return $this->weObj->text($reply)->reply();
        }  
    }
    
    /* 联系我们 */
    public function contact_us(){
        // 认证
        $aboutus = "管理员：\nQQ:1124732794\n电话：13813146651";
        return $this->weObj->text($aboutus)->reply();
    }
}
?>