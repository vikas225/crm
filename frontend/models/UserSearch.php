<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\User;

/**
 * UserSearch represents the model behind the search form about `frontend\models\User`.
 */
class UserSearch extends User
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'roles_id', 'country_code', 'active'], 'integer'],
            [['device_id', 'name', 'email', 'password', 'address', 'city', 'mobile_no', 'imei_no', 'sim_no', 'device_type', 'otp_expiry', 'email_key', 'accessToken', 'auth_key', 'sos_smart_password', 'last_battery_status', 'registration_datetime', 'modified_dateime', 'is_email_verified', 'is_mobile_verified', 'gcm_id', 'email_link_date', 'otp_code', 'image'], 'safe'],
            [['lat_lat', 'last_long'], 'number'],
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
        $query = User::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'roles_id' => $this->roles_id,
            'country_code' => $this->country_code,
            'otp_expiry' => $this->otp_expiry,
            'active' => $this->active,
            'lat_lat' => $this->lat_lat,
            'last_long' => $this->last_long,
            'registration_datetime' => $this->registration_datetime,
            'modified_dateime' => $this->modified_dateime,
            'email_link_date' => $this->email_link_date,
        ]);

        $query->andFilterWhere(['like', 'device_id', $this->device_id])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'password', $this->password])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'city', $this->city])
            ->andFilterWhere(['like', 'mobile_no', $this->mobile_no])
            ->andFilterWhere(['like', 'imei_no', $this->imei_no])
            ->andFilterWhere(['like', 'sim_no', $this->sim_no])
            ->andFilterWhere(['like', 'device_type', $this->device_type])
            ->andFilterWhere(['like', 'email_key', $this->email_key])
            ->andFilterWhere(['like', 'accessToken', $this->accessToken])
            ->andFilterWhere(['like', 'auth_key', $this->auth_key])
            ->andFilterWhere(['like', 'sos_smart_password', $this->sos_smart_password])
            ->andFilterWhere(['like', 'last_battery_status', $this->last_battery_status])
            ->andFilterWhere(['like', 'is_email_verified', $this->is_email_verified])
            ->andFilterWhere(['like', 'is_mobile_verified', $this->is_mobile_verified])
            ->andFilterWhere(['like', 'gcm_id', $this->gcm_id])
            ->andFilterWhere(['like', 'otp_code', $this->otp_code])
            ->andFilterWhere(['like', 'image', $this->image]);

        return $dataProvider;
    }
}
