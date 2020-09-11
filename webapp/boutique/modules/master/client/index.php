<!DOCTYPE html>
<html>

<?php include($this->rootPath("webapp/boutique/elements/templates/head.php")); ?>


<body class="fixed-sidebar">

  <div id="wrapper">

    <?php include($this->rootPath("webapp/boutique/elements/templates/sidebar.php")); ?>  

    <div id="page-wrapper" class="gray-bg">

      <?php include($this->rootPath("webapp/boutique/elements/templates/header.php")); ?>  

      <div class="wrapper wrapper-content  animated fadeInRight">
        <div class="row">
          <div class="col-sm-8">
            <div class="ibox">
              <div class="ibox-content">
                <p></p>
                <div class="">                                
                 <ul class="nav nav-tabs">
                  <li><a class="nav-link active" data-toggle="tab" href="#tab-1"><i class="fa fa-user"></i> Les commandes en cours</a></li>
                  <li><a class="nav-link" data-toggle="tab" href="#tab-3"><i class="fa fa-money"></i> Transactions de caisse</a></li>
                </ul>
                <div class="tab-content" style="min-height: 300px;">



                 <?php if ($employe->isAutoriser("production")) { ?>

                  <div id="tab-1" class="tab-pane active"><br>
                    <div class="row container-fluid">
                      <button type="button" <?= (count($encours) > 0)?" onclick='newcommande()' ": "data-toggle=modal data-target='#modal-newcommande'" ?>  class="btn btn-primary btn-sm dim float-right"><i class="fa fa-plus"></i> Nouvelle commande </button>
                    </div>
                    <div class="">
                      <div class="ibox-content">
                        <?php if (count($groupes + $encours) > 0) { ?>
                          <table class="footable table table-stripped toggle-arrow-tiny">
                            <thead>
                              <tr>
                                <th data-toggle="true">Status</th>
                                <th>Reference</th>
                                <th>Boutique</th>
                                <th>Reste</th>
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

<!--                               <div id="tab-2" class="tab-pane">
                                <div class="ibox-content inspinia-timeline">
                                    <?php foreach ($flux as $key => $transaction) { ?>
                                        <div class="timeline-item">
                                            <div class="row">
                                                <div class="col-2 date" style="padding-right: 1%; padding-left: 1%;">
                                                    <i data-toggle="tooltip" tiitle="Imprimer le bon de <?= $transaction->type  ?> " class="fa fa-file-text"></i>
                                                    <?= heurecourt($transaction->created) ?>
                                                    <br/>
                                                    <small class="text-navy"><?= datecourt($transaction->created) ?></small>
                                                </div>
                                                <div class="col-10 content">
                                                    <p class="m-b-xs text-uppercase"><?= $transaction->type ?> N°<strong><?= $transaction->reference ?></strong></p>
                                                    <table class="table table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <?php foreach ($transaction->items as $key => $ligne) {
                                                                    $ligne->actualise();  ?>
                                                                    <th class="text-center text-uppercase"><small class="gras"><?= $ligne->prixdevente->produit->name() ?></small><br> <small><?= $ligne->prixdevente->quantite->name() ?></small></th>
                                                                <?php } ?>
                                                                <th class="text-center mp0" style="background-color: transparent; border: none">
                                                                    <?php if ($transaction->type == "commande") { ?>
                                                                       <a target="_blank" href="<?= $this->url("fiches", "master", "boncommande", $transaction->id)  ?>" target="_blank" class="simple_tag"><i class="fa fa-file-text-o"></i> Bon de commande</a>
                                                                   <?php }else{ ?>
                                                                    <a target="_blank" href="<?= $this->url("fiches", "master", "bonlivraison", $transaction->id)  ?>" target="_blank" class="simple_tag"><i class="fa fa-file-text-o"></i> Bon de livraison</a>
                                                                <?php } ?>
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <?php 
                                                            foreach ($transaction->items as $key => $ligne) {
                                                                $ligne->actualise() ?>
                                                                <td><h5 class="text-<?= ($transaction->type == "prospection")? "orange":"green" ?> text-center"> <?= start0(($transaction->type == "prospection")? $ligne->quantite_vendu: $ligne->quantite) ?> </h5></td>
                                                            <?php  } ?>

                                                            <?php if ($transaction->type == "commande" && $transaction->reglementclient_id != 0) { ?>
                                                                <td>
                                                                    <small>Montant de la commande</small>
                                                                    <h4 class="mp0 text-uppercase" style="margin-top: -1.5%;"><?= money($transaction->montant) ?> <?= $params->devise  ?> 
                                                                    <?php if ($transaction->reglementclient_id != 0) { ?>
                                                                        <small style="font-weight: normal;;" data-toggle="tooltip" title="Payement par <?= $transaction->reglementclient->modepayement->name();  ?>">(<?= $transaction->reglementclient->modepayement->initial;  ?>)</small>
                                                                    <?php } ?>   
                                                                </h4>
                                                            </td>
                                                            <td class="text-center" data-toggle="tooltip" title="imprimer le facture">
                                                                <?php if ($employe->isAutoriser("caisse")) { ?>
                                                                    <a target="_blank" href="<?= $this->url("fiches", "master", "boncaisse", $transaction->id) ?>"><i class="fa fa-file-text fa-2x"></i></a>
                                                                <?php } ?>       
                                                            </td>
                                                        <?php }  ?>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>                                      
                        </div>

                      </div> -->
                    <?php } ?>


                    <div id="tab-3" class="tab-pane"><br>
                      <?php foreach ($fluxcaisse as $key => $transaction) {
                        $transaction->actualise(); ?>
                        <div class="timeline-item">
                          <div class="row">
                            <div class="col-2 date" style="padding-right: 1%; padding-left: 1%;">
                              <i data-toggle="tooltip" tiitle="Imprimer le bon de <?= $transaction->type  ?> " class="fa fa-file-text"></i>
                              <?= heurecourt($transaction->created) ?>
                              <br/>
                              <small class="text-navy"><?= datecourt($transaction->created) ?></small>
                            </div>
                            <div class="col-10 content">
                              <div>
                                <span class="">Reglement N°<strong><?= $transaction->reference ?></strong></span>
                                <span class="pull-right text-right text-green">
                                  <span class="gras" style="font-size: 16px"><?= money($transaction->montant) ?> <?= $params->devise ?> <?= ($transaction->etat_id == Home\ETAT::ENCOURS)?"*":"" ?></span> <br>
                                  <small>Par <?= $transaction->modepayement->name() ?></small><br>
                                  <?php if ($transaction->mouvement_id != null) { ?>
                                    <a href="<?= $this->url("fiches", "master", "boncaisse", $transaction->mouvement_id)  ?>" target="_blank" class="simple_tag"><i class="fa fa-file-text-o"></i> Bon de caisse</a>
                                  <?php } ?>
                                </span>
                              </div>
                              <p class="m-b-xs mp0"><?= $transaction->comment ?> </p>
                              <p class="m-b-xs"><?= $transaction->structure ?> - <?= $transaction->numero ?></p>
                            </div>
                          </div>
                        </div>
                      <?php } ?>                 
                    </div>


                  </div>

                </div>
              </div>
            </div>
          </div>

          <div class="col-sm-4">
            <div class="ibox selected">

              <div class="ibox-content">
                <div class="tab-content">

                  <div>
                    <?php Native\BINDING::html("select-tableau", $boutique->fourni("client"), $client, "id") ?>
                  </div><hr>



                  <div id="contact-1" class="tab-pane active">
                    <h2><?= $client->name() ?> 

                    <i onclick="modification('client', <?= $client->id ?>)" data-toggle="modal" data-target="#modal-client" class="pull-right fa fa-pencil cursor"></i>
                  </h2>
                  <h4><?= $client->typeclient->name() ?></h4>
                  <address>
                    <i class="fa fa-phone"></i>&nbsp; <?= $client->contact ?><br>
                    <i class="fa fa-map-marker"></i>&nbsp; <?= $client->adresse ?><br>
                    <i class="fa fa-envelope"></i>&nbsp; <?= $client->email ?>
                  </address><hr>

                  <div class="m-b-lg">
                    <span>Acompte actuel du client</span><br>
                    <h2 class="font-bold d-inline"><?= money($client->acompte) ?> <?= $params->devise  ?></h2> 
                    <button data-toggle="modal" data-target="#modal-acompte" class="cursor simple_tag pull-right"><i class="fa fa-plus"></i> Crediter acompte</button><br><br>

                    <?php if ($client->acompte > 0) { ?>
                      <button type="button" data-toggle="modal" data-target="#modal-rembourser" class="btn btn-danger dim btn-block"><i
                        class="fa fa-minus"></i> Rembourser le client
                      </button>
                    <?php } ?>

                    <hr>

                    <span>Dette actuelle du client</span><br>
                    <h2 class="font-bold d-inline text-red"><?= money($client->resteAPayer()) ?> <?= $params->devise  ?></h2> 
                    <?php if ($client->resteAPayer() > 0) { ?>
                      <button onclick="reglerToutesDettes(<?= $client->id ?>)" class="btn btn-xs dim btn-outline-danger pull-right"><i class="fa fa-money"></i> Régler toutes les dettes</button>
                    <?php } ?>                   

                  </div>

                </div>

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>



    <div class="modal inmodal fade" id="modal-listecommande">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            <h4 class="modal-title">Choisir la commande</h4>
            <span>Double-cliquez pour selectionner la commande voulue !</span>
          </div>
            <div class="modal-body">
              <table class="table table-commande">
                <thead>
                  <tr>
                    <th>Reference</th>
                    <th>Boutique</th>
                    <th>Reste</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($encours as $key => $groupe) {
                    $groupe->actualise(); ?>
                    <tr class="cursor" style="border-bottom: 2px solid black">
                      <td>
                        <span class="text-uppercase gras">Commande (<?= count($groupe->fourni("commande")) ?>)</span><br>
                        <span>Créée <?= depuis($groupe->created) ?></span>
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
                        <button onclick="chosir(<?= $groupe->id ?>)" data-dismiss="modal" class="btn btn-white btn-sm "><i class="fa fa-check"></i> Choisir </button>
                      </td>
                    </tr>
                  <?php  } ?>
                </tbody>
              </table>
            </div>
        </div>
      </div>
    </div>



    <?php include($this->rootPath("webapp/boutique/elements/templates/footer.php")); ?>

    <?php include($this->rootPath("composants/assets/modals/modal-client.php")); ?>  
    <?php include($this->rootPath("composants/assets/modals/modal-acompte.php")); ?>  
    <?php include($this->rootPath("composants/assets/modals/modal-dette.php")); ?>  
    <?php include($this->rootPath("composants/assets/modals/modal-rembourser.php")); ?>  
    <?php include($this->rootPath("composants/assets/modals/modal-newcommande.php")); ?>  



    <?php foreach ($encours as $key => $groupe) {
      foreach ($groupe->fourni("commande", ["reste >"=>0]) as $key => $commande) {
        $commande->actualise();
        include($this->rootPath("composants/assets/modals/modal-reglercommande.php"));
      }
    } 
    ?>

  </div>
</div>


<?php include($this->rootPath("webapp/boutique/elements/templates/script.php")); ?>


</body>

</html>
