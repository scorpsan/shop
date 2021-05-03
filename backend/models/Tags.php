<?php
namespace backend\models;

use common\models\Tags as BaseTags;
use Yii;

class Tags extends BaseTags
{
    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['frequency', 'name'], 'required'],
            [['frequency'], 'integer'],
            [['name'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => Yii::t('backend', 'ID'),
            'frequency' => Yii::t('backend', 'Frequency'),
            'name' => Yii::t('backend', 'Name'),
        ];
    }

}