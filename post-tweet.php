?php
session_start();
require 'autoload.php';
use Abraham\TwitterOAuth\TwitterOAuth;
define('CONSUMER_KEY', '----------');
define('CONSUMER_SECRET', '----------');
define('OAUTH_CALLBACK', '----------');
if (!isset($_SESSION['access_token'])) {
  $connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET);
  $request_token = $connection->oauth('oauth/request_token', array('oauth_callback' => OAUTH_CALLBACK));
  $_SESSION['oauth_token'] = $request_token['oauth_token'];
  $_SESSION['oauth_token_secret'] = $request_token['oauth_token_secret'];
  $url = $connection->url('oauth/authorize', array('oauth_token' => $request_token['oauth_token']));
  echo $url;
} else {
  $access_token = $_SESSION['access_token'];
  $connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $access_token['oauth_token'], $access_token['oauth_token_secret']);
  
  // Temel kullanıcı bilgisi alma
  $user = $connection->get("account/verify_credentials");
  
  // Ekrana kullanıcı adı yazdırma
  echo $user->screen_name;
  // Profile tweet gönderiliyor
  $post = $connection->post('statuses/update', array('status' => 'Bu tweet webinyo.com tarafından atılmıştır.'));
  // Sonuç dönderiliyor.
  print_r($post);
}
