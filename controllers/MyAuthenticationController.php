<?php

namespace app\controllers;

use app\models\LoginForm;
use Yii;
use yii\web\Controller;
use app\models\User;
use yii\filters\AccessControl;

class MyAuthenticationController extends Controller
{

  public function behaviors()
  {
    return [
      'access' => [
        'class' => AccessControl::class,
        'only' => ['login', 'logout'],
        'denyCallback' => function ($rule, $action) {
          return Yii::$app->response->redirect(['rooms']);
        },
        'rules' => [
          [
            'allow' => true,
            'actions' => ['login'],
            'roles' => ['?'], // guest
          ],
          [
            'allow' => true,
            'actions' => ['logout'],
            'roles' => ['@'], // authenticated
          ],
        ],
      ],
    ];
  }

  public function actionLogin()
  {
    $error = null;
    $username = Yii::$app->request->post('username', null);
    $password = Yii::$app->request->post('password', null);

    if ($username != null && $password != null) {
      $user = User::findOne(['username' => $username]);

      if ($user != null) {
        if ($user->validatePassword($password)) {
          Yii::$app->user->login($user);
        } else {
          $error = 'Password validation failed';
        }
      } else {
        $error = 'User not found';
      }
    }

    return $this->render('login', ['error' => $error]);
  }

  public function actionLoginWithModel()
  {
    $error = null;
    $model = new LoginForm();

    if ($model->load(Yii::$app->request->post())) {
      if ($model->validate() && $model->user != null) {
        Yii::$app->user->login($model->user);
      } else {
        $error = 'Username/Password error';
      }
    }

    return $this->render('login-with-model', ['model' => $model, 'error' => $error]);
  }

  public function actionLogout()
  {
    Yii::$app->user->logout();
    return $this->redirect(['login']);
  }
}
