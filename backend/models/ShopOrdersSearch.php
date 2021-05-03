<?php
namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * Class ShopOrdersSearch
 * @see ShopOrders
 */
class ShopOrdersSearch extends ShopOrders
{
    public $delivery_status;
    public $payment_status;

    public function rules(): array
    {
        return [
            [['delivery_method_id', 'payment_method_id'], 'integer'],
            [['order_number', 'customer_name'], 'string'],
            [['delivery_status', 'payment_status'], 'safe'],
        ];
    }

    public function scenarios(): array
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params): ActiveDataProvider
    {
        $query = ShopOrders::find()
            ->joinWith('items')
            ->with('deliveryStatus')
            ->with('paymentStatus')
        ;

        // add conditions that should always apply here
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'attributes' => [
                    'id',
                    'order_number',
                    'amount',
                    'created_at',
                ],
                'defaultOrder' => [
                    'order_number' => SORT_DESC,
                ],
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            ShopOrders::tableName().'.id' => $this->id,
            'delivery_method_id' => $this->delivery_method_id,
            'payment_method_id' => $this->payment_method_id,
        ]);
        $query->andFilterWhere(['like', 'order_number', $this->order_number])
            ->andFilterWhere(['like', 'customer_name', $this->customer_name]);
        $query->andFilterWhere([ShopOrdersStatuses::tableName().'.id' => $this->delivery_status])
            ->andFilterWhere([ShopOrdersStatuses::tableName().'.id' => $this->payment_status]);

        return $dataProvider;
    }

}