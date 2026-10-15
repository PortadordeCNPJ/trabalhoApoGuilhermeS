<?php
require "../bootstrap.php";

// Página padrão
$pagina = $_GET['pagina'] ?? 'home';

// Páginas disponíveis
$paginas = [
    'home' => 'home.php',
    'produtos' => 'produtos.php',
    'fretes' => 'fretes.php',
    'transportadores' => 'transportadores.php'
];

// Verifica se a página existe
if (!isset($paginas[$pagina])) {
    http_response_code(404);
    $pagina = 'home';
}

// Caminho completo da página
$arquivo = __DIR__ . '/../app/' . $paginas[$pagina];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@6.0.0-alpha.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-B/GM4XqrwHnWXNOWMbloTmrYXZg10cakYGmpfsR/bbzQ6JAJI4ihuyADKLnBgrCe" crossorigin="anonymous">
    <script type="module" src="https://cdn.jsdelivr.net/npm/bootstrap@6.0.0-alpha.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-1a/pXj49ZQ1aHEmrJ+gMw1otqoVsYwlEnlD8mIfY2TV03r20Y0CN7uqx1tQogjPL" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="transptech.css">
    <title>TranspTech</title>
</head>

<body>
    <h2>Hello World</h2>

</body>

</html>