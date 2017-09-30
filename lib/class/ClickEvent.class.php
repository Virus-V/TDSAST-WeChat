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
        return $this->weObj->text($reply)->reply();
    }
    
    /* 联系我们 */
    public function contact_us(){
        $aboutus = "南京邮电大学科学与技术协会\n网络部：3447950359\n电子部：\n计算机部：";
        return $this->weObj->text($aboutus)->reply();
    }
}
?>