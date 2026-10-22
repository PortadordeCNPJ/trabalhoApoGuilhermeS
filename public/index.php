<?php
require "../bootstrap.php";

// Página padrão
$pagina = $_GET['pagina'] ?? 'home';

// Páginas disponíveis
$paginas = [
    'login' => 'login.php',
    'home' => 'home.php',
    'produtos' => 'produtos.php',
    'fretes' => 'fretes.php',
    'transporte' => 'transporte.php',
    
    //Páginas que vão ficando dentro do controller
    'criarUsuarios' => 'criarUsuarios.php'
];

if (empty($_SESSION)) {

    // Verifica se a página existe
    if (!isset($paginas[$pagina])) {
        http_response_code(404);
        $pagina = 'login';
    } else {

        // Verifica se a página existe
        if (!isset($paginas[$pagina])) {
            http_response_code(404);
            $pagina = 'home';
        }
    }
}

// Verifica se a página existe



// Caminho completo da página
$arquivo = __DIR__ . '/../app/views/' . $paginas[$pagina];


// FAZER O LOGIN PARA PODER ARRUMAR A TELA DE LOGIN
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@6.0.0-alpha.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-B/GM4XqrwHnWXNOWMbloTmrYXZg10cakYGmpfsR/bbzQ6JAJI4ihuyADKLnBgrCe" crossorigin="anonymous">
    <script type="module" src="https://cdn.jsdelivr.net/npm/bootstrap@6.0.0-alpha.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-1a/pXj49ZQ1aHEmrJ+gMw1otqoVsYwlEnlD8mIfY2TV03r20Y0CN7uqx1tQogjPL" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="./assets/css/transptech.css">
    <title>TranspTech</title>
</head>

<body>

    <?php

    if (empty($_SESSION)) {

    ?>
        <div>
            <?php require $arquivo ?>
        </div>

    <?php
    } else {
    ?>
        <div class="cssMain">

            <div class="headerMain">
                <?php require '../app/views/header.php'; ?>
            </div>

            <div class="containerMain">
                <?php require $arquivo ?>
            </div>

            <div class="footerMain">
                <?php require '../app/views/footer.php'; ?>
            </div>
        </div>
    <?php
    }
    ?>


</body>

</html>