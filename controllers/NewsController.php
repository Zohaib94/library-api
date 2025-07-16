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

  public function actionItemsList()
  {
    $newsList = $this->dataItems();
    return $this->render('itemsList', ['newsList' => $newsList]);
  }

  public function actionItemDetail($id)
  {
    $newsList = $this->dataItems();

    $item = null;

    foreach ($newsList as $newsListItem) {
      if ($id == $newsListItem['id']) {
        $item = $newsListItem;
      }
    }

    return $this->render('itemDetail', ['item' => $item]);
  }

  public function actionResponsiveContentTest() {
    $responsive = Yii::$app->request->get('responsive', 0);

    if ($responsive) {
      $this->layout = 'responsive';
    } else {
      $this->layout = 'main';
    }

    return $this->render('responsiveContentTest', ['responsive' => $responsive]);
  }

  public function actionAdvTest()
  {
    return $this->render('advTest');
  }

  public function dataItems()
  {
    return [
      ['id' => 1, 'title' => 'First World War', 'date' => '1914-07-28'],
      ['id' => 2, 'title' => 'Second World War', 'date' => '1939-09-01'],
      ['id' => 3, 'title' => 'First man on the moon', 'date' => '1969-07-
 20']
    ];
  }
}
