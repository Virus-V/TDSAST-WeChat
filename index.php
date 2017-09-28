<?php
namespace Vpf\App;
use Vpf;

define('APP_NAME','TDSAST_WChat');
define('APP_VERSION','1.1.0');
define('APP_ENTRY',__FILE__);
define('APP_PATH',dirname(__FILE__));
define('VPF_PATH',dirname(APP_PATH).'/vpf');
require VPF_PATH.'/vpf.php';

// 科协微信公众号（个人主体）
// define('WCHAT_TOKEN','e916e7eb18b20c399307e2d1e8971faa');
// define('WCHAT_ENCODINGAESKEY','HRxyFWKxK9vOVg80jizyl6Fzr8XCmxNw8jxeMDvPJCm');
// define('WCHAT_APPID','wx5e7976716f37e2d3');
// define('WCHAT_APPSECRET','ae313bf8d6b3d084d4a5404c41c667fd');

// 我的测试号
define('WCHAT_TOKEN','e916e7eb18b20c399307e2d1e8971faa');
define('WCHAT_ENCODINGAESKEY','HRxyFWKxK9vOVg80jizyl6Fzr8XCmxNw8jxeMDvPJCm');
define('WCHAT_APPID','wx13eb64b80cf71a83');
define('WCHAT_APPSECRET','97317fb3699390f4caa444615f30115e');

/* 打开session */
session_start();

$app = new Vpf\App(); /* 创建控制器实例 */
$app->run();

?>
