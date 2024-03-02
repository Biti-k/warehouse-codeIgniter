<?php

// app/Helpers/info_helper.php
use CodeIgniter\CodeIgniter;

/**
 * Returns CodeIgniter's version.
 */

function transformar($cat_prods, $controller){
    foreach($cat_prods as $c){
        $cat = $controller->Categoria->get($c->categoria);
        $c->categoria .= "-" . $cat[0]->nombre;
    }
    return $cat_prods;
}