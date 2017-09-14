<?php

namespace Hyperbolaa\Alisms\Lib;

/**
 * 辅助类
 */
class Helper
{
	/**
	 * 短信签名
	 */
	public static function signature($parameters, $accessKeySecret)
	{
		// 将参数Key按字典顺序排序
		ksort($parameters);
		// 生成规范化请求字符串
		$canonicalizedQueryString = '';
		foreach($parameters as $key => $value)
		{
			$canonicalizedQueryString .= '&' . self::percentEncode($key). '=' . self::percentEncode($value);
		}
		// 生成用于计算签名的字符串 stringToSign
		$stringToSign = 'GET&%2F&' . self::percentencode(substr($canonicalizedQueryString, 1));
		//echo "<br>".$stringToSign."<br>";
		// 计算签名，注意accessKeySecret后面要加上字符'&'
		$signature = base64_encode(hash_hmac('sha1', $stringToSign, $accessKeySecret . '&', true));
		return $signature;
	}


	/**
	 * 使用urlencode编码后，将"+","*","%7E"做替换即满足ECS API规定的编码规范
	 */
	public static function percentEncode($str)
	{
		$res = urlencode($str);
		$res = preg_replace('/\+/', '%20', $res);
		$res = preg_replace('/\*/', '%2A', $res);
		$res = preg_replace('/%7E/', '~', $res);
		return $res;
	}

	/**
	 * 处理传进来的数据
	 */
	public static function formatValue($arr){
		$return = [];
		if(is_array($arr) && !empty($arr)){
			foreach ($arr as $key=>$item){
				if($item){
					$return[$key] = (string)$item;
				}
			}
		}
		return $return ? json_encode($return) : '{}';
	}



}
