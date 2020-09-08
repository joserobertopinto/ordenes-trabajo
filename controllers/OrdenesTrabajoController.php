<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use app\common\utils\ModelUtil;
use app\models\OrdenesTrabajo;
use app\models\OrdenesTrabajoSearch;
use app\models\Archivo;
use app\models\ArchivoSearch;
use app\models\Estado;
use app\models\Persona;
use app\models\UsuarioOrdenTrabajo;
use app\models\HistorialEstadoOrdenTrabajo;
use app\common\utils\Permiso;
use app\common\utils\Fecha;
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
            'access' => [
        		'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['update','create','index','view','operadores-ajax', 'pasar','volver'],
                        'allow' => true,
                        'roles' => ['@']
                    ],
                ]
            ],
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
        $model = $this->findModel($id);
        
        $archivo    = new Archivo();
        
        $dataProviderArchivo = new ActiveDataProvider([
            'query' => $model->getArchivos(),
        ]);

        return $this->render('view', [
            'model' => $model,
            'dataProviderArchivo' => $dataProviderArchivo
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
        $model->scenario            = OrdenesTrabajo::SCENARIO_CREATE;
        $model->id_ordenes_trabajo  = Uuid::uuid4();
        $model->id_usuario_crea     = Yii::$app->user->identity->id_usuario;
        $model->fecha_hora_creacion = Fecha::fechaHoraHoy();

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
            
            $transaccion= yii::$app->db->beginTransaction();
            
            $model->fecha_hora_comienzo = $model->fecha_comienzo.' '. $model->hora_comienzo;
            
            $error = $this->_guardarOperadores($model);
            
            if(empty($error)){
                $error = $model->setNumeroOrden();
                if(empty($error))
                    if($model->save()){
                        //paso solo a estado pendiente si esta en borrador, sino el estado queda como esta.
                        $error  = ($model->ultimoEstadoOrdenTrabajo->id_estado == Estado::ESTADO_BORRADOR)?$model->pasarEstado(Estado::ESTADO_PENDIENTE):'';
                    
                        if(empty($error)){
                            $transaccion->commit();
                            Yii::$app->session->addFlash('success', 'La Orden a sido guardada con éxito.');
                            
                            return $this->redirect(['view', 'id' => $model->id_ordenes_trabajo]);
                        }
                    
                    }else
                        $error =ModelUtil::aplanarErrores($model);
            }
            
            Yii::$app->session->addFlash('danger', $error);
            $transaccion->rollBack();
        }

        $model->loadOperadores();
        $model->loadFechaComienzo();

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
     * Creates a new OrdenesTrabajo model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionPasar($id = null, $id_estado = null)
    {
        $ok = true;
        $historial = new HistorialEstadoOrdenTrabajo;

        if(isset($id))
            $model = $this->findModel($id);
        else
            $model = $this->findModel(Yii::$app->request->post('OrdenesTrabajo')["id_ordenes_trabajo"]);;
        
        if($id_estado == Estado::ESTADO_FINALIZADO)
            $model->scenario = OrdenesTrabajo::SCENARIO_FINALIZAR;

        if ($historial->load(Yii::$app->request->post()) && $model->load(Yii::$app->request->post())) {
            if($model->validate()){
                $transaccion= yii::$app->db->beginTransaction();

                if(isset($historial->parcial) && ($historial->parcial == '1'))
                    $historial->id_estado = ESTADO::ESTADO_FINALIZADO_PARCIAL;
                
                $error  = ($model->pasarEstado($historial->id_estado));
                
                if(empty($error)){
                    $transaccion->commit();

                    Yii::$app->session->addFlash('success', 'Se ha cambiado el estado de la orden con éxito.');
                    
                    return $this->redirect(['view', 'id' => $model->id_ordenes_trabajo]);
                }
                else
                    $transaccion->rollback();
            }else
                $error = ModelUtil::aplanarErrores($model);

            $ok = false;
            Yii::$app->session->addFlash('danger', $error);
            
        }

        $historial->id_estado = !is_null($id_estado)?$id_estado : $historial->id_estado;

        $response['ok'] = $ok;
        $response['html']= $this->renderAjax('_formPasar',['model' => $model, 'historial' => $historial]);
        $response['titulo'] = 'Pasar a '. Estado::getEstadoLabelById($historial->id_estado);
        
        return  json_encode($response);

    }

    /**
     * vuelvo tarea a estado anterior
     */
    public function actionVolver($id){
        
        $model = $this->findModel($id);
        $historialCompleto = $model->historialEstadoOrdenTrabajo;
        $ultimoHistorial = $model->ultimoEstadoOrdenTrabajo;
        $anteUltimoHistorial = $historialCompleto[1]->id_historial_estado_orden_trabajo;
        
        $transaccion= yii::$app->db->beginTransaction();
        
        $model->id_historial_estado_orden_trabajo = $anteUltimoHistorial;
        
        if($model->save() && $ultimoHistorial->delete()){
            $transaccion->commit();
            Yii::$app->session->addFlash('success', 'Pase realizado con éxito.');

        }else{
            $transaccion->rollBack();
            Yii::$app->session->addFlash('danger', 'No se pudo realizar el cambio de estado.<br>'.ModeloUtil::aplanarErrores($model).'<br>'.ModelUtil::aplanarErrores($ultimoHistorial));
        }

        return $this->redirect(['view', 'id' => $model->id_ordenes_trabajo]);
        
    }

    /**
    * Busqueda de Persona.
    * @param string $q cadena de texto a buscar por like.
    */
    public function actionOperadoresAjax($q = null) {
            
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            
        $out = ['results' => ['id' => '', 'text' => '']];
            
        if (!is_null($q)) {

            $salida = [];
            $personas = Persona::find()
                ->where(['ilike','persona.apellido', $q])
                ->orWhere(['ilike','persona.nombre', $q])
                ->all();

            foreach ($personas as $persona) {
                    
                $usuario = $persona->usuario;
                $roles = $usuario->getListRolesByIdUser();
                
                if(in_array(Permiso::ROL_OPERADOR,$roles))
                    $salida[] = [
                        'id' => $usuario->getId(), 
                        'text' => $persona->apellido . ', ' . $persona->nombre .' (' . $persona->organismo->descripcion . ')'
                    ];
            }

            $out['results'] = $salida;
        }
        return $out;
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

    /**
     * Asocio los aperadores a la orden de trabajo
     * @param OrdenesTrabajo $model
     * @return String|Empty $error
     */
    private function _guardarOperadores($model) {
        $error = '';
        
        //elimino registros anteriores, entiendo no es necesario guardarlos 
        UsuarioOrdenTrabajo::deleteAll(['id_ordenes_trabajo' => $model->id_ordenes_trabajo]);
        
        if (!empty($model->listaOperadores)) {
            
            foreach ($model->listaOperadores as $operador) {
                $usuarioOrdenTrabajo = new UsuarioOrdenTrabajo();
                $usuarioOrdenTrabajo->id_ordenes_trabajo = $model->id_ordenes_trabajo;
                $usuarioOrdenTrabajo->id_usuario = $operador;
                
                if (!$usuarioOrdenTrabajo->save())
                    $error = 'No se pudo guardar los Operadores.'.ModelUtil::aplanarErrores($usuarioOrdenTrabajo);
            }
        }

        return $error;
    }
    
}
