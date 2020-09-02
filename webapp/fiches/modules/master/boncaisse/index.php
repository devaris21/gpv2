<!DOCTYPE html>
<html>

<?php include($this->rootPath("webapp/manager/elements/templates/head.php")); ?>


<body class="top-navigation">

    <div id="wrapper">

          

        <div id="page-wrapper" class="gray-bg">

           

          <div class="wrapper wrapper-content animated fadeInRight article">
            <div class="row justify-content-md-center">
                <div class="col-lg-10">
                    <div class="ibox" >
                        <div class="ibox-content border"  style="background-color: #fcfcfc">
                            <div class="facture">
                                <div class="row">
                                    <div class="col-sm-5">
                                        <div class="row">
                                            <div class="col-3">
                                                <img style="width: 120%" src="<?= $this->stockage("images", "societe", $params->image) ?>">
                                            </div>
                                            <div class="col-9">
                                                <h5 class="gras text-uppercase text-orange"><?= $params->societe ?></h5>
                                                <h5 class="mp0"><?= $params->adresse ?></h5>
                                                <h5 class="mp0"><?= $params->postale ?></h5>
                                                <h5 class="mp0">Tél: <?= $params->contact ?></h5>
                                                <h5 class="mp0">Email: <?= $params->email ?></h5>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-7 text-right">
                                        <h2 class="title text-uppercase gras text-blue">Bon de caisse</h2>
                                        <h3 class="text-uppercase">N°<?= $mouvement->reference ?></h3>
                                        <h5><?= datelong($mouvement->created) ?></h5>  
                                        <h4><small>Bon délivré par :</small> <span class="text-uppercase"><?= $mouvement->employe->name() ?></span></h4>                                
                                    </div>
                                </div><hr class="mp3">

                                <br>
                                <div style="margin: auto 5%;">
                                    <div class="row" style="margin-top: 1%;">
                                        <div class="col-6">
                                            <br>
                                            <span class="text-uppercase gras">Opération par <?= $mouvement->modepayement->name() ?></span>
                                        </div>
                                        <div class="col-6 text-right">
                                            <span>Montant :</span> <span class="prix text-uppercase"><?= money($mouvement->montant) ?> <?= $params->devise ?></span>
                                        </div>
                                    </div><br><br>

                                    <div class="text">
                                        <span>Opération de <i><?= $mouvement->typemouvement->name() ?> N°<?= $mouvement->reference ?></i> d'un montant de</span> <span class="lettre text-capitalize"><?= enLettre($mouvement->montant) ?> <?= $params->devise  ?></span><br>
                                        <span>pour <i><?= $mouvement->comment ?></i>.</span>
                                        <p class="m-b-xs"><?= $mouvement->structure ?> - <?= $mouvement->numero ?></p><br>
                                    </div>

                                    <br><br>

                                    <div class="row">
                                        <div class="col-6">
                                            <div class="text-left" style="height: 120px">
                                                <span><u>Signature du bénéficiaire</u></span>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="text-right" style="height: 120px">
                                                <span><u>Signature & Cachet</u></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <p class="text-center"><small><i>* Aucun remboursement n'est admis après réglement !</i></small></p>
                            </div><br><hr><br>

                            <div class="facture2">

                            </div>
                        </div>
                    </div>

                </div>
            </div>


        </div>


        <?php include($this->rootPath("webapp/manager/elements/templates/footer.php")); ?>


    </div>
</div>


<?php include($this->rootPath("webapp/manager/elements/templates/script.php")); ?>

<button class="btn btn-outline-primary btn-rounded btn-xs d-print-none" onclick="window.print()" style="position: fixed; bottom: 8%; right: 2%; z-index: 8000"><i class="fa fa-print"></i> Imprimer la fiche</button>

</body>

</html>
