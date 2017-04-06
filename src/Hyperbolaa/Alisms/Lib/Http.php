<?php

namespace Hyperbolaa\Alisms\Lib;

/**
 * 请求类
 */
class Http
{
	public $headers;
	public $user_agent;
	public $compression;

	public function __construct($compression = 'gzip')
	{
		$this->headers[]   = 'Accept: image/gif, image/x-bitmap, image/jpeg, image/pjpeg';
		$this->headers[]   = 'Connection: Keep-Alive';
		$this->headers[]   = 'Content-type: application/x-www-form-urlencoded;charset=UTF-8';
		$this->user_agent  = 'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; .NET CLR 1.0.3705; .NET CLR 1.1.4322; Media Center PC 4.0)';
		$this->compression = $compression;
	}

	/**
	 * @param $url
	 * @return mixed
	 */
	public function get($url)
	{
		$process = curl_init($url);
		curl_setopt($process, CURLOPT_HTTPHEADER, $this->headers);
		curl_setopt($process, CURLOPT_HEADER, 0);
		curl_setopt($process, CURLOPT_USERAGENT, $this->user_agent);

		curl_setopt($process, CURLOPT_SSL_VERIFYPEER, false); //不验证证书
		curl_setopt($process, CURLOPT_SSL_VERIFYHOST, false); //不验证证书

		curl_setopt($process, CURLOPT_ENCODING, $this->compression);
		curl_setopt($process, CURLOPT_TIMEOUT, 30);
		curl_setopt($process, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($process, CURLOPT_FOLLOWLOCATION, 1);
		$return = curl_exec($process);
		curl_close($process);
		return $return;
	}

	/**
	 * @param $url
	 * @param $data 字符串信息
	 * @return mixed
	 */
	public function post($url, $data)
	{
		$process = curl_init($url);
		curl_setopt($process, CURLOPT_HTTPHEADER, $this->headers);
		curl_setopt($process, CURLOPT_HEADER, 0);
		curl_setopt($process, CURLOPT_USERAGENT, $this->user_agent);

		curl_setopt($process, CURLOPT_SSL_VERIFYPEER, false); //不验证证书
		curl_setopt($process, CURLOPT_SSL_VERIFYHOST, false); //不验证证书

		curl_setopt($process, CURLOPT_ENCODING, $this->compression);
		curl_setopt($process, CURLOPT_TIMEOUT, 30);
		curl_setopt($process, CURLOPT_POSTFIELDS, $data);
		curl_setopt($process, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($process, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($process, CURLOPT_POST, 1);
		$return = curl_exec($process);
		curl_close($process);
		return $return;
	}
}
