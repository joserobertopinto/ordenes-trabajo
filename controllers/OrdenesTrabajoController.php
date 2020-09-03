<?php

namespace app\controllers;

use Yii;
use app\common\utils\ModelUtil;
use app\models\OrdenesTrabajo;
use app\models\OrdenesTrabajoSearch;
use app\models\Archivo;
use app\models\ArchivoSearch;
use app\models\Estado;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Ramsey\Uuid\Uuid;
use yii\data\ActiveDataProvider;

/**
 * OrdenesTrabajoController implements the CRUD actions for OrdenesTrabajo model.
 */
class OrdenesTrabajoController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all OrdenesTrabajo models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new OrdenesTrabajoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single OrdenesTrabajo model.
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
     * Creates a new OrdenesTrabajo model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $transaccion= yii::$app->db->beginTransaction();

        $model  = new OrdenesTrabajo();
        $model->scenario = OrdenesTrabajo::SCENARIO_CREATE;
        $model->id_ordenes_trabajo = Uuid::uuid4();

        if($model->save()){
            $error = $model->pasarEstado(Estado::ESTADO_BORRADOR);
            if(empty($error)){
                $transaccion->commit();            
                return $this->redirect(['update','id' => $model->id_ordenes_trabajo]);
            }
        }else
            $error = ModelUtil::aplanarErrores($model);
        
        $transaccion->rollback();
        Yii::$app->session->addFlash('danger', $error);
        
        return $this->redirect(['index']);
                   
    }

    /**
     * Updates an existing OrdenesTrabajo model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->scenario = OrdenesTrabajo::SCENARIO_UPDATE;

        if ($model->load(Yii::$app->request->post())) {
            if($model->save()){
                Yii::$app->session->addFlash('success', 'La Orden a sido guardada con éxito.');
                return $this->redirect(['view', 'id' => $model->id_ordenes_trabajo]);
            }else
                Yii::$app->session->addFlash('danger', ModelUtil::aplanarErrores($model));
        }

        $archivo    = new Archivo();

        $dataProviderArchivo = new ActiveDataProvider([
            'query' => $model->getArchivos(),
        ]);

        return $this->render('create', [
            'model'     => $model,
            'archivo'   => $archivo,
            'dataProviderArchivo' => $dataProviderArchivo,
        ]);

    }

    /**
     * Deletes an existing OrdenesTrabajo model.
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
     * Finds the OrdenesTrabajo model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return OrdenesTrabajo the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = OrdenesTrabajo::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
