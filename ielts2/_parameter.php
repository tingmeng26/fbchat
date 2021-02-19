<?php
//活動文案的內容變數
include(dirname(__FILE__) . $slash . '_db.php');

if ($nowHost == "Production") { //正式站

  $fb_app_id = '639597983322815';
  $fan_page_url = "https://www.facebook.com/dfapactw";

  if ($fan_page_id == "109611464003123") { //誠智數位有限公司
    $fan_page_url = "https://www.facebook.com/109611464003123";
    $ary_post_id = ['109611464003123_160463042251298'/*錶現*/, '109611464003123_160273532270249'/*攻略*/]; //文章ID：文章網址的id+'_'+story_fbid
    $chatbot_url = "http://m.me/109611464003123?ref=fb";
    $ary_fb_post_url = [
      "https://www.facebook.com/109611464003123/posts/160463042251298", /*錶現*/
      "https://www.facebook.com/109611464003123/posts/160273532270249" /*攻略*/
    ];
    // $ary_fanpage_subSettings = [
    //     'ary_post_id' => ['109611464003123_160463042251298'/*錶現*/, '109611464003123_160273532270249'/*攻略*/], //文章ID：文章網址的id+'_'+story_fbid
    //     'chatbot_url' => "http://m.me/109611464003123?ref=fb",
    //     'ary_fb_post_url' => [
    //         "https://www.facebook.com/109611464003123/posts/160463042251298", /*錶現*/
    //         "https://www.facebook.com/109611464003123/posts/160273532270249" /*攻略*/
    //     ]
    // ];
    //$fb_post_url = "https://www.facebook.com/109611464003123/posts/160463042251298";
  } else { //正式站

    $fb_app_id = '743283296233256';
    $fan_page_url = "https://www.facebook.com/BritishCouncilTaiwanIELTS";

    $ary_post_id = ['108529402543780_3772779766118707'];
    $ary_fb_post_url = [
      "https://www.facebook.com/108529402543780/posts/3772779766118707/",
    ];
  }
} else {
  //TEST1
  $fb_app_id = '211440349929997';
  $fan_page_url = "https://www.facebook.com/109611464003123";

  // 粉專編號+文章編號
  $ary_post_id = ['109611464003123_209162637381338'];
  $chatbot_url = "http://m.me/testcoder168?ref=fb";
  $ary_fb_post_url = [
    "https://www.facebook.com/109611464003123/posts/162122275418708",
    "https://www.facebook.com/109611464003123/posts/182309543399981"
  ];
}

$tag = ['雅師解惑', '#雅師解惑']; //必須標註的關鍵字
$need_pic = false; //必須上傳圖片
$weburl = 'https://ca08b5d5632c.ngrok.io/fbchat/';
$url = $weburl . "ielts2/";
$source_url = $url . "source/";


$answers = [
  'ANSQ1A1' => 'AU',
  'ANSQ1A2' => 'UK',
  'ANSQ1A3' => 'CA',
  'ANSQ1A4' => 'US',

  'ANSQ2A1' => 'UK',
  'ANSQ2A2' => 'CA',
  'ANSQ2A3' => 'US',
  'ANSQ2A4' => 'AU',

  'ANSQ3A1' => 'UK',
  'ANSQ3A2' => 'US',
  'ANSQ3A3' => 'CA',
  'ANSQ3A4' => 'AU',

  'ANSQ4A1' => 'CA',
  'ANSQ4A2' => 'US',
  'ANSQ4A3' => 'UK',
  'ANSQ4A4' => 'AU',

  'ANSQ5A1' => 'AU',
  'ANSQ5A2' => 'UK',
  'ANSQ5A3' => 'CA',
  'ANSQ5A4' => 'US',
];

$countryNameArray = [
  'UK' => '英國',
  'US' => '美國',
  'CA' => '加拿大',
  'AU' => '澳洲'
];

