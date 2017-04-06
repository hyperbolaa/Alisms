<?php
/**
 * 云市场短信接口
 */
namespace Hyperbolaa\Alisms\Sdk;

use Hyperbolaa\Alisms\Lib\Helper;

class SmsApi
{
	private $request_host   = 'http://sms.market.alicloudapi.com';
	private $request_uri    = '/singleSendSms';
	private $request_method = 'GET';

	private $app_key;
	private $app_secret;
	private $sign_name;
	private $template_code;

	public function setAppKey($value)
	{
		$this->app_key = $value;
		return $this;
	}

	public function setAppSecret($value)
	{
		$this->app_secret = $value;
		return $this;
	}

	public function setSignName($value)
	{
		$this->sign_name = $value;
		return $this;
	}


	public function setTemplateCode($value)
	{
		$this->template_code = $value;
		return $this;
	}

	/**
	 * 云市场短信发送----接口2---功能少些许
	 * @param $tpl
	 * @param $phoneNum
	 * @param $smsValueArr
	 * @return bool|string
	 */
	public function send($tpl, $phoneNum, $smsValueArr){

		$info                           = "";//系统请求返回信息
		$request_paras                  = [];
		$request_paras['SignName']      = $this->sign_name;
		$request_paras['RecNum']        = $phoneNum;
		$request_paras['TemplateCode']  = isset($this->template_code[$tpl]) ? $this->template_code[$tpl] : '';
		$request_paras['ParamString']   = Helper::formatValue($smsValueArr);

		$content = $this->httpSend($request_paras, $info);

		if ($content) {
			$result     = json_decode($content, true);//API返回值
			if ($result['success']) {
				return true;
			} else {
				return $info;
			}
		} else {
			return $info;
		}
	}


	/**
	 * @param $request_paras
	 * @param $info
	 * @return mixed
	 */
	private function httpSend($request_paras, &$info) {
		ksort($request_paras);
		$request_header_accept = "application/json;charset=utf-8";
		$headers = array(
			'X-Ca-Key' => $this->app_key,
			'Accept' => $request_header_accept
		);
		ksort($headers);
		$header_str = "";
		$header_ignore_list = array('X-CA-SIGNATURE', 'X-CA-SIGNATURE-HEADERS', 'ACCEPT', 'CONTENT-MD5', 'CONTENT-TYPE', 'DATE');
		$sig_header = array();
		foreach($headers as $k => $v) {
			if(in_array(strtoupper($k), $header_ignore_list)) {
				continue;
			}
			$header_str .= $k . ':' . $v . "\n";
			array_push($sig_header, $k);
		}
		$url_str = $this->request_uri;
		$para_array = array();
		foreach($request_paras as $k => $v) {
			array_push($para_array, $k .'='. $v);
		}
		if(!empty($para_array)) {
			$url_str .= '?' . join('&', $para_array);
		}
		$content_md5 = "";
		$date = "";
		$sign_str = "";
		$sign_str .= $this->request_method ."\n";
		$sign_str .= $request_header_accept."\n";
		$sign_str .= $content_md5."\n";
		$sign_str .= "\n";
		$sign_str .= $date."\n";
		$sign_str .= $header_str;
		$sign_str .= $url_str;

		$sign = base64_encode(hash_hmac('sha256', $sign_str, $this->app_secret, true));
		$headers['X-Ca-Signature'] = $sign;
		$headers['X-Ca-Signature-Headers'] = join(',', $sig_header);
		$request_header = array();
		foreach($headers as $k => $v) {
			array_push($request_header, $k .': ' . $v);
		}

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $this->request_host . $url_str);
		curl_setopt($ch, CURLINFO_HEADER_OUT, true);
		curl_setopt($ch, CURLOPT_VERBOSE, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $request_header);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$ret = curl_exec($ch);
		$info = curl_getinfo($ch);
		curl_close($ch);
		return $ret;
	}


}
