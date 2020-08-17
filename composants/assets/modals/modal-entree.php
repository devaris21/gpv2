<div class="modal inmodal fade" id="modal-entree">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title text-green">Nouvelle entrée</h4>
                <small class="font-bold text-green">Renseigner ces champs pour enregistrer les informations</small>
            </div>
            <form method="POST" class="formShamman" classname="operation">
                <div class="modal-body">
                    <div>
                        <label>Type d'opération <span1>*</span1></label>
                        <div class="form-group">
                            <?php Native\BINDING::html("select-tableau", Home\CATEGORIEOPERATION::entree(), null, "categorieoperation_id"); ?>
                        </div>
                    </div> 
                    <div>
                        <label>Montant de l'opération <span1>*</span1></label>
                        <div class="form-group">
                            <input type="number" number class="form-control" name="montant" required>
                        </div>
                    </div>                       

                    <div>
                        <label>Mode d'encaissement</label>
                        <div class="form-group">
                            <?php Native\BINDING::html("select", "modepayement"); ?>
                        </div>
                    </div> 
                    <div class="modepayement_facultatif row">
                        <div>
                            <label>Structure d'encaissement <span style="color: red">*</span> </label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-bank"></i></span><input type="text" name="structure" class="form-control">
                            </div>
                        </div><br>
                        <div>
                            <label>N° numero dédié <span style="color: red">*</span> </label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-pencil"></i></span><input type="text" name="numero" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div>
                        <label>Plus de détails sur l'opération <span1>*</span1></label>
                        <div class="form-group">
                            <textarea class="form-control" rows="3" name="comment"></textarea>
                        </div>
                    </div> 
                    <div>
                        <label>Ajouter une image du reçu</label>
                        <div class="">
                            <img style="width: 80px;" src="" class="img-thumbnail logo">
                            <input class="hide" type="file" name="image">
                            <button type="button" class="btn btn-sm bg-purple pull-right btn_image"><i class="fa fa-image"></i></button>
                        </div>
                    </div>                   
                </div><hr>
                <div class="container">
                    <input type="hidden" name="id">
                    <input type="hidden" name="comptebanque_id" value="<?= $comptebanque->id  ?>">
                    <button class="btn dim btn-primary btn-xs btn-block"><i class="fa fa-refresh"></i> Valider l'opération</button>
                </div>
                <br>
            </form>
        </div>
    </div>
</div>