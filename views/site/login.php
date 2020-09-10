<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title =  Yii::t('app', 'Login');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <!-- <h1><?//= Html::encode($this->title) ?></h1> -->
    <div class="col-md-4 col-sm-6 ml-auto mr-auto"><!-- col-lg-4  -->
        <div class="card card-login card-hidden">
            <div class="card-header card-header-rose text-center"  data-background-color="orange">
                <h4 class="card-title"><?= Yii::t('app', 'Login'); ?></h4>
                <!-- <div class="social-line">
                    <a href="#" class="btn btn-just-icon btn-link btn-white">
                        <i class="fa fa-facebook-square"></i>
                    </a>
                    <a href="#" class="btn btn-just-icon btn-link btn-white">
                        <i class="fa fa-twitter"></i>
                    </a>
                    <a href="#" class="btn btn-just-icon btn-link btn-white">
                        <i class="fa fa-google-plus"></i>
                    </a>
                </div> -->
            </div>
            <?php $form = ActiveForm::begin([
                    'id' => 'login-form',
//                    'fieldConfig' => [
//                        'template' => "{input}\n{hint}\n{error}",
//                    ],
                ]); ?>
            <div class="card-body ">
                <span class="bmd-form-group">
                        <?= $form->field($model, 'username',['template'=>'
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                <i class="material-icons">face</i>
                                </span>
                            </div>
                            {input}
                        </div>
                        '
                        ])->textInput(["placeholder"=>"Usuario..."])->label(false) ?>
                  <!--   <label class="bmd-label-floating">Username</label>
                    <input type="text" class="form-control"> -->
                </span>
                <span class="bmd-form-group">
                        <?= $form->field($model, 'password',['template'=>'
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                <i class="material-icons">lock_outline</i>
                                </span>
                            </div>
                            {input}
                        </div>
                        '
                        ])->passwordInput(["class"=>"form-control","placeholder"=>"Contraseña..."]) ?>
                        <!-- <input type="password" class="form-control" placeholder="Password..."> -->
                </span>
                <span class="bmd-form-group">
                    <div class="input-group">
                        &nbsp;
                        <?php //echo $form->field($model, 'rememberMe')->checkbox() ?>
                    </div>
                </span>
            </div>
           <div class="card-footer justify-content-center">
                <?= Html::submitButton('Ingresar', ['class' => 'btn btn-green btn-block btn-border', 'name' => 'login-button']) ?>
           </div>
           <div class="card-footer">
           </div>
           <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
