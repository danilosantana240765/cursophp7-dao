<?php
require_once("config.php");


//Carrega um usuario
/*$root = new Usuario();
$root->loadById(4);
echo $root*/
// Carrega lista de usuarios
//$lista = Usuario::getList();

//echo json_encode($lista);

//Carrega uma lista de usuario buscando por login

//$search = Usuario::search("us");
//echo json_encode($search);

//Carrega o usuario o login e uma senha

// Criando um novo usuario
//$usuario = new Usuario();
//$usuario->login("danilo", "12345678d");
/*$aluno = new Usuario("hcode", "12345");
$aluno->insert();
echo $aluno;*/

$usuario = new Usuario();
$usuario->loadById(10);
$usuario->update("professor", "professor");

echo $usuario;