$question = [
  'Q1' => [
    0 => [
      'txt' => "My youth, my youth is yours🎵Trippin' on skies, sippin' waterfalls",
      'btn' => [
        [
          "type" => "postback",
          "title" => "迷幻美麗少年 Troye Sivan",
          "payload" => "ANSQ1A1.Q2"
        ],
      ],
      'pic' => $source_url . 'question1/0.jpg'
    ],
    1 => [
      'txt' => "I found a love for me🎵Darling, just dive right in",
      'btn' => [
        [
          "type" => "postback",
          "title" => "紅髮艾德 Ed Sheeran",
          "payload" => "ANSQ1A2.Q2"
        ],
      ],
      'pic' => $source_url . 'question1/1.jpg'
    ],
    2 => [
      'txt' => "Yeah, you got that yummy, yum🎵That yummy, yum",
      'btn' => [
        [
          "type" => "postback",
          "title" => "小賈斯汀 Justin Bieber",
          "payload" => "ANSQ1A3.Q2"
        ],
      ],
      'pic' => $source_url . 'question1/2.jpg'
    ],
    3 => [
      'txt' => "So you‘re a tough guy🎵Like it really rough guy",
      'btn' => [
        [
          "type" => "postback",
          "title" => "怪物新人 Billie Eilish",
          "payload" => "ANSQ1A4.Q2"
        ],
      ],
      'pic' => $source_url . 'question1/3.jpg'
    ],
  ],
  'Q2' => [
    0 => [
      'txt' => "奶香四溢的酥脆派與濃郁鮮味",
      'btn' => [
        [
          "type" => "postback",
          "title" => "Stargazy Pie",
          "payload" => "ANSQ2A1.Q3"
        ],
      ],
      'pic' => $source_url . 'question2/0.jpg'
    ],
    1 => [
      'txt' => "酥炸薯條佐鮮美肉汁與罪惡起司",
      'btn' => [
        [
          "type" => "postback",
          "title" => "Poutine",
          "payload" => "ANSQ2A2.Q3"
        ],
      ],
      'pic' => $source_url . 'question2/1.jpg'
    ],
    2 => [
      'txt' => "拍照系美食彩虹貝果",
      'btn' => [
        [
          "type" => "postback",
          "title" => "Rainbow Bagel",
          "payload" => "ANSQ2A3.Q3"
        ],
      ],
      'pic' => $source_url . 'question2/2.jpg'
    ],
    3 => [
      'txt' => "南半球國民美食 令人難忘的滋味",
      'btn' => [
        [
          "type" => "postback",
          "title" => "Vegemite",
          "payload" => "ANSQ2A4.Q3"
        ],
      ],
      'pic' => $source_url . 'question2/3.jpg'
    ],
  ],
  'Q3' => [
    0 => [
      'txt' => "Welsh Corgi",
      'btn' => [
        [
          "type" => "postback",
          "title" => "柯基 ❤️",
          "payload" => "ANSQ3A1.Q4"
        ],
      ],
      'pic' => $source_url . 'question3/0.jpg'
    ],
    1 => [
      'txt' => "Boston Terrier",
      'btn' => [
        [
          "type" => "postback",
          "title" => "波士頓㹴 ❤️",
          "payload" => "ANSQ3A2.Q4"
        ],
      ],
      'pic' => $source_url . 'question3/1.jpg'
    ],
    2 => [
      'txt' => "Labrador Retriever",
      'btn' => [
        [
          "type" => "postback",
          "title" => "拉布拉多犬 ❤️",
          "payload" => "ANSQ3A3.Q4"
        ],
      ],
      'pic' => $source_url . 'question3/2.jpg'
    ],
    3 => [
      'txt' => "Australian Terrier",
      'btn' => [
        [
          "type" => "postback",
          "title" => "澳洲㹴 ❤️",
          "payload" => "ANSQ3A4.Q4"
        ],
      ],
      'pic' => $source_url . 'question3/3.jpg'
    ],
  ],
  'Q4' => [
    0 => [
      'txt' => "世界遺產 班夫國家公園",
      'btn' => [
        [
          "type" => "postback",
          "title" => "Banff National Park",
          "payload" => "ANSQ4A1.Q5"
        ],
      ],
      'pic' => $source_url . 'question4/0.jpg'
    ],
    1 => [
      'txt' => "世界奇景 羚羊峽谷",
      'btn' => [
        [
          "type" => "postback",
          "title" => "Antelope Canyon",
          "payload" => "ANSQ4A2.Q5"
        ],
      ],
      'pic' => $source_url . 'question4/1.jpg'
    ],
    2 => [
      'txt' => "世界文化遺產 巨石陣",
      'btn' => [
        [
          "type" => "postback",
          "title" => "Stonehenge",
          "payload" => "ANSQ4A3.Q5"
        ],
      ],
      'pic' => $source_url . 'question4/2.jpg'
    ],
    3 => [
      'txt' => "世界最美公路 大洋路",
      'btn' => [
        [
          "type" => "postback",
          "title" => "The Great Ocean Road",
          "payload" => "ANSQ4A4.Q5"
        ],
      ],
      'pic' => $source_url . 'question4/3.jpg'
    ],
  ],
  'Q5' => [
    0 => [
      'txt' => "放鬆愜意的海邊民宿",
      'btn' => [
        [
          "type" => "postback",
          "title" => "Beach House",
          "payload" => "ANSQ5A1.END"
        ],
      ],
      'pic' => $source_url . 'question5/0.jpg'
    ],
    1 => [
      'txt' => "充滿皇家感的城堡花園",
      'btn' => [
        [
          "type" => "postback",
          "title" => "Castle Garden",
          "payload" => "ANSQ5A2.END"
        ],
      ],
      'pic' => $source_url . 'question5/1.jpg'
    ],
    2 => [
      'txt' => "如童話故事的森林小屋",
      'btn' => [
        [
          "type" => "postback",
          "title" => "Forest Cottage",
          "payload" => "ANSQ5A3.END"
        ],
      ],
      'pic' => $source_url . 'question5/2.jpg'
    ],
    3 => [
      'txt' => "市中心的城市現代公寓",
      'btn' => [
        [
          "type" => "postback",
          "title" => "Urban Apartment",
          "payload" => "ANSQ5A4.END"
        ],
      ],
      'pic' => $source_url . 'question5/3.jpg'
    ],
  ]
];



