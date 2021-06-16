<?php
namespace frontend\forms;

use yii\base\Model;
use Yii;

class CheckoutForm extends Model
{
    public $email;
    public $phone;
    public $name;
    public $country;
    public $region;
    public $district;
    public $city;
    public $address;
    public $address2;
    public $postal;
    public $shipping_method;
    public $payment_method;
    public $note;
    public $user_address = null;
    public $remember_me = null;

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            // email rules
            'emailRequired' => ['email', 'required'],
            'emailPattern' => ['email', 'email'],
            'emailLength' => ['email', 'string', 'max' => 255],
            'emailTrim' => ['email', 'trim'],
            // phone rules
            'phoneTrim' => ['phone', 'filter', 'filter' => 'trim'],
            'phoneRequired' => ['phone', 'required'],
            //'phonePattern' => ['phone', 'match', 'pattern' => '/^[+][0-9]{7,20}$/', 'message' => Yii::t('frontend', 'Wrong format, enter phone number in international format.')],
            // name rules
            'nameRequired' => [['name'], 'required'],
            'nameLength' => [['name'], 'string', 'max' => 255],
            'nameTrim' => [['name'], 'filter', 'filter' => 'trim'],
            // address rules
            [['country', 'city', 'address'], 'required'],
            [['country', 'region', 'district', 'city', 'address', 'address2'], 'string', 'max' => 255],
            [['postal'], 'string', 'max' => 10],
            [['shipping_method', 'payment_method'], 'integer'],
            [['note'], 'string'],
            [['shipping_method'], 'required', 'on' => 'shipping', 'message' => Yii::t('frontend', 'Select order delivery method')],
            [['payment_method'], 'required', 'on' => 'payment', 'message' => Yii::t('frontend', 'Select a Payment Method')],
            [['shipping_method', 'payment_method'], 'required', 'on' => 'order'],
            [['user_address', 'remember_me'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'email' => Yii::t('frontend', 'Email'),
            'phone' => Yii::t('frontend', 'Phone'),
            'name' => Yii::t('frontend', 'Full Name'),
            'country' => Yii::t('frontend', 'Country'),
            'region' => Yii::t('frontend', 'Region'),
            'district' => Yii::t('frontend', 'District'),
            'city' => Yii::t('frontend', 'City'),
            'address' => Yii::t('frontend', 'Address'),
            'address2' => Yii::t('frontend', 'Apartment, suite, etc. (optional)'),
            'postal' => Yii::t('frontend', 'Postal'),
            'shipping_method' => Yii::t('frontend', 'Shipping method'),
            'payment_method' => Yii::t('frontend', 'Payment'),
            'note' => Yii::t('frontend', 'Comment'),
            'user_address' => Yii::t('frontend', 'Address'),
            'remember_me' => Yii::t('frontend', 'Save this address for next time'),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
        $this->phone = Yii::$app->params['userPhoneCode'];
    }

    /**
     * {@inheritdoc}
     */
    public function beforeValidate(): bool
    {
        if (parent::beforeValidate()) {
            $this->phone = '+' . preg_replace('/\D+/', '', $this->phone);
            return true;
        }
        return false;
    }

}