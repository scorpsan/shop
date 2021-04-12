<?php
namespace frontend\forms;

use yii\base\Model;

class DeleteForm extends Model
{
    public $confirm;
	public $text;
	public $item_id;

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
			[['item_id', 'confirm'], 'required'],
			[['item_id'], 'integer'],
            [['confirm'], 'boolean'],
			[['confirm'], 'default', 'value' => false],
			[['text'], 'safe'],
        ];
    }

}