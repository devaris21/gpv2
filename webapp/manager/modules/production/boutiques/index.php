<!DOCTYPE html>
<html>

<?php include($this->rootPath("webapp/manager/elements/templates/head.php")); ?>


<body class="fixed-sidebar">

    <div id="wrapper">

        <?php include($this->rootPath("webapp/manager/elements/templates/sidebar.php")); ?>  

        <div id="page-wrapper" class="gray-bg">

            <?php include($this->rootPath("webapp/manager/elements/templates/header.php")); ?>  

            <?php include($this->rootPath("webapp/manager/elements/templates/script.php")); ?>

            <div class="wrapper wrapper-content">
                <div class="animated fadeInRightBig">

                    <div class="tabs-container produits">
                        <ul class="nav nav-tabs text-uppercase" role="tablist">
                            <li ><a class="nav-link" data-toggle="tab" href="#pan-global"><i class="fa fa-globe" ></i> Global</a></li>
                            <li ><a class="nav-link" data-toggle="tab" href="#pan-ventes"><i class="fa fa-handshake-o" ></i> Stock des produits</a></li>
                            <li ><a class="nav-link" data-toggle="tab" href="#pan-rapport"><i class="fa fa-money" ></i> Rapport de vente</a></li>
                            <li ><a class="nav-link" data-toggle="tab" href="#pan-caisse"><i class="fa fa-money" ></i> La caisse</a></li>
<!--                             <li style="width: 270px; position: absolute; right: 0;"><?php //Native\BINDING::html("select", "boutique", $boutique, "id") ?></li>
 -->                        </ul>
                        <div class="tab-content loading-data">

                            <?php include($this->relativePath("partials/tab-global.php")); ?>
                            <?php include($this->relativePath("partials/tab-stock.php")); ?>
                            <?php include($this->relativePath("partials/tab-rapport.php")); ?>
                            <?php include($this->relativePath("partials/tab-caisse.php")); ?>

                        </div>
                    </div>


                </div>

                <br>
                <?php include($this->rootPath("webapp/manager/elements/templates/footer.php")); ?>

                <?php include($this->rootPath("composants/assets/modals/modal-vente.php")); ?> 
                <?php include($this->rootPath("composants/assets/modals/modal-prospection.php")); ?> 
                <?php include($this->rootPath("composants/assets/modals/modal-ventecave.php")); ?> 

                
            </div>
        </div>


    </body>


    </html>