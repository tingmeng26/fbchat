<?php

class UtmCode {

    public static $session_name = 'utm_code_session';

    public function __construct()
    {

    }
    
    public static function get(){
        $items = unserialize(getSession(self::$session_name));
        return is_object($items) ? $items : new items();
    }

    public static function set(){
        $items = self::get();
        $source = get("utm_source", 1);
        $medium = get("utm_medium", 1);
        $content = get("utm_content", 1);
        $campaign = get("utm_campaign", 1);
        if($source !== '' && strlen($source) < 100){
            $items->source = $source;
        }
        if($medium !== '' && strlen($medium) < 100){
            $items->medium = $medium;
        }
        if($content !== '' && strlen($content) < 100){
            $items->content = $content;
        }
        if($campaign !== '' && strlen($campaign) < 100){
            $items->campaign = $campaign;
        }
        setSession(self::$session_name, serialize($items));
        
    }

    public static function clear(){
        setSession(self::$session_name, null);
        unSession(self::$session_name);
    }

}
class items {
    public $source="";
    public $medium="";
    public $content="";
    public $campaign="";
    
}
/* End of this file */