<!DOCTYPE html>
<html>

<?php include($this->rootPath("webapp/entrepot/elements/templates/head.php")); ?>


<body class="fixed-sidebar">

    <div id="wrapper">

        <?php include($this->rootPath("webapp/entrepot/elements/templates/sidebar.php")); ?>  

        <div id="page-wrapper" class="gray-bg">

          <?php include($this->rootPath("webapp/entrepot/elements/templates/header.php")); ?>  

          <div class="wrapper wrapper-content">
            <div class="animated fadeInRightBig">


                <div class=" border-bottom white-bg dashboard-header">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="text-center" style="margin-top: 15%;">
                                <img src="<?= $this->stockage("images", "societe", $params->image) ?>" style="width: 70%;" alt=""><br>
                                <h2 class="text-uppercase"><?= $entrepot->name() ?></h2><br>
                            </div>
                        </div>
                        <div class="col-md-9 border-left">
                            <div class="row text-center">
                                <div class="col-sm-4 border-left border-bottom">
                                    <div class="p-lg">
                                        <i class="fa fa-free-code-camp fa-3x text-dark"></i>
                                        <h1 class="m-xs"><?= start0(count(Home\LIGNEPRODUCTION::findBy(["DATE(created) ="=>dateAjoute()])))  ?></h1>
                                        <h3 class="no-margins text-uppercase gras">Production</h3>
                                        <small>Aujourd'hui</small>
                                    </div>
                                </div>
                                <div class="col-sm-4 border-left border-bottom">
                                    <div class="p-lg">
                                        <i class="fa fa-codepen fa-3x text-danger"></i>
                                        <h2 class="m-xs"><?= start0(count(Home\EMBALLAGE::ruptureEntrepot($entrepot->id)))  ?></h2>
                                        <h4 class="no-margins text-uppercase gras">Rupture d'emballages</h4>
                                        <small><?= $params->societe ?></small>
                                    </div>
                                </div>
                                <div class="col-sm-4 border-left border-bottom">
                                    <div class="p-lg">
                                        <i class="fa fa-cubes fa-3x text-danger"></i>
                                        <h2 class="m-xs"><?= start0(count(Home\RESSOURCE::ruptureEntrepot($entrepot->id)))  ?></h2>
                                        <h4 class="no-margins text-uppercase gras">Rupture de ressources</h4>
                                        <small><?= $params->societe ?></small>
                                    </div>
                                </div>
                                <div class="col-sm-4 border-left">
                                    <div class="p-lg">
                                        <i class="fa fa-stack-overflow fa-3x text-dark"></i>
                                        <h1 class="m-xs"><?= start0(count($approvisionnements__)); ?></h1>
                                        <h3 class="no-margins text-uppercase gras">Appro en cours</h3>
                                        <small><?= $params->societe ?></small>
                                    </div>
                                </div>
                                <div class="col-sm-4 border-left">
                                    <div class="p-lg">
                                        <i class="fa fa-truck fa-3x text-orange"></i>
                                        <h1 class="m-xs"><?= start0(count($entrepot->fourni("miseenboutique", ["etat_id ="=>Home\ETAT::PARTIEL, "entrepot_id="=>$entrepot->id]))); ?></h1>
                                        <h3 class="no-margins text-uppercase gras">Demandes de depôt</h3>
                                        <small><?= $params->societe ?></small>
                                    </div>
                                </div>
                                <div class="col-sm-4 border-left">
                                    <div class="p-lg">
                                        <i class="fa fa-truck fa-3x text-green"></i>
                                        <h1 class="m-xs"><?= start0(count($entrepot->fourni("miseenboutique", ["etat_id ="=>Home\ETAT::ENCOURS, "entrepot_id="=>$entrepot->id]))); ?></h1>
                                        <h3 class="no-margins text-uppercase gras">Depôts en cours</h3>
                                        <small><?= $params->societe ?></small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><hr>
                </div>


            </div>
        </div>
        <br>

        <?php include($this->rootPath("webapp/entrepot/elements/templates/footer.php")); ?>


    </div>
</div>


<?php include($this->rootPath("webapp/entrepot/elements/templates/script.php")); ?>

<script type="text/javascript" src="<?= $this->relativePath("../../production/programmes/script.js") ?>"></script>
<script type="text/javascript" src="<?= $this->relativePath("../../master/client/script.js") ?>"></script>
<script type="text/javascript" src="<?= $this->relativePath("../../production/miseenboutique/script.js") ?>"></script>

</body>

</html>