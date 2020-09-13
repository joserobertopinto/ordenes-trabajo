<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\OrdenesTrabajo;
use app\models\OrdenesTrabajoSearch;
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
        /**
         * timeline
         */
        // var_dump(Yii::$app->request->bodyParams);exit;
        $searchModelHistorial = new OrdenesTrabajoSearch();
        $dataProviderHistorial = $searchModelHistorial->timeSearch(Yii::$app->request->bodyParams);

        /*************************************************** */

        $queryUsuario = '';

        if(Permiso::esUsuarioOperador())
            $queryUsuario = User::getCurrentUserId();

        /************************************************************************************* */
        $queryAsignadas =  OrdenesTrabajo::find()
            ->joinWith(['ultimoEstadoOrdenTrabajo', 'usuarioOrdenTrabajo'])
            ->andWhere(['=', 'historial_estado_orden_trabajo.id_estado', Estado::ESTADO_PENDIENTE])
            ->andFilterWhere(['=', 'usuario_orden_trabajo.id_usuario', $queryUsuario])
            ->orderBy('fecha_hora_comienzo DESC')
            ->limit(10);

        $dataProviderAsignadas = new ActiveDataProvider([
            'query' => $queryAsignadas
        ]);

        /************************************************************************************* */
        $queryFinalizadas =  OrdenesTrabajo::find()
            ->joinWith(['ultimoEstadoOrdenTrabajo', 'usuarioOrdenTrabajo'])
            ->andWhere(['=', 'historial_estado_orden_trabajo.id_estado', Estado::ESTADO_FINALIZADO])
            ->andFilterWhere(['=', 'usuario_orden_trabajo.id_usuario', $queryUsuario])
            ->orderBy('fecha_hora_comienzo DESC')
            ->limit(10);
                
        $dataProviderFinalizadas = new ActiveDataProvider([
            'query' =>  $queryFinalizadas
        ]);

        /************************************************************************************ */
        // tareas asignadas con fecha de comienzo menor al actual
        $totalFinalizadas=  OrdenesTrabajo::find()
            ->joinWith(['ultimoEstadoOrdenTrabajo', 'usuarioOrdenTrabajo'])
            ->andWhere(['=', 'historial_estado_orden_trabajo.id_estado', Estado::ESTADO_PENDIENTE])
            ->andFilterWhere(['=', 'usuario_orden_trabajo.id_usuario', $queryUsuario])
            ->count();

        /************************************************************************************ */
        // tareas asignadas con fecha de comienzo menor al actual
        $totalVencidas=  OrdenesTrabajo::find()
        ->joinWith(['ultimoEstadoOrdenTrabajo', 'usuarioOrdenTrabajo'])
        ->andWhere(['=', 'historial_estado_orden_trabajo.id_estado', Estado::ESTADO_PENDIENTE])
        ->andFilterWhere(['=', 'usuario_orden_trabajo.id_usuario', $queryUsuario])
        ->count();

        /************************************************************************************ */
        // tareas asignadas con fecha de comienzo menor al actual

        $totalFinalizadasParcial =  OrdenesTrabajo::find()
            ->joinWith(['ultimoEstadoOrdenTrabajo', 'usuarioOrdenTrabajo'])
            ->andWhere(['=', 'historial_estado_orden_trabajo.id_estado', Estado::ESTADO_PENDIENTE])
            ->andFilterWhere(['=', 'usuario_orden_trabajo.id_usuario', $queryUsuario])
            ->count();

        /************************************************************************************ */

        return $this->render('index',[
            'totalFinalizadas'          => $totalFinalizadas, 
            'totalVencidas'             => $totalVencidas,
            'totalFinalizadasParcial'   => $totalFinalizadasParcial,
            'dataProviderAsignadas'     => $dataProviderAsignadas,
            'dataProviderFinalizadas'   => $dataProviderFinalizadas,
            'searchModelHistorial'      => $searchModelHistorial,
            'dataProviderHistorial'     => $dataProviderHistorial
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
