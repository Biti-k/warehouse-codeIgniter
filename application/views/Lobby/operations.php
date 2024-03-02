<!DOCTYPE html>
<?php include(APPPATH . 'libraries/phpqrcode/QRCode.php'); ?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <style>
        .etiqueta{
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
            transition: 450ms;
            transform-origin: 100% 100%;
            min-height: 3vw;
        }
        .etiqueta:hover{
            cursor:pointer;
            transform: scaleY(0.85);
        }
        .main{
            width: 97%;
        }
        html{
            height: 100%;
        }
        body{
            height: 100%;
        }
        img{
            width: 40%;
        }

        .enl{
            transform: translateX(-50%);
            font-size: 2vw;
        }
        svg{
            background: #FAF9F6;
            padding: 1px;
            border-radius: 15px;
            height: 50%;
        }
    </style>
    <script src="<?php echo base_url('/js/main.js') ?>" ></script>
    <title>Magatzem</title>
</head>
<body>
    <div class="etiquetes row container-fluid m-0 mt-3">
        <div class="etiquetaContainer d-flex gap-4">
            <h2 class="text-center bg-dark text-light p-1 etiqueta col-2 m-0 shadow position-relative"><a class="text-light text-decoration-none position-absolute start-50 enl w-100 h-100" href="<?php echo site_url("/Inici");?>">Products</a></h2>
            <h2 class="text-center bg-dark text-light p-1 etiqueta col-2 m-0 shadow position-relative"><a class="text-light text-decoration-none position-absolute start-50 enl w-100 h-100" href="<?php echo site_url("/Inici/Operations");?>">Operations</a></h2>
        </div>
    </div>
    <div class="main container-fluid ms-4 bg-light m-0 row h-100 pt-3 rounded shadow">
        <div class="m-0 products container col-12">

            <div class="xml d-flex justify-content-between">
                <div>
                    <h3>Products</h3>
                    <a class='btn btn-primary' href='<?= site_url("Inici/see_all_operations/") ?>'>See all operations reports</a>
                </div>
                <?php echo form_open_multipart("/Inici/insert_xml") ?>
                    <h4>Insert xml operations</h4>
                    <div class="d-flex align-items-center mb-3">
                        <input class="form-control" type="file" id="formFile" name='xmlFile'>
                        <input type="submit" class='btn btn-primary ms-2' value="Send">
                        <p> <?php echo isset($uploadErrors) ? $uploadErrors : ""; ?> </p>
                    </div>
                <?php echo form_close(); ?>
            </div>
            <?php
                foreach($productes as $producte){
                    echo "<div class='producte bg-dark p-3 row rounded mb-3'> <div class='text-image col-8'><h5 class='text-light'> " . $producte->nom . " - Stock: " . $producte->stock . "</h5><img class='h-auto rounded' src='". base_url('/uploads/') . $producte->imatge . "'></div>";
                    echo "<div class='categorias text-light col-4'><h5>Categories</h5> <ul class='mb-5'>";
                    foreach($cat_prods as $cprod){
                        if($cprod->producte == $producte->id){
                            $categoria = $cprod->categoria;
                            $categoria = substr($categoria, strpos($categoria, "-") + 1);
                            echo "<li>" . $categoria. "</li>";
                        }
                    }
                    echo "</ul>";
                    ?>
                        <div>
                            <?php
                                echo form_open("/Inici/operations"); 
                            ?>
                                <h3 class='text-light'>Add/take</h3>
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="basic-addon1">Quantity</span>
                                    <input type="number" name="qt" class="form-control" placeholder="Quantity" aria-label="name" aria-describedby="basic-addon1">
                                </div>
                                <div class="buttons d-flex gap-4">
                                    <input type='submit' name='add' class='btn btn-primary w-50 fw-bold' value="BUY">
                                    <input type='submit' name='take' class='btn btn-warning w-50 fw-bold' value="SELL">
                                    <input type='hidden' value='<?php echo $producte->id; ?>' name='pid'>
                                </div>
                                </form>
                                <div class="operations d-flex justify-content-center mt-4">
                                </div>
                                <?php echo validation_errors("<p class='text-danger bg-light rounded-pill p-1 mt-3 text-center'>", "</p>") ?>
                            </div>
                            <?php 
                                // outputs image directly into browser, as PNG stream
                                echo "<div class='w-100 d-flex justify-content-center'>" . QRCode::svg(site_url("/Inici/producte?id=" . $producte->id)) . "</div>";
                            ?>
                        </div>

                    </div>
                    <?php
                }
            ?>
        </div>
            
        </div>
    </div>
</body>
</html>