$sharedMessage = [
  'US' => "Wow! 你有90%的美國留學指數。\n雅師建議你，未來在美國留學，除了課堂的知識外，英語的日常應用也一樣重要！",
  'CA' => "Wow! 你有90%的加拿大留學指數。\n雅師建議你，未來在加拿大留學，除了課堂的知識外，也可以多多探訪自然風光、體驗當地的歷史人文。",
  'UK' => "Wow! 你有90%的英國留學指數。\n雅師建議你，未來在英國留學，除了課堂的知識外，記得多結識各種不同文化背景的同學，拓寬你的世界。",
  "AU" => "Wow! 你有90%的澳洲留學指數。\n雅師建議你，未來在澳洲留學，除了課堂的知識外，多加入當地的社團或活動，增加英語的日常應用！"
];




function getResponse($key, $data)
{
  if ($key == '') {
    return null;
  }
  global  $source_url, $answers, $db, $weburl, $fb_app_id, $fan_page_id, $sharedMessage;
  $r = [];
  saveTest($key);
  switch ($key) {
    case "開始遊戲":
      $cp_data = [];
      $txt = "Hi! 我是留學國師 aka 雅師。" .
        "或許你正在徬徨無助，或許你只需" .
        "要一點幫助。沒關係！我會盡力協" .
        "助你。接下來，我會問你幾個非常" .
        "簡單的問題，預測最適合你留學的" .
        "國家。準備好我們就開始囉！";
      $btn = [
        [
          "type" => "postback",
          "title" => "I’m ready!",
          "payload" => "AGREEMENT"
        ],
      ];
      $cp_data['message'] = buttonTemplate($btn, $txt);;
      $r[] = $cp_data;
      $userData = DBResult($data['psid']);
      // 判斷如果已完成填寫email 不重置結果
      if (empty($userData['email'])) {
        DBReset($data);
      }
      break;
    case 'AGREEMENT':
      $cp_data = [];
      $cp_data['message'] = textTemplate('Wait! 在開始之前~');
      $r[] = $cp_data;
      $cp_data = [];
      $cp_data['message'] = textTemplate("此遊戲內容與結果僅純屬娛樂，並不代表英國文化協會立場\n\n"
        . "[注意!] 若您未滿18歲，請先告知您的家長將參與此活動，並請由您的家長填寫以下資訊，以參與抽獎活動。\n\n"
        . "英國文化協會將依據活動須知使用您的Email來參與此活動的抽獎，同時，英國文化協會有意使用您提供的資料Email和Social Media，寄送您可能有興趣的活動及服務相關訊息給您。\n\n"
        . "若不再繼續訂閱時，也可以隨時取消。我們將依據您的意願處理您的個人資料。");
      $r[] = $cp_data;
      $cp_data = [];
      $txt = "資訊保護\n\n"
        . "英國文化協會遵循英國及世界各國之資料保護法案，以符合個資保護之國際標準。您可以要求我們提供您的個資檔案紀錄，也有權向我們要求更正您的資料。若您對我們的個資使用方式有所疑慮，您有權向隱私監管機構申訴。有關個資保護說明，請瀏覽英國文化協會官網 www.britishcouncil.org/privacy ，或聯繫英國文化協會。我們將按照英國文化協會資料保存政策，將您的個資檔案保管7年。";
      $btn = [
        [
          "type" => "postback",
          "title" => "Agree!",
          "payload" => "Q1"
        ],
      ];
      $cp_data['message'] = buttonTemplate($btn, $txt);
      $r[] = $cp_data;
      break;
    case 'Q1':
      // 進入Q1 表示同意活動聲明
      $updateData = [
        'psid' => $data['psid'],
        'agree_campaign' => 1
      ];
      DBSave($updateData);
      $cp_data = [];
      $cp_data['message'] = textTemplate('Firstly，我將給你4首歌的部分歌詞。試試看，哪一句歌詞，讓你立刻哼起旋律？');
      $r[] = $cp_data;
      $cp_data = [];
      $cp_data['message'] = textTemplate('往右滑看更多選項👉');
      $r[] = $cp_data;
      $cp_data = [];
      $array = getQuestion('Q1');
      $cp_data['message'] = multipleGenericTemplate($array);
      $r[] = $cp_data;
      break;
    case substr($key, -2) == 'Q2':
      // 存第一題答案
      saveAnswer($key, $data, 'a1');
      // 第二題題目
      $cp_data = [];
      $cp_data['message'] = textTemplate('閉上眼，跟我一起說：I’m starving.');
      $r[] = $cp_data;
      $cp_data = [];
      $cp_data['message'] = textTemplate('然後張開眼，眼前這4個食物，你最想吃哪一個？');
      $r[] = $cp_data;
      $cp_data = [];
      $cp_data['message'] = textTemplate('往右滑看更多選項👉');
      $r[] = $cp_data;
      $cp_data = [];
      $array = getQuestion('Q2');
      $cp_data['message'] = multipleGenericTemplate($array);
      // $cp_data['message'] = multipleMediaTemplate($array);
      // $cp_data['message'] = mediaTemplate("https://www.facebook.com/init.kobeengineer/photos/a.1416496745064002/3542276335819355/", 
      // $cp_data['message'] = mediaTest();
      $r[] = $cp_data;
      break;
    case substr($key, -2) == 'Q3':
      // 存第二題答案
      saveAnswer($key, $data, 'a2');
      // 第三題題目
      $cp_data = [];
      $cp_data['message'] = textTemplate('走進公園中，你看見一個外國人牽著一隻狗狗，讓你不禁：AWWW!🥰');
      $r[] = $cp_data;
      $cp_data = [];
      $cp_data['message'] = textTemplate('你覺得牠是哪一隻狗狗？');
      $r[] = $cp_data;
      $cp_data = [];
      $cp_data['message'] = textTemplate('往右滑看更多選項👉');
      $r[] = $cp_data;
      $cp_data = [];
      $array = getQuestion('Q3');
      $cp_data['message'] = multipleGenericTemplate($array);
      // $cp_data['message'] = multipleMediaTemplate($array);
      // $cp_data['message'] = mediaTemplate("https://www.facebook.com/init.kobeengineer/photos/a.1416496745064002/3542276335819355/", 
      // $cp_data['message'] = mediaTest();
      $r[] = $cp_data;
      break;

    case substr($key, -2) == 'Q4':
      // 存第三題答案
      saveAnswer($key, $data, 'a3');
      // 第四題題目
      $cp_data = [];
      $cp_data['message'] = textTemplate('未來留學除了讀書外，四處遊玩更是一門重要學分。如果有一個7天的假期，你最想到哪裡大開眼界？');
      $r[] = $cp_data;
      $cp_data = [];
      $cp_data['message'] = textTemplate('(可惡，好想去啊🤦‍♂)');
      $r[] = $cp_data;
      $cp_data = [];
      $cp_data['message'] = textTemplate('往右滑看更多選項👉');
      $r[] = $cp_data;
      $cp_data = [];
      $array = getQuestion('Q4');
      $cp_data['message'] = multipleGenericTemplate($array);
      // $cp_data['message'] = multipleMediaTemplate($array);
      // $cp_data['message'] = mediaTemplate("https://www.facebook.com/init.kobeengineer/photos/a.1416496745064002/3542276335819355/", 
      // $cp_data['message'] = mediaTest();
      $r[] = $cp_data;
      break;

    case substr($key, -2) == 'Q5':
      // 存第四題答案
      saveAnswer($key, $data, 'a4');
      // 第三題題目
      $cp_data = [];
      $cp_data['message'] = textTemplate('Friday night 來點小放鬆，看一部喜歡的電影或影集吧。');
      $r[] = $cp_data;
      $cp_data = [];
      $cp_data['message'] = textTemplate('在電影中，主角從租屋處走了出來，和鄰居打聲招呼後，便騎著腳踏車往學校去。');
      $r[] = $cp_data;
      $cp_data = [];
      $cp_data['message'] = textTemplate("天~ 主角和這場景都好吸引人呀~\n\n你覺得主角住在什麼房子裡呢？");
      $r[] = $cp_data;
      $cp_data = [];
      $cp_data['message'] = textTemplate('往右滑看更多選項👉');
      $r[] = $cp_data;
      $cp_data = [];
      $array = getQuestion('Q5');
      $cp_data['message'] = multipleGenericTemplate($array);
      // $cp_data['message'] = multipleMediaTemplate($array);
      // $cp_data['message'] = mediaTemplate("https://www.facebook.com/init.kobeengineer/photos/a.1416496745064002/3542276335819355/", 
      // $cp_data['message'] = mediaTest();
      $r[] = $cp_data;
      break;
    case substr($key, -3) == 'END':
      // 存第五題答案
      saveAnswer($key, $data, 'a5');
      // 計算結果
      $calculateResult = DBResult($data['psid']);
      $countArray = array_count_values([
        $calculateResult['a1'], $calculateResult['a2'], $calculateResult['a3'], $calculateResult['a4'], $calculateResult['a5']
      ]);
      $testResult = '';
      $temp = 0;
      foreach ($countArray as $key => $row) {
        if ($row > $temp) {
          $testResult = $key;
          $temp = $row;
        }
      }
      $cp_data = [];
      $cp_data['message'] = textTemplate('雅師幫你解惑中…');
      $r[] = $cp_data;
      $cp_data = [];
      $updateData = [
        'psid' => $data['psid'],
        "result" => $testResult
      ];
      DBSave($updateData);
      $cp_data['message'] = textTemplate($sharedMessage[$testResult]);
      $r[] = $cp_data;
      $cp_data = [];
      $cp_data['message'] = textTemplate('兼顧學術&應用英語才能讓你暢行無阻！');
      $r[] = $cp_data;
      // 取得結果圖片
      $attachId = getResultImageAttachId($testResult);
      // 若查無 attach id 則自主機 source/result/ 取得圖片
      if (empty($attachId)) {
        $cp_data = [];
        $cp_data['message'] = imageTemplate($source_url . "share/{$testResult}.jpg");
      } else {
        $cp_data['message'] = imageAttachmentTemplate($attachId);
      }
      $r[] = $cp_data;

      // 判斷該使用者若已填完email 則不用再出現分享鈕
      $userData = DBResult($data['psid']);
      if (!empty($userData['email'])) {
        $r[] = getSuggestionMessage();
      } else {
        $cp_data = [];
        $ary_edata = [
          $fan_page_id,
          $testResult,
          "ielts2",
          $post_id_key ?? 0
        ];
        $fb_url = "https://www.facebook.com/dialog/share?app_id=" . $fb_app_id . "&hashtag=" . urlencode("#留學國師2021年度預測") . "&href=" . urlencode($weburl . "ielts2/fb.php?edata=" . implode("_", $ary_edata)) . "&redirect_uri=" . urlencode($weburl . 'ielts2/shared.php?date=' . date('Ymd') . $data['psid']);
        $cp_data['message'] = buttonTemplate(
          [[
            "type" => "web_url",
            "title" => '公開分享抽限量好禮',
            "url" => $fb_url,
          ]],
          '抽獎去吧~'
        );
        $r[] = $cp_data;
      }
      break;
    case 'I_have_shared':
      // 分享完畢填寫 email
      // 更改為分享完畢狀態
      $result = shared($data['psid']);
      $cp_data = [];
      $cp_data['message'] = textTemplate("感謝分享。現在留下你的Email就送🤩31天IELTS Study Planner，給你滿滿的備考資源。活動結束後再加碼抽出5名獲得英國文化會獨家好禮🤩旅行大禮包！讓你讀好玩滿！");

      $r[] = $cp_data;
      $cp_data = [];
      // 取得結果圖片
      $attachId = getResultImageAttachId('reward');
      // 若查無 attach id 則自主機 source/result/ 取得圖片
      if (empty($attachId)) {
        $cp_data = [];
        $cp_data['message'] = imageTemplate($source_url . "reward/0.jpg");
      } else {
        $cp_data['message'] = imageAttachmentTemplate($attachId);
      }
      $r[] = $cp_data;
      break;
    case 'I_have_shared2':
      break;
    case filter_var($key, FILTER_VALIDATE_EMAIL) == true:
      // 填寫 email
      $result = saveEmail($key, $data['psid']);
      $cp_data = [];
      if ($result) {
        $r[] = getSuggestionMessage();
      }
      break;
    case 'suggest':
      // 給已完成email登錄且又分享的使用者  不提示輸入email 直接給結尾訊息
      $r[] = getSuggestionMessage();
      // $cp_data = [];
      // $cp_data['message'] = textTemplate('test123');
      // $r[]  = $cp_data;
      break;
    default:
      // 判斷為填email階段並驗證email格式錯誤  給予提示  其他當作一般訊息不予處理
      $userData = DBResult($data['psid']);
      if (!empty($userData) && $userData['shared'] == 1 && empty($userData['email']) && strtotime($userData['updatetime'] . '+ 10 minutes') >= strtotime('now') && !filter_var($key, FILTER_VALIDATE_EMAIL)) {
        $cp_data = [];
        $cp_data['message'] = textTemplate('Email格式錯誤，請重新輸入!');
        $r[] = $cp_data;
      }

      break;
  }
  return $r;
}

