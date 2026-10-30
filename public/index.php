<?php

require "../bootstrap.php";


// Página padrão
$pagina = $_GET['pagina'] ?? 'home';

// Páginas disponíveis

if (empty($_SESSION)) {
    $paginas = [
        //Views
        'login' => 'views/login.php',

        //Páginas que vão ficando dentro do controller
        'usuarioLogin' => 'controllers/UsuarioLogin.php',
    ];
} else {
    if ($_SESSION['tipo_usuario'] === "usuario") {
        $paginas = [
            //Views
            'home' => 'views/home.php',
            'produtos' => 'views/produtos.php',
            'fretes' => 'views/fretes.php',
            'transporte' => 'views/transporte.php',
            'criarUsuarios' => 'views/criarUsuarios.php',
        ];
    } else {
        $paginas = [
            //Views
            'home' => 'views/home.php',
            'fretes' => 'views/fretes.php',
            'transporte' => 'views/transporte.php',
            'criarUsuarios' => 'views/criarUsuarios.php',
            'admin' => 'views/admin/adminHome.php',
            'cadastro_produtos' => 'views/admin/produtos.php',
            'produtoController' => 'controllers/ProdutoController.php',
        ];
    }
}


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
$arquivo = __DIR__ . '/../app/' . $paginas[$pagina];


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
    <link rel="stylesheet" type="text/css" href="./assets/css/produtos.css">
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

                <?php

                require $arquivo;

                if ($arquivo === 'C:\xampp\htdocs\trabalhoApoGuilhermeS\public/../app/controllers/ProdutoController.php') {
                    \app\controllers\ProdutoController::cadastrar();
                }

                if ($arquivo === 'C:\xampp\htdocs\trabalhoApoGuilhermeS\public/../app/views/admin/produtos.php') {
                    \app\controllers\ProdutoController::index();
                }
                ?>
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