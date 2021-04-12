<?php
namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * Class ShopProductsSearch
 * @see ShopProducts
 */
class ShopProductsSearch extends ShopProducts
{
    public $title;

    public function rules() {
        return [
            [['id'], 'integer'],
            [['published', 'top', 'new'], 'boolean'],
            [['code', 'title'], 'safe'],
        ];
    }

    public function scenarios() {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params) {
        $query = ShopProducts::find()
            ->joinWith('translate')
            ->with('translates')
            ->with('images')
            ->with('category')
        ;
        // add conditions that should always apply here
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'attributes' => [
                    'id',
                    'code',
                    'sort',
                    'published',
                    'top',
                    'new',
                    'hit',
                    'rating',
                    'created_at',
                    'updated_at',
                ],
                'defaultOrder' => [
                    'sort' => SORT_ASC,
                ],
            ],
        ]);
        $dataProvider->sort->attributes['title'] = [
            'asc' => [ShopProductsLng::tableName().'.title' => SORT_ASC],
            'desc' => [ShopProductsLng::tableName().'.title' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            ShopProducts::tableName().'.id' => $this->id,
            'category_id' => $this->category_id,
            'published' => $this->published,
            'top' => $this->top,
            'new' => $this->new,
        ]);
        $query->andFilterWhere(['like', ShopProductsLng::tableName().'.title', $this->title])
            ->andFilterWhere(['like', 'code', $this->code]);

        return $dataProvider;
    }

}