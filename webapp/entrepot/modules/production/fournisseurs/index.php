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
                <h2 class="text-uppercase text-green gras">Liste des fournisseurs</h2>
            </div>
            <div class="col-sm-3">
               <button data-toggle="modal" data-target="#modal-fournisseur" style="margin-top: 5%" class="btn btn-primary dim"><i class="fa fa-plus"></i> Nouveau fournisseur</button>
        </div>
    </div>

    <div class="wrapper wrapper-content">
        <div class="ibox">
            <div class="ibox-title">
                <h5>Tous les fournisseurs (<?= start0(count($fournisseurs)) ?>)</h5>
            </div>
            <div class="ibox-content">
               <?php if (count($fournisseurs) > 0) { ?>
                <table class="table table-hover issue-tracker">
                    <tbody>
                        <tr>
                            <?php foreach ($fournisseurs as $key => $fournisseur) { ?>
                                <td ><img style="width: 60px" src="<?= $this->stockage("images", "fournisseurs", $fournisseur->image); ?>"></td>
                                <td class="issue-info">
                                    <a><?= $fournisseur->name()  ?></a>
                                    <small><?= $fournisseur->description ?></small>
                                </td>
                                <td>
                                    <?= $fournisseur->adresse ?><br>
                                    <?= $fournisseur->email ?>
                                </td>
                                <td>
                                    <?= $fournisseur->contact ?><br>
                                    <?= $fournisseur->fax ?>
                                </td>
                                <td class="text-right">
                                    <a href="<?= $this->url("gestion", "production", "fournisseur", $fournisseur->id)  ?>" class="btn btn-white btn-xs"><i class="fa fa-eye"></i> Voir le compte</a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            <?php }else{ ?>
                <h1 style="margin: 6% auto;" class="text-center text-muted"><i class="fa fa-folder-open-o fa-3x"></i> <br> Aucun fournisseur pour le moment</h1>
            <?php } ?>

        </div>
    </div>
</div>


<?php include($this->rootPath("webapp/entrepot/elements/templates/footer.php")); ?> 

 <?php include($this->rootPath("composants/assets/modals/modal-fournisseur.php")); ?> 

</div>
</div>



<?php include($this->rootPath("webapp/entrepot/elements/templates/script.php")); ?>
<script type="text/javascript" src="<?= $this->relativePath("../../master/client/script.js") ?>"></script>


</body>

</html>
