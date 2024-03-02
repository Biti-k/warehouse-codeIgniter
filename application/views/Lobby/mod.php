<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/6065513cb1.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <title>Modify product</title>
    <style>
        html{
            height: 100%;
        }
        body{
            height: 100%;
        }

        .main{
            min-height: 60%;
        }
        
        .fa-arrow-turn-up{
            transform: rotate(-90deg);
            transition: 250ms;
        }

        .fa-arrow-turn-up:hover{
            color: white !important;
            background-color: #292929 !important;
        }
    </style>
</head>
<?php 
    $mod = $_GET['mod'];
?>
<body>
    <div class="container bg-light w-100 mt-4 rounded main d-flex align-items-center flex-column">
    <h1 class='text-center mt-4'><a href='<?php echo site_url("/Inici");?>'><i class="fa-solid fa-arrow-turn-up text-black bg-white p-2 fs-2 rounded-pill me-4 shadow"></i></a>Modify product: <u><?php echo $producte[0]->nom; ?></u></h1>
      <div class="p-3 modify bg-dark rounded w-75 mt-2">
        <?php echo form_open_multipart('Inici/mod?mod=' . $mod) ?>
        <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1">Product name</span>
                <input type="text" name="name" class="form-control" placeholder="Product name" aria-label="name" aria-describedby="basic-addon1" value="<?php echo $producte[0]->nom; ?>">
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1">Initial Stock</span>
                <input type="text" name="stock" class="form-control" placeholder="Stock" aria-label="name" aria-describedby="basic-addon1" value="<?php echo $producte[0]->stock; ?>">
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
                                <input type='checkbox' name='categoriesS[]'";
                            foreach($cat_prods as $c){
                                if($c->producte == $producte[0]->id && $c->categoria == $cat->id){
                                    echo " checked ";
                                }
                            }
                            echo  "value=" . $cat->id . "> " . $cat->nombre . "
                            </label>
                            </li>";
                        }

                    ?>
                </ul>
            </div>
            
            <div class="mb-3">
                <label for="formFile" class="form-label text-light fs-5" >Replace image</label>
                <input class="form-control" type="file" id="formFile" name='img'>
            </div>

            <?php echo validation_errors("<p class='text-danger p-1 mt-3 bg-light rounded'>", "</p>") ?>   
            <p><?php echo isset($uploadErrors) ? $uploadErrors : ''; ?></p>
            <input type="submit" name="modified" value="Send" class="btn btn-primary m-auto d-block mt-4 w-50">
            
        <?php echo form_close(); ?>
      </div>  
    </div>
</body>
</html>