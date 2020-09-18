<div class="modal inmodal fade" id="modal-cloture">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Clôture de l'exercice comptable</h4>
                <small class="font-bold">Renseigner ces champs pour enregistrer les informations</small>
            </div>
            <form method="POST" id="formCloture">
                <div class="modal-body">
                    <div class="">
                        <dl>
                            <dt class="text-danger"><i class="fa fa-exclamation"></i> Clôture de l'exercice comptable</dt>
                            <dd>la clôture de l'exercice comptable consiste à arreter les documents de synthèse et créer les mouvements d'à nouveau de chaque compte pour l'exercice prochain. <br>
                                Les mouvements restent modifiables sur un exercice déjà clôturer mais vous devriez refaire la clôture l'exercice.<br>
                                Les écritures comptables seront automatiquement validés et mis à jour<br>
                            </dd>
                        </dl>
                    </div><hr>
                    <div class="row">
                        <div class="col-sm-6">
                            <label>Entrer votre mot de passe pour valider l'opération <span1>*</span1></label>
                            <div class="form-group">
                                <input type="password" autocomplete="off" class="form-control" name="password" required>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <br>
                            <button class="btn dim btn-primary pull-right"><i class="fa fa-refresh"></i> Valider le formulaire</button>
                        </div>   
                    </div>
                </div><hr>
            </form>
        </div>
    </div>
</div>