<!DOCTYPE html>
<html>

<?php include($this->rootPath("webapp/boutique/elements/templates/head.php")); ?>


<body class="fixed-sidebar">

    <div id="wrapper">

        <?php include($this->rootPath("webapp/boutique/elements/templates/sidebar.php")); ?>  

        <div id="page-wrapper" class="gray-bg">

            <?php include($this->rootPath("webapp/boutique/elements/templates/header.php")); ?>  


            <div class="wrapper-content">
                <div class="animated fadeInRightBig">

                    <?php foreach ($typeproduits as $key => $type) { ?>
                        <div class="ibox">
                            <div class="ibox-title">
                                <h5 class="text-uppercase">Stock de <?= $type->name() ?></h5>
                            </div>
                            <div class="ibox-content">
                                <div class="row">
                                    <?php foreach ($parfums as $key =>$parfum) { ?>
                                        <div class="col-md border-right">
                                            <h6 class="text-uppercase text-center gras" style="color: <?=$parfum->couleur; ?>">Stock de <?=$parfum->name() ?></h6>
                                            <ul class="list-group clear-list m-t">
                                                <?php foreach ($quantites as $key => $qua) { ?>
                                                    <li class="list-group-item">
                                                        <i class="fa fa-flask" style="color: <?=$parfum->couleur; ?>"></i> <small><?= $qua->name() ?></small>          
                                                        <span class="float-right">
                                                            <span title="en boutique" class="gras text-<?= (0 > 0)?"green":"danger" ?>"><?= money(45) ?></span>&nbsp;|&nbsp;
                                                            <span title="en entrepôt" class=""><?= money(000045) ?></span>
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
                    <?php } ?>

                </div>
            </div>

            
            <?php include($this->rootPath("webapp/boutique/elements/templates/footer.php")); ?>
            

        </div>
    </div>


    <?php include($this->rootPath("webapp/boutique/elements/templates/script.php")); ?>


</body>

</html>
