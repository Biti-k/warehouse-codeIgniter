<!DOCTYPE html>
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
            min-height: 100%;
        }
        img{
            width: 40%;
        }

        .enl{
            transform: translateX(-50%);
            font-size: 2vw;
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
    <div class="main container-fluid ms-4 bg-light m-0 row h-100 rounded shadow">
        <div class="m-0 products container col-6">
            <h3 class="pt-3">Products</h3>
            <?php 
                foreach($productes as $producte){
                    echo "<div class='producte bg-dark p-3 row rounded mb-3'> <div class='text-image col-8'><h5 class='text-light'> " . $producte->nom . " - Stock: " . $producte->stock . "</h5><img class='h-auto rounded' src='". base_url('/uploads/') . $producte->imatge . "'></div>";
                    echo "<div class='categorias text-light col-4'><h5>Categories</h5> <ul>";
                    foreach($cat_prods as $cprod){
                        if($cprod->producte == $producte->id){
                            $categoria = $cprod->categoria;
                            $categoria = substr($categoria, strpos($categoria, "-") + 1);
                            echo "<li>" . $categoria. "</li>";
                        }
                    }
                    echo "</ul></div><div class='delete-mod w-100 d-flex justify-content-end gap-4'>";
                    echo "<a class='btn btn-danger' href='#' data-bs-toggle='modal' data-bs-target='#modalDelete{$producte->id}' '>DELETE</a>";
                    echo "<a class='btn btn-primary' href='" . site_url('/Inici/mod') . "?mod=" . $producte->id . "'>MODIFY</a>";
                    echo "</div></div>";
                    echo "<div class='modal' tabindex='-1' id='modalDelete{$producte->id}'>
                    <div class='modal-dialog'>
                            <div class='modal-content d-flex justify-content-center'>    
                                <div class='modal-header'>
                                    <h5 class='modal-title text-center'>Delete product?</h5>
                                    <button type='button' class='btn-close text-center' data-bs-dismiss='modal' aria-label='Close'></button>
                                </div>
                                <div class='modal-footer d-flex justify-content-center'>
                                    <button type='button' class='btn btn-primary' data-bs-dismiss='modal'>NO</button>
                                    <button type='button' class='btn btn-danger' onclick='confirmDelete({$producte->id})'>YES</button>
                                </div>
                            </div>
                        </div>
                    </div>";
                    // JavaScript for confirmation modal
                    echo "<script>
                            function confirmDelete(productId){
                                console.log('hola');
                                window.location.href = '" . site_url('/Inici') . "?delete=' + productId;
                            }
                    </script>";
                }
            ?>
        </div>
        <div class="m-0 px-2 form container col-6 gx-0">
            <h3 class="pt-3">New Product</h3>
            <?php 
                echo form_open_multipart('Inici', "class='bg-dark h-auto rounded p-2'");
            ?>
            <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1">Product name</span>
                <input type="text" name="name" class="form-control" placeholder="Product name" aria-label="name" aria-describedby="basic-addon1">
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1">Stock</span>
                <input type="text" name="stock" class="form-control" placeholder="Stock" aria-label="name" aria-describedby="basic-addon1">
            </div>
            
            <div class="btn-group w-100 mb-3">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                    Categories
                </button>
                <ul class="dropdown-menu w-100" aria-labelledby="dropdownMenuButton">
                    <?php 
                        foreach($categories as $cat){
                            echo 
                            "<li>
                            <label class='dropdown-item'>
                                <input type='checkbox' name='categoriesS[]' value=" . $cat->id . "> " . $cat->nombre . "
                            </label>
                            </li>";
                        }

                    ?>
                </ul>
            </div>
            
                <div class="mb-3">
                    <label for="formFile" class="form-label text-light fs-5" >Image</label>
                    <input class="form-control" type="file" id="formFile" name='img'>
                </div>

            <?php echo validation_errors("<p class='text-danger p-1 mt-3 bg-light rounded'>", "</p>") ?>   
            <p><?php echo isset($uploadErrors) ? $uploadErrors : ''; ?></p>
            <input type="submit" name="submit" value="Create product" class="btn btn-primary m-auto d-block mt-4">
            
            <?php
                echo form_close();
            ?>
            
        </div>
    </div>
</body>
</html>