<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class MailerController extends Controller
{
    public function send(Request $request){
        require base_path("vendor/autoload.php");
        $mail = new PHPMailer(true);     // Passing `true` enables exceptions

        try {

            // Email server settings
            $mail->SMTPDebug = 0;
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';             //  smtp host
            $mail->SMTPAuth = true;
            $mail->Username = 'batstateu.arasof.healthservices@gmail.com';   //  sender username
            $mail->Password = 'xcubxplyegmectck';       // sender password
            $mail->SMTPSecure = 'tls';                  // encryption - ssl/tls
            $mail->Port = 587;                          // port - 587/465

            $mail->setFrom('BatStateU.ARASOF.HealthServices@gmail.com', 'noreply');
            $mail->addAddress($request->emailTo);
            
            if(isset($request->emailCc)){
                $mail->addCC($request->emailCc);
            }

            if(isset($request->emailBcc)){
                $mail->addBCC($request->emailBcc);
            }

            //$mail->addReplyTo('batstateu.arasof.healthservices@gmail.com', 'BatStateU - ARASOF Health Services');

            if(isset($_FILES['emailAttachments'])) {
                for ($i=0; $i < count($_FILES['emailAttachments']['tmp_name']); $i++) {
                    $mail->addAttachment($_FILES['emailAttachments']['tmp_name'][$i], $_FILES['emailAttachments']['name'][$i]);
                }
            }

            $mail->isHTML(true);// Set email content format to HTML

            $mail->Subject = $request->subject;
            $mail->Body    = $request->body;

            // $mail->AltBody = plain text version of email body;

            if( !$mail->send() ) {
                return false;  
            }  
            else {
                return true; 
            }

        } catch (Exception $e) {
            return false; 
        }
    }
}
