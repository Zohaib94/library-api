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

  public function initializeAuthorizations()
  {
    $auth = Yii::$app->authManager;

    $permissions = [
      'createReservation' => 'Create a reservation',
      'createRoom' => 'Create a room',
      'createCustomer' => 'Create a Customer',
      'updateReservation' => 'Update a reservation',
      'updateRoom' => 'Update a room',
      'updateCustomer' => 'Update a Customer',
      'deleteReservation' => 'Delete a reservation',
      'deleteRoom' => 'Delete a room',
      'deleteCustomer' => 'Delete a Customer',
    ];

    $roles = [
      'operator' => ['createReservation', 'createRoom', 'createCustomer'],
    ];

    // Create permissions
    foreach ($permissions as $permName => $permDesc) {
      $p = $auth->createPermission($permName);
      $p->description = $permDesc;
      $auth->add($p);

      $role = $auth->createRole('role_' . $permName);
      $role->description = $permDesc;
      $auth->add($role);

      if (!$auth->hasChild($role, $p)) {
        $auth->addChild($role, $p);
      }
    }

    // operator role will get permission to create reservation, create room, create customer
    foreach ($roles as $roleKey => $permissions) {
      $role = $auth->createRole($roleKey);
      $role->description = $roleKey;
      $auth->add($role);

      foreach ($permissions as $permissionName) {
        $permission = $auth->getPermission($permissionName);
        if (!$auth->hasChild($role, $permission)) {
          $auth->addChild($role, $permission);
        }
      }
    }

    $role = $auth->getRole('admin');

    if (!$role) {
      $role = $auth->createRole('admin');
      $role->description = 'admin';
      $auth->add($role);
    }

    foreach ($permissions as $permName => $permDesc) {
      $permission = $auth->getPermission($permName);

      if (!$auth->hasChild($role, $permission)) {
        $auth->addChild($role, $permission);
      }
    }
  }

  public function actionIndex()
  {
    $auth = Yii::$app->authManager;

    // $this->initializeAuthorizations();

    $users = User::find()->all();

    $rolesAvailable = $auth->getRoles();
    $rolesNamesByUser = [];

    foreach ($users as $user) {
      $rolesNames = [];

      $roles = $auth->getRolesByUser($user->id);

      foreach ($roles as $r) {
        $rolesNames[] = $r->name;
      }

      $rolesNamesByUser[$user->id] = $rolesNames;
    }

    return $this->render('index', [
      'users' => $users,
      'rolesAvailable' => $rolesAvailable,
      'rolesNamesByUser' =>
      $rolesNamesByUser
    ]);
  }

  public function actionAddRole($userId, $roleName)
  {
    $auth = Yii::$app->authManager;
    $auth->assign($auth->getRole($roleName), $userId);

    return $this->redirect(['index']);
  }

  public function actionRemoveRole($userId, $roleName)
  {
    $auth = Yii::$app->authManager;
    $auth->revoke($auth->getRole($roleName), $userId);

    return $this->redirect(['index']);
  }
}
