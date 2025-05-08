<?php
// core/MailerService.php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


class MailerService
{
    private $mailer;

    public function __construct()
    {
        $this->mailer = new PHPMailer(true);

        // SMTP 設定
        $this->mailer->isSMTP();
        $this->mailer->Host       = 'smtp.gmail.com';
        $this->mailer->SMTPAuth   = true;
        $this->mailer->Username   = 'kocoimur0003@gmail.com';      // 替換
        $this->mailer->Password   = $_ENV['PHP_MAILER'];        // Gmail 應用程式密碼
        $this->mailer->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $this->mailer->Port       = 587;
		    // 重點在這行！設定郵件編碼為 UTF-8
        $this->mailer->CharSet = 'UTF-8';

        $this->mailer->setFrom('kocoimur0003@gmail.com', 'MemberSystem');
    }

    public function sendVerifyToken($to, $token)
    {
        try {
            $this->mailer->addAddress($to);

            $this->mailer->isHTML(true);
            $this->mailer->Subject = '開通帳號驗證信';
            $this->mailer->Body    = '
                <h2>開通帳號驗證信</h2>
                <p>請點擊以下連結來開通您的帳號：</p>
                <p><a href="https://keepgoingpiggy.com/?route=verify&token=' . $token . '">驗證連結</a></p>
                <p>若您未註冊，請勿點擊此連結。</p>
            ';

            $this->mailer->send();
        } catch (Exception $e) {
            error_log("寄信失敗: {$this->mailer->ErrorInfo}");
        }
    }
}
?>