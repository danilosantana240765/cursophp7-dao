<?php
class Usuario {
	private $idusuario;
	private $deslogin;
	private $dessenha;
	private $dtcadastro;

	public function getIdUsuario(){
		return $this->idusuario;
	}

	public function setGetIdUsuario($idusuario){
		$this->idusuario = $idusuario;
	}

	public function getDeslogin(){
		return $this->deslogin;
	}

	public function setDeslogin($deslogin){
		$this->deslogin = $deslogin;
	}

	public function getDessenha(){
		return $this->dessenha;
	}

	public function setDessenha($dessenha){
		$this->dessenha = $dessenha;
	}

	public function getDtCadastro(){
		return $this->dtcadastro;
	}

	public function setDtCadastro($dtcadastro){
		$this->dtcadastro = $dtcadastro;
	}

	//Metódos 
	public function loadById($id){
		$sql = new Sql();
		$result = $sql->select("SELECT * FROM tb_usuarios WHERE idusuario = :ID", array(
			":ID" => $id
		));

		if(count($result) > 0){
			//$row = $result[0];

			$this->setData($result[0]);
		}
	}

	public static function getList(){
		$sql = new Sql();
		return $sql->select("SELECT * FROM tb_usuarios ORDER BY deslogin");
	}

	public static function search($login){
		$sql = new Sql();
		return $sql->select("SELECT * FROM tb_usuarios WHERE deslogin LIKE :SEARCH ORDER BY deslogin", array(
			":SEARCH" => "%".$login."%"
		));
	}

	public function login($login, $password){
		$sql = new Sql();
		$result = $sql->select("SELECT * FROM tb_usuarios WHERE deslogin = :DESLOGIN AND dessenha = :PASSWORD", array(
			":DESLOGIN" => $login,
			":PASSWORD" => $password
		));

		if(count($result) > 0){
			//$row = $result[0];
			$this->setData($result[0]);
		}else {
			throw new Exception("Login e/ou senha inválido");
		}
	}

	public function setData($data){
		//print_r($data);
		$this->setGetIdUsuario($data['idusuario']);
		$this->setDeslogin($data['deslogin']);
		$this->setDessenha($data['dessenha']);
		$this->setDtCadastro(new DateTime($data['dt_cadastro']));
	}

	public function insert(){
		$sql = new Sql();
		$result = $sql->select("CALL sp_usuarios_insert(:LOGIN, :PASSWORD)", array(
			":LOGIN" => $this->getDeslogin(),
			":PASSWORD" => $this->getDessenha()
		));

		if(count($result) > 0){
			$this->setData($result[0]);
		}
	}

	public function update($login, $password){
		$this->setDeslogin($login);
		$this->setDessenha($password);
		$sql = new Sql();
		$sql->query("UPDATE tb_usuarios SET deslogin = :LOGIN, dessenha = :PASSWORD WHERE idusuario = :ID", array(
			":LOGIN" => $this->getDeslogin(),
			":PASSWORD" => $this->getDessenha(),
			":ID" => $this->getIdUsuario()
		));
	}

	public function __construct($login = "", $password = ""){
		$this->setDeslogin($login);
		$this->setDessenha($password);
	}

	public function __toString(){
		return json_encode(array(
			"idsuario" => $this->getIdUsuario(),
			"deslogin" => $this->getDeslogin(),
			"dessenha" => $this->getDessenha(),
			"dtcadastro" => $this->getDtCadastro()->format("d/m/Y H:i:s")
		));
	}

}