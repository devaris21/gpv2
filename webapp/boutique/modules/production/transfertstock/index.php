<!DOCTYPE html>
<html>

<?php include($this->rootPath("webapp/boutique/elements/templates/head.php")); ?>


<body class="fixed-sidebar">

    <div id="wrapper">

        <?php include($this->rootPath("webapp/boutique/elements/templates/sidebar.php")); ?>  

        <div id="page-wrapper" class="gray-bg">

            <?php include($this->rootPath("webapp/boutique/elements/templates/header.php")); ?>  

            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-sm-9">
                    <h2 class="text-uppercase text-blue gras">Les transferts de stock en boutique</h2>
                    <div class="container">
                    </div>
                </div>
                <div class="col-sm-3 text-right">
                </div>
            </div>

            <div class="wrapper wrapper-content">
                <div class="ibox">
                    <div class="ibox-title">
                        <h5>Toutes les transferts de stock survenues dans cette boutique</h5>
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
                    <?php if (count($datas) > 0) { ?>
                        <table class="footable table table-stripped toggle-arrow-tiny">
                            <thead>
                                <tr>

                                    <th data-toggle="true">Status</th>
                                    <th>Produit</th>
                                    <th>Source</th>
                                    <th></th>
                                    <th>Final</th>
                                    <th>Entrepôt</th>
                                    <th>Enregistré par</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($datas as $key => $transfert) {
                                    $transfert->actualise(); 
                                    ?>
                                    <tr style="border-bottom: 2px solid black">
                                        <td>
                                            <span class="text-uppercase gras">Transfert de stock</span><br>
                                            <small>Enregistré <?= depuis($transfert->created)  ?></small>
                                        </td>
                                        <td><b><?= $transfert->produit->name() ?></b></td>
                                        <td class="">
                                            <span><?= start0($transfert->quantite)  ?></span><br>
                                            <small class="text-uppercase gras"><img style="width: 20px;" src="<?= $this->stockage("images", "emballages", $transfert->emballage_source->image) ?>"> <?= $transfert->emballage_source->name() ?></small>
                                        </td>
                                        <td><i class="fa fa-long-arrow-right fa-2x"></i></td>
                                        <td class="">
                                            <span class=""><?= start0($transfert->quantite2)  ?></span><br>
                                            <small class="text-uppercase gras"><img style="width: 20px;" src="<?= $this->stockage("images", "emballages", $transfert->emballage_destination->image) ?>"> <?= $transfert->emballage_destination->name() ?></small>
                                        </td>
                                        <td>
                                            <h6 class="text-uppercase text-muted gras" style="margin: 0"><?= $transfert->boutique->name() ?></h6>
                                        </td>
                                        <td><i class="fa fa-user"></i> <?= $transfert->employe->name() ?></td>
                                        <td>
                                            <?php if ($employe->isAutoriser("modifier-supprimer")) { ?>
                                                <button onclick="annulerTransfert(<?= $transfert->id ?>)" class="btn btn-white btn-sm"><i class="fa fa-close text-red"></i></button>
                                            <?php } ?>
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
                        <h1 style="margin: 6% auto;" class="text-center text-muted"><i class="fa fa-folder-open-o fa-3x"></i> <br> Aucun transfert pour le moment</h1>
                    <?php } ?>

                </div>
            </div>
        </div>


        <?php include($this->rootPath("webapp/boutique/elements/templates/footer.php")); ?> 

        <?php foreach (Home\TYPEPRODUIT_PARFUM::findBy(["isActive ="=>Home\TABLE::OUI]) as $key => $pro) {
            $qua = $pro->enStock(Home\PARAMS::DATE_DEFAULT, dateAjoute(1), $pro->id, $boutique->id);
            if ($qua > 0) { include($this->rootPath("composants/assets/modals/modal-conditionnement.php")); } 
        }  ?>
    </div>
</div>


<?php include($this->rootPath("webapp/boutique/elements/templates/script.php")); ?>
<script type="text/javascript" src="<?= $this->rootPath("webapp/boutique/modules/master/client/script.js") ?>"></script>


</body>

</html>
