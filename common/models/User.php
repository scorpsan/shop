<?php
namespace common\models;

use Da\User\Model\User as BaseUser;
use yii\db\ActiveQuery;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * @property-read ActiveQuery $addresses
 * @property string $phone [varchar(21)]
 * @property string $Host [char(60)]
 * @property string $User [char(80)]
 * @property string $Password
 * @property string $Select_priv [varchar(1)]
 * @property string $Insert_priv [varchar(1)]
 * @property string $Update_priv [varchar(1)]
 * @property string $Delete_priv [varchar(1)]
 * @property string $Create_priv [varchar(1)]
 * @property string $Drop_priv [varchar(1)]
 * @property string $Reload_priv [varchar(1)]
 * @property string $Shutdown_priv [varchar(1)]
 * @property string $Process_priv [varchar(1)]
 * @property string $File_priv [varchar(1)]
 * @property string $Grant_priv [varchar(1)]
 * @property string $References_priv [varchar(1)]
 * @property string $Index_priv [varchar(1)]
 * @property string $Alter_priv [varchar(1)]
 * @property string $Show_db_priv [varchar(1)]
 * @property string $Super_priv [varchar(1)]
 * @property string $Create_tmp_table_priv [varchar(1)]
 * @property string $Lock_tables_priv [varchar(1)]
 * @property string $Execute_priv [varchar(1)]
 * @property string $Repl_slave_priv [varchar(1)]
 * @property string $Repl_client_priv [varchar(1)]
 * @property string $Create_view_priv [varchar(1)]
 * @property string $Show_view_priv [varchar(1)]
 * @property string $Create_routine_priv [varchar(1)]
 * @property string $Alter_routine_priv [varchar(1)]
 * @property string $Create_user_priv [varchar(1)]
 * @property string $Event_priv [varchar(1)]
 * @property string $Trigger_priv [varchar(1)]
 * @property string $Create_tablespace_priv [varchar(1)]
 * @property string $Delete_history_priv [varchar(1)]
 * @property string $ssl_type [varchar(9)]
 * @property string $ssl_cipher
 * @property string $x509_issuer
 * @property string $x509_subject
 * @property int $max_questions [bigint(20) unsigned]
 * @property int $max_updates [bigint(20) unsigned]
 * @property int $max_connections [bigint(20) unsigned]
 * @property int $max_user_connections [bigint(21)]
 * @property string $plugin
 * @property string $authentication_string
 * @property string $password_expired [varchar(1)]
 * @property string $is_role [varchar(1)]
 * @property string $default_role
 * @property string $max_statement_time [decimal(12,6)]
 */
class User extends BaseUser
{
    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return array_merge(
            parent::attributeLabels(),
            [
                'phone' => Yii::t('frontend', 'Phone'),
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios(): array
    {
        return ArrayHelper::merge(
            parent::scenarios(),
            [
                'register' => ['username', 'phone', 'email', 'password'],
                'connect' => ['username', 'email'],
                'create' => ['username', 'phone', 'email', 'password'],
                'update' => ['username', 'phone', 'email', 'password'],
                'settings' => ['username', 'phone', 'email', 'password'],
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return array_merge(
            parent::rules(),
            [
                // phone rules
                'phoneTrim' => ['phone', 'filter', 'filter' => 'trim'],
                'phoneRequired' => ['phone', 'required'],
                'phonePattern' => ['phone', 'match', 'pattern' => '/^\+[0-9]{7,20}$/', 'message' => Yii::t('frontend', 'Wrong format, enter phone number in international format.')],
                'phoneUnique' => [
                    'phone',
                    'unique',
                    'message' => Yii::t('frontend', 'This Phone has already been taken.'),
                ],
            ]
        );
    }

    /**
     * Gets query for [[ProfileAddress]].
     *
     * @return ActiveQuery
     */
    public function getAddresses(): ActiveQuery
    {
        return $this->hasMany(ProfileAddress::class, ['user_id' => 'id']);
    }

}