<!DOCTYPE html>
<html>

<?php include($this->rootPath("webapp/master/elements/templates/head.php")); ?>


<body class="fixed-sidebar">

    <div id="wrapper">

        <?php include($this->rootPath("webapp/master/elements/templates/sidebar.php")); ?>  

        <div id="page-wrapper" class="gray-bg">

          <?php include($this->rootPath("webapp/master/elements/templates/header.php")); ?>  

          <div class="row wrapper border-bottom white-bg page-heading">
            <div class="col-sm-9">
                <h2 class="text-uppercase text-green gras">Liste de vos commerciaux</h2>
                <div class="container">
                  <!--   <div class="row">
                        <div class="col-xs-7 gras ">Afficher même les rangements passées</div>
                        <div class="offset-1"></div>
                        <div class="col-xs-4">
                            <div class="switch">
                                <div class="onoffswitch">
                                    <input type="checkbox" class="onoffswitch-checkbox" id="example1">
                                    <label class="onoffswitch-label" for="example1">
                                        <span class="onoffswitch-inner"></span>
                                        <span class="onoffswitch-switch"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div> -->
                </div>
            </div>
            <div class="col-sm-3">
             <div class="row">
                <div class="col-md-12">
                    <div class="widget style1 lazur-bg">
                        <div class="row">
                            <div class="col-3">
                                <i class="fa fa-th-large fa-3x"></i>
                            </div>
                            <div class="col-9 text-right">
                                <span> Total des commerciaux </span>
                                <h2 class="font-bold"><?= start0(count($commerciaux))  ?></h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="wrapper wrapper-content">
        <div class="ibox">
            <div class="ibox-title">
                <h5>Liste de vos commerciaux</h5>
                <div class="ibox-tools">
                    <button data-toggle="modal" data-target="#modal-commercial" style="margin-top: -5%" class="btn btn-primary btn-xs dim"><i class="fa fa-plus"></i> Nouveau commercial</button>
                </div>
            </div>
            <div class="ibox-content">
                <?php if (count($commerciaux) > 0) { ?>
                <table class="table table-hover ">
                    <tbody>
                        <tr>
                            <?php foreach ($commerciaux as $key => $commercial) {
                            $commercial->actualise() ?>
                                <td ><img style="width: 50px" src="<?= $this->stockage("images", "commercials", $commercial->image); ?>"></td>
                                <td class="">
                                    <a class="gras"><?= $commercial->name()  ?></a><br>
                                    <small><?= $commercial->adresse ?></small>
                                </td>
                                <td>
                                    <?= $commercial->nationalite ?><br>
                                    <?= $commercial->sexe->name() ?>
                                </td>
                                <td>
                                    <?= $commercial->contact ?><br>
                                </td>
                                <td><label class="label label-<?= $commercial->disponibilite->class ?>"><?= $commercial->disponibilite->name() ?></label></td>
                                <td class="text-right">
                                    <a href="<?= $this->url("gestion", "master", "commercial", $commercial->id)  ?>" class="btn btn-white btn-xs"><i class="fa fa-eye"></i> Voir le compte</a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            <?php }else{ ?>
                <h1 style="margin: 6% auto;" class="text-center text-muted"><i class="fa fa-folder-open-o fa-3x"></i> <br> Aucun commercial pour le moment</h1>
            <?php } ?>

        </div>
    </div>
</div>


<?php include($this->rootPath("webapp/master/elements/templates/footer.php")); ?> 

<?php include($this->rootPath("composants/assets/modals/modal-commercial.php")); ?> 

</div>
</div>



<?php include($this->rootPath("webapp/master/elements/templates/script.php")); ?>
<script type="text/javascript" src="<?= $this->relativePath("../../master/client/script.js") ?>"></script>


</body>

</html>
