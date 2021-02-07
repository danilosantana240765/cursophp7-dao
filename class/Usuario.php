<?php

class Usuario {
	private $idusuario;
	private $deslogin;
	private $dessenha;
	private $dtcadastro;

	public function setIdUsuario($idusuario) {
		$this->idusuario = $idusuario;
	}

	public function setDesLogin($deslogin) {
		$this->deslogin = $deslogin;
	}

	public function setDesSenha($dessenha) {
		$this->dessenha = $dessenha;
	}

	public function setDtCadastro($dtcadastro) {
		$this->dtcadastro = $dtcadastro;
	}

	public function getIdUsuario() {
		return $this->idusuario;
	}

	public function getDesLogin() {
		return $this->deslogin;
	}

	public function getDesSenha() {
		return $this->dessenha;
	}

	public function getDtCadastro() {
		return $this->dtcadastro;
	}

	public function loadById($id) {
		$sql = new Sql();
		$result = $sql->select("SELECT * FROM usuario WHERE idusuario = :ID", array(
			":ID" => $id
		));

		if(count($result[0]) > 0) {
			$row = $result[0];

			$this->setIdUsuario($row["idusuario"]);
			$this->setDesLogin($row["deslogin"]);
			$this->setDesSenha($row["dessenha"]);
			$this->setDtCadastro(new DateTime($row["dtcadastro"]));
		}
	}

	public static function getList() {
		return (new Sql)->select("SELECT * FROM usuario ORDER BY deslogin");
	}

	public static function search($login) {
		return (new Sql)->select("SELECT * FROM usuario WHERE deslogin LIKE :LOGIN", array(
			":LOGIN" => "%{$login}%"
		));
	}

	public function login($login, $senha) {
		$sql = new Sql();
		$result = $sql->select("SELECT * FROM usuario WHERE deslogin = :LOGIN AND dessenha = :PASS", array(
			":LOGIN" => $login,
			":PASS" => $senha
		));

		if(isset($result[0])) {
			$row = $result[0];

			$this->setIdUsuario($row["idusuario"]);
			$this->setDesLogin($row["deslogin"]);
			$this->setDesSenha($row["dessenha"]);
			$this->setDtCadastro(new DateTime($row["dtcadastro"]));
		} else {
			throw new Exception("Login ou senha inválido", 1);
		}
	}

	public function __toString() {
		return json_encode(array(
			"idusuario" => $this->getIdUsuario(),
			"deslogin" => $this->getDesLogin(),
			"dessenha" => $this->getDesSenha(),
			"dtcadastro" => $this->getDtCadastro()->format("d/m/Y H:i:s")
		));
	}
}