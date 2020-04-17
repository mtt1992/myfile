<?php
  //-----------
	// https://api.telegram.org/bot1011487225:AAGifzTkxzJvb5aaih4V51eYzFygFvlMCxI/setwebhook?url=https://mtt1992.herokuapp.com/
	//------------
	$bot_url = "https://api.telegram.org/bot1011487225:AAGifzTkxzJvb5aaih4V51eYzFygFvlMCxI";
	//---------------------------
	$update = file_get_contents("php://input");
	
	$update_array = json_decode($update, true); // JSON
	
	if( isset($update_array["message"]) ) {
	
		$text 	 = $update_array["message"]["text"];
		$chat_id = $update_array["message"]["chat"]["id"];
	}
	//---------------------------
	key1 = 'ارسال پیام';
	key2 = 'ارسال عکس';
	key3 = 'ارسال فایل صوتی';
	key4 = 'ارسال فایل ویدیوئی';
	key5 = 'ارسال داکیومنت';
	key6 = 'ارسال استیکر';
	key7 = 'ارسال موقعیت مکانی';
	key8 = 'ارسال اطلاعات تماس';
	$reply_keyboard = [
						 [$key1 , $key2],
						 [$key3 , $key4],
						 [$key5 , $key6],
						 [$key7 , $key8],
					   ];
	$reply_kb_options = [
							'keyboard' 		    => $reply_keyboard,
							'resize_keyboard'   => true, 
							'one_time_keyboard' => false,
						];
	//---------------------------
	switch($text) {
		
		case "/start"  : show_menu();  break;
		
		case $key1 : send_message();   break;
		case $key2 : send_photo();     break;
		case $key3 : send_audio();     break;
		case $key4 : send_video();     break;
		case $key5 : send_document();  break;
		case $key6 : send_sticker();   break;
		case $key7 : send_location();  break;
		case $key8 : send_contact();   break;
	}
	//---------------------------

	// نمایش منو
	function show_menu(){
	
		$json_kb = json_encode($GLOBALS['reply_kb_options']);
		$reply = "یکی از گزینه های زیر را انتخاب کنید";
		$url = $GLOBALS['bot_url'] . "/sendMessage";
		$post_params = [ 'chat_id' => $GLOBALS['chat_id'] , 'text' => $reply, 'reply_markup' => $json_kb ];
		send_reply($url, $post_params);
	}
	//---------------------------
	
	// ارسال پیام
	function send_message() {
		
		$reply = "salam";
		$url = $GLOBALS['bot_url'] . "/sendMessage";
		$post_params = [ 'chat_id' => $GLOBALS['chat_id'] , 'text' => $reply ];
		send_reply($url, $post_params);
	}
	
	//---------------------------
	
	//	ارسال عکس
	function send_photo() {
		
		$url = $GLOBALS['bot_url'] . "/sendPhoto";
		$post_params = [ 
						'chat_id' => $GLOBALS['chat_id'] , 
						'photo'   => new CURLFILE(realpath("image_file.png")),
						'caption'  => "توضیحات عکس", //optional
						];
		send_reply($url, $post_params);
	}
	
	//---------------------------
	
	// ارسال فایل صوتی
	function send_audio() {
		
		$url = $GLOBALS['bot_url'] . "/sendAudio";
		$post_params = [ 
						'chat_id'   => $GLOBALS['chat_id'] , 
						'audio'     => new CURLFILE(realpath("audio_file.mp3")),
						'caption'   => "توضیحات فایل صوتی", 			 //optional
						'title'	    => "عنوان فایل صوتی",   			 //optional
						'performer' => "متنی که روی فایل ظاهر میسازد",   //optional
						];
		send_reply($url, $post_params);
	}
	
	//---------------------------
	
	// ارسال فایل ویدیو
	function send_video() {
		
		$url = $GLOBALS['bot_url'] . "/sendVideo";
		$post_params = [ 
						'chat_id'   => $GLOBALS['chat_id'] , 
						'video'     => new CURLFILE(realpath("video_file.mp4")),
						'caption'   => "توضیحات فایل ویدیوئی", 	 //optional
						];
		send_reply($url, $post_params);
	}
	//---------------------------
	
	// ارسال داکیومنت
	function send_document() {
		
		$url = $GLOBALS['bot_url'] . "/sendDocument";
		$post_params = [ 
						'chat_id'   => $GLOBALS['chat_id'] , 
						'document'     => new CURLFILE(realpath("document.pdf")),
						'caption'   => "توضیحات داکیومنت", 	 //optional
						];
		send_reply($url, $post_params);
	}
	//---------------------------
	
	// ارسال استیکر
	function send_sticker() {
		
		$url = $GLOBALS['bot_url'] . "/sendSticker";
		$post_params = [ 
						'chat_id'   => $GLOBALS['chat_id'] , 
						'sticker'     => new CURLFILE(realpath("sticker.webp")),
						];
		send_reply($url, $post_params);	
	}
	//---------------------------
	
	// ارسال موقعیت مکانی
	function send_location() {
		
		$url = $GLOBALS['bot_url'] . "/sendLocation";
		$post_params = [ 
						'chat_id'      => $GLOBALS['chat_id'] , 
						'latitude'     => 34.3536098,
						'longitude'    => 62.24218,16,
						];
		send_reply($url, $post_params);	
	}
	//---------------------------
	
	// ارسال اطلاعات تماس
	function send_contact() {
		
		$url = $GLOBALS['bot_url'] . "/sendContact";
		$post_params = [ 
						'chat_id'      => $GLOBALS['chat_id'] , 
						'phone_number'   => "0796858483",
						'first_name'    => "Moh Taqi",
						'last_name'		=> "Tokhi",		//optional
						];
		send_reply($url, $post_params);	
	}
	//---------------------------
	function send_reply($url, $post_params) {
		$cu = curl_init();
		curl_setopt($cu, CURLOPT_URL, $url);
		curl_setopt($cu, CURLOPT_POSTFIELDS, $post_params);
		curl_setopt($cu, CURLOPT_RETURNTRANSFER, true); // get result
		$result = curl_exec($cu);
		curl_close($cu);
		return $result;
	}
	//---------------------------


?>
