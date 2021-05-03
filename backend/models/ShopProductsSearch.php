<?php
namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * Class ShopProductsSearch
 * @see ShopProducts
 */
class ShopProductsSearch extends ShopProducts
{
    public $title;

    public function rules(): array
    {
        return [
            [['id'], 'integer'],
            [['published', 'top', 'new', 'in_stock'], 'boolean'],
            [['code', 'title'], 'safe'],
        ];
    }

    public function scenarios(): array
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params): ActiveDataProvider
    {
        $query = ShopProducts::find()
            ->joinWith('translate')
            ->with('wishes')
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
                    'in_stock',
                ],
                'defaultOrder' => [
                    'sort' => SORT_ASC,
                ],
            ],
        ]);
        $dataProvider->sort->attributes['title'] = [
            'asc' => [ShopProductsLng::tableName() . '.title' => SORT_ASC],
            'desc' => [ShopProductsLng::tableName() . '.title' => SORT_DESC],
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
            'in_stock' => $this->in_stock,
        ]);
        $query->andFilterWhere(['like', ShopProductsLng::tableName().'.title', $this->title])
            ->andFilterWhere(['like', 'code', $this->code]);

        return $dataProvider;
    }

}