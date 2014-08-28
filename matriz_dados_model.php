<?php 

class MatrizDadosModel{

	private $conexao = NULL;
	private $dados_conexao = array('host'=>'localhost', 'user'=>'root', 'password'=>'', 'database'=>'matriz_dados');

	function __construct(){
		$this->ReiniciarConexao();
	}

	/*
	* Abre uma nova conexao com o banco de dados. Se uma conexão ja existir, ela sera fechada.
	*/
	private function ReiniciarConexao(){
		if($this->conexao) mysqli_close($this->conexao);
		$this->conexao = mysqli_connect($this->dados_conexao['host'], $this->dados_conexao['user'], $this->dados_conexao['password'], $this->dados_conexao['database']); 
	}

	/*
	* Salva um cargo no banco de dados e retorna seu id.
	*/
	public function SalvarCargo($nome_cargo, &$lista_cargo){
		$sql = " INSERT INTO cargo (nome) VALUES ('$nome_cargo') ";
		mysqli_query($this->conexao, $sql);

		$cargo_id = mysqli_insert_id($this->conexao);		
		$lista_cargo[$cargo_id] = $nome_cargo;

		return $cargo_id;
	}

	/*
	* Salva uma turma no banco de dados e retorna seu id.
	*/
	public function SalvarTurma($nome_turma, &$lista_turma){
		$sql = " INSERT INTO turma (nome) VALUES ('$nome_turma') ";
		mysqli_query($this->conexao, $sql);

		$turma_id = mysqli_insert_id($this->conexao);		
		$lista_turma[$turma_id] = $nome_turma;

		return $turma_id;
	}

	public function SalvarParticipante($sql){
		mysqli_multi_query($this->conexao, $sql);
		$this->ReiniciarConexao();
	}

	/*
	* Busca no banco de dados por um determinado cargo. Se o cargo existir a função retorna seu id.
	*/
	public function BuscarCargo($nome_cargo, &$lista_cargo){
		$sql = " SELECT id, nome FROM cargo WHERE nome = '$nome_cargo' ";
		$resultado = mysqli_query($this->conexao, $sql);
		$resultado = mysqli_fetch_row($resultado);
		
		if($resultado):
			$lista_cargo[$resultado[0]] = $resultado[1];
			return $resultado[0];
		endif;

		return FALSE;
	}

	/*
	* Busca no banco de dados por uma determinada turma. Se a turma existir a função retorna seu id.
	*/
	public function BuscarTurma($nome_turma, $lista_turma){
		$sql = " SELECT id, nome FROM turma WHERE nome = '$nome_turma' ";
		$resultado = mysqli_query($this->conexao, $sql);
		$resultado = mysqli_fetch_row($resultado);

		if($resultado):
			$lista_turma[$resultado[0]] = $resultado[1];
			return $resultado[0];
		endif;

		return FALSE;
	}

}