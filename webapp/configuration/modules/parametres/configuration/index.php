<!DOCTYPE html>
<html>

<?php include($this->rootPath("webapp/manager/elements/templates/head.php")); ?>


<body class="fixed-sidebar">

    <div id="wrapper">

        <?php include($this->rootPath("webapp/manager/elements/templates/sidebar.php")); ?>  

        <div id="page-wrapper" class="gray-bg">

            <?php include($this->rootPath("webapp/manager/elements/templates/header.php")); ?>  

            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-sm-4">
                    <h2 class="text-uppercase">Configuration de Base</h2>
                </div>
                <div class="col-sm-8">

                </div>
            </div>

            <div class="wrapper wrapper-content" id="autos">
                <div class="animated fadeInRightBig">
                    <div class="ibox" >
                        <div class="ibox-content" style="min-height: 400px;">
                            <div class="tabs-container">
                                <ul class="nav nav-tabs" role="tablist">
                                    <li class=""><a class="nav-link active" data-toggle="tab" href="#tab-general"><i class="fa fa-info"></i> Infos Générales</a></li>
                                    <li class=""><a class="nav-link " data-toggle="tab" href="#tab-production"><i class="fa fa-th-large"></i> Elements & Production </a></li>
                                    <li class=""><a class="nav-link " data-toggle="tab" href="#tab-gestion"><i class="fa fa-th-large"></i> Gestion & Production </a></li>
                                    <li class=""><a class="nav-link " data-toggle="tab" href="#tabpersonnel"><i class="fa fa-male"></i> Personnel & Exte </a></li>
                                    <li class=""><a class="nav-link " data-toggle="tab" href="#tabvehicules"><i class="fa fa-car"></i> Véhicules & Machines </a></li>
                                    <li class=""><a class="nav-link " data-toggle="tab" href="#tab-caisse"><i class="fa fa-money"></i> Options de caisse </a></li>
                                    <li class=""><a class="nav-link " data-toggle="tab" href="#admin"><i class="fa fa-gears"></i> Administration </a></li>
                                </ul><br>                               
                                <div class="tab-content">



                                    <?php include($this->relativePath("partiels/tab-general.php")) ?>
                                    <?php include($this->relativePath("partiels/tab-production.php")) ?>
                                    <?php include($this->relativePath("partiels/tab-gestion.php")) ?>
                                    <?php include($this->relativePath("partiels/tab-caisse.php")) ?>



                                    <div role="tabpanel" id="tabpersonnel" class="tab-pane">
                                        <div class="row">

                                        <div class="col-sm-12 bloc">
                                            <div class="ibox border">
                                                <div class="ibox-title">
                                                    <h5 class="text-uppercase">Les commerciaux</h5>
                                                    <div class="ibox-tools">
                                                        <a class="btn_modal" data-toggle="modal" data-target="#modal-chauffeur">
                                                            <i class="fa fa-plus"></i> Ajouter
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="ibox-content">
                                                    <table class="table table-striped">
                                                        <thead>
                                                            <tr>
                                                                <th></th>
                                                                <th>Libéllé</th>
                                                                <th>Coordonnées</th>
                                                                <th colspan="2">Salaire Mensuel</th>
                                                                <th></th>
                                                                <th></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php $i =0; foreach (Home\COMMERCIAL::findBy(["visibility ="=>1], [], ["name"=>"ASC"]) as $key => $item) {
                                                                $i++; ?>
                                                                <tr>
                                                                    <td>
                                                                        <img alt="image" style="width: 40px;" class="m-t-xs" src="<?= $this->stockage("images", "chauffeurs", $item->image) ?>">
                                                                    </td>
                                                                    <td>
                                                                        <span class="gras"><?= $item->name(); ?></span> 
                                                                    </td>
                                                                    <td>
                                                                        <i class="fa fa-map-marker"></i> <?= $item->adresse  ?><br>
                                                                        <i class="fa fa-phone"></i> <?= $item->contact  ?>
                                                                    </td>

                                                                    <td><h3 class="gras"><?= money($item->salaire) ?> <?= $params->devise ?></h3></td>
                                                                    <td class="border-right" data-toggle="modal" data-target="#modal-salaire" title="modifier le salaire" onclick="modification('chauffeur', <?= $item->id ?>)"><i class="fa fa-refresh text-blue cursor"></i></td>

                                                                    <td data-toggle="modal" data-target="#modal-chauffeur" title="modifier ce chauffeur" onclick="modification('chauffeur', <?= $item->id ?>)"><i class="fa fa-pencil text-blue cursor"></i></td>
                                                                    <td title="supprimer ce chauffeur" onclick="suppression('chauffeur', <?= $item->id ?>)"><i class="fa fa-close cursor text-danger"></i></td>
                                                                </tr>
                                                            <?php } ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-12 bloc">
                                            <div class="ibox border">
                                                <div class="ibox-title">
                                                    <h5 class="text-uppercase">Vos fournisseurs de ressources</h5>
                                                    <div class="ibox-tools">
                                                        <a class="btn_modal" data-toggle="modal" data-target="#modal-fournisseur">
                                                            <i class="fa fa-plus"></i> Ajouter
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="ibox-content">
                                                    <table class="table table-striped">
                                                        <thead>
                                                            <tr>
                                                                <th></th>
                                                                <th>Libéllé</th>
                                                                <th>Adresse</th>
                                                                <th>Coordonnées</th>
                                                                <th>fax</th>
                                                                <th></th>
                                                                <th></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php $i =0; foreach (Home\FOURNISSEUR::findBy([], [], ["name"=>"ASC"]) as $key => $item) { ?>
                                                                <tr>
                                                                    <td>
                                                                        <img alt="image" style="width: 40px;" class="m-t-xs" src="<?= $this->stockage("images", "fournisseurs", $item->image) ?>">
                                                                    </td>
                                                                    <td class="gras"><?= $item->name(); ?></td>
                                                                    <td><i class="fa fa-map-marker"></i> <?= $item->adresse  ?></td>
                                                                    <td>
                                                                        <i class="fa fa-envelope"></i> <?= $item->email  ?><br>
                                                                        <i class="fa fa-phone"></i> <?= $item->contact  ?>  
                                                                    </td>
                                                                    <td><i class="fa fa-fax"></i> <?= $item->fax ?></td>
                                                                    <td data-toggle="modal" data-target="#modal-fournisseur" title="modifier ce fournisseur" onclick="modification('fournisseur', <?= $item->id ?>)"><i class="fa fa-pencil text-blue cursor"></i></td>
                                                                    <td title="supprimer ce fournisseur" onclick="suppression('fournisseur', <?= $item->id ?>)"><i class="fa fa-close cursor text-danger"></i></td>
                                                                </tr>
                                                            <?php } ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>

