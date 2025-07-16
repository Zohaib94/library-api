<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "room".
 *
 * @property int $id
 * @property int $floor
 * @property int $room_number
 * @property int $has_conditioner
 * @property int $has_tv
 * @property int $has_phone
 * @property string $available_from
 * @property float|null $price_per_day
 * @property string|null $description
 *
 * @property Reservation[] $reservations
 */
class Room extends \yii\db\ActiveRecord
{
  public $fileImage;
  /**
   * {@inheritdoc}
   */
  public static function tableName()
  {
    return 'room';
  }

  /**
   * {@inheritdoc}
   */
  public function rules()
  {
    return [
      [['price_per_day', 'description'], 'default', 'value' => null],
      [['floor', 'room_number', 'has_conditioner', 'has_tv', 'has_phone', 'available_from'], 'required'],
      [['floor', 'room_number', 'has_conditioner', 'has_tv', 'has_phone'], 'integer'],
      [['available_from'], 'safe'],
      [['price_per_day'], 'number'],
      [['description'], 'string'],
      ['fileImage', 'file']
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function attributeLabels()
  {
    return [
      'id' => Yii::t('app', 'ID'),
      'floor' => Yii::t('app', 'Floor'),
      'room_number' => Yii::t('app', 'Room Number'),
      'has_conditioner' => Yii::t('app', 'Has Conditioner'),
      'has_tv' => Yii::t('app', 'Has Tv'),
      'has_phone' => Yii::t('app', 'Has Phone'),
      'available_from' => Yii::t('app', 'Available From'),
      'price_per_day' => Yii::t('app', 'Price Per Day'),
      'description' => Yii::t('app', 'Description'),
    ];
  }

  /**
   * Gets query for [[Reservations]].
   *
   * @return \yii\db\ActiveQuery
   */
  public function getReservations()
  {
    return $this->hasMany(Reservation::class, ['room_id' => 'id']);
  }

  public function getLastReservation()
  {
    return $this->hasOne(Reservation::class, ['room_id' => 'id'])->orderBy('id');
  }
}
