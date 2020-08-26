<!DOCTYPE html>
<html>

<?php include($this->rootPath("webapp/entrepot/elements/templates/head.php")); ?>


<body class="fixed-sidebar">

    <div id="wrapper">

        <?php include($this->rootPath("webapp/entrepot/elements/templates/sidebar.php")); ?>  

        <div id="page-wrapper" class="gray-bg">

          <?php include($this->rootPath("webapp/entrepot/elements/templates/header.php")); ?>  


          <div class="ibox">
            <div class="ibox-title">
                <h5 class="text-uppercase">Stock de ressource</h5>
                <div class="ibox-tools">
                    <button data-toggle='modal' data-target="#modal-approvisionnement" style="margin-top: -4%" class="btn btn-warning btn-xs dim"><i class="fa fa-plus"></i> Nouvel Approvisionnement</button>
                </div>
            </div>
            <div class="ibox-content">
                <div class="row text-center">
                  <?php $total = 0; foreach ($ressources as $key => $ressource) {
                    $stock = $ressource->stock(dateAjoute(), dateAjoute(1), $entrepot->id);
                    $prix = $stock * $ressource->price();
                    $total += $prix ?>
                    <div class="col-sm-4 col-md-3 col-lg-2 border-left border-bottom">
                        <div class="p-xs">
                            <i class="fa fa-hospital-o fa-2x text-green"></i>
                            <h6 class="m-xs gras <?= ($stock > $params->ruptureStock)?"":"clignote" ?>"><?= round($stock, 2) ?> <?= $ressource->abbr ?></h6>
                            <h5 class="no-margins text-uppercase gras <?= ($stock > $params->ruptureStock)?"":"clignote" ?>"><?= $ressource->name() ?> </h5>
                            <small>Es: <?= money($prix) ?> <?= $params->devise ?></small>
                        </div>
                    </div>
                <?php } ?>
            </div>

            <div class="text-center">
                <h5>Estimation du stock actuel</h5>
                <h1 class="no-margins"><?= money($total) ?> <?= $params->devise ?></h1>
            </div>
        </div>
    </div>



    <div class="wrapper wrapper-content">
        <div class="text-center animated fadeInRightBig">

            <div class="ibox ">
                <div class="ibox-title">
                    <h5 class="float-left text-uppercase">Historiques du <?= datecourt($date1) ?> au <?= datecourt($date2) ?></h5>
                    <div class="ibox-tools">
                        <form id="formFiltrer" method="POST">
                            <div class="row" style="margin-top: -1%">
                                <div class="col-5">
                                    <input type="date" value="<?= $date1 ?>" class="form-control input-sm" name="date1">
                                </div>
                                <div class="col-5">
                                    <input type="date" value="<?= $date2 ?>" class="form-control input-sm" name="date2">
                                </div>
                                <div class="col-2">
                                    <button type="button" onclick="filtrer()" class="btn btn-sm btn-white"><i class="fa fa-search"></i> Filtrer</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="ibox-content">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th rowspan="2" class="border-none"></th>
                                <?php foreach ($ressources as $key => $ressource) {  ?>
                                    <th><small class="gras"><?= $ressource->name() ?></small></th>
                                <?php } ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $index = $date1;
                            while ($index <= $date2) { ?>
                                <tr>
                                    <td class="gras"><?= datecourt($index) ?></td>
                                    <?php foreach ($ressources as $key => $ressource) {
                                        $stock = $ressource->stock($index, $index, $entrepot->id);
                                        $appro = $ressource->achat($index, $index, $entrepot->id);
                                        $conso = $ressource->consommee($index, $index, $entrepot->id);
                                        $perte = $ressource->perte($index, $index, $entrepot->id);
                                        ?>
                                        <td class="cursor myPopover"
                                        data-toggle="popover"
                                        data-placement="right"
                                        title="<small><b><?= $ressource->name() ?></b> | <?= datecourt($index) ?></small>"
                                        data-trigger="hover"
                                        data-html="true"
                                        data-content="
                                        <span>Appro du jour : <b><?= round($appro, 2) ?> <?= $ressource->abbr ?></b></span><br>
                                        <span>Conso du jour : <b><?= round($conso, 2) ?> <?= $ressource->abbr ?></b></span><br>
                                        <span>Perte : <b><?= round($perte, 2) ?> <?= $ressource->abbr ?></b></span>
                                        <hr style='margin:1.5%'>
                                        <span>En stock à ce jour : <b><?= round($stock, 2) ?> <?= $ressource->abbr ?></b></span><br> <span>">
                                            <?= round($stock, 2) ?> <?= $ressource->abbr ?>
                                        </td>
                                    <?php } ?>
                                </tr>
                                <?php
                                $index = dateAjoute1($index, 1);
                            }
                            ?>
                            <tr style="height: 18px;"></tr>
                        </tbody>
                    </table> 
                </div>

            </div>


        </div>
    </div>


    <?php include($this->rootPath("webapp/entrepot/elements/templates/footer.php")); ?>
    <?php include($this->rootPath("composants/assets/modals/modal-approvisionnement.php")); ?>  

</div>
</div>


<?php include($this->rootPath("webapp/entrepot/elements/templates/script.php")); ?>


</body>

</html>
