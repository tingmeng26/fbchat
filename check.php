<?php
$verify_token = get('hub_verify_token',1);
$challenge = get('hub_challenge',1);
if($verify_token === $inc_fb_verify_token){
    echo $challenge;
}else{
    echo 'Error, wrong validation token';
}
?>