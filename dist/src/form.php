<?php

if(!empty($_POST['name']) && !empty($_POST['email']) && !empty($_POST['message']) && isset($_POST['privacy']))
{
   // This is Google API url where we pass the API secret key to validate the user request.
   $google_recaptcha_url = 'https://www.google.com/recaptcha/api/siteverify';
   $recaptcha_secret_key = '6LeGjT8aAAAAADLRYznfATCqbMGp_3iTtTzkUcoO'; // Add your generated Secret key
   $set_recaptcha_response = $_POST['recaptcha_response'];

   // Make the request and capture the response by making below request. 
   $get_recaptcha_response = file_get_contents($google_recaptcha_url . '?secret=' . $recaptcha_secret_key . '&response=' . $set_recaptcha_response);
   
   $get_recaptcha_response = json_decode($get_recaptcha_response);
   $success_msg="";
   $err_msg="";

   // Set the Google recaptcha spam score here and based the score, take your action
   if ($get_recaptcha_response->success == true && $get_recaptcha_response->score >= 0.5 && $get_recaptcha_response->action == 'submit') {
      $subject = 'Kontaktanfrage über Kontakformular auf blumen-billmeier-haar.de';          // email subject
      $emailTo = 'info@blumen-billmeier-haar.de';         // change to your email
      $errors = array();                          // array to hold validation errors
      $data = array();                            // array to pass back data
      if($_SERVER['REQUEST_METHOD'] === 'POST') {
         $name = stripslashes(trim($_POST['name']));
         $email = stripslashes(trim($_POST['email']));
         $number = stripslashes(trim($_POST['number']));
         $message = stripslashes(trim($_POST['message']));

         $body = '
            <strong>Name: </strong>'.$name.'<br />
            <strong>Email: </strong>'.$email.'<br />
            <strong>Nummer: </strong>'.$number.'<br />
            <strong>Nachricht: </strong>'.$message.'<br />
         ';
         $headers  = "MIME-Version: 1.1" . PHP_EOL;
         $headers .= "Content-type: text/html; charset=utf-8" . PHP_EOL;
         $headers .= "Content-Transfer-Encoding: 8bit" . PHP_EOL;
         $headers .= "Date: " . date('r', $_SERVER['REQUEST_TIME']) . PHP_EOL;
         $headers .= "Message-ID: <" . $_SERVER['REQUEST_TIME'] . md5($_SERVER['REQUEST_TIME']) . '@' . $_SERVER['SERVER_NAME'] . '>' . PHP_EOL;
         $headers .= "From: " . "=?UTF-8?B?".base64_encode($name)."?=" . PHP_EOL;
         $headers .= "Return-Path: $emailTo" . PHP_EOL;
         $headers .= "X-Mailer: PHP/". phpversion() . PHP_EOL;
         $headers .= "X-Originating-IP: " . $_SERVER['SERVER_ADDR'] . PHP_EOL;
         mail($emailTo, "=?utf-8?B?" . base64_encode($subject) . "?=", $body, $headers);   
         $success_msg = "Dankeschön für Ihre Nachricht, $name! Wir werden uns umgehend mit Ihnen in Verbindung setzen!";
      }
   } else {
      $err_msg = "Etwas ist schief gelaufen. Bitte versuchen Sie es später eneut!";
   }
} else {
   $err_msg = "Bitte füllen Sie alle benötigten Felder aus. Eine Verabreitung Ihrer Anfrage ist ansonsten leider nicht möglich!";

}
// Get the response and pass it into your ajax as a response.
$return_msg = array(
   'error'     =>  $err_msg,
   'success'   =>  $success_msg
);
echo json_encode($return_msg);

?>