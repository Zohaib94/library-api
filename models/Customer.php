<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "customer".
 *
 * @property int $id
 * @property string $name
 * @property string $surname
 * @property string|null $phone_number
 *
 * @property Reservation[] $reservations
 * @property Room[] $rooms
 * @property int $reservationsCount
 */
class Customer extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'customer';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['phone_number'], 'default', 'value' => null],
            [['name', 'surname'], 'required'],
            [['name', 'surname', 'phone_number'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'surname' => Yii::t('app', 'Surname'),
            'phone_number' => Yii::t('app', 'Phone Number'),
        ];
    }

    /**
     * Gets query for [[Reservations]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReservations()
    {
        return $this->hasMany(Reservation::class, ['customer_id' => 'id']);
    }

    public function getRooms()
    {
        return $this->hasMany(Room::class, ['id' =>
        'room_id'])->via('reservations');
    }

    public function getReservationsCount()
    {
        return $this->hasMany(Reservation::class, ['customer_id' => 'id'])->count();
    }

    public function getNameAndSurname()
    {
        return $this->name . ' ' . $this->surname;
    }
}
