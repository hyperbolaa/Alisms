<?php
/**
 * 阿里短信服务的接口
 */
namespace Hyperbolaa\Alisms\Sdk;


use Hyperbolaa\Alisms\Lib\Helper;
use Hyperbolaa\Alisms\Lib\Http;

class SmsYun
{

	private $sms_url    = 'https://sms.aliyuncs.com/?';//短信的请求地址
	private $sms_action = 'SingleSendSms';//操作方法

	private $access_key_id;
	private $access_key_secret;
	private $common_sign_name;//普通短信签名
	private $spread_sign_name;//推广短信签名
	private $template_code;//短信模板


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

	public function setSpreadSignName($value)
	{
		$this->spread_sign_name = $value;
		return $this;
	}


	public function setTemplateCode($value)
	{
		$this->template_code = $value;
		return $this;
	}

	/**
	 * 短信发送
	 */
	/**
	 * @param $tpl;         短信模板别名
	 * @param $phoneNum;    手机号
	 * @param $smsValueArr; ['code'=>${code}]    code:模板的变量名称，$code:变量对应的值
	 * @return bool|string
	 */
	public function send($tpl, $phoneNum, $smsValueArr){
		$request_paras = [];

		$request_paras['TemplateCode']      = isset($this->template_code[$tpl]) ? $this->template_code[$tpl] : '';
		$request_paras['ParamString']       = Helper::formatValue($smsValueArr);
		$request_paras['RecNum']            = $phoneNum;
		$request_paras['AccessKeyId']       = $this->access_key_id;
		$request_paras['SignName']          = $this->common_sign_name;
		$request_paras['Action']            = $this->sms_action;
		$request_paras['Format']            = 'JSON';
		$request_paras['Version']           = '2016-09-27';
		$request_paras['SignatureMethod']   = 'HMAC-SHA1';
		$request_paras['Timestamp']         = date('Y-m-d\TH:i:s\Z',strtotime('now')-8*3600);
		$request_paras['SignatureVersion']  = '1.0';
		$request_paras['SignatureNonce']    = md5(uniqid().'hyperbolaa');
		$request_paras['Signature']         = Helper::signature($request_paras, $this->access_key_secret);

		return $this->httpSend($request_paras);
	}


	/**
	 * 推广短信的处理---推广短信不支持变量
	 * @param $tpl
	 * @param $phoneNum
	 * @return int
	 */
	public function spread($tpl,$phoneNum){

		$request_paras = [];
		$request_paras['TemplateCode']      = isset($this->template_code[$tpl]) ? $this->template_code[$tpl] : '';
		$request_paras['ParamString']       = '{}';
		$request_paras['RecNum']            = $phoneNum;
		$request_paras['AccessKeyId']       = $this->access_key_id;
		$request_paras['SignName']          = $this->spread_sign_name;
		$request_paras['Action']            = $this->sms_action;
		$request_paras['Format']            = 'JSON';
		$request_paras['Version']           = '2016-09-27';
		$request_paras['SignatureMethod']   = 'HMAC-SHA1';
		$request_paras['Timestamp']         = date('Y-m-d\TH:i:s\Z',strtotime('now')-8*3600);
		$request_paras['SignatureVersion']  = '1.0';
		$request_paras['SignatureNonce']    = md5(uniqid().'hyperbolaa');
		$request_paras['Signature']         = Helper::signature($request_paras, $this->access_key_secret);

		return $this->httpSend($request_paras);
	}


	/**
	 * @param $request_paras
	 * @return int|string
	 */
	private function httpSend($request_paras){

		$url        = $this->sms_url.http_build_query($request_paras);
		$curl       = new Http();
		$content    = $curl->get($url);
		$result     = json_decode($content, true);
		if (isset($result['Code']) || isset($result['Message'])) {
			return $result['Code'].'----'.$result['Message'];//错误信息
		} else {
			return true;
		}
	}


}
