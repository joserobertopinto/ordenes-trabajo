<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\OrdenesTrabajo;
use app\models\Estado;
use app\models\User;
use app\common\utils\Permiso;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout','logout', 'index'],
                'rules' => [
                    [
                        'actions' => ['logout','index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['login'],
                        'roles' => ['?']
                    ]
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $queryAsignadas = OrdenesTrabajo::find()
            ->joinWith(['ultimoEstadoOrdenTrabajo'])
            ->where(['=', 'historial_estado_orden_trabajo.id_estado', Estado::ESTADO_PENDIENTE])
            ->orderBy('fecha_hora_comienzo DESC')
            ->limit(10);
        
        if(Permiso::esUsuarioOperador())
            $queryAsignadas
                ->joinWith(['usuarioOrdenTrabajo'])
                ->andWhere(['=', 'usuario_orden_trabajo.id_usuario', User::getCurrentUserId()]);

        $dataProviderAsignadas = new ActiveDataProvider([
            'query' => $queryAsignadas
        ]);

        /************************************************************************************* */


        $queryFinalizadas = OrdenesTrabajo::find()
        ->joinWith(['ultimoEstadoOrdenTrabajo'])
        ->where(['OR', "historial_estado_orden_trabajo.id_estado = '" . Estado::ESTADO_FINALIZADO . "'"," historial_estado_orden_trabajo.id_estado = '" . Estado::ESTADO_FINALIZADO_PARCIAL . "'"])
        ->orderBy('fecha_hora_comienzo DESC')
        ->limit(10);
        
        if(Permiso::esUsuarioOperador())
            $queryFinalizadas
                ->joinWith(['usuarioOrdenTrabajo'])
                ->andWhere(['=', 'usuario_orden_trabajo.id_usuario', User::getCurrentUserId()]);

        $dataProviderFinalizadas = new ActiveDataProvider([
            'query' => $queryFinalizadas,
        ]);

        /************************************************************************************ */
        // tareas asignadas con fecha de comienzo menor al actual
        $asignadas = OrdenesTrabajo::find()->count();
        
        // tareas asignadas con fecha de comienzo menor al actual
        $asignadasSinComenzar = OrdenesTrabajo::find()->count();

        return $this->render('index',[
            'asignadasSinComenzar'      => $asignadasSinComenzar, 
            'asignadas'                 => $asignadas,
            'dataProviderAsignadas'     => $dataProviderAsignadas,
            'dataProviderFinalizadas'   => $dataProviderFinalizadas,
        ]);
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->redirect(['login']);
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
}
