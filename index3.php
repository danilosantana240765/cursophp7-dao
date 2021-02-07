<?php
require_once "config.php";

$sql = new Sql();

// $usuarios = $sql->select("SELECT * FROM meu_chat");

// echo json_encode($usuarios);

$user = new Usuario();
$user->loadById(2);

echo $user;