<!DOCTYPE html>
<html>

<?php include($this->rootPath("webapp/manager/elements/templates/head.php")); ?>


<body class="fixed-sidebar">

    <div id="wrapper">

        <?php include($this->rootPath("webapp/manager/elements/templates/sidebar.php")); ?>  

        <div id="page-wrapper" class="gray-bg">

          <?php include($this->rootPath("webapp/manager/elements/templates/header.php")); ?>  

          <div class="row wrapper border-bottom white-bg page-heading">
            <div class="col-sm-9">
                <h2 class="text-uppercase text-green gras">Les commandes en cours</h2>
                <div class="container">

                </div>
            </div>
            <div class="col-sm-3">
<!--                 <button style="margin-top: 5%;" type="button" data-toggle=modal data-target='#modal-clients' class="btn btn-primary btn-sm dim float-right"><i class="fa fa-plus"></i> Nouvelle commande </button>
 -->
            </div>
        </div>

        <div class="wrapper wrapper-content">
            <div class="ibox">
                <div class="ibox-title">
                    <h5>Toutes les commandes</h5>
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
                    <?php if (count($groupes + $encours) > 0) { ?>
                        <table class="footable table table-stripped toggle-arrow-tiny">
                            <thead>
                                <tr>
                                    <th data-toggle="true">Status</th>
                                    <th>Reference</th>
                                    <th>Boutique</th>
                                    <th>Reste</th>
                                    <th>Client</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($encours as $key => $groupe) {
                                    $groupe->actualise(); 
                                    $datas = $groupe->fourni("commande", ["etat_id != "=>Home\ETAT::ANNULEE]);
                                    $datas1 = $groupe->fourni("prospection", ["etat_id > "=>Home\ETAT::ANNULEE, "etat_id < "=>Home\ETAT::VALIDEE]);
                                    ?>
                                    <tr style="border-bottom: 2px solid black">
                                        <td class="project-status">
                                            <span class="label label-<?= $groupe->etat->class ?>"><?= $groupe->etat->name() ?></span>
                                        </td>
                                        <td>
                                            <span class="text-uppercase gras">Commande (<?= count($groupe->fourni("commande")) ?>)</span><br>
                                            <span><?= depuis($groupe->created) ?></span>
                                            <?php if (count($datas1) > 0) { ?>
                                                <p class="text-blue">(<?= count($datas1) ?>) livraison(s) en cours/programmée pour cette commande</p>
                                            <?php } ?>
                                        </td>
                                        <td>
                                            <h5 class="text-uppercase"><?= $groupe->boutique->name() ?></h5>
                                        </td>
                                        <td>
                                            <h3 class="gras text-orange"><?= money($groupe->resteAPayer()) ?> <?= $params->devise  ?></h3>
                                        </td>
                                         <td>
                                            <h5 class="text-uppercase"><a href="<?= $this->url("manager", "master", "client", $groupe->client_id)  ?>"><?= $groupe->client->name() ?></a></h5>
                                        </td>
                                        <td>
                                            <button onclick="fichecommande(<?= $groupe->id  ?>)" class="btn btn-white btn-sm "><i class="fa fa-plus"></i> de détails </button>
                                        </td>
                                    </tr>
                                <?php  } ?>

                                <tr />

                                <?php foreach ($groupes as $key => $groupe) {
                                    $groupe->actualise(); 
                                    $datas = $groupe->fourni("commande", ["etat_id != "=>Home\ETAT::ANNULEE]);
                                    $datas1 = $groupe->fourni("prospection", ["etat_id > "=>Home\ETAT::ANNULEE, "etat_id < "=>Home\ETAT::VALIDEE]);
                                    ?>
                                    <tr style="border-bottom: 2px solid black">
                                        <td class="project-status">
                                            <span class="label label-<?= $groupe->etat->class ?>"><?= $groupe->etat->name() ?></span>
                                        </td>
                                        <td>
                                            <span class="text-uppercase gras">Commande (<?= count($groupe->fourni("commande")) ?>)</span><br>
                                            <span><?= depuis($groupe->created) ?></span>
                                            <?php if (count($datas1) > 0) { ?>
                                                <p class="text-blue">(<?= count($datas1) ?>) livraison(s) en cours/programmée pour cette commande</p>
                                            <?php } ?>
                                        </td>
                                        <td>
                                            <h5 class="text-uppercase"><?= $groupe->boutique->name() ?></h5>
                                        </td>
                                        <td>
                                            <h3 class="gras text-orange"><?= money($groupe->resteAPayer()) ?> <?= $params->devise  ?></h3>
                                        </td>
                                        <td>
                                            <h5 class="text-uppercase"><a href="<?= $this->url("manager", "master", "client", $groupe->client_id)  ?>"><?= $groupe->client->name() ?></a></h5>
                                        </td>
                                        <td>
                                            <button onclick="fichecommande(<?= $groupe->id  ?>)" class="btn btn-white btn-sm "><i class="fa fa-plus"></i> de détails </button>
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
                        <h1 style="margin-top: 30% auto;" class="text-center text-muted aucun"><i class="fa fa-folder-open-o fa-3x"></i> <br> Aucune commande en cours pour le moment !</h1>
                    <?php } ?>

                </div>
            </div>
        </div>


        <?php include($this->rootPath("webapp/manager/elements/templates/footer.php")); ?> 

    </div>
</div>


<?php include($this->rootPath("composants/assets/modals/modal-clients.php")); ?> 
<?php include($this->rootPath("composants/assets/modals/modal-client.php")); ?> 


<?php include($this->rootPath("webapp/manager/elements/templates/script.php")); ?>
<script type="text/javascript" src="<?= $this->relativePath("../../master/client/script.js") ?>"></script>


</body>

</html>
