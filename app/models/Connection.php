<?php

namespace app\models;

use PDO;

class connection
{

    //Função que ira fazer a conexão com bando de dados (PDO)
    public static function connect()
    {

        //require puxando as informações do config.php
        $config = require "./config.php";

        new PDO('mysql:host=localhost;dbname=transp_tech;charset=utf8', 'root', '');

        //Aqui estamos atribuindo e criando o PDO, passando para ele as informações que nós colocamos no array de dentro de config.php 
        $pdo = new PDO("mysql:host={$config['db']['host']};dbname={$config['db']['dbname']};charset={$config['db']['chartset']}", $config['db']['user'], $config['db']['pass']);
        
        //Esse setAttribute, mostra os tipos que os erros iram aparecer quando der um tipo de erro
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        //Esse setAttribute, mostra as informações que vem das tabelas, como objeto e não como array
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

        return $pdo;
    }
}
