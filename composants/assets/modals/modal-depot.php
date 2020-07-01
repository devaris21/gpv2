<div class="modal inmodal fade" id="modal-depot">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title text-green">Dépot</h4>
                <small class="font-bold text-green">Renseigner ces champs pour enregistrer les informations</small>
            </div>
            <form method="POST" class="formShamman" classname="mouvement">
                <div class="modal-body">

                    <div class="">
                        <label>Montant de l'opération <span1>*</span1></label>
                        <div class="form-group">
                            <input type="number" number class="form-control" name="montant" required>
                        </div>
                    </div>   
                    <div class="">
                        <label>Plus de détails sur l'opération <span1>*</span1></label>
                        <div class="form-group">
                            <textarea class="form-control" rows="4" name="comment"></textarea>
                        </div>
                    </div> 
                    <div class="">
                        <label>Ajouter une image du reçu</label>
                        <div class="">
                            <img style="width: 80px;" src="" class="img-thumbnail logo">
                            <input class="hide" type="file" name="image">
                            <button type="button" class="btn btn-sm bg-purple pull-right btn_image"><i class="fa fa-image"></i> Ajouter le reçu</button>
                        </div>
                    </div>

                </div><hr>
                <div class="container">
                    <input type="hidden" name="id">
                    <input type="hidden" name="typemouvement_id" value="<?= home\TYPEMOUVEMENT::DEPOT  ?>">
                    <button class="btn dim btn-primary pull-right"><i class="fa fa-refresh"></i> Valider l'opération</button>
                </div>
                <br>
            </form>
        </div>
    </div>
</div>