function getSuggestionMessage()
{
  $cp_data = [];
  // $cp_data['message'] = textTemplate("雅師已收到你的資料，祝你中獎！\n雅師指引攻略👇");
  // $r[] = $cp_data;
  // $cp_data = [];
  $btn = [
    [
      'type' => "web_url",
      'url' => "https://bit.ly/3ooCUCZ",
      'title' => "IELTS Study Planner📕",
    ],
    [
      'type' => "web_url",
      'url' => "https://tw.ieltsasia.org/IELTSopensdoors/?utm_source=Chatbot2&utm_medium=Chatbot2&utm_campaign=Chatbot2",
      'title' => "雅師指點迷津💯",
    ],
    [
      'type' => "web_url",
      'url' => "https://bit.ly/36vOs11",
      'title' => "托福名師挑戰裸考雅思?!🤭",
    ],
  ];
  $cp_data['message'] = buttonTemplate($btn, "雅師已收到你的資料，祝你中獎！\n雅師指引攻略👇");
  return $cp_data;
}
/**
 * 取得問題array
 * @param string number Q1 Q2 etc..
 * @return array
 */
function getQuestion($number)
{
  global $question;
  $array = [];
  foreach ($question[$number] as $row) {
    array_push($array, [
      'title' => $row['txt'],
      'image_url' => $row['pic'],
      'buttons' => $row['btn']
    ]);
  }
  return $array;
}

