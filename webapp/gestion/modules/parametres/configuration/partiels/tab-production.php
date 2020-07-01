    <div role="tabpanel" id="tab-production" class="tab-pane">
        <div class="row">

            <div class="col-sm-6 bloc">
                <div class="ibox border">
                    <div class="ibox-title">
                        <h5 class="text-uppercase">Les produits</h5>
                        <div class="ibox-tools">
                            <a class="btn_modal btn_modal" data-toggle="modal" data-target="#modal-produit">
                                <i class="fa fa-plus"></i> Ajouter
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th></th>
                                    <th></th>
                                    <th>Libéllé</th>
                                    <th>Activé ?</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i =0; foreach (Home\PRODUIT::findBy([], [], ["isActive"=>"DESC", "name"=>"ASC"]) as $key => $item) {
                                    $i++; ?>
                                    <tr>
                                        <td><?= $i ?></td>
                                        <td ><img style="width: 40px" src="<?= $this->stockage("images", "produits", $item->image); ?>"></td>

                                        <td><div class="border" style="width: 20px; height: 20px; background-color: <?= $item->couleur ?>"></div></td>
                                        <td class="gras"><?= $item->name(); ?></td>
                                        <td>
                                            <div class="switch">
                                                <div class="onoffswitch">
                                                    <input type="checkbox" <?= ($item->isActive())?"checked":""  ?> onchange='changeActive("produit", <?= $item->getId() ?>)' class="onoffswitch-checkbox" id="example<?= $item->getId() ?>">
                                                    <label class="onoffswitch-label" for="example<?= $item->getId() ?>">
                                                        <span class="onoffswitch-inner"></span>
                                                        <span class="onoffswitch-switch"></span>
                                                    </label>
                                                </div>
                                            </div>
                                        </td>
                                        <td data-toggle="modal" data-target="#modal-produit" title="modifier le produit" onclick="modification('produit', <?= $item->getId() ?>)"><i class="fa fa-pencil text-blue cursor"></i></td>
                                        <td data-toggle="tooltip" title="modifier le produit" onclick="suppressionWithPassword('produit', <?= $item->getId() ?>)"><i class="fa fa-close cursor text-danger"></i></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 bloc">
                <div class="ibox border">
                    <div class="ibox-title">
                        <h5 class="text-uppercase">Les matières premières</h5>
                        <div class="ibox-tools">
                            <a class="btn_modal" data-toggle="modal" data-target="#modal-ressource">
                                <i class="fa fa-plus"></i> Ajouter
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th></th>
                                    <th>Libéllé</th>
                                    <th>Unité</th>
                                    <th>Abbr</th>
                                    <th>Produit fini lié</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i =0; foreach (Home\RESSOURCE::findBy([], [], ["name"=>"ASC"]) as $key => $item) {
                                    $item->actualise();
                                    $i++; ?>
                                    <tr>
                                        <td><?= $i ?></td>
                                        <td ><img style="width: 40px" src="<?= $this->stockage("images", "ressources", $item->image); ?>"></td>
                                        <td class="gras"><?= $item->name(); ?></td>
                                        <td><?= $item->unite; ?></td>
                                        <td><?= $item->abbr; ?></td>
                                        <td><?= $item->produit->name(); ?></td>
                                        <td data-toggle="modal" data-target="#modal-ressource" title="modifier l'élément" onclick="modification('ressource', <?= $item->getId() ?>)"><i class="fa fa-pencil text-blue cursor"></i></td>
                                        <td title="supprimer la ressource" onclick="suppressionWithPassword('ressource', <?= $item->getId() ?>)"><i class="fa fa-close cursor text-danger"></i></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>



            <div class="col-sm-4 bloc">
                <div class="ibox border">
                    <div class="ibox-title">
                        <h5 class="text-uppercase">Différentes quantités</h5>
                        <div class="ibox-tools">
                            <a class="btn_modal" data-toggle="modal" data-target="#modal-quantite">
                                <i class="fa fa-plus"></i> Ajouter
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Libéllé</th>
                                    <th>Activé ?</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i =0; foreach (Home\QUANTITE::findBy([], [], ["isActive"=>"DESC", "name"=>"ASC"]) as $key => $item) { ?>
                                    <tr>
                                        <td class="gras"><?= $item->name(); ?></td>
                                        <td>
                                            <div class="switch">
                                                <div class="onoffswitch">
                                                    <input type="checkbox" <?= ($item->isActive())?"checked":""  ?> onchange='changeActive("quantite", <?= $item->getId() ?>)' class="onoffswitch-checkbox" id="qte<?= $item->getId() ?>">
                                                    <label class="onoffswitch-label" for="qte<?= $item->getId() ?>">
                                                        <span class="onoffswitch-inner"></span>
                                                        <span class="onoffswitch-switch"></span>
                                                    </label>
                                                </div>
                                            </div>
                                        </td>
                                        <td data-toggle="modal" data-target="#modal-quantite" title="modifier la quatité" onclick="modification('quantite', <?= $item->getId() ?>)"><i class="fa fa-pencil text-blue cursor"></i></td>
                                        <td title="supprimer la quantité" onclick="suppressionWithPassword('quantite', <?= $item->getId() ?>)"><i class="fa fa-close cursor text-danger"></i></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>



            <div class="col-sm-4 bloc">
                <div class="ibox border">
                    <div class="ibox-title">
                        <h5 class="text-uppercase">Les prix de ventes</h5>
                        <div class="ibox-tools">
                            <a class="btn_modal" data-toggle="modal" data-target="#modal-prix">
                                <i class="fa fa-plus"></i> Ajouter
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Libéllé</th>
                                    <th>Activé ?</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i =0; foreach (Home\PRIX::findBy([], [], ["isActive"=>"DESC"]) as $key => $item) { ?>
                                    <tr>
                                        <td class="gras"><?= $item->price(); ?> <?= $params->devise ?></td>
                                        <td>
                                            <div class="switch">
                                                <div class="onoffswitch">
                                                    <input type="checkbox" <?= ($item->isActive())?"checked":""  ?> onchange='changeActive("prix", <?= $item->getId() ?>)' class="onoffswitch-checkbox" id="prix<?= $item->getId() ?>">
                                                    <label class="onoffswitch-label" for="prix<?= $item->getId() ?>">
                                                        <span class="onoffswitch-inner"></span>
                                                        <span class="onoffswitch-switch"></span>
                                                    </label>
                                                </div>
                                            </div>
                                        </td>
                                        <td data-toggle="modal" data-target="#modal-prix" title="modifier la zone de livraison" onclick="modification('prix', <?= $item->getId() ?>)"><i class="fa fa-pencil text-blue cursor"></i></td>
                                        <td title="supprimer la zone de livraison" onclick="suppressionWithPassword('prix', <?= $item->getId() ?>)"><i class="fa fa-close cursor text-danger"></i></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>


            <div class="col-sm-4 bloc">
                <div class="ibox border">
                    <div class="ibox-title">
                        <h5 class="text-uppercase">Les zones de vente</h5>
                        <div class="ibox-tools">
                            <a class="btn_modal" data-toggle="modal" data-target="#modal-zonedevente">
                                <i class="fa fa-plus"></i> Ajouter
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Libéllé</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i =0; foreach (Home\ZONEDEVENTE::findBy([], [], ["name"=>"ASC"]) as $key => $item) { ?>
                                    <tr>
                                        <td class="gras"><?= $item->name(); ?></td>
                                        <td data-toggle="modal" data-target="#modal-zonedevente" title="modifier la zone de livraison" onclick="modification('zonedevente', <?= $item->getId() ?>)"><i class="fa fa-pencil text-blue cursor"></i></td>
                                        <td title="supprimer la zone de livraison" onclick="suppressionWithPassword('zonedevente', <?= $item->getId() ?>)"><i class="fa fa-close cursor text-danger"></i></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
