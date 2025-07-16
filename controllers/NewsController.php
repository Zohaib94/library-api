<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;

class NewsController extends Controller
{
  public function actionIndex()
  {
    return $this->render('index');
  }

  public function actionItemsList()
  {
    $year = Yii::$app->request->get('year');
    $category = Yii::$app->request->get('category');
    $newsList = $this->data();
    $filteredData = [];

    if ($year == null && $category == null) {
      $filteredData = $newsList;
    } else {
      foreach ($newsList as $news) {
        if ($year != null && date('Y', strtotime($news['date'])) == $year) {
          $filteredData[] = $news;
        } else if ($category != null && $news['category'] == $category) {
          $filteredData[] = $news;
        }
      }
    }

    return $this->render('itemsList', ['year' => $year, 'category' => $category, 'filteredData' => $filteredData]);
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

  public function actionItemDetailNew($title)
  {
    $newsData = $this->data();

    // Find the news item by title
    foreach ($newsData as $item) {
      if ($item['title'] === $title) {
        return $this->render('itemDetailNew', ['item' => $item]);
      }
    }

    // If not found, throw 404
    throw new \yii\web\NotFoundHttpException('News item not found');
  }

  public function actionResponsiveContentTest()
  {
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
      [
        'id' => 3,
        'title' => 'First man on the moon',
        'date' => '1969-07-
 20'
      ]
    ];
  }

  public function data()
  {
    return [
      [
        "id" => 1,
        "date" => "2015-04-19",
        "category" => "business",
        "title" => "Test news of 2015-04-19"
      ],
      [
        "id" => 2,
        "date" => "2015-05-20",
        "category" => "shopping",
        "title" => "Test news of 2015-05-20"
      ],
      [
        "id" => 3,
        "date" => "2015-06-21",
        "category" => "business",
        "title" => "Test news of 2015-06-21"
      ],
      [
        "id" => 4,
        "date" => "2016-04-19",
        "category" => "shopping",
        "title" => "Test news of 2016-04-19"
      ],
      [
        "id" => 5,
        "date" => "2017-05-19",
        "category" => "business",
        "title" => "Test news of 2017-05-19"
      ],
      [
        "id" => 6,
        "date" => "2018-06-19",
        "category" => "shopping",
        "title" => "Test news of 2018-06-19"
      ]
    ];
  }
}
