<?php
/**
 * Mail class
 *
 * This class will handle system mails. Send mails to recipients.
 * Integrated with Mailgun API
 *
 * @author  Aruna Attanayake <aruna@keeneye.solutions>
 */

namespace app\components;

use Yii;
use yii\base\Component;
use yii\helpers\Html;
use yii\base\View;
use app\components\RestClient;


class Mail extends Component
{
    public $emailTemplatePath = '@app/views/email-template/notificationTemplate';
    public $emailContPath = '@app/mail/';
    public $apiEndPoint;
    public $apiUsername;
    public $apiPassword;
    public $fromEmail;
    public $fromName;
    public $language = 'en-US';
    public $defLang = 'en-US';
    public $view;
    public $productName = '';

    public function __construct()
    {
        $this->fromEmail = Yii::$app->params['supportEmail'];
        $this->fromName = Yii::$app->params['productName'];
        $this->apiEndPoint = Yii::$app->params['mailgun']['apiEndPoint'];
        $this->apiUsername = Yii::$app->params['mailgun']['apiUsername'];
        $this->apiPassword = Yii::$app->params['mailgun']['apiPassword'];
        $this->productName = Yii::$app->params['productName'];
        $this->view = new View();
    }

    /**
     * Send signup email
     * @param string $email Recipient email
     * @param string $name Recipient name
     * @return boolean true/false
     */
    public function sendSignupEmail($email, $name)
    {
        $subject = Yii::t('mail', 'Welcome to {productName}', ['productName' => $this->productName], $this->language);
        $message = $this->getEmailContent('signup', [
            '{name}' => $name,
            '{productName}' => $this->productName,
        ]);

        return $this->send($email, $subject, $message);
    }

    /**
     * Send forgot password email
     * @param string $email Recipient email
     * @param string $link Password reset link
     * @return boolean true/false
     */
    public function sendForgotPasswordEmail($email, $link)
    {
        $subject = Yii::t('mail', 'Reset password', [], $this->language);
        $message = $this->getEmailContent('forgot-password', [
            '{link}' => $link
        ]);

        return $this->send($email, $subject, $message);
    }

    /**
     * Send password reset email
     * @param string $email Recipient email
     * @param string $name Recipient name
     * @return boolean true/false
     */
    public function sendPasswordResetEmail($email, $name)
    {
        $subject = Yii::t('mail', 'Reset password', [], $this->language);
        $message = $this->getEmailContent('password-reset', [
            '{name}' => $name,
        ]);

        return $this->send($email, $subject, $message);
    }

    /**
     * Send email
     * @param string $toEmail Recipient email
     * @param string $subject Email subject
     * @param string $content Email body
     * @param string $fromEmail Sender email
     * @param string $fromName Sender name
     * @return boolean true/false
     */
    public function send($toEmail, $subject, $content, $fromEmail = null, $fromName = null)
    {
        $view = new View();
        Yii::$app->language = $this->language;

        if (null == $fromEmail) {
            $fromEmail = $this->fromEmail;
        }

        if (null == $fromName) {
            $fromName = $this->fromName;
        }

        $restClient = new RestClient($this->apiUsername, $this->apiPassword, $this->apiEndPoint);
        $restClient->sendRequest('messages', [
            'from' => "$fromName <$fromEmail>",
            'to' => $toEmail,
            'subject' => $subject,
            'html' => $view->render($this->emailTemplatePath, ['content' => $content], true)
        ], 'POST');

        $res = $restClient->response;

        Yii::$app->appLog->writeLog('Email API response.', ['response' => $res]);

        if (!empty($res)) {
            $res = json_decode($res);
            if (strstr(@$res->message, 'Queued')) {
                Yii::$app->appLog->writeLog('Email sent.', ['from' => $fromEmail, 'to' => $toEmail]);
                return true;
            }
        }

        Yii::$app->appLog->writeLog('Email sending failed.', ['from' => $fromEmail, 'to' => $toEmail]);

        return false;
    }

    /**
     * Retrieve email content
     * @param string $templateName Email template name
     * @return boolean true/false
     */
    private function getEmailContent($templateName, $params)
    {
        $language = '' == $this->language ? $this->defLang : $this->language;
        $content = $this->view->render($this->emailContPath . $language . "/{$templateName}", [], true);
        $keys = array_keys($params);
        $values = array_values($params);

        return str_replace($keys, $values, $content);
    }

    /**
     * Send email
     * @param string $toEmail Recipient email
     * @param string $subject Email subject
     * @param string $content Email body
     * @param string $fromEmail Sender email
     * @param string $fromName Sender name
     * @return boolean true/false
     */
    /*public function send($toEmail, $subject, $content, $fromEmail = null, $fromName = null)
    {
        Yii::$app->language = $this->language;

        if (null == $fromEmail) {
            $fromEmail = $this->fromEmail;
        }

        if (null == $fromName) {
            $fromName = $this->fromName;
        }

        $error = '';
        $response = false;
        try {
            $response = Yii::$app->mailer
                    ->compose($this->emailTemplatePath, ['content' => $content])
                    ->setFrom([$fromEmail => $fromName])
                    ->setTo($toEmail)
                    ->setSubject($subject)
                    ->send();
        } catch (\Exception $e) {
            $error = $e->getMessage();
        }

        if ($response) {
            Yii::$app->appLog->writeLog('Email sent.', ['from' => $fromEmail, 'to' => $toEmail]);
            return true;
        }

        Yii::$app->appLog->writeLog('Email sending failed.', ['from' => $fromEmail, 'to' => $toEmail, 'error' => $error]);
        return false;
    }*/
}