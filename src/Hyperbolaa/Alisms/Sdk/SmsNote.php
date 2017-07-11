<?php
/**
 * 阿里短信服务的接口
 */
namespace Hyperbolaa\Alisms\Sdk;

use Hyperbolaa\Alisms\Lib\Helper;
use Hyperbolaa\Alisms\Core\Profile\DefaultProfile;
use Hyperbolaa\Alisms\Core\DefaultAcsClient;
use Hyperbolaa\Alisms\Lib\SendSmsRequest;
use Hyperbolaa\Alisms\Core\Regions\EndpointConfig;

class SmsNote
{

	private $domain    = 'dysmsapi.aliyuncs.com';//短信的请求地址
	private $region    = 'cn-hangzhou';//区域
	private $product   = 'Dysmsapi';//短信API产品名称

	private $access_key_id;
	private $access_key_secret;
	private $common_sign_name;//普通短信签名
	private $template_code;//短信模板
	private $enable_http_proxy = false;
	private $http_proxy_ip = '127.0.0.1';
	private $http_proxy_port = 8888;


	/**
	 * @param $tpl;         短信模板别名
	 * @param $phoneNum;    手机号,多手机号支持英文逗号隔开，最多20个手机号
	 * @param $smsValueArr; ['code'=>${code}]    code:模板的变量名称，$code:变量对应的值
	 * @return bool|string
	 */
	public function send($tpl, $phoneNum, $smsValueArr=[],$out_id=null){
		//定义代理
		define('ENABLE_HTTP_PROXY', $this->enable_http_proxy);
		define('HTTP_PROXY_IP',     $this->http_proxy_ip);
		define('HTTP_PROXY_PORT',   $this->http_proxy_port);

		EndpointConfig::initEndpoint();
		//初始化访问的acsCleint
		$profile = DefaultProfile::getProfile($this->region, $this->access_key_id, $this->access_key_secret);
		DefaultProfile::addEndpoint("cn-hangzhou", "cn-hangzhou", $this->product, $this->domain);
		$acsClient= new DefaultAcsClient($profile);
		$request = new SendSmsRequest();
		//dump(3);exit;
		//必填-短信接收号码。支持以逗号分隔的形式进行批量调用，批量上限为20个手机号码,批量调用相对于单条调用及时性稍有延迟,验证码类型的短信推荐使用单条调用的方式
		$request->setPhoneNumbers($phoneNum);
		//必填-短信签名
		$request->setSignName($this->common_sign_name);
		//必填-短信模板Code
		$request->setTemplateCode(isset($this->template_code[$tpl]) ? $this->template_code[$tpl] : '');
		//选填-假如模板中存在变量需要替换则为必填(JSON格式)
		!empty($smsValueArr) && $request->setTemplateParam(Helper::formatValue($smsValueArr));
		//选填-发送短信流水号
		$out_id && $request->setOutId($out_id);
		//发起访问请求
		$acsResponse = $acsClient->getAcsResponse($request);

		//返回数据
		if ($acsResponse->Code != 'OK') {
			return $acsResponse->Code.'---------'.$acsResponse->Message;//错误信息
		} else {
			return true;
		}
	}


	public function setAccessKeyId($value)
	{
		$this->access_key_id = $value;
		return $this;
	}

	public function setAccessKeySecret($value)
	{
		$this->access_key_secret = $value;
		return $this;
	}

	public function setCommonSignName($value)
	{
		$this->common_sign_name = $value;
		return $this;
	}

	public function setTemplateCode($value)
	{
		$this->template_code = $value;
		return $this;
	}


	public function setHttpProxy($value){
		$this->enable_http_proxy = $value;
		return $this;
	}

	public function setHttpProxyIp($value){
		$this->http_proxy_ip = $value;
		return $this;
	}

	public function setHttpProxyPort($value){
		$this->http_proxy_port = $value;
		return $this;
	}

}
