<?php 
    defined('BASEPATH') OR exit('No direct script access allowed');
    
?>
<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <style>
        html{
            height: 100%;
        }
        body{
            height: 100%;
        }
        form{
            transform: scale(1.2);
        }
    </style>
</head>
<body class="h-100 d-flex flex-column justify-content-center align-items-center">
<form action="<?php echo site_url('Login/login');?>" method="post" name="f">
	<p class="fs-1 m-0">Username:</p> <br><input type='text' name="nom"><br>
	<p class="fs-1 m-0">Password:</p> <br><input type='password' name="pass"><br>
    <div class="submit d-flex justify-content-center">
        <input type="submit" name="submit" value="Login" class="mt-3 m-auto fs-5 w-100 btn btn-primary text-center">
    </div>
    <p class="text-warning"> <?php echo $msg; ?> </p>
</form>
</body>
</html>
