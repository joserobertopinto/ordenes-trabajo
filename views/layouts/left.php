<?php
    $menu = $img = "";
    $config = new rce\material\Config();
    if (class_exists('common\models\Menu')) {
        // advence template
        $menu = common\models\Menu::getMenu();
        // echo $menu;die;
    }
    if (class_exists('app\models\Menu')) {
        // basic template
        $menu = app\models\Menu::getMenu();
    }
    if(empty($config::sidebarBackgroundImage())) {
        $img = $directoryAsset.'/img/sidebar-1.jpg';
    }else {
        $img = $config::sidebarBackgroundImage();
    }
?>
<div class="sidebar" data-color="<?= $config::sidebarColor()  ?>" data-background-color="<?= $config::sidebarBackgroundColor()  ?>">
    <div class="logo">
        <a href="#" class="simple-text logo-mini">
        </a>
        <a href="#" class="simple-text logo-normal">
            <?= $config::siteTitle()  ?>
        </a>
    </div>
    <div class="sidebar-wrapper">
        <ul class="nav">
            <li class="nav-item">
            <a class="nav-link" href="/ordenes-trabajo">
                <i class="material-icons">dashboard</i>
                <p>Inicio</p>
            </a>
            </li>
            <li class="nav-item ">
                <a class="nav-link" href="<?=Yii::$app->urlManager->createUrl(['ordenes-trabajo/index']);?>">
                <i class="material-icons">assignment</i>
                <p>Lista de Operaciones</p>
                </a>
            </li>
            <li class="nav-item ">
                <a class="nav-link" href="./permit/access/role">
                <i class="material-icons">supervisor_account</i>
                <p>Seguridad</p>
                </a>
            </li>
        </ul>
        <?= $menu ?>
    </div>
    <div class="sidebar-background" style="background-image: url(<?= $img ?>) "></div>
</div>

<?php
    $this->registerJs("
    $(function(){
        $('.nav a').filter(function(){
            return this.href==location.href}).parent().addClass('active').siblings().removeClass('active');

        $('.nav a').click(function(){
            $(this).parent().addClass('active').siblings().removeClass('active')    
            });
        });
    ");
?>