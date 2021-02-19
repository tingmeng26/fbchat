<?php
class coderPush
{
	//發送推播
	public static function push($devices){
	      //hotelB2B

	    $registrationIds = $devices['Token'];

	    $msg = array(
	        'body'  =>  $devices['Content'],
	        'title' =>  $devices['Title'],
	            'icon'  => 'myicon',/*Default Icon*/
	            'sound' => 'mySound'/*Default sound*/
	    );

	    $fields = array(
	        'to' => $registrationIds,
	        'notification' => $msg,
	    	'data'=>$devices['data']);

	    $headers = array(
	            'Authorization: key=' . PUSH_API_ACCESS_KEY,
	            'Content-Type: application/json'
	        );

	    $ch = curl_init();
	    curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
	    curl_setopt( $ch,CURLOPT_POST, true );
	    curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
	    curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
	    curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
	    curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
	    $result = curl_exec($ch );
	    curl_close( $ch );
	    return $result;
	}
}