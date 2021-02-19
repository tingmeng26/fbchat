<?php
/**
 * FB相關Library
 *
 * @author Cully, Khai
 * @version 1.1
 */

class coderFB{
    /**
     * 私有變數,FB需要的scope
     */
    private static $_scope='email';
    /**
     * 私有變數,FB實體
     */ 
    private static $_fb;
    /**
     * 私有變數,FB的access_token
     */
    public static $access_token='';

    /**
     * 取得UserProfile
     *
     * @return fb的me
     * 錯誤返回Exception
     */
    public static function getUserProfile($token){
        $facebook = self::_initFB();
        $facebook->setAccessToken($token);

        try {
            // $fields = array(
            //    'id', 'name', 'first_name', 'last_name', 'link', 'website', 
            //   'gender', 'locale', 'about', 'email', 'hometown', 'location');
            // $user_profile = $facebook->api('/me?fields=' . implode(',', $fields));
            $user_profile = $facebook->api('/me');
            return $user_profile;
        } catch (FacebookApiException $e) {
            $user = null;
            return null;
        }
    }


    /**
     * 取得登入者的FBID
     *
     * @return fbid
     * 錯誤返回Exception
     */
    public static function getFBID(){
        $facebook = self::_initFB();
        return $facebook->getUser();

    }   
    /**
     * 取得FB物件
     * 
     * @return $fb物件
     */ 
    private static function _initFB(){
        if(!isset(self::$_fb)){
            require(CONFIG_DIR.'Facebook/facebook.php');
            self::$_fb = new Facebook(array(
              'appId'  => APP_ID,
              'secret' => APP_SECRECT,
            ));
        }
        return self::$_fb;
    }

    /**
     * FB登入,自動轉到FB登入頁後返回本頁
     * 
     * @return $fb物件
     */ 
    public static function fbLogin(){
        $facebook = self::_initFB();
        header('location:'.$facebook->getLoginUrl(array('scope' => self::$_scope)));
    }

    public static function feed($ary){
        $response = false;
        try { 
            $facebook = self::_initFB();
            $response = $facebook->api('me/feed', 'post', $ary);
        } catch (FacebookApiException $e) { 
            throw new Exception('分享錯誤:'.print_r($e->getResult()).print_r($post_id));
        } 
        return $response;
    }
}