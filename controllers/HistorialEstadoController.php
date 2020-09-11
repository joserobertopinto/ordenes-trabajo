<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use app\models\HistorialEstadoOrdenTrabajo;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class HistorialEstadoController extends \yii\web\Controller
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
                        'actions' => ['editar-comentario'],
                        'allow' => true,
                        'roles' => ['@']
                    ],
                ]
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'editar-comentario' => ['POST'],
                ],
            ],
        ];
    }

     /**
     * 
     */
    public function actionEditarComentario($id){
        $ok = true;
        $mensaje = '';
        $model = $this->findModel($id);
        $post = Yii::$app->request->post();
        $model->observacion = $post['comentario'];
        
        if(!$model->save()){
            $ok = false;
            $mensaje = ModelUtil::aplanarErrores();
        }

        // print_r($post['comentario']);
        // exit;
        $response['ok'] = $ok;
        $response['mensaje'] = $mensaje;

        return json_encode($response);
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
        if (($model = HistorialEstadoOrdenTrabajo::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

}
