<html>
<header>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</header>
<body>

<div class="container">

    <?php

    require  __DIR__."/../vendor/autoload.php";

    use CSK\UrlFileReader;
    use CSK\FileParam;
    use CSK\UrlModel;

    //read and pars urls
    try {
        //$fileParamInstance = new FileParam('../_data_', 'urls.txt');
        //for testing error
        //$fileParamInstance = new FileParam('uyengruywefyger', 'urls.txt');
        $fileParamInstance = new FileParam(null, 'urls.txt');
        $ur = new UrlFileReader($fileParamInstance);
        $arrayUrls = $ur->read();
    }
    catch (\Exception $e){
        ?>
        <div class="alert alert-danger mt-3 mb-0" role="alert">
            <?= $e->getMessage();?>
        </div>
        <?php
    }

    $arrayDomain=[];
    foreach ($arrayUrls as $arrayUrl){
        $arrayDomain[method_exists($arrayUrl,'getDomain')?$arrayUrl->getDomain():null] += 1;
    }

    //insert in SQLite database
    try{

        $fileParamInstance2 = new FileParam('../db','urlDataBase.db');
        $urlModelInstance = new UrlModel($fileParamInstance2);
        $urlModelInstance->deleteAll();
        foreach ($arrayUrls as $item){
            $urlModelInstance->insert($item);
        }
    }
    catch (\Exception $e){
        ?>
        <div class="alert alert-danger mt-3 mb-0" role="alert">
            <?= $e->getMessage();?>
        </div>
        <?php
    }
    ?>

    <!--presentation part-->
    <div class="jumbotron mt-3 mb-0">
        <h1 class="display-4">Test work.</h1>
        <p class="lead">Read the url from  <?= $ur->getFileName() ?> and parsing. Saving data in SQLite and reading from there.</p>
        <hr class="my-4">
        <p>ustyushkin.vyacheslav@gmail.com</p>
    </div>

    <!--required part-->
    <div class="row">
        <div class="col mt-3">
            <ul class="list-group">
                <?php
                foreach ($arrayDomain as $key=>$value){
                    ?>
                    <li class="list-group-item"><?= $key ?> (number of repetitions <?= $value ?>)</li>
                    <?php
                }
                ?>
            </ul>
        </div>
    </div>

    <!--print_r part-->
    <p class="mt-3">
        <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseV" aria-expanded="false" aria-controls="collapseV">
            var_dump of returned array from UrlFileReader
        </button>
    </p>
    <div class="collapse" id="collapseV">
        <div class="card card-body">
            <?php
            foreach ($arrayUrls as $item){
                print_r($item);
                echo "<hr>";
            }
            ?>
        </div>
    </div>

    <!--getted data from SQLite-->
    <p class="mt-3">
        <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseS" aria-expanded="false" aria-controls="collapseS">
            Readed data from SQLite
        </button>
    </p>
    <div class="collapse" id="collapseS">
        <div class="card card-body">
            <?php
            $selectedUrls = $urlModelInstance->select();
            foreach ($selectedUrls as $item){
                print_r($item);
                echo "<hr>";
            }
            ?>
        </div>
    </div>
</div>

</body>
</html>