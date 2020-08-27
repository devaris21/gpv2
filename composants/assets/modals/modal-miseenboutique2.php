
<div class="modal inmodal fade" id="modal-miseenboutique<?= $mise->id ?>" style="z-index: 1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-body">
                <div class="ibox-content">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <div class="text-center">
                        <h1 class="title text-uppercase gras text-green">Validation de la mise en boutique </h1>
                        <small>Veuillez renseigner la quantité de chaque type de produit que vous voulez mettre en boutique !</small>
                    </div><hr>

                    <form id="formValiderMiseenboutique" classname="miseenboutique">
                        <div class="row">
                            <div class="col-md-8">
                                <table class="table  table-striped">
                                    <tbody class="">
                                        <?php foreach ($mise->lignemiseenboutiques as $key => $ligne) { ?>
                                            <tr class="border-0 border-bottom ">
                                                <td class="text-left">
                                                    <h4 class="mp0 text-uppercase"><?= $ligne->produit->name() ?></h4>
                                                </td>
                                                <td width="130" class="text-center">
                                                    <img style="height: 20px" src="<?= $this->stockage("images", "emballages", $ligne->emballage->image) ?>"><br>
                                                    <small><?= $ligne->emballage->name() ?></small>
                                                    <input type="text" data-id="<?= $ligne->id ?>" number class="form-control text-center gras text-green recu" value="<?= $ligne->quantite ?>" max="<?= $ligne->quantite ?>">
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>

                            <div class="col-md-4"  style="background-color: #eee">
                                <div class="ibox">
                                    <br>
                                    <div class="">
                                        <label>Ajouter une note</label>
                                        <textarea class="form-control" name="comment" value="<?= $mise->comment ?>" rows="4"></textarea>
                                    </div><br><br>

                                    <div class="text-center">
                                        <button class="btn dim btn-primary btn-block" ><i class="fa fa-check"></i> Valider la mise en boutique</button>
                                    </div><br>
                                </div>

                            </div>
                        </div>
                        <hr>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
