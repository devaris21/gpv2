

<div role="tabpanel" id="tab-caisse" class="tab-pane">
    <div class="row">

        <div class="col-sm-8 bloc">
            <div class="ibox border">
                <div class="ibox-title">
                    <h5 class="text-uppercase">Type d'opération</h5>
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
                            <?php $i =0; foreach (Home\CATEGORIEOPERATION::findBy([], [], ["typeoperationcaisse_id"=>"ASC", "name"=>"ASC"]) as $key => $item) {
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

        <div class="col-md-4">
            <form method="POST" class="formShamman" classname="params" reload="false">
                                         <!--    <div class="row">
                                                <div class="col-xs-7 gras">Autoriser système de versement en attente</div>
                                                <div class="offset-1"></div>
                                                <div class="col-xs-4">
                                                    <div class="switch">
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

                                            <div class="row">
                                                <div class="col-xs-7 gras">Bloquer les dépenses or fonds directs</div>
                                                <div class="offset-1"></div>
                                                <div class="col-xs-4">
                                                    <div class="switch">
                                                        <div class="onoffswitch">
                                                            <input type="checkbox" name="bloquerOrfonds" <?= ($params->bloquerOrfonds == "on")?"checked":""  ?> class="onoffswitch-checkbox" id="example1">
                                                            <label class="onoffswitch-label" for="example1">
                                                                <span class="onoffswitch-inner"></span>
                                                                <span class="onoffswitch-switch"></span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div><br> -->

                                            <div class="row">
                                                <div class="col-4">
                                                    <label>% de tva </label>
                                                    <input type="number" number class="form-control" name="tva" value="<?= $params->tva ?>">
                                                </div><br>
                                                <div class="col-8">
                                                    <label>Seuil de tolérance du crédit client </label>
                                                    <input type="number" number class="form-control" name="seuilCredit" value="<?= $params->seuilCredit ?>">
                                                </div>
                                                <div class="col-6">
                                                    <br>
                                                    <input type="hidden" name="id" value="<?= $params->id ?>">
                                                    <button class="btn btn-primary dim "><i class="fa fa-check"></i> Mettre à jour</button>
                                                </div>
                                            </div>
                                            <hr>
                                        </form>
                                    </div>
                                </div>
                            </div>
