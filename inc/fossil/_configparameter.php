<?PHP
/*Upload path*/
$admin_path_temp="../../upload/temp/";
$path_temp = "upload/temp/";

//admin
$admin_path_admin = "../upload/admin/";
$admin_path_admin2 = "../../Web_Manage/upload/admin/";

//消息
$path_news = "upload/news/";
$admin_news = "../../upload/news/";

/*Cache path*/
$cache_path='upload/cache/';
$cache_path_web=$cache_path;
$cache_path_mob='../'.$cache_path;
$cache_path_do='../'.$cache_path;
$cache_path_api='../'.$cache_path;
$cache_path_admin='../../'.$cache_path;

//ckeditor
$path_ckeditor=$weburl.'upload/editor/';//ckeditor中路徑
$admin_path_ckeditor="../../upload/editor/";//上傳放置(以後台位置來看)
$db_path_ckeditor='upload/editor/';//存入資料庫時改為

/*Image setup*/
//banner - 電腦
$pic_banner_w = 1920;
$pic_banner_h = 1800;

/*Cache name*/
$web_cache=array();

/*資料用ARY*/
$incary_YNE=array('No','Yes');
$incary_isshow=array( 1=>'顯示',0 =>'隱藏');
$incary_sex = array('女','男');
$incary_yn=array(0 =>'否', 1=>'是');
$incary_yn_anti = array_flip($incary_yn);
$incary_yn_layout = array('<span class="label">否</span>','<span class="label label-success">是</span>');

$incary_yn_layout2 = array('<span class="label">不顯示</span>','<span class="label label-success">顯示</span>');

$incary_results = [
    1 => '勇往直前的狠犬',
    2 => '聰明伶俐的貓咪',
    3 => '親切可人的兔子',
    4 => '謙虛有禮的貓頭鷹',
];

$fan_page_id = "407102656714712";

if ($nowHost == "Production") { //正式站

    $inc_fb_verify_token = '5NPfRbFZwhAZXSM3SFSFDSFS9W3DuF3BGQxDgF8vCXTBMgYP'; //驗證webhook的token 自訂

    //粉絲專頁ID=>settings
    $ary_fanpage_settings = [
        '407102656714712' => [  /*Fossil正式粉絲團*/
            'page_token' => 'EAAJFtgKYUr8BACgRYm4JEdj0cZALs6oKeVqR0wk1ZBvhOZBhNalZCGkyBboiZCeeD4s7sQr3gX6ibBue7BOqALGzbpqimJDDZAbIeZCbZBh9LXiAonzZCYEXxFn7vLoxuMnUJLvKJMIAnKYNwKJtJV0JoIyZCl7tYfaZB3g1wA0YtpGVzLeMTjb7iuAl2o3On4uXHUZD',
        ],
        '109611464003123' => [  /*誠智數位有限公司*/
            'page_token' => 'EAAJFtgKYUr8BACKZAmrLknjkzIfp33LwyOGNHzZCxeWIbd60uTbuSvDWzOUlBaCAZAZClbSUkVYJvPb7uZASWXWCQXvaxxZA7n48wYKqbdIPiZCAtrBZAPYdSTVt7i3Qg1vtjUQVZAG13zHLuGcyfS7cR0AzfKV6vibAFBY86973z4qO1l0jTVEXpzdo7OWMoVbQZD',
        ]
    ];
    
} else {


    $inc_fb_verify_token = '5NPfRbFZwhAZXSM3C8z2V54sXRYD2vCs5R6KvsYb9W3DuF3BGQxDgF8vCXTBMgYP'; //驗證webhook的token 自訂

    //粉絲專頁ID=>settings
    $ary_fanpage_settings = [
        '108172000819767' => [  //TEST1
            'page_token' => 'EAADATcry4g0BAMdjZAPkYSd65W9sdMB7OgT2NXe3RfdIa28VTtLzeFCvKU1JZCXrBfXtGA5SVcz4wCwzUcRDUDyMsGHC7xc2D4CMaBkpnXFQkOBZCtgnLtv3OsVjSWxGsLOZChItfsJU7vw5fE6PQopQmrdZAzhLJWqsZBXZBNJgXGFE6auGZCaW'
        ]
    ];
    
}

?>