<?php
$hook = file_get_contents('php://input');
$db=include("common/config/main-local.php");
$db=$db["components"]["db"];
$dbname=explode("dbname=",$db["dsn"]);
$dbname=$dbname[count($dbname)-1];

mysql_connect("localhost",$db["username"],$db["password"]) or die("unable to connect to localhost.");
mysql_select_db($dbname) or die("unable to connect to db.");
if($res=mysql_query("insert into event_meta set event_id=0, meta_key='eb_hook_data', meta_value='$hook'"))$id=mysql_insert_id();
else echo 0;

if(isset($id)){
	$ch = curl_init(); 
	curl_setopt($ch, CURLOPT_URL, "http://webriderz.uniquecoders.in/muuv/api/web/index.php?r=v1/event-post/eb-order&id=".$id); 
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_USERAGENT,'Mozilla');
	$output = curl_exec($ch); 
	print_r($output);
	curl_close($ch);
}

die();

if(isset($hook->api_url) || 1){
	$ch = curl_init(); 
	curl_setopt($ch, CURLOPT_URL, "http://webriderz.uniquecoders.in/muuv/api/web/index.php?r=v1/event-post/eb-order&id="); 
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_USERAGENT,'Mozilla');
	$output = curl_exec($ch); 
	print_r($output);
	curl_close($ch);
	/*$order=json_decode($output);
	$event_id=$order->event_id;
	curl_setopt($ch, CURLOPT_URL, "https://www.eventbriteapi.com/v3/events/".$event_id."/ticket_classes?token=RDCIEI3EG25PRQCSSZAW"); 
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
	$output = curl_exec($ch); 
	curl_close($ch);
	if(mysl_query("insert into event_meta set event_id=51, meta_key='eb_data', meta_value='$output'"))echo 1;
	else echo 0;*/
}

/*$hook=json_decode('{"config": {"action": "order.placed", "user_id": "197358559571", "endpoint_url": "http://webriderz.uniquecoders.in/muuv/index.php", "webhook_id": "345330"}, "api_url": "https://www.eventbriteapi.com/v3/orders/607025163/"}');
print_r($hook);*/
?>