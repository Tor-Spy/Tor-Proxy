<?php
class tor{
	private $ip;
	private $port;
	private $rport;
	private $pass;

	public function __construct($ip = "127.0.0.1", $port = "9050", $rport = "9051", $pass = ""){
		$this->ip = $ip;
		$this->port = $port;
		$this->rport = $rport;
		$this->pass = $pass;
	}

	function changeip(){
		$old = $this->get("http://checkip.dyndns.org/");

		$this->resettor();

		for($i = 0; $i < 10; $i++){
			sleep(1);

			if($old != $this->get("http://checkip.dyndns.org/")){
				return true;
			}
		}

		return false;
	}

	function resettor(){
		$fp = fsockopen($this->ip, $this->rport, $errno, $errstr, 30);
		if (!$fp) {
			echo "$errstr ($errno)<br />\n";
		} else {
			$out = "authenticate \"".$this->pass."\"\nsignal newnym\nquit\n";
			fwrite($fp, $out);
			fclose($fp);
		}
	}

	function get($url){
		$tor = "socks5h://".$this->ip.':'.$this->port;
		$useragent = "Opera/9.80 (J2ME/MIDP; Opera Mini/4.2.14912/870; U; id) Presto/2.4.15";

		$ch = curl_init();

		curl_setopt($ch, CURLOPT_PROXY, $tor);
		curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

		$result = curl_exec($ch);

		curl_close($ch);

		return $result;
	}

	function post($url, $fields){
		$fields_string = "";

		foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
		rtrim($fields_string, '&');

		$tor = "socks5h://".$this->ip.':'.$this->port;
		$useragent = "Opera/9.80 (J2ME/MIDP; Opera Mini/4.2.14912/870; U; id) Presto/2.4.15";

		$ch = curl_init();

		curl_setopt($ch, CURLOPT_PROXY, $tor);
		curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch,CURLOPT_POST, count($fields));
		curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);

		$result = curl_exec($ch);

		curl_close($ch);

		return $result;
	}

	function postraw($url, $fields){
		$tor = $this->ip.':'.$this->port;
		$useragent = "Opera/9.80 (J2ME/MIDP; Opera Mini/4.2.14912/870; U; id) Presto/2.4.15";

		$ch = curl_init();

		curl_setopt($ch, CURLOPT_PROXY, $tor);
		curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
		curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);

		$result = curl_exec($ch);

		curl_close($ch);

		return $result;
	}
}
