<?php

$appid = "YOUR_WECHAT_APPID";
$secret = "YOUR_WECHAT_APPSECRET";
$wid = "IDENTIFIER_OF_YOUR_WECHAT";
$filename = "wx.token";

function getToken($appid, $secret, $filename)
{
	$r = request("https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$appid&secret=$secret");
	$r = json_decode(trim($r), TRUE);
	if (is_array($r) && isset($r['access_token']))
	{
		$token = $r['access_token'];
		$expire = $r['expires_in'] + time() - 10;
		$rr = Array();
		$rr['token'] = $token;
		$rr['expire'] = $expire;
		file_put_contents($filename, json_encode($rr));
		return $token;
	} else
		return "";
}

function request($url, $post='')
{
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	if (strlen($post))
	{
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
	}
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
	$result = curl_exec($ch);
	curl_close($ch);
	return $result;
}

$token = @file_get_contents($filename);
if ($token === FALSE)
	$token = getToken($appid, $secret, $filename);
else {
	$rr = json_decode(trim($token), TRUE);
	if (isset($rr['token']) && isset($rr['expire']) && $rr['expire'] > time())
		$token = $rr['token'];
	else
		$token = getToken($appid, $secret, $filename);
}

if (strlen($token) == 0)
	die("token length = 0");

$post_data['touser'] = $wid;
$post_data['msgtype'] = "text";
$post_data['text']['content'] = $_REQUEST['C'] . "\n\n\nFROM IP " . $_SERVER['REMOTE_ADDR'];
$post_data = json_encode($post_data, JSON_UNESCAPED_UNICODE);

var_dump(request("https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token=$token", $post_data));

?>