<!DOCTYPE html>
<html>

<?php include($this->rootPath("webapp/gestion/elements/templates/head.php")); ?>


<body class="fixed-sidebar">

    <div id="wrapper">

        <?php include($this->rootPath("webapp/gestion/elements/templates/sidebar.php")); ?>  

        <div id="page-wrapper" class="gray-bg">

          <?php include($this->rootPath("webapp/gestion/elements/templates/header.php")); ?>  

          <div class="row wrapper border-bottom white-bg page-heading">
            <div class="col-sm-7">
                <h2 class="text-uppercase">Le Stock des ressources</h2>
                <span>au <?= datecourt(dateAjoute())  ?></span>
            </div>
            <div class="col-sm-5">
                <div class="title-action">
                    <button data-toggle='modal' data-target="#modal-approvisionnement" class="btn btn-warning dim"><i class="fa fa-plus"></i> Nouvel Approvisionnement</button>
                </div>
            </div>
        </div>

        <div class="wrapper wrapper-content">
            <div class="text-center animated fadeInRightBig">

                <div class="ibox ">
                    <div class="ibox-title">
                        <h5 class="float-left">Pour les <?= $this->getId()  ?> derniers jours</h5>
                        <div class="float-right">
                            <div class="btn-group text-right">
                                <a href="<?= $this->url("gestion", "master", "ressources", 7) ?>" class="btn btn-xs btn-white <?= ($this->getId() == 7)?"active":"" ?>"><i class="fa fa-calendar"></i> la semaine</a>
                                <a href="<?= $this->url("gestion", "master", "ressources", 15) ?>" class="btn btn-xs btn-white <?= ($this->getId() == 15)?"active":"" ?>"><i class="fa fa-calendar"></i> la quinzaine</a>
                                <a href="<?= $this->url("gestion", "master", "ressources", 30) ?>" class="btn btn-xs btn-white <?= ($this->getId() == 30)?"active":"" ?>"><i class="fa fa-calendar"></i> le mois</a>
                            </div>
                        </div>
                    </div>
                    <div class="ibox-content">

                        <div class="tabs-container" id="ressources">

                            <div class="tabs-left">
                                <ul class="nav nav-tabs">
                                   <?php foreach (Home\TYPERESSOURCE::getAll() as $key => $type) { ?>
                                    <li><a class="nav-link text-uppercase" data-toggle="tab" href="#tab-<?= $type->getId() ?>">Intrants - <?= $type->name(); ?></a></li>
                                <?php }  ?>
                            </ul>
                            <div class="tab-content " id="produits">
                                <?php foreach (Home\TYPERESSOURCE::getAll() as $key => $type) { ?>
                                    <div id="tab-<?= $type->getId() ?>" class="tab-pane">
                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="col-sm">
                                                    <div class="carre bg-green"></div><span>Quantité approvisionnée</span>
                                                </div>
                                                <div class="col-sm">
                                                    <div class="carre bg-danger"></div><span>Quantité consommée</span>
                                                </div>
                                            </div><hr>
                                            <h2 class="text-uppercase gras text-center">Intrants - <?= $type->name(); ?></h2>
                                            <table class="table table-bordered table-hover">
                                                <thead>
                                                    <tr>
                                                        <th rowspan="2" class="border-none"></th>
                                                        <?php 
                                                        $lots = $type->fourni("ressource") ;
                                                        foreach ($lots as $key => $ressource) { ?>
                                                            <th><small><?= $ressource->name() ?></small></th>
                                                        <?php } ?>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>Stock de la veille</td>
                                                        <?php foreach ($lots as $key => $ressource) { ?>
                                                            <td><span class="text-muted gras" style="font-size: 15px"><?= $ressource->stock(dateAjoute1($productionjours[0]->ladate, -1)) ?></span> </td>
                                                        <?php } ?>
                                                    </tr>

                                                    
                                                    <?php
                                                    $i =0;
                                                    foreach ($productionjours as $key => $production) {
                                                        $i++; ?>
                                                        <tr>
                                                            <td><?= datecourt3($production->ladate)  ?></td>
                                                            <?php
                                                            $production->fourni("ligneconsommationjour");
                                                            foreach ($lots as $key => $ressource) {
                                                                foreach ($production->ligneconsommationjours as $key => $ligne) {
                                                                    if ($ressource->getId() == $ligne->ressource_id) { 
                                                                     $requette = "SELECT ligneapprovisionnement.ressource_id, SUM(quantite_recu) as quantite FROM ressource, approvisionnement, ligneapprovisionnement WHERE ressource.id = ligneapprovisionnement.ressource_id AND ligneapprovisionnement.approvisionnement_id = approvisionnement.id  AND ressource.id = ? AND DATE(approvisionnement.datelivraison) = ? AND approvisionnement.etat_id = ? GROUP BY ligneapprovisionnement.ressource_id ";
                                                                     $datas = Home\RESSOURCE::execute($requette, [$ressource->getId(), $production->ladate, Home\ETAT::VALIDEE]);
                                                                     if (count($datas) > 0) {
                                                                        $item = $datas[0];
                                                                    }else{
                                                                        $item = new \stdclass();
                                                                        $item->quantite = 0;
                                                                    }
                                                                    ?>
                                                                    <td>
                                                                        <h3 class="d-inline text-red gras"><?= start0($ligne->consommation) ?></h3> &nbsp; | &nbsp;
                                                                        <h4 class="d-inline text-green"><?= start0(round($item->quantite, 2)) ?></h4>
                                                                    </td>
                                                                <?php }
                                                            }
                                                        } ?>
                                                    </tr>
                                                <?php } ?>
                                                <tr style="height: 18px;"></tr>
                                                <tr>
                                                    <td style="width: 20%"><h2 class="text-center gras text-uppercase">Stock actuel</h2></td>
                                                    <?php foreach ($lots as $key => $ressource) { ?>
                                                        <td><h2 class="text-success gras" ><?= start0($ressource->stock(dateAjoute())) ?></h2></td>
                                                    <?php } ?>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>   
                            <?php }  ?>
                        </div>

                    </div>

                </div>
                
            </div>

        </div>


    </div>
</div>


<?php include($this->rootPath("webapp/gestion/elements/templates/footer.php")); ?>
<?php include($this->rootPath("composants/assets/modals/modal-approvisionnement.php")); ?>  

</div>
</div>


<?php include($this->rootPath("webapp/gestion/elements/templates/script.php")); ?>


</body>

</html>
