<!DOCTYPE html>
<html>

<?php include($this->rootPath("webapp/entrepot/elements/templates/head.php")); ?>


<body class="fixed-sidebar">

    <div id="wrapper">

        <?php include($this->rootPath("webapp/entrepot/elements/templates/sidebar.php")); ?>  

        <div id="page-wrapper" class="gray-bg">

            <?php include($this->rootPath("webapp/entrepot/elements/templates/header.php")); ?>  

            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-sm-9">
                    <h2 class="text-uppercase text-red gras">Les pertes en entrepot</h2>
                    <div class="container">
                    </div>
                </div>
                <div class="col-sm-3 text-right">
                </div>
            </div>

            <div class="wrapper wrapper-content">
                <div class="ibox">
                    <div class="ibox-title">
                        <h5>Toutes les pertes survenues dans cet entrepot</h5>
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
                    <?php if (count($datas + $encours) > 0) { ?>
                        <table class="footable table table-stripped toggle-arrow-tiny">
                            <thead>
                                <tr>

                                    <th data-toggle="true">Status</th>
                                    <th>Reference</th>
                                    <th>Element</th>
                                    <th>Qté</th>
                                    <th>Entrepôt</th>
                                    <th>Enregistré par</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($encours as $key => $perte) {
                                    $perte->actualise(); 
                                    ?>
                                    <tr style="border-bottom: 2px solid black">
                                        <td class="project-status">
                                            <span class="label label-<?= $perte->etat->class ?>"><?= $perte->etat->name ?></span>
                                        </td>
                                        <td>
                                            <span class="text-uppercase gras">Perte par <?= $perte->typeperte->name() ?></span><br>
                                            <small><?= $perte->comment ?></small>
                                        </td>
                                        <td><b><?= $perte->name() ?></b></td>
                                        <td><?= start0($perte->quantite) ?> <?= $perte->typeproduit_parfum->typeproduit->abbr ?></td>
                                        <td>
                                            <h6 class="text-uppercase text-muted gras" style="margin: 0"><?= $perte->entrepot->name() ?></h6>
                                        </td>
                                        <td><i class="fa fa-user"></i> <?= $perte->employe->name() ?></td>
                                        <td>
                                            <a href="<?= $this->url("boutique", "fiches", "bonmiseenboutique", $perte->id) ?>" target="_blank" class="btn btn-white btn-sm"><i class="fa fa-file-text text-blue"></i></a>
                                            <?php if ($perte->etat_id == Home\ETAT::PARTIEL) { ?>
                                                <button onclick="accepter(<?= $perte->id ?>)" class="btn btn-white btn-sm text-green"><i class="fa fa-check"></i> Accepter</button>
                                            <?php } ?>
                                            <?php if ($employe->isAutoriser("modifier-supprimer")) { ?>
                                                <button onclick="annulerMiseenboutique(<?= $perte->id ?>)" class="btn btn-white btn-sm"><i class="fa fa-close text-red"></i></button>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                <?php  } ?>
                                <tr />
                                <?php foreach ($datas as $key => $perte) {
                                    $perte->actualise(); 
                                    ?>
                                    <tr style="border-bottom: 2px solid black">
                                        <td class="project-status">
                                            <span class="label label-<?= $perte->etat->class ?>"><?= $perte->etat->name ?></span>
                                        </td>
                                        <td>
                                            <span class="text-uppercase gras">Perte par <?= $perte->typeperte->name() ?></span><br>
                                            <small><?= $perte->comment ?></small>
                                        </td>
                                        <td><b><?= $perte->name() ?></b></td>
                                        <td><?= start0($perte->quantite) ?> <?= $perte->typeproduit_parfum->typeproduit->abbr ?></td>
                                        <td>
                                            <h6 class="text-uppercase text-muted gras" style="margin: 0"><?= $perte->entrepot->name() ?></h6>
                                            <small>Emise <?= depuis($perte->created) ?></small>
                                        </td>
                                        <td><i class="fa fa-user"></i> <?= $perte->employe->name() ?></td>
                                        <td>
                                            <a href="<?= $this->url("boutique", "fiches", "bonmiseenboutique", $perte->id) ?>" target="_blank" class="btn btn-white btn-sm"><i class="fa fa-file-text text-blue"></i></a>
                                        </td>
                                    </tr>
                                <?php  } ?>

                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="5">
                                        <ul class="pagination float-right"></ul>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>

                    <?php }else{ ?>
                        <h1 style="margin: 6% auto;" class="text-center text-muted"><i class="fa fa-folder-open-o fa-3x"></i> <br> Aucun conditionnement pour le moment</h1>
                    <?php } ?>

                </div>
            </div>
        </div>


        <?php include($this->rootPath("webapp/entrepot/elements/templates/footer.php")); ?> 

        <?php foreach (Home\TYPEPRODUIT_PARFUM::findBy(["isActive ="=>Home\TABLE::OUI]) as $key => $pro) {
            $qua = $pro->enStock(Home\PARAMS::DATE_DEFAULT, dateAjoute(1), $pro->id, $entrepot->id);
            if ($qua > 0) { include($this->rootPath("composants/assets/modals/modal-conditionnement.php")); } 
        }  ?>
    </div>
</div>


<?php include($this->rootPath("webapp/entrepot/elements/templates/script.php")); ?>
<script type="text/javascript" src="<?= $this->rootPath("webapp/boutique/modules/master/client/script.js") ?>"></script>


</body>

</html>
