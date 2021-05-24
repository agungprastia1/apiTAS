<?php
defined('BASEPATH') or exit('no direct script access allowed');

use chriskacerguis\RestServer\RestController;

//Import PHPMailer classes into the global namespace
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

require 'vendor/autoload.php';

class RessetPass extends RestController
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('M_auth', 'auth');
        $this->methods['index_get']['limit'] = 500;
    }

    public function index_post()
    {
        $email = $this->post('email');
        $cekEmail = $this->auth->getWhere('akun', $email);

        if (count($cekEmail) > 0) {
            $this->kirimEmail($email);
        } else {
            $this->response([
                'status' => false,
                'message' => 'email not found',
                'data' => $email
            ], 404);
        }
    }

    public function kirimEmail($email)
    {

        //Create a new PHPMailer instance
        $mail = new PHPMailer();

        //Tell PHPMailer to use SMTP
        $mail->isSMTP();

        //Enable SMTP debugging
        //SMTP::DEBUG_OFF = off (for production use)
        //SMTP::DEBUG_CLIENT = client messages
        //SMTP::DEBUG_SERVER = client and server messages
        $mail->SMTPDebug = SMTP::DEBUG_OFF;

        //Set the hostname of the mail server
        $mail->Host = 'smtp.gmail.com';
        //Use `$mail->Host = gethostbyname('smtp.gmail.com');`
        //if your network does not support SMTP over IPv6,
        //though this may cause issues with TLS

        //Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
        $mail->Port = 587;

        //Set the encryption mechanism to use - STARTTLS or SMTPS
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;

        //Whether to use SMTP authentication
        $mail->SMTPAuth = true;

        //Username to use for SMTP authentication - use full email address for gmail
        $mail->Username = 'Tenowmar@gmail.com';

        //Password to use for SMTP authentication
        $mail->Password = 'risixtwenty';

        //Set who the message is to be sent from
        $mail->setFrom('Tenowmar@gmail.com', 'Toko Aki Se-Indonesia');

        //Set an alternative reply-to address
        // $mail->addReplyTo('agungztya@gmail.com', 'First Last');

        //Set who the message is to be sent to
        $mail->addAddress($email);
        //Set the subject line
        $mail->Subject = 'Resset Password User';

        //Read an HTML message body from an external file, convert referenced images to embedded,
        //convert HTML into a basic plain-text alternative body
        // $mail->msgHTML(file_get_contents('reset.html'), $this->views('reset'));

        $mail->Body = '<p>Untuk Resset Password akun anda <a href = "http://localhost/api-mobile/RessetPass/resset/' . $email . '" >Klik Disini</a></p>';
        //Replace the plain text body with one created manually
        $mail->AltBody = 'This is a plain-text message body';

        //Attach an image file
        // $mail->addAttachment('images/phpmailer_mini.png');

        //send the message, check for errors
        if (!$mail->send()) {
            $this->response([
                'status' => false,
                'message' => $mail->ErrorInfo
            ], 406);
        } else {
            $this->response([
                'status' => true,
                'message' => 'HTTP_OK'
            ], 200);
        }
    }

    public function resset_put($id)
    {
        $pass = md5($this->put('pass'));
        $cekemail = $this->auth->getWhere('akun', $id);
        if (count($cekemail) > 0) {
            $this->auth->ressetPass('akun', $pass, $id);
            $this->response([
                'status' => true,
                'message' => 'HTTP_OK'
            ], 200);
        } else {
            $this->response([
                'status' => false,
                'message' => 'PASSWORD NOT MODIFIED'
            ], 403);
        }
    }
}
