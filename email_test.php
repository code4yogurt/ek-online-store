<?php
$to = 'joshua_macuja@dlsu.edu.ph';
$subject ='This is an email';
$message = 'this is a test email\r\nHope you got it\r\nioasjdoiajsodijasoidjoasjdoiasjdoiasjdioasjdioasbausbvasvioasijasoidjasiojdoiasjdioasjdioasjdioahfuweitiuwguhg8394yg934hguwvsduvbuacaspcioqehf929gdivuofhguhfgohdufhubauidytatydeyabfuonosnuobyiecbifbauobcisyvirsbiuvuauicgaivzvuehuiiqet783675137857q8ruiasfjhvzhcbhjcvayuofenwouegousguirgosnvohsuivbusirbuivsbiuvb';
$message = wordwrap($message, 70, "\r\n");
$headers = 'From:joshboyee@yahoo.com';
if(mail($to, $subject,$message,$headers)){
  echo 'email has been sent to '.$to;
}else{
  echo 'There was an eeror sending the email';
}

?>