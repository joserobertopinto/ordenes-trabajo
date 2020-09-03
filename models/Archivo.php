<?php

namespace app\models;

use Yii;
use yii\web\UploadedFile;
use app\common\utils\Fecha;
use yii\helpers\Html;

/**
 * This is the model class for table "ordenes_trabajo.archivo".
 *
 * @property string $id_archivo
 * @property string $nombre
 * @property string|null $descripcion
 * @property string $path
 * @property string $fecha_creacion
 * @property string $extension
 * @property int $tamanio
 * @property bool $borrado
 */
class Archivo extends \yii\db\ActiveRecord
{
    public $archivo, $extensiones_permitidas;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ordenes_trabajo.archivo';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['archivo', 'descripcion'], 'required'],
            [['id_archivo','id_ordenes_trabajo'], 'string'],
            [['fecha_creacion','archivo' ,'extensiones_permitidas'], 'safe'],
            [['tamanio'], 'default', 'value' => null],
            [['tamanio'], 'integer'],
            [['borrado'], 'boolean'],
            [['nombre'], 'string', 'max' => 100],
            [['descripcion', 'path'], 'string', 'max' => 500],
            [['extension'], 'string', 'max' => 5],
            [['id_archivo'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_archivo' => Yii::t('app', 'Id Archivo'),
            'nombre' => Yii::t('app', 'Nombre'),
            'descripcion' => Yii::t('app', 'Descripcion'),
            'path' => Yii::t('app', 'Path'),
            'fecha_creacion' => Yii::t('app', 'Fecha Creacion'),
            'extension' => Yii::t('app', 'Extension'),
            'tamanio' => Yii::t('app', 'Tamanio'),
            'borrado' => Yii::t('app', 'Borrado'),
            'archivo' => 'Archivo',
            'id_ordenes_trabajo' => 'Orden de Trabajo'
        ];
    }

    
    public function upload(){
        //C:\xampp\htdocs\oficinajudicial/uploads/f5c3ec1a-c3da-496d-ac02-43ffef99a581.jpg
        $this->archivo->saveAs(Yii::$app->basePath.$this->path. $this->id_archivo . '.' . $this->extension); //'../uploads/'
    }
    
    
    public function base64ToFile() {
        $output_file = Yii::$app->basePath.$this->path. $this->id_archivo . '.' . $this->extension;
        $ifp = fopen( $output_file, "wb" );
        fwrite( $ifp, base64_decode( $this->base64) );
        fclose( $ifp );
        $this->tamanio = filesize($output_file);
        return( $output_file );
    }
    
    public function fileToBase64(){
        //return "";
        $file = file_get_contents($this->getPathDescarga());
        $base64 = base64_encode($file);
        return $base64;
    }
    
    public function setPathArchivo($id_ordenes_trabajo){
        
        $path = Yii::$app->params['uploads'].$id_ordenes_trabajo;
        self::resuelveCarpeta($path);
        
        $this->path=$path.DIRECTORY_SEPARATOR;//Yii::$app->params['uploads'];
    }
    
    /**
     * retorna el nombre real del archivo, sin el uuid con el que se guarda
     */
    public function getNombreReal(){
        return $this->nombre.'.'.$this->extension;
    }
    
    /**
     * retorna el nombre del archivo almacenado en el FileSystem
     */
    public function getNombreEnFileSystem(){
        return $this->id_archivo.'.'.$this->extension;
    }
    
    /**
     * Retorna el path completo para la descarga
     * @return string
     */
    public function getPathDescarga(){
        return Yii::$app->basePath.$this->path.$this->getNombreEnFileSystem();
    }
    
    /**
     * verifica que exista la carpeta, si no está la crea
     */
    public static function resuelveCarpeta($folder,$usarBasePath=true){
        $salida = true;
        if ($usarBasePath)
            $folder = Yii::$app->basePath .$folder;
        
        if (!file_exists($folder)){
            
            if (mb_strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
                $salida = mkdir($folder);
            }else{
                //Tuve que usa @mkdir porque por permisos sino genera un warning.
                //manejamos el error con $salida
                $salida = @mkdir($folder, 0775, true); //mkdir($folder, 0777);
            }        
        }
        
        return $salida;
    }

    /**
     * Elimina el archivo del filesystem
     * @throws \yii\base\Exception
     */
    public function deleteFileSystem(){
        if(!empty($this->path)){
            $file = '..'.$this->path. $this->id_archivo . '.' . $this->extension; 
            if (is_writable($file)) 
                @unlink($file);
            else
                throw new \yii\base\Exception('No se puede eliminar el archivo del FileSystem.');
        }
    }
    
    public function getNombreExtension(){
        return $this->nombre.'.'.$this->extension;
    }
    
    public function getTamanioFormateado(){
        $size='';
        if 	($this->tamanio <= 1024)
            $size=$this->tamanio.' Bytes';
        elseif ($this->tamanio <= (1024 * 1024))
            $size=round(($this->tamanio/1024),2).' KBytes';
        else
            $size=round((($this->tamanio/1024)/1024),2).' MBytes';
                
                return $size;
    }
    
