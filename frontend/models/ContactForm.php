<?php
namespace frontend\models;

use yii\base\Model;
use Yii;
use himiklab\yii2\recaptcha\ReCaptchaValidator3;

class ContactForm extends Model
{
    public $name;
    public $email;
    public $phone;
    public $subject;
    public $body;
    public $reCaptcha;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            // name, email, subject and body are required
            [['name', 'email', 'phone', 'subject', 'body'], 'required'],
            // email has to be a valid email address
            [['email'], 'email'],
            [['reCaptcha'], ReCaptchaValidator3::class, 'secret' => Yii::$app->reCaptcha->secretV3, 'threshold' => 0.5, 'action' => 'ContactForm'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'name' => Yii::t('frontend', 'Name'),
            'email' => Yii::t('frontend', 'Email'),
            'phone' => Yii::t('frontend', 'Phone'),
            'subject' => Yii::t('frontend', 'Subject'),
            'body' => Yii::t('frontend', 'Message'),
            'reCaptcha' => Yii::t('frontend', 'Verification Code'),
        ];
    }

    /**
     * @param $email
     * @return bool
     */
    public function contact($email) {
        if ($this->validate()) {
            Yii::$app->mailer->compose()
                ->setTo($email)
                ->setFrom([Yii::$app->params['senderEmail'] => Yii::$app->params['senderName']])
                ->setReplyTo([$this->email => $this->name])
                ->setSubject($this->subject)
                ->setTextBody($this->name . "\r\n" . $this->body . "\r\n" . $this->phone)
                ->setHtmlBody('<h4>' . $this->name . '</h4><br>' . $this->body . '<br><br><a href="tel:' . $this->phone . '">' . $this->phone . '</a>')
                ->send();
            return true;
        }
        return false;
    }

}