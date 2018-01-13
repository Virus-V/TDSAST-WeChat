<?php
namespace Vpf\App\Ctrl\Wechat;
use Vpf;

/* 点击事件处理类 */
class ClickEvent{
    private $weObj = null;
    private $phrase = array(
        "如果你是异性，你会不会爱上现在的自己？？",
        "你现在的努力，配得上未来你想要的生活吗？？？",
        "别配不上你的野心，别辜负你受的苦！！",
        "你所有的努力，只为遇见更美好的自己。",
        "你真的愿意，让这么恶心的人，压在你头上吗？！！",
        "再不努力，她就会跟你说，对不起，我们还是做朋友吧，ATM机会告诉你，您好，你的余额已不足。",
        "你以后给父母买东西的时候，能不能像他们现在一样，毫不犹豫。",
        "再不努力，生命就不只是眼前的苟且，还有未来的苟且。",
        "你多学一样本事，以后就少说一句求人的话！！",
        "你今天翻的是书，明天你数的就是钱！",
        "你记得第二个登上月球的人吗，不记得！",
        "你的情敌，正在偷偷用工，那些你讨厌的人，现在比你更努力！！",
        "你现在不努力，以后连婚纱都是租的！",
        "你可以上二流的大学，但是你不可以过二流的人生！！",
        "父母风吹日晒起早贪黑，赚的辛苦血汗钱供你吃供你穿供你用，你凭什么不努力？！",
        "总是有人要赢得，为什么不是你！！",
        "不逼自己一把，你怎么知道自己有多优秀？",
        "你不能把这个世界，让给所鄙视的人",
        "你，不是富二代，但你要让你的孩子成为富二代！",
        "让你自己成为豪门，而不是嫁进去",
        "你不能拼爹，所以你只能拼命",
        "别忘了，你曾经也是第一名",
        "别成为你当初最厌恶的人",
        "要成为你爸妈吹牛逼的资本！",
    );
    
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
                      'Url' => 'http:' . __HOST__ . Vpf\U('page@index/do_auth', 'oi='.$openId)
                  ),
            );
            return $this->weObj->news($reply)->reply();
        }else{
            if($permit_info['permit'] == 1){  // 已进行权限认证
                // 认证不成功返回认证页面
                Vpf\import('phpMQTT');
                $mqtt_broker_cfg = Vpf\C('MQTT_CFG');
                $mqtt = new \Bluerhinos\phpMQTT($mqtt_broker_cfg['mqtt_broker_ip'], $mqtt_broker_cfg['mqtt_broker_port'], $mqtt_broker_cfg['client_id']);
                // 日志记录模型
                $m_door_log = Vpf\M('door_log');
                if ($mqtt->connect(true, NULL, $mqtt_broker_cfg['username'], $mqtt_broker_cfg['password'])) {
                    $mqtt->publish("td_cloud/tdsast/ext_door", "Lock ON", 0);
                    $mqtt->close();
                    // 查询前三次开门者
                    $last_opener = $m_door_log->order('`time` desc')
                        ->join('`__STUDENT_INFO__` on `__DOOR_LOG__`.`stu_id` = `__STUDENT_INFO__`.`stu_id`')
                        ->limit(3)->select();
                    // 插入日志
                    $m_door_log->addLog($permit_info['stu_id']);
                    // 构造应答
                    $reply = "新世界的大门已打开～";
                    $reply .= "\n". $this->phrase[rand(0, count($this->phrase)-1)];
                    foreach($last_opener as $opener){
                        $reply .= "\n". $opener['realname'] .'（'.$opener['stu_id'].'）于'. date('Y-m-d H:i:s', $opener['time']). '开门'.($opener['result'] ? '成功' : '失败');
                    }
                } else {
                    $reply = "请求超时。。";
                    // 插入日志，开门失败
                    $m_door_log->addLog($permit_info['stu_id'], 0);
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
