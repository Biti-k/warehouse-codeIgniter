<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>See all operations</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/6065513cb1.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <style>
        .etiqueta{
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
            transition: 450ms;
            transform-origin: 100% 100%;
        }
        .etiqueta:hover{
            cursor:pointer;
            transform: scaleY(0.85);
        }
        .main{
            width: 97%;
            min-height: 90%;
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
        
        .op{
            flex-wrap: wrap;
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
<body class="d-flex justify-content-center">
    <div class="main bg-light p-2 m-2 rounded shadow">
        <h2 class="bg-dark text-light rounded-pill p-1 shadow text-center mt-2 w-100"><a href=<?= site_url('/Inici/operations');?>><i class="fa-solid fa-arrow-turn-up text-black bg-white p-2 fs-2 rounded-pill me-4 shadow"></i></a>All operations <a class='btn btn-secondary ms-2' href='<?= site_url("/inici/pdfOperations"); ?>'>DOWNLOAD PDF</a></h2>
        <div class="d-flex mx-0 h-auto gap-2 justify-content-center row row-cols-2 gx-2 gy-2">
            <?php 
                foreach($ops as $op){
                    ?>
                    <div class="rounded bg-secondary p-2 d-flex flex-wrap op lh-3 shadow col w-auto"> 
                    
                    <?php echo "<div class='text-light'><b>Product: </b>" . $op->producte . "<br> <b>Date:</b> " .  $op->data . "<br> <b>Quantity: </b>";
                        if($op->unitats < 0){
                            echo $op->unitats . " (SOLDS)</div>";
                        }else{
                            echo $op->unitats . " (BOUGHTS)</div>";
                        }
                    
                    ?>
                    </div>
                    <?php
                }

            ?>
        </div>
    </div>

</body>
</html>