<?php
require_once('oauth/twitteroauth.php');
function oauthGetTweets($config) {
	if( empty($config['access_token']) ) 
		return array('error' => __('Not properly configured, check settings', ''));		
	if( empty($config['access_token_secret']) ) 
		return array('error' => __('Not properly configured, check settings', ''));
	if( empty($config['consumer_key']) ) 
		return array('error' => __('Not properly configured, check settings', ''));		
	if( empty($config['consumer_key_secret']) ) 
		return array('error' => __('Not properly configured, check settings', ''));		
	$options = array(
		'trim_user' => true,
		'exclude_replies' => false,
		'include_rts' => true,
		'count' => $config['count'],
		'screen_name' => $config['username']
	);
	$connection = new TwitterOAuth($config['consumer_key'], $config['consumer_key_secret'], $config['access_token'], $config['access_token_secret']);
	$result = $connection->get('statuses/user_timeline', $options);
	return $result;
}
function twitterify($ret) {
  $ret = preg_replace("#(^|[\n ])([\w]+?://[\w]+[^ \"\n\r\t< ]*)#", "\\1<a href=\"\\2\" >\\2</a>", $ret);
  $ret = preg_replace("#(^|[\n ])((www|ftp)\.[^ \"\t\n\r< ]*)#", "\\1<a href=\"http://\\2\" >\\2</a>", $ret);
  $ret = preg_replace("/@(\w+)/", "<a href=\"http://www.twitter.com/\\1\" >@\\1</a>", $ret);
  $ret = preg_replace("/#(\w+)/", "<a href=\"https://twitter.com/search?q=\\1\" >#\\1</a>", $ret);
return $ret;
}
function parseTweets($results = array()) {
	$tweets = array();
        
	if(!empty($results)&&!isset($results['error'])){
		foreach($results as $result) {
			$temp = explode(' ', $result['created_at']);
			$timestamp = $temp[2] . ' ' . $temp[1] . ' ' . $temp[5];
			$tweets[] = array(
				'timestamp' => $timestamp,
				'text' => twitterify($result['text'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH),
				'id' => $result['id_str']
			);
		}
	}
	return $tweets;
}
?>