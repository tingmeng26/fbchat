<?php
function set_emailsample($body)
{ //設置email的樣板
  $html = '';
  $html .= '<!doctype html>
    <head></head>
    <body>
        ' . $body . '
    </body>
    </html>
    ';

  return $html;
}

function escapeJsonString($string)
{ //過濾特殊字元
  $result = str_replace(
    array('&nbsp;', ' ', '　　', '　', '\\n', '\\r'),
    '',
    $string
  );
  return $result;
}
//=======判斷來源=======
function checkRequestSrc($islocation = true, $isajax = true)
{
  global $session_domain;
  if ($isajax && (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || $_SERVER['HTTP_X_REQUESTED_WITH'] !== 'XMLHttpRequest')) {
    throw new Exception("來人 關門 放狗!E01", 1);
  }
  if ($islocation) {
    if (!isset($_SERVER['HTTP_REFERER']) || $_SERVER['HTTP_REFERER'] == '') {
      throw new Exception("年輕人終究是年輕人!E02", 1);
    } else {
      $url = parse_url($_SERVER['HTTP_REFERER']);
      if ($url['host'] != $session_domain) {
        throw new Exception("你爸爸在你身後，他非常火!E03", 1);
      }
    }
  }
  // return true;
}

function isMobile()
{

  if (isset($_SERVER['HTTP_X_WAP_PROFILE'])) {
    return true;
  }

  if (isset($_SERVER['HTTP_VIA'])) {
    // 找不到为flase,否则为true
    return stristr($_SERVER['HTTP_VIA'], "wap") ? true : false;
  }

  if (isset($_SERVER['HTTP_USER_AGENT'])) {
    $clientkeywords = array(
      'nokia', 'sony', 'ericsson', 'mot', 'samsung', 'htc', 'sgh', 'lg', 'sharp', 'sie-', 'philips', 'panasonic', 'alcatel',
      'lenovo', 'iphone', 'ipod', 'blackberry', 'meizu', 'android', 'netfront', 'symbian', 'ucweb', 'windowsce', 'palm', 'operamini', 'operamobi',
      'openwave', 'nexusone', 'cldc', 'midp', 'wap', 'mobile', 'MicroMessenger'
    );

    if (preg_match("/(" . implode('|', $clientkeywords) . ")/i", strtolower($_SERVER['HTTP_USER_AGENT']))) {
      return true;
    }
  }

  if (isset($_SERVER['HTTP_ACCEPT'])) {

    if ((strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') !== false) && (strpos($_SERVER['HTTP_ACCEPT'], 'text/html') ===
      false || (strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') < strpos($_SERVER['HTTP_ACCEPT'], 'text/html')))) {
      return true;
    }
  }
  return false;
}
//chatbot

//檢查是否有標註tag
//$type = all[全部tag都得標註];any[任一有標註即可]
function check_tag($message, $post_id_key, $type = 'all')
{
  global $tag;

  if ($type == 'all') {
    $r = true;
    // foreach ($tag as $t) {
    //     if (!preg_match('/' . $t . '/', $message)) {
    //         $r = false;
    //         // break;
    //     } else {
    //         $r = true;
    //         return $r;
    //     }
    // }

    $t = $tag[$post_id_key];
    if (!preg_match('/' . $t . '/', $message)) {
      $r = false;
      // break;
    } else {
      $r = true;
      return $r;
    }
  } elseif ($type == 'any') {
    $r = false;
    foreach ($tag as $t) {
      if (preg_match('/' . $t . '/', $message)) {
        $r = true;
        break;
      }
    }
  }

  return $r;
}


function responseTemplate($title, $buttons)
{
  $cp_data = [];
  $cp_data["text"] = $title;
  $cp_data["quick_replies"] = [];
  foreach ($buttons as $key => $b) {
    $cp_data["quick_replies"][] = [
      "content_type" => "text",
      "title" => $b['title'],
      "payload" => $b['payload']
    ];
  }
  return $cp_data;
}
function textTemplate($text)
{
  return [
    'text' => $text
  ];
}

function listTemplate($list)
{
  return [
    'attachment' => [
      "type" => "template",
      "payload" => [
        "template_type" => "list",
        "elements" => $list,
      ]
    ]
  ];
}
function genericTemplate($title, $buttons, $pic)
{
  return [
    'attachment' => [
      "type" => "template",
      "payload" => [
        "template_type" => "generic",
        "elements" => [
          [
            "title" => $title,
            "image_url" => $pic,
            "buttons" => $buttons
          ]
        ],
      ]
    ]
  ];
}

/**
 * 多個 圖+文+按鍵 
 * @param array data  object title,image_url,buttons
 */
function multipleGenericTemplate($data)
{
  return [
    'attachment' => [
      "type" => "template",
      "payload" => [
        "template_type" => "generic",
        "elements" => $data,
      ]
    ]
  ];
}

function buttonTemplate($btn_content, $text = "請選擇")
{
  $r = [
    'attachment' => [
      "type" => "template",
      "payload" => [
        "template_type" => "button",
        "text" => $text,
        "buttons" => $btn_content
      ]
    ]
  ];

  return  $r;
}

function urlButtonTemplate($btn_content,$txt='請選擇'){
  $r = [
    'attachment' => [
      "type" => "template",
      "payload" => [
        "template_type" => "button",
        "text" => $txt,
        "buttons" => $btn_content
      ]
    ]
  ];

  return  $r;

}
function imageTemplate($pic)
{
  return [
    'attachment' => [
      "type" => "image",
      "payload" => [
        "is_reusable" => true,
        "url" => $pic
      ]
    ]
  ];
}

function imageAttachmentTemplate($attachment_id)
{
  return [
    'attachment' => [
      "type" => "image",
      "payload" => [
        "attachment_id" => $attachment_id
      ]
    ]
  ];
}

function mediaTemplate($pic, $buttons = null)
{
  $template = [
    'attachment' => [
      "type" => "template",
      "payload" => [
        "template_type" => "media",
        "elements" => [
          [
            "media_type" => "image",
            "url" => $pic //須為FB網址
          ]
        ],
      ]
    ]
  ];

  //https://business.facebook.com/109611464003123/photos/162735592024043/162735562024046

  if ($buttons != null) {
    $template['attachment']['payload']['elements'][0]['buttons'] = $buttons;
  }

  return $template;
}

function mediaTest(){
  return [
    'attachment' => [
      "type" => "template",
      "payload" => [
        "template_type" => "media",
        "elements" => [
          [
            "media_type" => "image",
            "attachment_id" => '399241251155939' 
          ],
          [
            "media_type" => "image",
            "attachment_id" => '783019518916095' 
          ],
        ],
      ]
    ]
  ];
}

/**
 * 圖 + 按鍵訊息 以 attach id 方式  參考 mediaTest
 */
function multipleMediaTemplate($data)
{
  return [
    'attachment' => [
      "type" => "template",
      "payload" => [
        "template_type" => "media",
        "elements" => $data
      ]
    ]
  ];
}


function push($cp_data)
{
  $inc_fb_token = 'EAAyn6ZAR2CykBAEKCVppf66A0TF33kpAlgvuvArg5HupnZC3UVAKa4OSW0xJHO2oxSoPIuAaTmS3LDedmzXqZCvhBi0XMOMM3tw6MStM4anPADO7d2WfVaICrnTU9ieo4e6MubpczrKsbNTkg83xplAqiXWZCuZATZBcEEWZAZCuqAZDZD';
  $r = curl_post("https://graph.facebook.com/v7.0/me/messages?access_token={$inc_fb_token}", $cp_data);
  saveTest('post的結果為'.$r);
  return $r;
}
function curl_post($url, $data)
{
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_POST, true);
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
  curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-type: application/json"));
  curl_setopt($ch, CURLOPT_POSTFIELDS, $data); //http_build_query
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
  curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
  $output = curl_exec($ch);
  curl_close($ch);

  return $output;
}
