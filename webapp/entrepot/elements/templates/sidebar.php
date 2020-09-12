<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <h1 class="logo-name text-center" style="font-size: 50px; letter-spacing: 5px; margin: 0% auto !important; padding: 0% !important;">GPV</h1>
            <li class="nav-header" style="padding: 15px 10px !important; background-color: orange">
                <div class="dropdown profile-element">                        
                    <div class="row">
                        <div class="col-3">
                            <img alt="image" class="rounded-circle" style="width: 35px" src="<?= $this->stockage("images", "employes", $employe->image) ?>"/>
                        </div>
                        <div class="col-9">
                            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                <span class="block m-t-xs font-bold"><?= $employe->name(); ?></span>
                                <span class="text-muted text-xs block"><?= $entrepot->name(); ?></span>
                            </a>
                            <ul class="dropdown-menu animated fadeInRight m-t-xs">
                                <li><a class="dropdown-item" href="<?= $this->url("main", "access", "locked") ?>">Vérouiller la session</a></li>
                                <li><a class="dropdown-item" href="#" id="btn-deconnexion" >Déconnexion</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="logo-element">
                    GPV
                </div>
            </li>

            <?php 
            $groupes__ = Home\GROUPECOMMANDE::encours();
            $approvisionnements__ = Home\APPROVISIONNEMENT::encours();
            $mises__ = $entrepot->fourni("miseenboutique", ["etat_id ="=>Home\ETAT::ENCOURS]) + $entrepot->fourni("miseenboutique", ["etat_id ="=>Home\ETAT::PARTIEL]);

            ?>
            <ul class="nav metismenu" id="side-menu">
                <li class="" id="dashboard">
                    <a href="<?= $this->url($this->section, "master", "dashboard") ?>"><i class="fa fa-tachometer"></i> <span class="nav-label">Tableau de bord</span></a>
                </li>
                <li class="" id="stock">
                    <a href="<?= $this->url($this->section, "master", "stock") ?>"><i class="fa fa-cubes"></i> <span class="nav-label">Stock des produits</span></a>
                </li>
                <li style="margin: 3% auto"><hr class="mp0" style="background-color: #000; "></li>


                <?php if ($employe->isAutoriser("production")) { ?>
                    <li class="" id="production">
                        <a href="<?= $this->url($this->section, "production", "production") ?>"><i class="fa fa-free-code-camp"></i> <span class="nav-label">Production</span></a>
                    </li>
                    <li class="" id="conditionnement">
                        <a href="<?= $this->url($this->section, "production", "conditionnement") ?>"><i class="fa fa-flask"></i> <span class="nav-label">Conditionnement</span></a>
                    </li>
                    <li class="" id="miseenboutique">
                        <a href="<?= $this->url($this->section, "production", "miseenboutique") ?>"><i class="fa fa-reply"></i> <span class="nav-label">Mise en boutique <?php if (count($mises__) > 0) { ?> <span class="label label-warning float-right"><?= count($mises__) ?></span> <?php } ?></span></a>
                    </li>
                    <li class="" id="transfertstock">
                        <a href="<?= $this->url($this->section, "production", "transfertstock") ?>"><i class="fa fa-refresh"></i> <span class="nav-label">Transfert de stock</span></a>
                    </li>
                    <li class="" id="perteentrepot">
                        <a href="<?= $this->url($this->section, "production", "perteentrepot") ?>"><i class="fa fa-trash"></i> <span class="nav-label">Perte en entrepot</span></a>
                    </li>
                    <li style="margin: 3% auto"><hr class="mp0" style="background-color: #000; "></li>
                <?php } ?>

                
                <?php if ($employe->isAutoriser("stock")) { ?>
                    <li class="" id="fournisseurs">
                        <a href="<?= $this->url($this->section, "stock", "fournisseurs") ?>"><i class="fa fa-address-book-o"></i> <span class="nav-label">Liste des Fournisseurs</span></a>
                    </li>
                    <li class="groupe">
                        <a href="#"><i class="fa fa-file-text-o"></i> <span class="nav-label">Approvisionnements</span> <span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level collapse">
                            <li id="approressource"><a href="<?= $this->url($this->section, "stock", "approressource") ?>">Appro de ressources</a></li>
                            <li id="approemballage"><a href="<?= $this->url($this->section, "stock", "approemballage") ?>">Appro d'emballages</a></li>
                            <li id="approetiquette"><a href="<?= $this->url($this->section, "stock", "approetiquette") ?>">Appro d'etiquettes</a></li>
                        </ul>
                    </li>
                    <li class="groupe">
                        <a href="#"><i class="fa fa-cubes"></i> <span class="nav-label">Les stocks</span> <span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level collapse">
                            <li id="ressources"><a href="<?= $this->url($this->section, "stock", "ressources") ?>">Stock de ressources</a></li>
                            <li id="emballages"><a href="<?= $this->url($this->section, "stock", "emballages") ?>">Stock d'emballages</a></li>
                            <li id="etiquettes"><a href="<?= $this->url($this->section, "stock", "etiquettes") ?>">Stock d'etiquettes</a></li>
                        </ul>
                    </li>
                    <li style="margin: 3% auto"><hr class="mp0" style="background-color: #000; "></li>
                <?php } ?>


                <?php if ($employe->isAutoriser("rapports")) { ?>
                    <li class="" id="rapportproduction">
                        <a href="<?= $this->url($this->section, "rapports", "rapportproduction") ?>"><i class="fa fa-file-text-o"></i> <span class="nav-label">Rapport de production</span></a>
                    </li>
                    <li style="margin: 3% auto"><hr class="mp0" style="background-color: #aaa; "></li>
                <?php } ?>
                

                <?php if ($employe->isAutoriser("caisse")) { ?>
                    <li class="" id="caisse">
                        <a href="<?= $this->url($this->section, "caisse", "caisse") ?>"><i class="fa fa-money"></i> <span class="nav-label">La caisse</span></a>
                    </li>
                    <li style="margin: 3% auto"><hr class="mp0" style="background-color: #000; "></li>
                <?php } ?>

            </ul>

        </ul>

    </div>
</nav>

<style type="text/css">
    li.dropdown-divider{
     !important;
 }
</style>