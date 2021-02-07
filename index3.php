<?php
require_once "config.php";

$sql = new Sql();

// $usuarios = $sql->select("SELECT * FROM meu_chat");

// echo json_encode($usuarios);

$user = new Usuario();
$user->loadById(2);
// echo $user;

# Carrega todos os usuário
//echo json_encode(Usuario::getList());

# Carrega uma lista de usuario buscando pelo usuario
//echo json_encode(Usuario::search("jo"));

# Efetuar um login
/*try {
	$user->login("danilosantana", "12345678");
	echo $user;
} catch(Exception $e) {
	echo json_encode(array(
		"message"=> $e->getMessage(),
		"line"=> $e->getLine()
	));
}*/

# Inserindo um usuario
/*$user->setDesLogin("gabriela");
$user->setDesSenha("12345");
$user->insert();
echo $user;*/

# Atualizando o usuario
/*$usuario = new Usuario();
$usuario->loadById(8);
$usuario->update("professor", "@93838s");
echo $usuario;*/

# Deletando um usuário
$usuario = new Usuario();
$usuario->loadById(7);
$usuario->delete();

echo $usuario;