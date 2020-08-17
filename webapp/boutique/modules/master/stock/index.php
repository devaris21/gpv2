<!DOCTYPE html>
<html>

<?php include($this->rootPath("webapp/boutique/elements/templates/head.php")); ?>


<body class="fixed-sidebar">

    <div id="wrapper">

        <?php include($this->rootPath("webapp/boutique/elements/templates/sidebar.php")); ?>  

        <div id="page-wrapper" class="gray-bg">
          
          <?php include($this->rootPath("webapp/boutique/elements/templates/header.php")); ?>  

          <div class="row wrapper border-bottom white-bg page-heading">
            <div class="col-sm-4">
                <h2>This is main title</h2>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="index.html">This is</a>
                    </li>
                    <li class="breadcrumb-item active">
                        <strong>Breadcrumb</strong>
                    </li>
                </ol>
            </div>
            <div class="col-sm-8">
                <div class="title-action">
                    <a href="" class="btn btn-primary">This is action area</a>
                </div>
            </div>
        </div>

        <div class="wrapper-content">
            <div class="text-center animated fadeInRightBig">
                
                <div class="ibox">
                    <div class="ibox-title">
                        
                    </div>
                    <div class="ibox-content">
                        <div class="row">
                                <?php foreach ($produits as $key => $produit) { ?>
                                    <div class="col-md border-right">
                                        <h6 class="text-uppercase text-center gras" style="color: <?= $produit->couleur; ?>">Stock de <?= $produit->name() ?></h6>
                                        <ul class="list-group clear-list m-t">
                                            <?php foreach ($tableau[$produit->id] as $key => $pdv) { ?>
                                                <li class="list-group-item">
                                                    <i class="fa fa-flask" style="color: <?= $produit->couleur; ?>"></i> <small><?= $pdv->quantite ?></small>          
                                                    <span class="float-right">
                                                        <span title="en boutique" class="gras text-<?= ($pdv->boutique > 0)?"green":"danger" ?>"><?= money($pdv->boutique) ?></span>&nbsp;|&nbsp;
                                                        <span title="en entrepôt" class=""><?= money($pdv->stock) ?></span>
                                                    </span>
                                                </li>
                                            <?php } ?>
                                            <li class="list-group-item"></li>
                                        </ul>
                                    </div>
                                <?php } ?>
                            </div>
                    </div>
                </div>
            </div>
        </div>

        
        <?php include($this->rootPath("webapp/boutique/elements/templates/footer.php")); ?>
        

    </div>
</div>


<?php include($this->rootPath("webapp/boutique/elements/templates/script.php")); ?>


</body>

</html>
