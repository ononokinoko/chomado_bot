<?php
require_once(__DIR__ . '/twitteroauth/twitteroauth.php'); // OAuth
require_once(__DIR__ . '/class/weather.php'); // class Weather
require_once(__DIR__ . '/class/config.php'); // class Config

// ファイルの行をランダムに抽出
$filelist = file(__DIR__ . '/tweet_content_data_list/list.txt');
shuffle($filelist);

// 呟く文成形 
$message = sprintf(
    "%s\n\n%s",
    $filelist[0],   // (*ﾟ▽ﾟ* っ)З ちょまぎょ!
    //『東京の現在(00:03)の天気はうす曇り(6.1℃)です。明日はPM Rainで、最高5.6℃、最低3.9℃です』
    (new Weather('tokyo'))->GetWeatherMessage(
        (new DateTime('now', new DateTimeZone('Asia/Tokyo')))
    )
);

// Twitterに接続
$config = Config::getInstance();
$connection = new TwitterOAuth(
    $config->getTwitterConsumerKey(),
    $config->getTwitterConsumerSecret(),
    $config->getTwitterAccessToken(),
    $config->getTwitterAccessTokenSecret()
);

// 投稿
$connection->post('statuses/update', array("status"=> $message ));
