 <div role="tabpanel" id="tab-general" class="tab-pane active">
    <div class="row">
        <div class="col-md-8 border-right">
            <div class="ibox">
                <div class="ibox-content"><br>
                    <div class="row">
                        <div class="col-sm-12">
                            <span class="text-muted">Raison sociale ou nom de la société</span>
                            <h2 class="gras text-uppercase text-primary"><?= $params->societe ?></h2>
                        </div>
                    </div><br>

                    <div class="row">
                        <div class="col-sm-4">
                            <span class="text-muted">Situation Géographique</span>
                            <h4><?= $params->adresse ?></h4>
                        </div>

                        <div class="col-sm-4">
                            <span class="text-muted">Contacts</span>
                            <h4><?= $params->contact ?></h4>
                        </div>

                        <div class="col-sm-4">
                            <span class="text-muted">Email</span>
                            <h4><?= $params->email ?></h4>
                        </div>
                    </div><br>

                    <div class="row">
                        <div class="col-sm-4">
                            <span class="text-muted">Boite Postale</span>
                            <h4><?= $params->postale ?></h4>
                        </div>

                        <div class="col-sm-4">
                            <span class="text-muted">Fax</span>
                            <h4><?= $params->fax ?></h4>
                        </div>

                        <div class="col-sm-4">
                            <span class="text-muted">Devise</span>
                            <h4><?= $params->devise ?></h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-md-4 col-sm-6 text-center">
            <h4 class="text-muted text-uppercase">Votre logo</h4>
            <img style="width: 240px" src="<?= $this->stockage("images", "societe", $params->image)  ?>">
        </div>

    </div><hr>
    <div>
        <button onclick="modification('params', <?= $params->id ?>)" class="btn btn-primary dim pull-right" data-toggle="modal" data-target="#modal-params"><i class="fa fa-pencil"></i> Modifier les informations</button>
    </div><br><br><br>
</div>