    /**
     * formateo la fecha para que se vea como d/m/Y
     * {@inheritDoc}
     * @see \yii\db\BaseActiveRecord::afterFind()
     */
    public function afterFind(){
        parent::afterFind();
        $this->fecha_creacion = Fecha::convertir($this->fecha_creacion);
    }
    
    public function validarExtension($attribute,$params){
        if (!empty($this->extensiones_permitidas))
            $exp_per = $this->extensiones_permitidas;
        else
            $exp_per = Yii::$app->params['extensiones'];
            
        if (!in_array($this->extension, $exp_per, true))
                $this->addError('extension','Las extensiones permitidas son:'.implode(',',$exp_per));
    }
    
    /**
     * Solo efectua el Upload del Documento, y setea las propiedades del Documento
     * @param string $scenarioValidacionUpload le dice que scenario usar al validar el Upload, si no vienen nada usa el SCENARIO_UPLOAD por defecto
     */
    //TODO: sacar la asignacion del escenario de aca y poner antes (en los controladores segunla accion). Mejorar tambien las reglas
    public function validarUpload( ){
        
        //Resguardo el scenario actual del modelo y seteo scenario para hacer solo el upload del documento
        
        $this->archivo = UploadedFile::getInstance($this, 'archivo');
        if ($this->validate()) { //valida que se un archivo con las extensiones permitidas
            //     		$this->documento->saveAs('uploads/' . $this->documento->baseName . '.' . $this->documento->extension);
            $this->nombre	 = preg_replace('/[^a-zA-Z0-9-_\.]/','',$this->archivo->baseName);
            $this->extension = $this->archivo->extension;
            $this->tamanio	 = $this->archivo->size;
            $this->fecha_creacion = date('d-m-Y H:i:s');
            $rta= true;
        } else {
            $rta= false;
        }
        
        return $rta;
    }
    
    /**
     * retorna el nombre de archivo de la forma: nombre.ext
     */
    public function getNombreCompleto(){
        return (empty($this->nombre)?'':$this->nombre).'.'.(empty($this->extension)?'':$this->extension);
    }
    
    /**
     * metodo estatico
     * @param uuid $id id del archivo
     */
    public static function descargar($id){
        $archivo = self::findOne($id);
        $archivo->descargarInstanciado();
    }

    /**
     * metodo de instancia, descarga la instancia
     * @throws \yii\web\HttpException
     */
    public function descargarInstanciado(){
        if (! file_exists($this->getPathDescarga())) {
            throw new \yii\web\HttpException(404, 'El archivo que intenta ver no se encuentra.');
        }
        
        header('Content-Type: application/'.$this->extension);//
        header('Content-Disposition: attachment; filename='.$this->getNombreReal());
        header('Pragma: no-cache');
        //ob_clean(); //limpia el buffer de salida
        header("Cache-Control: public");
        header("Content-Description: File Transfer");
        header("Content-Transfer-Encoding: binary");
        
        if (!readfile($this->getPathDescarga()))
            throw new \yii\web\HttpException(404, 'Error al leer el archivo.');

    }

    /**
     * Borrado logico del archivo
     * @param string $mensaje //mensaje sin hay error
     * @return boolean
     */
    public function guardarComoBorrado(&$mensaje){
        $ok = true;
        $this->borrado  = true;
        $this->scenario = self::SCENARIO_MARCAR_BORRADO;
        if (!$this->save()){
            $mensaje = 'No se pudo marcar como borrado el archivo '.$this->nombreCompleto.'<BR>'.VarDumper::dumpAsString($this->errors,3,true);
            $ok = false;
        }
        
        return $ok;
    }
    
    /**
     *
     * @param string $accion //ej. 'huella-dactilar/descargar/'
     * @return NULL|string
     */
    public function getlinkDescarga($accion){
        //return SessionUtil::getLinkMultiDataCenter($this->id_data_center, 'persona', $accion.$this->id_archivo);
    }
    
    public function getImgTagData() {
        
        $out = '';
        if (!empty($this->extension)){
            if ( strtolower($this->extension) == 'png' )
                $mime = 'image/png';
            else
                $mime = 'image/jpeg'; //es un .jpg, .jpeg o .pje
            
            $out = 'data:' . $mime . ';base64,' . $this->fileToBase64();
        }
        
        return $out;
    }
    
    public function getDescargaHtmlLink(){
        return Html::a($this->nombreCompleto,['archivo/descargar', 'id'=>$this->id_archivo],[ 'title'=>'Descargar Archivo','data-pjax'=>'0']);
    }

    public function generarAsignarNombre(){
        $i = Archivo::find()->where(['id_ordenes_trabajo' => $this->id_ordenes_trabajo])->count();
        $this->nombre = 'archivo_adjunto_'.($i+1);
    }

}
