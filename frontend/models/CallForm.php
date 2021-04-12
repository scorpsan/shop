<?php
namespace frontend\models;

use yii\base\Model;
use Yii;
use himiklab\yii2\recaptcha\ReCaptchaValidator3;

class CallForm extends Model
{
    public $name;
    public $email = '';
    public $phone;
    public $reCaptcha;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['name', 'phone'], 'required'],
            [['email'], 'email'],
            [['reCaptcha'], ReCaptchaValidator3::class, 'secret' => Yii::$app->reCaptcha->secretV3, 'threshold' => 0.5, 'action' => 'CallForm'],
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
            'reCaptcha' => Yii::t('frontend', 'Verification Code'),
        ];
    }

    /**
     * @param $email
     * @return bool
     */
    public function contact($email) {
        if ($this->validate()) {
            $mail = Yii::$app->mailer->compose()
                ->setTo($email)
                ->setSubject(Yii::t('frontend', 'Request a call'))
                ->setTextBody($this->name . "\r\n" . $this->phone)
                ->setHtmlBody('<h4>' . $this->name . '</h4><br><a href="tel:' . $this->phone . '">' . $this->phone . '</a>');
            if (isset($this->email) && !empty($this->email)) {
                $mail->setFrom([Yii::$app->params['senderEmail'] => Yii::$app->params['senderName']])
                    ->setReplyTo([$this->email => $this->name]);
            } else {
                $mail->setFrom([Yii::$app->params['senderEmail'] => Yii::$app->params['senderName']]);
            }
            $mail->send();
            return true;
        }
        return false;
    }

}