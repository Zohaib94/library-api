<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;

class NewsController extends Controller
{
  public function actionIndex()
  {
    echo "this is my first controller";
  }

  public function actionItemsList() {
    return $this->render('itemsList');
  }
}
