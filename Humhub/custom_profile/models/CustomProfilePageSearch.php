<?php
/**
 * @link http://veteranmentornetwork.com
 * @copyright Copyright (c) 2016 Veteran Mentor Network
 * @license http://veteranmentornetwork.com/license
 */

namespace humhub\modules\custom_profile\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\customprofile\models\CustomProfilePage;

/**
 * CustomProfilePageSearch represents the model behind the search form about `app\modules\customprofile\models\CustomProfilePage`.
 */
class CustomProfilePageSearch extends CustomProfilePage
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['name','title_line1', 'title_line2', 'introductory_text', 'footer_text'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = CustomProfilePage::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'title_line1', $this->title_line1])
            ->andFilterWhere(['like', 'title_line2', $this->title_line2])
            ->andFilterWhere(['like', 'introductory_text', $this->introductory_text])
            ->andFilterWhere(['like', 'footer_text', $this->footer_text]);

        return $dataProvider;
    }
}
