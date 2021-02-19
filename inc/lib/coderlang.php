<?php
class coderLang
{
    private static $_lang='';
    private static $_def_lang='tw';
    private static $_cookie_name='site_lang';
    public static $_lang_ary=array('tw'=>'繁體中文','jp'=>'日文','en'=>'ENGLISH');
    public static $_dic=null;
    public static function getDic(){
        if(self::$_dic!=null){
            return self::$_dic;
        }
        $lang=self::get();
        self::confDic($lang);
        return self::$_dic;
    }
    private static function confDic($lang){
        $path=CONFIG_DIR.'lang/'.$lang.'.php';
        if(!file_exists ($path)){
            $path=CONFIG_DIR.'lang/'.self::$_def_lang.'.php';
        }
        include_once($path);
        self::$_dic=$_dic_lang;
    }
    public static function set($lang)
    {
        global $rootpath;
        if(array_key_exists( $lang, self::$_lang_ary ) ){
            coderWebHelp::saveCookie(self::$_cookie_name, $lang,  $rootpath, $httponly=true);
            self::$_lang=$lang;
        }
    }
    public static function get(){
        if(self::$_lang!='' && array_key_exists(self::$_lang, self::$_lang_ary)){
            return self::$_lang;
        }
        if(get('lang',1)!=''){
            $lang=get('lang',1);
        }else{
            $lang=coderWebHelp::getCookie(self::$_cookie_name);
        }
        if(trim($lang)=="" || !array_key_exists($lang,  self::$_lang_ary)){
            self::set(self::$_def_lang);
            $lang=self::$_def_lang;
        }
        return $lang;
    }

}