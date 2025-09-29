<?php

/**
 * 发送post请求
 * @param string $url 请求地址
 * @param array $post_data post键值对数据
 * @return string
 */
function send_post($url, $post_data)
{
  $postdata = json_encode($post_data);
  $options = [
    'http' => [
      'method' => 'POST',
      'header' => [
        'Content-type:application/json',
        'Authorization: secret_zJdgtwvJPkS7oDVnO9Cygsw108YiM4DMW04QEVq2HBP',
        'Notion-Version: 2021-05-13',
      ],
      'content' => $postdata,
      'timeout' => 15 * 60 // 超时时间（单位:s）
    ]
  ];
  $context = stream_context_create($options);
  $result = file_get_contents($url, false, $context);
  $result = json_decode($result, JSON_UNESCAPED_UNICODE);
  return $result;
}

function initDatabases()
{
    $param = [
        "filter" => [
            "property" => "启用",
            "checkbox" => [
                "equals" => true
            ]
        ]
    ];
    $url = 'https://api.notion.com/v1/databases/a89bd8d1a259466c98ec672e09d8f603/query';
    $data = send_post($url, $param);

    $urlArray = [];
    $list = $data['results'];
    foreach ($list as $key => $value) {
        $url = $value['properties']['短链接']['rich_text'][0]['text']['content'];
        $longurl = $value['properties']['原始url']['rich_text'][0]['text']['content'];
        $urlArray[$url] = $longurl;
    }
    file_put_contents('databases.json', json_encode($urlArray));
}

function getDatabases()
{
    $databases = file_get_contents('databases.json');
    return json_decode($databases);
}
if (isset($_GET['reload'])) {
    initDatabases();
}
$k = explode("/",$_SERVER['REQUEST_URI'])[2];
$databases = getDatabases();
if(isset($databases->$k)){
    header('Location: ' . $databases->$k);
} else {
    echo '当前链接已失效';
    exit;
}