/**
 * 儲存答案
 * @param string postbask的關鍵字
 * @param array  postbask的值
 * @param string 第幾題  a1 a2 etc..
 */
function saveAnswer($key, $data, $list)
{
  global $answers;
  $string = strstr($key, '.', true);
  $updateData = [
    'psid' => $data['psid'],
    "$list" => $answers[$string] ?? null
  ];
  DBSave($updateData);
}

/**
 * 取得結果國家圖片 attach id
 */
function getResultImageAttachId($key)
{
  global $db;
  $sql = "select attachment_id from ielts2_data where keyname=:key";
  $data = $db->query_first($sql, [':key' => $key]);
  return $data['attachment_id'] ?? '';
}

/**
 * 設為已分享
 * @param string ps id
 * @return boolean
 */
function shared($id)
{
  global $db;
  $result = $db->query_update('ielts2', [
    'shared' => 1,
    'updatetime' => date('Y-m-d H:i:s')
  ], "psid=$id and result != ''");
  return $result;
}

/**
 * 儲存email
 * @param string email
 * @param string ps id
 */
function saveEmail($email, $id)
{
  global $db;
  $result = false;
  $sql = "select updatetime from ielts2 where psid=:id and shared = 1 and email is null";
  $data = $db->query_first($sql, [
    ':id' => $id
  ]);
  $data = $data['updatetime'] ?? 0;
  if (!empty($data)) {
    // 判斷於通知輸入 email 訊息10分內回覆
    if (strtotime($data . '+ 10 minutes') >= strtotime('now')) {
      $result = $db->query_update('ielts2', [
        'email' => $email,
        'updatetime' => date('Y-m-d H:i:s')
      ], "psid=$id and shared = 1");
    }
  }
  return $result;
}
