<?php

namespace app\models;

use Yii;
use yii\base\NotSupportedException;
use yii\db\ActiveRecord;
use yii\helpers\Security;
use yii\web\IdentityInterface;
use app\models\Persona;

/**
 * This is the model class for table "ordenes_trabajo.usuario".
 *
 * @property string $id_usuario
 * @property string $id_persona
 * @property string|null $descripcion
 * @property string $username
 * @property string $password
 * @property string|null $tipo_usuario
 * @property bool|null $pwd_hash
 */
class User extends \yii\db\ActiveRecord  implements IdentityInterface
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ordenes_trabajo.usuario';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_usuario', 'id_persona', 'username', 'password'], 'required'],
            [['id_usuario', 'id_persona'], 'string'],
            [['pwd_hash'], 'boolean'],
            [['descripcion', 'password', 'tipo_usuario'], 'string', 'max' => 255],
            [['username'], 'string', 'max' => 50],
            [['id_usuario'], 'unique'],
            [['id_persona'], 'exist', 'skipOnError' => true, 'targetClass' => Persona::className(), 'targetAttribute' => ['id_persona' => 'id_persona']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_usuario' => Yii::t('app', 'Id Usuario'),
            'id_persona' => Yii::t('app', 'Id Persona'),
            'descripcion' => Yii::t('app', 'Descripcion'),
            'username' => Yii::t('app', 'Username'),
            'password' => Yii::t('app', 'Password'),
            'tipo_usuario' => Yii::t('app', 'Tipo Usuario'),
            'pwd_hash' => Yii::t('app', 'Pwd Hash'),
        ];
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getPersona()
    {
    	return $this->hasOne(Persona::className(), ['id_persona' => 'id_persona']);
    }

    /** INCLUDE USER LOGIN VALIDATION FUNCTIONS**/
    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * @inheritdoc
     */
/* modified */
    public static function findIdentityByAccessToken($token, $type = null)
    {
          return static::findOne(['access_token' => $token]);
    }
 
/* removed
    public static function findIdentityByAccessToken($token)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }
*/
    /**
     * Finds user by username
     *
     * @param  string      $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
    }

    /**
     * Finds user by password reset token
     *
     * @param  string      $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        $expire = \Yii::$app->params['user.passwordResetTokenExpire'];
        $parts = explode('_', $token);
        $timestamp = (int) end($parts);
        if ($timestamp + $expire < time()) {
            // token expired
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token
        ]);
    }

    /**
     * id usuario logeado
     */
    public static function getCurrentUserId(){
        return \Yii::$app->user->identity->id_usuario;
    }
    /**
     * username usuario logeado
     */
    public static function getCurrentUserName(){
        return \Yii::$app->user->identity->username;
    }

    public static function getApellidoNombreByIdUser($id){
        $user = self::findOne($id);
        return $user->persona->getApellidoNombre();
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param  string  $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        //Quito SHA1 para demo
        // return $this->password === sha1($password);
        return $this->password === $password;
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Security::generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Security::generateRandomKey();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Security::generateRandomKey() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }
    /** EXTENSION MOVIE **/

    public function getListRolesByIdUser(){
        return array_keys(\Yii::$app->authManager->getRolesByUser($this->getId()));
    }
}
