<?php
use yii\helpers\Html;
use app\common\utils\Permiso;

/* @var $this \yii\web\View */
/* @var $content string */
?>

  <!-- Navbar -->
      <nav class="navbar navbar-expand-lg head-navbar-custom">
        <div class="container-fluid">
          <div class="navbar-wrapper">
            <a class="navbar-brand" href="#"><?= $this->title?></a>
          </div>
          <button class="navbar-toggler" type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
            <span class="sr-only">Toggle navigation</span>
            <span class="navbar-toggler-icon icon-bar"></span>
            <span class="navbar-toggler-icon icon-bar"></span>
            <span class="navbar-toggler-icon icon-bar"></span>
          </button>
          <div class="collapse navbar-collapse justify-content-end">
            <ul class="navbar-nav">
              <li class="nav-item dropdown">
                <a class="nav-link" href="#" id="navbarDropdownProfile" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="material-icons">person</i>
                  <p class="d-lg-none d-md-block">
                    Account
                  </p>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownProfile">
                  <div tabindex="-1" class="noti-title dropdown-header" style="text-align:center">
                    <h6 class="text-overflow m-0"><?= (Yii::$app->user->identity->persona->getApellidoNombre()); ?></h6>
                    <h7 class="text-overflow m-0"><?= ((Permiso::esUsuarioSupervisor())?'Supervisor':'Operador'); ?></h7>
                  </div>
                  <div tabindex="-1" class="noti-title dropdown-header">
                    <h8 class="text-overflow m-0" style="text-align:center"><?= (Yii::$app->user->identity->persona->sucursal->descripcion); ?></h8>
                  </div>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item" href="#" style="padding: 0;">
                    <?php
                    echo Html::beginForm(['/site/logout'], 'post');
                    echo Html::submitButton(
                        'Salir (' . Yii::$app->user->identity->username . ')',
                        ['class' => 'btn btn-link logout']
                    );
                    echo Html::endForm();
                    ?>
                  </a>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </nav>
  <!-- End Navbar -->