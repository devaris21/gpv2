<!DOCTYPE html>
<html>

<?php include($this->rootPath("webapp/master/elements/templates/head.php")); ?>

<body class="top-navigation">

    <div id="wrapper">
        <div id="page-wrapper" class="gray-bg">
            <div class="row border-bottom white-bg">
                <nav class="navbar navbar-expand-lg navbar-static-top" role="navigation">
                    <!--<div class="navbar-header">-->
                        <!--<button aria-controls="navbar" aria-expanded="false" data-target="#navbar" data-toggle="collapse" class="navbar-toggle collapsed" type="button">-->
                            <!--<i class="fa fa-reorder"></i>-->
                            <!--</button>-->

                            <a href="#" class="navbar-brand " style="padding: 3px 15px;"><h1 class="mp0 gras" style="font-size: 45px">GPV</h1></a>
                            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-label="Toggle navigation">
                                <i class="fa fa-reorder"></i>
                            </button>

                            <!--</div>-->
                            <div class="navbar-collapse collapse" id="navbar">
                                <ul class="nav navbar-nav mr-auto">
                                    <li class="gras <?= (isJourFerie(dateAjoute(1)))?"text-red":"text-muted" ?>">
                                        <span class="m-r-sm welcome-message text-uppercase" id="date_actu"></span> 
                                        <span class="m-r-sm welcome-message gras" id="heure_actu"></span> 
                                    </li>

                                </ul>
                                <ul class="nav navbar-top-links navbar-right">
                                    <li id="btn-deconnexion" class="text-red cursor">
                                        <a href="<?= $this->url("config", "master", "dashboard"); ?>" class="btn_modal btn btn-xs btn-white" >
<< Retour à la vue générale
</a>
                                    </li>
                                </ul>
                            </div>
                        </nav>
                    </div>

                    <br>
                    <div class="wrapper-content">
                        <div class="animated fadeInRightBig container-fluid">

                            <div class="row">
                                <div class="col-sm-6 bloc">
                                    <div class="ibox border">
                                        <div class="ibox-title">
                                            <h5 class="text-uppercase">Opérations d'entrée de caisse</h5>
                                            <div class="ibox-tools">
                                                <a class="btn_modal" data-toggle="modal" data-target="#modal-categorieoperation">
                                                    <i class="fa fa-plus"></i> Ajouter
                                                </a>
                                            </div>
                                        </div>
                                        <div class="ibox-content">
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th><i class="fa fa-ticket"></i></th>
                                                        <th>Libéllé</th>
                                                        <th>Type</th>
                                                        <th></th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $i =0; foreach (Home\CATEGORIEOPERATION::findBy(["typeoperationcaisse_id ="=>Home\TYPEOPERATIONCAISSE::ENTREE], [], ["typeoperationcaisse_id"=>"ASC", "name"=>"ASC"]) as $key => $item) {
                                                        $item->actualise();
                                                        $i++; ?>
                                                        <tr>
                                                            <td><?= $i ?></td>
                                                            <td><div class="border" style="width: 20px; height: 20px; background-color: <?= $item->color ?>"></div></td>
                                                            <td class="gras"><?= $item->name(); ?></td>
                                                            <td class="gras text-<?= ($item->typeoperationcaisse_id == Home\TYPEOPERATIONCAISSE::ENTREE)?"green":"red"  ?>"><?= $item->typeoperationcaisse->name(); ?></td>
                                                            <td data-toggle="modal" data-target="#modal-categorieoperation" title="modifier la categorie" onclick="modification('categorieoperation', <?= $item->id ?>)"><i class="fa fa-pencil text-blue cursor"></i></td>
                                                            <td title="supprimer la categorie" onclick="suppressionWithPassword('categorieoperation', <?= $item->id ?>)"><i class="fa fa-close cursor text-danger"></i></td>
                                                        </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div><hr>

                                    <div class="">
                                        <form method="POST" class="formShamman" classname="params" reload="false">
                                            <div class="row">
                                                <div class="col-sm-8 text-center border-right">
                                                    <div class="row">
                                                        <div class="col-7 gras">Autoriser Versements en attente</div>
                                                        <div class="offset-1"></div>
                                                        <div class="col-4">
                                                            <div class="switch d-block">
                                                                <div class="onoffswitch">
                                                                    <input type="checkbox" name="autoriserVersementAttente" <?= ($params->autoriserVersementAttente == "on")?"checked":""  ?> class="onoffswitch-checkbox" id="example2">
                                                                    <label class="onoffswitch-label" for="example2">
                                                                        <span class="onoffswitch-inner"></span>
                                                                        <span class="onoffswitch-switch"></span>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div >
                                                        <label>% tva sur les ventes</label>
                                                        <input type="number" number class="form-control" name="tva" value="<?= $params->tva ?>">
                                                    </div><br>
                                                    <div>
                                                        <label>Seuil de tolérance du crédit client </label>
                                                        <input type="number" number class="form-control" name="seuilCredit" value="<?= $params->seuilCredit ?>">
                                                    </div>
                                                    <div>
                                                        <br>
                                                        <input type="hidden" name="id" value="<?= $params->id ?>">
                                                        <button class="btn btn-primary dim "><i class="fa fa-check"></i> Mettre à jour</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                                <div class="col-sm-6 bloc">
                                    <div class="ibox border">
                                        <div class="ibox-title">
                                            <h5 class="text-uppercase">Opérations de sortie de caisse</h5>
                                            <div class="ibox-tools">
                                                <a class="btn_modal" data-toggle="modal" data-target="#modal-categorieoperation">
                                                    <i class="fa fa-plus"></i> Ajouter
                                                </a>
                                            </div>
                                        </div>
                                        <div class="ibox-content">
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th><i class="fa fa-ticket"></i></th>
                                                        <th>Libéllé</th>
                                                        <th>Type</th>
                                                        <th></th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $i =0; foreach (Home\CATEGORIEOPERATION::findBy(["typeoperationcaisse_id ="=>Home\TYPEOPERATIONCAISSE::SORTIE], [], ["typeoperationcaisse_id"=>"ASC", "name"=>"ASC"]) as $key => $item) {
                                                        $item->actualise();
                                                        $i++; ?>
                                                        <tr>
                                                            <td><?= $i ?></td>
                                                            <td><div class="border" style="width: 20px; height: 20px; background-color: <?= $item->color ?>"></div></td>
                                                            <td class="gras"><?= $item->name(); ?></td>
                                                            <td class="gras text-<?= ($item->typeoperationcaisse_id == Home\TYPEOPERATIONCAISSE::ENTREE)?"green":"red"  ?>"><?= $item->typeoperationcaisse->name(); ?></td>
                                                            <td data-toggle="modal" data-target="#modal-categorieoperation" title="modifier la categorie" onclick="modification('categorieoperation', <?= $item->id ?>)"><i class="fa fa-pencil text-blue cursor"></i></td>
                                                            <td title="supprimer la categorie" onclick="suppressionWithPassword('categorieoperation', <?= $item->id ?>)"><i class="fa fa-close cursor text-danger"></i></td>
                                                        </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <br>

                    <?php include($this->rootPath("webapp/master/elements/templates/footer.php")); ?>


                </div>
            </div>


            <?php include($this->rootPath("webapp/master/elements/templates/script.php")); ?>

            <?php include($this->rootPath("composants/assets/modals/modal-params.php") );  ?>


        </body>



        </html>