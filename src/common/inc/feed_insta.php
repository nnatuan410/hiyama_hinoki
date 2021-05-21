<?php

$instagram_business_id = '17841408796158817'; // InstagramビジネスアカウントID
$access_token = 'EAAInsSpc0wgBAIZBPH17ez77JbOTNCe036N1amTvsMMmHbTbAMZCgjio9JZCgrsBdXrQGPwTD1z0vtZCYmYhZBQaH8SsQE056rKdksd5fvPeaSWT9kEQDuZCQK4EIlStHukHZBmqLIFXSrL1xgxFiGlTHbTto32eFFU00SqKe7iv63fVRvw7WIAmCnmr3w91Q8ZD'; // 3段階目のアクセストークン

$target_user = 'tocho_koho_official'; // 取得するInstagramビジネスアカウントのユーザー名

//自分が所有するアカウント以外のInstagramビジネスアカウントが投稿している写真も取得したい場合は以下
$query = 'business_discovery.username(' . $target_user . '){id,followers_count,media_count,ig_id,media{caption,media_url,media_type,permalink,timestamp,id}}';

//自分のアカウントの画像が取得できればOKな場合は$queryを以下のようにしてください。
//$query = 'name,media{caption,media_url,media_type,permalink,timestamp,id}&access_token='.$access_token;

$instagram_api_url = 'https://graph.facebook.com/v4.0/';
$target_url = $instagram_api_url . $instagram_business_id . "?fields=" . $query . "&access_token=" . $access_token;

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $target_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$instagram_data = curl_exec($ch);
curl_close($ch);

header('Content-Type: application/json');
echo $instagram_data;
