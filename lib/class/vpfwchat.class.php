<?php
/* VPF微信平台类 */
if(!defined('IN_VPF')) die('Need VPF Framework!');
/* 导入微信接口 */
\Vpf\import('wechat',dirname(__FILE__).D_S.'wechat');
/* 导入错误码 */
\Vpf\import('errCode',dirname(__FILE__).D_S.'wechat');

class vpfwchat extends Wechat{
    
    public function __construct($options = null){
        if(is_null($options)){
            $options = array(
                'token'=>   defined('WCHAT_TOKEN') ? WCHAT_TOKEN : \Vpf\C('WCHAT_TOKEN'),
                'encodingaeskey'=> defined('WCHAT_ENCODINGAESKEY') ? WCHAT_ENCODINGAESKEY : \Vpf\C('WCHAT_ENCODINGAESKEY'),
                'appid'=>   defined('WCHAT_APPID') ? WCHAT_APPID : \Vpf\C('WCHAT_APPID'),
                'appsecret'=>   defined('WCHAT_APPSECRET') ? WCHAT_APPSECRET : \Vpf\C('WCHAT_APPSECRET'),
            );
        }
        /* 设置是否调试 */
        $this->debug = \Vpf\C('APP_DEBUG');
        parent::__construct($options);
        
    }
    
    /**
     * 重载日志记录方法
     * @param mixed $log 输入日志
     * @return mixed
     */
    protected function log($log){
        /* 是否输出调试信息 */
        if ($this->debug) {
            if (is_array($log)) $log = print_r($log,true);
            \Vpf\Log::record($log);
        }
        return true;
    }
    /**
     * 重载设置缓存
     * @param string $cachename
     * @param mixed $value
     * @param int $expired
     * @return boolean
     */
    protected function setCache($cachename, $value, $expired) {
        return \Vpf\S($cachename, $value, $expired);
    }

    /**
     * 重载获取缓存
     * @param string $cachename
     * @return mixed
     */
    protected function getCache($cachename) {
        return \Vpf\S($cachename);
    }

    /**
     * 重载清除缓存
     * @param string $cachename
     * @return boolean
     */
    protected function removeCache($cachename) {
        return \Vpf\S($cachename,null);
    }
}
?>