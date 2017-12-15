<?php
namespace Vpf\App\Ctrl;
use Vpf,Vpf\App;

final class AuthenticateCtrl extends \Vpf\Ctrl{
	
	public function __construct(){
		parent::__construct();
		/* curl版本低于7.35.0的话，重定向会失败 */
		if(extension_loaded('curl')){
			$curl_version = curl_version();
			if(version_compare($curl_version['version'], '7.35.0', '<')){
				define('IS_CURL_OK', false);
			}else{
				define('IS_CURL_OK', true);
			}
		}else{
			define('IS_CURL_OK', false);
		}
		//define('IS_CURL_OK', false);
	}
	
    public function index(){
		set_time_limit(5);
		/* 打开session */
        if(!isset($_SESSION)){
            session_start();
            session_write_close();
        }
		/* 判断是否有回调地址 */
		if(empty($_SESSION['auth_callback'])){
			Vpf\halt('missing callback url!');
		}
		
		$url = 'http://42.247.7.170/default2.aspx';
		$referer = 'http://42.247.7.170/';
		
		if(IS_CURL_OK){
			$headerArr = array(
				'Referer:' . $referer,
			);
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_HEADER, TRUE);    //表示需要response header
			curl_setopt($ch, CURLOPT_NOBODY, FALSE); //表示需要response body
			curl_setopt($ch, CURLOPT_HTTPHEADER , $headerArr );  //构造IP
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, FALSE);
			curl_setopt($ch, CURLOPT_TIMEOUT, 300);
			$result_temp = curl_exec($ch);
			$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			curl_close ( $ch );
			list($headers,$result) = explode("\r\n\r\n",$result_temp, 2);
		}else{
			/* 初始化网页抓取类 */
			$snoopy = new \Snoopy();
			$snoopy->agent = 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/49.0.2623.87 Safari/537.36';
			$snoopy->referer = $referer;
			$snoopy->rawheaders['Connection'] = 'close';
			if(!$snoopy->fetch($url)){
				Vpf\halt($snoopy->error);
			}
			$result = $snoopy->results;
			$headers = join('', $snoopy->headers);
			$httpcode = $snoopy->status;
			unset($snoopy);
		}
		/* 判断正方是否正常打开 */
        if ($httpcode != '200') Vpf\halt(Vpf\L('ZF_OPEN_FAILED'));
		
		if(preg_match('/Set-Cookie:[\s+](.*);/iU',$headers,$cookie)){
			header('Set-Cookie: '.$cookie[1].'; path=/');
		}
		/* 去掉空白，制表，换行符 */
		$result = preg_replace("/[\t\n\r]+/","",$result);
		
		/* 构建html DOM解析器 */
		$html = new \simple_html_dom();
		$html->load($result);
		$charsetDOM = $html->find('meta[http-equiv="Content-Language"]', 0, true); //不区分大小写
		/* 获得原网页的字符集 */
		$rawCharset = !is_null($charsetDOM) && isset($charsetDOM->content) ? $charsetDOM->content : 'gb2312';
		$html->clear();
		unset($charsetDOM);
		$regex="/.*?<form(.*?)>(.*?)<\/form>.*?/i";
		if(preg_match_all($regex, $result, $matches)){
			//$result = iconv('gb2312','utf-8',$matches[2][0]);
			$result = Vpf\auto_charset($matches[2][0], $rawCharset);
			/* 重新加载内容 */
			$html->load($result);
			$pageArray = array();
			/* 获得验证码地址 */
			$icode = $html->find('img#icode',0);
			$pageArray['vcode'] = 'http://42.247.7.170/'.ltrim($icode->src,'/');
			
			/* 得到form的属性 */
			$formAttrs = explode(' ',trim($matches[1][0]));
			foreach($formAttrs as $formAttr){
				list($faKey,$faVal) = explode('=',$formAttr);
				$pageArray['form'][$faKey] = trim($faVal,'"');
			}
			/* 抓取所有登录表单元素 */
			if($inputGroup = $html->find('input')){
				foreach($inputGroup as $inputItem){
					$pageArray['input'][] = $inputItem->type.'#'.$inputItem->name.(($inputValue = $inputItem->value) ? '#'.$inputValue : '');
				}
			}
			$html->clear();
		}
		
        foreach($pageArray['input'] as $input){
            $inputA = explode('#',$input);
            if(($inputType = array_shift($inputA)) != 'hidden') continue;
            
            if(($cnt = count($inputA)) == 2){
                $hiddenInput[$inputA[0]] = $inputA[1];
            }elseif($cnt == 1){
                $hiddenInput[$inputA[0]] = '';
            }
        }
        $this->assign('hiddenInput',$hiddenInput);
        $_urls['vcode'] = Vpf\U('THIS/getvcode','xuexiaoshabi=true');
        $_urls['zflogin'] = Vpf\U('THIS/zflogin', 'charset='.$rawCharset);
        /* 之前登录过，但失败了 */
        if(isset($_GET['failed']) && $_GET['failed']){
            /* 显示失败信息 */
            $this->assign('showfail', true);
        }
        $this->assign('_URLS',$_urls);
        $this->display('zf_login/login');
    }
	
	/* 获取验证码 */
    public function getvcode(){
        $url = 'http://42.247.7.170/CheckCode.aspx';
		if(IS_CURL_OK){
			$headerArr = array(
				'Referer:http://42.247.7.170/',
			);
			if(isset($_COOKIE['ASP_NET_SessionId'])){
				$headerArr[] = 'Cookie: ASP.NET_SessionId='.$_COOKIE['ASP_NET_SessionId'];
			}
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_HEADER, TRUE);    //表示需要response header
			curl_setopt($ch, CURLOPT_NOBODY, FALSE); //表示需要response body
			curl_setopt($ch, CURLOPT_HTTPHEADER , $headerArr );  //构造IP
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, FALSE);
			//curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
			curl_setopt($ch, CURLOPT_TIMEOUT, 120);
			$result_temp = curl_exec($ch);
			$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			curl_close ( $ch );
			list($headers,$result) = explode("\r\n\r\n",$result_temp, 2);
		}else{
			/* 初始化网页抓取类 */
			$snoopy = new \Snoopy();
			$snoopy->agent = 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/49.0.2623.87 Safari/537.36';
			$snoopy->referer = 'http://42.247.7.170/';
			$snoopy->rawheaders['Connection'] = 'close';
			if(isset($_COOKIE['ASP_NET_SessionId'])){
				$snoopy->cookies['ASP.NET_SessionId'] = $_COOKIE['ASP_NET_SessionId'];
			}
			if(!$snoopy->fetch($url)){
				Vpf\halt($snoopy->error);
			}
			$result = $snoopy->results;
			$httpcode = $snoopy->status;
			$headers = join('', $snoopy->headers);
			unset($snoopy);
			
		}
		if ($httpcode == '200') {
			if(preg_match('/Set-Cookie:[\s+](.*);/iU',$headers,$cookie)){
				header('Set-Cookie: '.$cookie[1].'; path=/');
			}
			header('Content-Type:image/Gif');
			echo $result;
		}
    }
	
    /* 正方教务登录 */
    public function zflogin(){
		
        $url = 'http://42.247.7.170/default2.aspx';
        $_POST['RadioButtonList1'] = iconv('utf-8','gb2312','学生'); //urlencode((gb2312)学生);
        $_POST['Button1'] = '';
        $_POST['lbLanguage'] = '';
		
        //$_POST['hidPdrs'] = '';
        //$_POST['hidsc'] = '';
        //$_POST['Textbox1'] = '';
		
		/* 设置源字符集 */
        $rawCharset = isset($_GET['charset']) ? trim($_GET['charset']) : 'gb2312';
		if(IS_CURL_OK){
			$headerArr = array(
				'Referer: http://42.247.7.170/default2.aspx',
				'Content-Type: application/x-www-form-urlencoded',
				'Host: 42.247.7.170',
				'Origin: http://42.247.7.170',
				'User-Agent: Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/49.0.2623.87 Safari/537.36',
			);
			/* 加入cookies */
			if(isset($_COOKIE['ASP_NET_SessionId'])){
				$headerArr[] = 'Cookie: ASP.NET_SessionId='.$_COOKIE['ASP_NET_SessionId'];
			}
			$ch = curl_init ();
			curl_setopt ( $ch, CURLOPT_URL, $url );
			curl_setopt ( $ch, CURLOPT_POST, 1 );
			curl_setopt ( $ch, CURLOPT_HEADER, 0 );
			curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
			curl_setopt ( $ch, CURLOPT_SSL_VERIFYHOST, 2 );
			curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, 0 );
			curl_setopt ( $ch, CURLOPT_FOLLOWLOCATION, 1 ); // 302 redirect
			/* 抽一下脸，纪念我曾经的傻逼 */
			curl_setopt ( $ch, CURLOPT_HTTPHEADER , $headerArr );  //构造IP
			curl_setopt ( $ch, CURLOPT_POSTFIELDS, http_build_query($_POST) );
			curl_setopt ( $ch, CURLOPT_TIMEOUT, 300);
			$result = curl_exec ( $ch );
			$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			curl_close ( $ch );
		}else{
			$headerArr = array(
				'Host' => '42.247.7.170',
				'Origin' => 'http://42.247.7.170',
				'Connection' => 'close',
			);
			/* 初始化网页抓取类 */
			$snoopy = new \Snoopy();
			/* 加入cookies */
			if(isset($_COOKIE['ASP_NET_SessionId'])){
				$snoopy->cookies['ASP.NET_SessionId'] = $_COOKIE['ASP_NET_SessionId'];
			}
			$snoopy->agent = 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/49.0.2623.87 Safari/537.36';
			$snoopy->referer = 'http://42.247.7.170/default2.aspx';
			/* 设置http请求头 */
			$snoopy->rawheaders = $headerArr;
			if(!$snoopy->submit($url, $_POST)){
				Vpf\halt($snoopy->error);
			}
			$result = $snoopy->results;
			$httpcode = $snoopy->status;
			unset($snoopy);
		}
		
		/* 判断正方是否正常打开 */
        if ($httpcode != '200') Vpf\halt(Vpf\L('ZF_OPEN_FAILED'));
		
		/** 判断是否登录成功，检查是否有退出按钮 */
		/* 构建html DOM解析器 */
		$html = new \simple_html_dom();
		$html->load($result);
		$likTcDOM = $html->find('#likTc', 0);
		/* 如果没有找到id="likTc"的元素，则表示登录失败 */
		if(is_null($likTcDOM)){
			/* $parame = array(
                'failed' => true
            );
			Vpf\redirect(Vpf\U('THIS/index', $parame)); */
			// 返回json格式的数据
			$this->ajax_return(array('result'=>false), '登录失败啦！');
			exit;
		}
		$html->clear();
		unset($likTcDOM);
		// ***************************************
		// 登录成功
		// ***************************************
		// 成绩查询 ：xscj_gc.aspx?xh=15220109&xm=荣卓然&gnmkdm=N121605
		// 课表查询 ：xskbcx.aspx?xh=15220109&xm=荣卓然&gnmkdm=N121603
		// 学生个人信息：xsgrxx.aspx?xh=15220109&xm=荣卓然&gnmkdm=N121501
        /* if(preg_match('/.*?<a.+"(xsgrxx\.aspx\?.*?)".*?>.*?<\/a>.*?/i',$result,$stuInfoUrl)){ */
        if(preg_match_all('/href="((xscj_gc|xskbcx|xsgrxx)\.aspx\?xh=.*?)"/i',$result, $stuInfoUrl)){
            $parsedInfo = array();
            foreach($stuInfoUrl[2] as $key => $type){
				if(!method_exists($this, $type)) continue;
				$parsedInfo[$type] = $this->$type('http://42.247.7.170/' . Vpf\auto_charset($stuInfoUrl[1][$key], $rawCharset), $rawCharset);
			}
            session_start();
			$_SESSION['auth_result'] = array(true,'Success.');
			$_SESSION['auth_response'] = $parsedInfo;
            session_write_close();
			$this->go_callback();
        }else{
			//Vpf\halt(Vpf\L('WTF ERROR?!'));
			session_start();
			$_SESSION['auth_result'] = array(false, 'Profile information links are not found');
            session_write_close();
			$this->go_callback();
        }
    }
	
    /* 课表查询 */
    private function xskbcx($url, $rawCharset = 'gb2312'){
		$parsedInfo = array();
        /* 从正方获得学生信息 */
		if(IS_CURL_OK){
			$headerArr = array(
				'Referer:http://42.247.7.170/',
				'User-Agent: Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/49.0.2623.87 Safari/537.36',
			);
			if(isset($_COOKIE['ASP_NET_SessionId'])){
				$headerArr[] = 'Cookie: ASP.NET_SessionId='.$_COOKIE['ASP_NET_SessionId'];
			}
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_HEADER, false);    //表示需要response header
			curl_setopt($ch, CURLOPT_NOBODY, FALSE); //表示需要response body
			curl_setopt($ch, CURLOPT_HTTPHEADER , $headerArr );  //构造IP
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, FALSE);
			//curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
			curl_setopt($ch, CURLOPT_TIMEOUT, 120);
			$result = curl_exec($ch);
			$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			curl_close ( $ch );
		}else{
			/* 初始化网页抓取类 */
			$snoopy = new \Snoopy();
			$snoopy->agent = 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/49.0.2623.87 Safari/537.36';
			$snoopy->referer = 'http://42.247.7.170/';
			$snoopy->rawheaders['Connection'] = 'close';
			if(isset($_COOKIE['ASP_NET_SessionId'])){
				$snoopy->cookies['ASP.NET_SessionId'] = $_COOKIE['ASP_NET_SessionId'];
			}
			if(!$snoopy->fetch($url)){
				Vpf\halt($snoopy->error);
			}
			$result = $snoopy->results;
			$httpcode = $snoopy->status;
			unset($snoopy);
		}
        
        if($httpcode != 200) return null;
        /* 删除空白字符 */
        $result=preg_replace("/[\t\n\r]+/","",$result);
		
		$listedSyllabus = array();
		$html = new \simple_html_dom();
		$html->load(Vpf\auto_charset($result, $rawCharset));
		/* 课程表 */
		$syllabus = $html->find('table#Table1', 0);
		if(is_null($syllabus)) return null;
		//找到所有tr，并弹出第一个
		$allTrExceptFirst = $syllabus->find('tr');
		array_shift($allTrExceptFirst);
		/* 遍历剩下的tr元素 */
		foreach($allTrExceptFirst as $trElement){
			/* 找到所有带align属性的td元素 */
			$allClasses = $trElement->find('td[align]');
			foreach($allClasses as $classes){
				if($classes->innertext != '&nbsp;'){
					//解析当前课程
					$classInfo = $this->parseClassInfo($classes->innertext);
					$listedSyllabus[$classInfo[1][0]][] = $classInfo;
				}
			}
		}
		$html->clear();
		return $listedSyllabus;
	}
	
	/* 获得成绩 */
    private function xscj_gc($url, $rawCharset = 'gb2312'){
		return null;
	}
	
    /* 获得个人信息 */
    private function xsgrxx($url, $rawCharset = 'gb2312'){
		$parsedInfo = array();
        /* 从正方获得学生信息 */
		if(IS_CURL_OK){
			$headerArr = array(
				'Referer:http://42.247.7.170/',
				'User-Agent: Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/49.0.2623.87 Safari/537.36',
			);
			if(isset($_COOKIE['ASP_NET_SessionId'])){
				$headerArr[] = 'Cookie: ASP.NET_SessionId='.$_COOKIE['ASP_NET_SessionId'];
			}
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_HEADER, false);    //表示需要response header
			curl_setopt($ch, CURLOPT_NOBODY, FALSE); //表示需要response body
			curl_setopt($ch, CURLOPT_HTTPHEADER , $headerArr );  //构造IP
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, FALSE);
			//curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
			curl_setopt($ch, CURLOPT_TIMEOUT, 120);
			$result = curl_exec($ch);
			$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			curl_close ( $ch );
		}else{
			/* 初始化网页抓取类 */
			$snoopy = new \Snoopy();
			$snoopy->agent = 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/49.0.2623.87 Safari/537.36';
			$snoopy->referer = 'http://42.247.7.170/';
			$snoopy->rawheaders['Connection'] = 'close';
			if(isset($_COOKIE['ASP_NET_SessionId'])){
				$snoopy->cookies['ASP.NET_SessionId'] = $_COOKIE['ASP_NET_SessionId'];
			}
			if(!$snoopy->fetch($url)){
				Vpf\halt($snoopy->error);
			}
			$result = $snoopy->results;
			$httpcode = $snoopy->status;
			unset($snoopy);
		}
        
        if($httpcode != 200) return null;
		
        /* 删除空白字符 */
        $result=preg_replace("/[\t\n\r]+/","",$result);
        if(preg_match('/.*?(<table class="formlist" width="100%" align="center">.*?<\/table>).*?/U',$result,$stuInfoTable)){ //寻找必要信息
            if($userInfo = $this->fetchStudentData(Vpf\auto_charset($stuInfoTable[1], $rawCharset))){ 
				return $userInfo;
            }else{
                App\dump_log(Vpf\L('FETCH_PROFILE_FAILED'));
				return null;
            }
        }else{ //没找到必要信息
            /* 记录错误 */
            file_put_contents(TEMP_PATH.D_S. date('y-m-d H:i:s').'.html', $result);
            //没找到必要信息
            return null;
        }
    }

	/* 处理课表条目 这里处理的数据一定要是utf-8格式的，否则不保证正确性 */
	private function parseClassInfo($classInfo){
		$classInfo = explode('<br>', $classInfo);
		foreach($classInfo as $key=>$info){
			$classInfo[$key] = trim($info);
		}
		/* Array
        (
            [0] => 计算机组成与结构
            [1] => 周三第1,2节{第1-18周}
            [2] => 张少白
            [3] => 扬教1310
        ) */
		$time_tmp[0] = mb_substr($classInfo[1],1,1,'utf-8');
		switch($time_tmp[0]){
			case '日':
				$time_tmp[0] = 0;
			break;
			case '一':
				$time_tmp[0] = 1;
			break;
			case '二':
				$time_tmp[0] = 2;
			break;
			case '三':
				$time_tmp[0] = 3;
			break;
			case '四':
				$time_tmp[0] = 4;
			break;
			case '五':
				$time_tmp[0] = 5;
			break;
			case '六':
				$time_tmp[0] = 6;
			break;
		}
		$time_tmp[1] = preg_replace('/[^0-9\,\-\{\}]/us', '', $classInfo[1]);
		$classInfo[1] = $time_tmp;
		return $classInfo;
	}
	
    /* 抓取必要的信息 */
    private function fetchStudentData($html_raw){
        /* 网页元素类型，0 input，1 span */
        $mustInfo = array(
            'gender' => array('#lbl_xb', 1), //性别
            'stu_id' => array('#xh', 1), //学号
            'realname' => array('#xm', 1), //真实姓名
            'nation' => array('#lbl_mz', 1), //民族
            'department' => array('#lbl_zymc', 1), //专业
            'idnumber' => array('#lbl_sfzh', 1), //身份证号
        );
        /* 可选内容，这是可以被学生修改的，在网页上是个input，所以要用value属性 */
        $optionalInfo = array(
            'phone' => array('#TELNUMBER', 0), //手机号
            'qq' => array('#dzyxdz', 0), //邮箱，从邮箱中提取QQ
            'hometown' => array('#lbl_jtszd', 1), //家庭所在地
        );
        /* 用户信息 */
        $userInfo = array();
        
        $html = new \simple_html_dom();
        $html->load($html_raw);
        /* 抓取必须数据，如果有一个为空则表示失败 */
        foreach($mustInfo as $key => $dom_info){
            /* 判断该dom的类型，选择提取值的方式 */
            $tmp_fetch = trim($dom_info[1] ? $html->find($dom_info[0], 0)->plaintext : $html->find($dom_info[0], 0)->value);
            /* 判断是否满足错误条件 */
            if(empty($tmp_fetch))return false;
            $userInfo[$key] = $tmp_fetch;
        }
        /* 抓取非必须数据，如果为空则继续抓，尽力而为 */
        foreach($optionalInfo as $key => $dom_info){
            /* 判断该dom的类型，选择提取值的方式 */
            $tmp_fetch = trim($dom_info[1] ? $html->find($dom_info[0], 0)->plaintext : $html->find($dom_info[0], 0)->value);
            /* 如果不为空就加到数组里 */
            if(!empty($tmp_fetch))
                $userInfo[$key] = $tmp_fetch;
        }
        /* 清理 */
        $html->clear();
        unset($key, $dom_info);
        
        /* 如果抓到了邮箱信息同时邮箱里面包含@qq三个字符，表示前面的是qq号 */
        if(isset($userInfo['qq']) && strpos($userInfo['qq'], '@qq') !== null){
            $userInfo['qq'] = substr($userInfo['qq'], 0, -7);
        }
        /* 没有抓到家庭住址信息，从身份证号中获取家庭住址 */
        if(!isset($userInfo['hometown'])){
            $m_area_code = Vpf\M('area_code');
            /* 获取身份证前6位 */
            $where['code'] = substr($userInfo['idnumber'], 0,6);
            $home_info = $m_area_code->field('area')->where($where)->find();
            if($home_info){
                $userInfo['hometown'] = $home_info['area'];
            }
        }
        $userInfo['birthday'] = substr($userInfo['idnumber'], 6, 8);
        return $userInfo;
    }
	
	private function go_callback(){
		if(isset($_SESSION['auth_callback'])){
			//Vpf\redirect($_SESSION['auth_callback']);
			$this->ajax_return(array('result' => true,'callback' => $_SESSION['auth_callback']), '登录成功！');
		}
		exit;
	}
}
?>