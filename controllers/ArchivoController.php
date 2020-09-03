<?php

namespace app\controllers;

use Yii;
use app\models\Archivo;
use app\models\ArchivoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\helpers\VarDumper;
use app\common\utils\ModelUtil;

/**
 * ArchivoController implements the CRUD actions for Archivo model.
 */
class ArchivoController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            // 'access' => [
        	// 	'class' => AccessControl::className(),
        	// 			'rules' => [
        	// 					[
       		// 						'actions' => ['index','view'],
       		// 						'allow' => true,
       		// 						//'roles' => ['P_XXXXXX'],
        	// 					],
        	// 					[
        	// 						'actions' => ['create','update', 'descargar', 'descargar-imagen'],
        	// 						'allow' => true,
        	// 						//'roles' => ['P_YYYYYYYYYYY'],
        	// 					],
        	// 					[
        	// 						'actions' => ['delete'],
        	// 						'allow' => true,
        	// 						//'roles' => ['P_YYYYYYYYYYY'],
        	// 					],
        						
        	// 			],
        	// 	],   
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Archivo models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ArchivoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Archivo model.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Archivo model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {

        $ok = true;
        $model = new Archivo();
        
        if ($model->load(Yii::$app->request->post())) {
            $this->_guardarArchivoForm($model);
        }
        
        $response['ok'] = $ok;
        $response['html']= $this->renderAjax('_form', [
            'model' => $model,
        ]);
        
        return  json_encode($response);
    }

    /**
     * Updates an existing Archivo model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_archivo]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Archivo model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Archivo model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Archivo the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Archivo::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

        /**
     * Maneja el submit del form upload de archivo, 
     * Guarda el Archivo
     * @param Solicitud $model
     * @param Archivo $modelArchivo
     */
    private function _guardarArchivoForm($model){
        $ok = true;
        $mensaje = '';
        $fechaHora = Date('d-m-Y H:i:s');
        
        //-----Transaccion de guardado-------
        $transaction =  Yii::$app->db->beginTransaction();
        try {
            
            $model->extensiones_permitidas = \Yii::$app->params['extensiones_documentos_orden'];
            if ($ok && !$model->validarUpload()){
                $ok = false;
                $mensaje = 'Archivo: '.ModelUtil::aplanarErrores($model).'<BR>';
            }
            
            if ($ok && !$model->hasErrors()) {
                
                $model->setPathArchivo($model->id_ordenes_trabajo);

                $model->generarAsignarNombre();
                
                if (!$model->save()){
                    $ok = false;
                    $model->addError('archivo', $model->getErrorSummary(true)[0]);
                }
            }
            
            if ($ok)
                $model->upload();
                
        } catch (Exception $e) {
            $ok = false;
            $mensaje = 'Se ha producido un error: <BR>'.$e->getMessage();
        }
        
        if ($ok){
            $transaction->commit();
            Yii::$app->session->addFlash('success', 'Se agregó el archivo con éxito.');
        }else{
            $transaction->rollBack();
            if (!empty($mensaje))
                Yii::$app->session->addFlash('danger', $mensaje);
        }

        return $ok;
    }

    /**
     * Descarga el archivo
     * @param string $id
     * @throws \yii\web\HttpException
     */
    public function actionDescargar($id) {
        
        $this->findModel($id)->descargarInstanciado();
        
    }
}
