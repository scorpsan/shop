<?php
namespace shop\jobs;

use yii\base\BaseObject;
use yii\queue\RetryableJobInterface;
use yii\base\Exception;
use Yii;

/**
 * @property-read mixed $ttr
 */
class MailSendJob extends BaseObject implements RetryableJobInterface
{
    public $retry = true;

    public $view = '';
    public $lng;
    public $fromEmail;
    public $toEmail;
    public $subject;
    public $message = null;
    public $params = [];

    public function execute($queue)
    {
        try {
            Yii::$app->language = $this->lng;

            $emailSend = Yii::$app->mailer;

            $emailSend->setViewPath('@common/mail');

            if (!$emailSend->compose(['html' => $this->view, 'text' => "text/{$this->view}"], ['content' => $this->message, 'params' => $this->params])
                ->setFrom($this->fromEmail)
                ->setTo($this->toEmail)
                ->setSubject($this->subject)->send()) {
                throw new Exception('Failed: Mail send failed');
            }

        } catch (Exception $exception) {
            throw new Exception($exception->getMessage());
        }

        return true;
    }

    public function getTtr()
    {
        return Yii::$app->queueMail->ttr;
    }

    public function canRetry($attempt, $error)
    {
        return $this->retry && ($error instanceof Exception);
    }

}