<!--                                         <div class="col-md-12 bloc">
                                            <div class="ibox border">
                                                <div class="ibox-title">
                                                    <h5 class="text-uppercase">Vos prestataires de services</h5>
                                                    <div class="ibox-tools">
                                                        <a class="btn_modal" data-toggle="modal" data-target="#modal-manoeuvre">
                                                            <i class="fa fa-plus"></i> Ajouter
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="ibox-content">
                                                    <table class="table table-striped">
                                                        <thead>
                                                            <tr>
                                                                <th></th>
                                                                <th>Libéllé</th>
                                                                <th>Adresse</th>
                                                                <th>Coordonnées</th>
                                                                <th>fax</th>
                                                                <th></th>
                                                                <th></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php //$i =0; foreach (Home\PRESTATAIRE::findBy([], [], ["name"=>"ASC"]) as $key => $item) { ?>
                                                                <tr>
                                                                    <td>
                                                                        <img alt="image" style="width: 40px;" class="m-t-xs" src="<?= $this->stockage("images", "prestataires", $item->image) ?>">
                                                                    </td>
                                                                    <td class="gras"><?= $item->name(); ?></td>
                                                                    <td><i class="fa fa-map-marker"></i> <?= $item->adresse  ?></td>
                                                                    <td>
                                                                        <i class="fa fa-envelope"></i> <?= $item->email  ?><br>
                                                                        <i class="fa fa-phone"></i> <?= $item->contact  ?>  
                                                                    </td>
                                                                    <td><i class="fa fa-fax"></i> <?= $item->fax ?></td>
                                                                    <td data-toggle="modal" data-target="#modal-prestataire" title="modifier ce prestataire" onclick="modification('prestataire', <?= $item->id ?>)"><i class="fa fa-pencil text-blue cursor"></i></td>
                                                                    <td title="supprimer ce prestataire" onclick="suppression('prestataire', <?= $item->id ?>)"><i class="fa fa-close cursor text-danger"></i></td>
                                                                </tr>
                                                            <?php // } ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div> -->

                                    </div>
                                </div>



                                <!-- //////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->


                                <div role="tabpanel" id="tabvehicules" class="tab-pane">
                                    <div class="row">

                                        <div class="col-md-4 col-sm-6 bloc">
                                            <div class="ibox border">
                                                <div class="ibox-title">
                                                    <h5 class="text-uppercase">Type de véhicule</h5>
                                                    <div class="ibox-tools">
                                                        <a class="btn_modal" data-toggle="modal" data-target="#modal-typevehicule">
                                                            <i class="fa fa-plus"></i> Ajouter
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="ibox-content">
                                                    <table class="table table-striped">
                                                        <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>Libéllé</th>
                                                                <th></th>
                                                                <th></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php $i =0; foreach (Home\TYPEVEHICULE::findBy([], [], ["name"=>"ASC"]) as $key => $item) {
                                                                $i++; ?>
                                                                <tr>
                                                                    <td><?= $i ?></td>
                                                                    <td class="gras"><?= $item->name(); ?></td>
                                                                    <td data-toggle="modal" data-target="#modal-typevehicule" title="modifier l'élément" onclick="modification('typevehicule', <?= $item->id ?>)"><i class="fa fa-pencil text-blue cursor"></i></td>
                                                                    <td title="supprimer l'élément" onclick="suppression('typevehicule', <?= $item->id ?>)"><i class="fa fa-close cursor text-danger"></i></td>
                                                                </tr>
                                                            <?php } ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-4 col-sm-6 bloc">
                                            <div class="ibox border">
                                                <div class="ibox-title">
                                                    <h5 class="text-uppercase">Catégorie de véhicule</h5>
                                                    <div class="ibox-tools">
                                                        <a class="btn_modal" data-toggle="modal" data-target="#modal-groupevehicule">
                                                            <i class="fa fa-plus"></i> Ajouter
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="ibox-content">
                                                    <table class="table table-striped">
                                                        <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>Libéllé</th>
                                                                <th></th>
                                                                <th></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php $i =0; foreach (Home\GROUPEVEHICULE::findBy([], [], ["name"=>"ASC"]) as $key => $item) {
                                                                $i++; ?>
                                                                <tr>
                                                                    <td><?= $i ?></td>
                                                                    <td class="gras"><?= $item->name(); ?></td>
                                                                    <td data-toggle="modal" data-target="#modal-groupevehicule" title="modifier l'élément" onclick="modification('groupevehicule', <?= $item->id ?>)"><i class="fa fa-pencil text-blue cursor"></i></td>
                                                                    <td title="supprimer l'élément" onclick="suppression('groupevehicule', <?= $item->id ?>)"><i class="fa fa-close cursor text-danger"></i></td>
                                                                </tr>
                                                            <?php } ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-4 col-sm-6 bloc">
                                            <div class="ibox border">
                                                <div class="ibox-title">
                                                    <h5 class="text-uppercase">Panne de véhicule</h5>
                                                    <div class="ibox-tools">
                                                        <a class="btn_modal" data-toggle="modal" data-target="#modal-typeentretienvehicule">
                                                            <i class="fa fa-plus"></i> Ajouter
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="ibox-content">
                                                    <table class="table table-striped">
                                                        <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>Libéllé</th>
                                                                <th></th>
                                                                <th></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php $i =0; foreach (Home\TYPEENTRETIENVEHICULE::findBy([], [], ["name"=>"ASC"]) as $key => $item) {
                                                                $i++; ?>
                                                                <tr>
                                                                    <td><?= $i ?></td>
                                                                    <td class="gras"><?= $item->name(); ?></td>
                                                                    <td data-toggle="modal" data-target="#modal-typeentretienvehicule" title="modifier l'élément" onclick="modification('typeentretienvehicule', <?= $item->id ?>)"><i class="fa fa-pencil text-blue cursor"></i></td>
                                                                    <td title="supprimer l'élément" onclick="suppression('typeentretienvehicule', <?= $item->id ?>)"><i class="fa fa-close cursor text-danger"></i></td>
                                                                </tr>
                                                            <?php } ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-md-7">
                                            <div class="ibox border" >
                                                <div class="ibox-title">
                                                    <h5 class="text-uppercase"><i class="fa fa-car"></i> Tous les véhicules </h5>
                                                    <div class="ibox-tools">
                                                        <a class="btn_modal" data-toggle="modal" data-target="#modal-vehicule">
                                                            <i class="fa fa-plus"></i> Ajouter
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="ibox-content table-responsive" style="min-height: 400px;">
                                                    <table class="table table-striped">
                                                       <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Libéllé</th>
                                                            <th></th>
                                                            <th></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach (Home\VEHICULE::findBy(["visibility ="=>1]) as $key => $vehicule) {
                                                            $vehicule->actualise();
                                                            ?>
                                                            <tr>    
                                                                <td>
                                                                    <img alt="image" style="width: 40px;" class="m-t-xs" src="<?= $this->stockage("images", "vehicules", $vehicule->image) ?>">
                                                                </td>
                                                                <td class="">
                                                                    <h5 class="text-uppercase gras"><?= $vehicule->marque->name() ?> <?= $vehicule->modele ?></h5>
                                                                    <h6 class=""><?= $vehicule->immatriculation ?></h6>
                                                                </td>
                                                                <td class="">
                                                                    <h5 class="mp0"><?= $vehicule->typevehicule->name() ?></h5>
                                                                    <h5 class="mp0"><?= $vehicule->groupevehicule->name() ?></h5>
                                                                </td>     
                                                                <td data-toggle="modal" data-target="#modal-vehicule" title="modifier l'élément" onclick="modification('vehicule', <?= $vehicule->id ?>)"><i class="fa fa-pencil text-blue cursor"></i></td>
                                                                <td title="supprimer l'élément" onclick="suppressionWithPassword('vehicule', <?= $vehicule->id ?>)"><i class="fa fa-close cursor text-danger"></i></td>
                                                            </tr>
                                                        <?php } ?>
                                                    </tbody>
                                                </table>                             
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-md-5">
                                        <div class="ibox border" >
                                            <div class="ibox-title">
                                                <h5 class="text-uppercase"><i class="fa fa-steam"></i> les machines </h5>
                                                <div class="ibox-tools">
                                                    <a class="btn_modal" data-toggle="modal" data-target="#modal-machine">
                                                        <i class="fa fa-plus"></i> Ajouter
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="ibox-content table-responsive" style="min-height: 400px;">
                                                <table class="table table-striped">
                                                   <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Libéllé</th>
                                                        <th></th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach (Home\MACHINE::getAll() as $key => $machine) {
                                                        $machine->actualise();
                                                        ?>
                                                        <tr>    
                                                            <td>
                                                                <img alt="image" style="width: 40px;" class="m-t-xs" src="<?= $this->stockage("images", "machines", $machine->image) ?>">
                                                            </td>
                                                            <td class="">
                                                                <h5 class="text-uppercase gras"><?= $machine->name() ?></h5>
                                                                <h6 class=""><?= $machine->marque ?> <?= $machine->modele ?></h6>
                                                            </td>
                                                            <td data-toggle="modal" data-target="#modal-machine" title="modifier l'élément" onclick="modification('machine', <?= $machine->id ?>)"><i class="fa fa-pencil text-blue cursor"></i></td>
                                                            <td title="supprimer l'élément" onclick="suppression('machine', <?= $machine->id ?>)"><i class="fa fa-close cursor text-danger"></i></td>
                                                        </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>                             
                                        </div>
                                    </div>
                                </div>


                            </div>
                        </div>



                        <!-- //////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->





                        <!-- //////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->



                        <div role="tabpanel" id="admin" class="tab-pane">
                          <div class="bloc">
                            <div class="ibox border">
                                <div class="ibox-title">
                                    <h5 class="text-uppercase">Administrateurs et gerants</h5>
                                    <div class="ibox-tools">
                                        <a class="btn_modal" data-toggle="modal" data-target="#modal-employe">
                                            <i class="fa fa-plus"></i> Ajouter
                                        </a>
                                    </div>
                                </div>
                                <div class="ibox-content">
                                    <table class="table table-striped table-hover">
                                        <tbody>
                                            <?php $i =0; foreach (Home\EMPLOYE::findBy([], [], ["name"=>"ASC"]) as $key => $item) {
                                                $item->actualise();  ?>
                                                <tr>
                                                    <td>
                                                        <?php if ($item->is_allowed == 1) { ?>
                                                            <span class="label label-success">Actif</span>
                                                        <?php }else{ ?>
                                                            <span class="label label-danger">Bloqué</span>
                                                        <?php } ?>
                                                    </td>
                                                    <td >
                                                        <span class="gras text-uppercase"><?= $item->name() ?></span><br>
                                                        <span> <?= $item->email ?></span><br>
                                                        <span> <?= $item->adresse ?></span><br>
                                                        <span> <?= $item->contact ?></span>
                                                    </td>
                                                    <td>
                                                        <?php if ($item->is_new == 1) { ?>
                                                            <span class="">Login: <?= $item->login ?></span><br>
                                                            <span class="">Pass: <?= $item->pass ?></span>
                                                        <?php } ?>
                                                    </td>
                                                    <td class="" width="400px">
                                                        <?php $datas = $item->fourni("role_employe");
                                                        $lots = [];
                                                        foreach ($datas as $key => $rem) {
                                                            $rem->actualise();
                                                            $lots[] = $rem->role->id; ?>
                                                            <button style="margin-top: 1%" employe="<?= $rem->employe_id ?>" role="<?= $rem->role_id ?>" class="btn btn-primary btn-xs refuser"><?= $rem->role->name() ?></button>
                                                            <?php } ?><hr class="mp3">

                                                            <?php foreach (Home\ROLE::getAll() as $key => $role) {
                                                                if (!in_array($role->id, $lots)) { ?>
                                                                   <button style="margin-top: 1%" employe="<?= $rem->employe_id ?>" role="<?= $role->id ?>" class="btn btn-white btn-xs autoriser"><?= $role->name() ?></button>
                                                               <?php } } ?>                
                                                           </td>
                                                           <td class="text-right">          
                                                            <button onclick="resetPassword('employe', <?= $item->id ?>)" class="btn btn-white btn-xs"><i class="fa fa-refresh text-blue"></i> Init. mot de passe</button><br>

                                                            <?php if ($item->is_allowed == 1) { ?>
                                                                <button onclick="lock('employe', <?= $item->id ?>)" class="btn btn-white btn-xs"><i class="fa fa-lock text-orange"></i> Bloquer</button>
                                                            <?php }else{ ?>
                                                                <button onclick="unlock('employe', <?= $item->id ?>)" class="btn btn-white btn-xs"><i class="fa fa-unlock text-green"></i> Débloquer</button>
                                                            <?php } ?>
                                                            <button data-toggle="modal" data-target="#modal-employe" class="btn btn-white btn-xs" onclick="modification('employe', <?= $item->id ?>)"><i class="fa fa-pencil"></i></button>
                                                            <button class="btn btn-white btn-xs" onclick="suppressionWithPassword('employe', <?= $item->id ?>)"><i class="fa fa-close text-red"></i></button>
                                                        </td>
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
            </div>
        </div>
    </div>
</div>




<?php include($this->rootPath("webapp/manager/elements/templates/footer.php")); ?>
<?php include($this->relativePath("modals.php")); ?>


</div>
</div>


<?php include($this->rootPath("webapp/manager/elements/templates/script.php")); ?>


</body>

</html>
