<?PHP
/*Upload path*/

use function PHPSTORM_META\map;

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

$COUNTRY_NAME = [
  'UK'=>'英國',
  'US'=>'美國',
  'CA'=>'加拿大',
  'AU'=>'澳洲'
];

$incary_alphabet = array_merge([''], range('A', 'Z'));
$incary_ielts_answers = [
    'ANSQ1A1' => false,
    'ANSQ1A2' => false,
    'ANSQ1A3' => true,
    'ANSQ1A4' => false,

    'ANSQ2A1' => false,
    'ANSQ2A2' => false,
    'ANSQ2A3' => true,

    'ANSQ3A1' => false,
    'ANSQ3A2' => false,
    'ANSQ3A3' => true,

    'ANSQ4A1' => false,
    'ANSQ4A2' => false,
    'ANSQ4A3' => false,
    'ANSQ4A4' => true,

    'ANSQ5A1' => true,
    'ANSQ5A2' => false,
    'ANSQ5A3' => false,
    'ANSQ5A4' => false,

    'ANSQ6A1' => false,
    'ANSQ6A2' => false,
    'ANSQ6A3' => true,

    'ANSQ7A1' => false,
    'ANSQ7A2' => false,
    'ANSQ7A3' => false,
    'ANSQ7A4' => true,

    'ANSQ8A1' => false,
    'ANSQ8A2' => true,
    'ANSQ8A3' => false,
    'ANSQ8A4' => false,

    'ANSQ9A1' => false,
    'ANSQ9A2' => false,
    'ANSQ9A3' => true,
    'ANSQ9A4' => false,
];




    $fan_page_id = "103313764977349";
    $inc_fb_verify_token = 'EAAyn6ZAR2CykBAEKCVppf66A0TF33kpAlgvuvArg5HupnZC3UVAKa4OSW0xJHO2oxSoPIuAaTmS3LDedmzXqZCvhBi0XMOMM3tw6MStM4anPADO7d2WfVaICrnTU9ieo4e6MubpczrKsbNTkg83xplAqiXWZCuZATZBcEEWZAZCuqAZDZD'; //驗證webhook的token 自訂

    //粉絲專頁ID=>settings
    $ary_fanpage_settings = [
        '103313764977349' => [  
            'case' => 'ielts2',
            'page_token' => 'EAAyn6ZAR2CykBAEKCVppf66A0TF33kpAlgvuvArg5HupnZC3UVAKa4OSW0xJHO2oxSoPIuAaTmS3LDedmzXqZCvhBi0XMOMM3tw6MStM4anPADO7d2WfVaICrnTU9ieo4e6MubpczrKsbNTkg83xplAqiXWZCuZATZBcEEWZAZCuqAZDZD'
        ]
    ];
    


?>
