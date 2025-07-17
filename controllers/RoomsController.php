<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Room;
use yii\web\UploadedFile;

class RoomsController extends Controller
{
    public function actionCreate()
    {
        $model = new Room();
        $modelCanSave = false;

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->fileImage = UploadedFile::getInstance($model, 'fileImage');

            if ($model->fileImage) {
                $model->fileImage->saveAs(Yii::getAlias(('@app/web/uploadedfiles/' . $model->fileImage->baseName . '.' . $model->fileImage->extension)));
            }

            $modelCanSave = true;
        }

        return $this->render('create', [
            'model' => $model,
            'modelCanSave' => $modelCanSave
        ]);
    }

    public function actionIndex()
    {
        $sql = 'SELECT * FROM room ORDER BY id ASC';
        $db = Yii::$app->db;
        $rooms = $db->createCommand($sql)->queryAll();

        return $this->render('index', ['rooms' => $rooms]);
    }

    public function actionIndexFiltered()
    {
        $query = Room::find();

        $searchFilter = [
            'floor' => ['operator' => '', 'value' => ''],
            'room_number' => ['operator' => '', 'value' => ''],
            'price_per_day' => ['operator' => '', 'value' => '']
        ];

        if (isset($_POST['SearchFilter'])) {
            $fieldsList = ['floor', 'room_number', 'price_per_day'];

            foreach ($fieldsList as $field) {
                $fieldOperator = $_POST['SearchFilter'][$field]['operator'];
                $fieldValue = $_POST['SearchFilter'][$field]['value'];

                $searchFilter[$field] = [
                    'operator' => $fieldOperator,
                    'value' => $fieldValue
                ];

                if ($fieldValue != '') {
                    if ($field == 'floor' || $field == 'room_number') {
                        $fieldValue = (int)$fieldValue;
                    } elseif ($field == 'price_per_day') {
                        $fieldValue = (float)$fieldValue;
                    }

                    $query->andWhere([$fieldOperator, $field, $fieldValue]);
                }
            }
        }

        $rooms = $query->all();

        return $this->render('indexFiltered', ['rooms' => $rooms, 'searchFilter' => $searchFilter]);
    }

    public function actionLastReservationByRoomId($room_id)
    {
        $room = Room::findOne($room_id);
        $lastReservation = $room->lastReservation;

        return $this->render('lastReservationByRoomId', ['room' => $room, 'lastReservation' => $lastReservation]);
    }

    public function actionLastReservationForEveryRoom()
    {
        // Eager load last reservation from 'getLastReservation'
        $rooms = Room::find()->with('lastReservation')->all();

        return $this->render('lastReservationForEveryRoom', ['rooms' => $rooms]);
    }
}
