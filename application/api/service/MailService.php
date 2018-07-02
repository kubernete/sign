<?php
/**
 * 由 PhpStorm 创造.
 * 用户: Administrator朕之天下
 * 日期: 2018/6/1
 * 时间: 20:40
 */

namespace app\api\service;

use phpmailer\PHPMailer;
use phpmailer\phpmailerException;

/**
 * Class MailService 发送邮件服务
 * @package app\api\service
 */
class MailService
{
    /**
     * @param $to
     * @param $title
     * @param $content
     * @return bool
     */
    public function sendMail($to, $title, $content)
    {

        date_default_timezone_set('PRC');//set time
        if(empty($to)) {
            return false;
        }
        try {
            //Create a new PHPMailer instance
            $mail = new PHPMailer;
            $this->setMailParam($mail, $to, $title, $content);
            if (!$mail->send()) {
                return false;

            } else {
                return true;
            }
        }catch(phpmailerException $e) {
            return false;
        }
    }



    protected function setMailParam(PHPMailer $mail,$to, $title, $content)
    {

        //Tell PHPMailer to use SMTP
        $mail->isSMTP();

        $mail->Debugoutput = 'html';
        //Set the hostname of the mail server
        $mail->Host = config('email.host');
        //Set the SMTP port number - likely to be 25, 465 or 587
        $mail->Port = config('email.port');
        //Whether to use SMTP authentication
        $mail->SMTPAuth = true;
        //Username to use for SMTP authentication
        $mail->Username = config('email.username');
        //Password to use for SMTP authentication
        $mail->Password = config('email.password');
        //Set who the message is to be sent from
        $mail->setFrom(config('email.username'), '新叶签到');
        //Set an alternative reply-to address
        //$mail->addReplyTo('replyto@example.com', 'First Last');
        //Set who the message is to be sent to
        $mail->addAddress($to);
        //Set the subject line
        $mail->Subject = $title;
        //Read an HTML message body from an external file, convert referenced images to embedded,
        //convert HTML into a basic plain-text alternative body
        $mail->msgHTML($content);
        //Replace the plain text body with one created manually
        //$mail->AltBody = 'This is a plain-text message body';
        //Attach an image file
        //$mail->addAttachment('images/phpmailer_mini.png');

        //send the message, check for errors

    }

}