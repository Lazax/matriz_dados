<?php
include 'matriz_dados_model.php';

class MatrizDadosController{

	private $lista_cargo = array();
	private $lista_turma = array();
	private $query_inserir_participante = '';
	private $matrizModal = NULL;

	function __construct(){
		$this->matrizModal = new MatrizDadosModel();
	}

	function IniciarParseDados($matriz_dados){
		$arquivo = fopen($matriz_dados['tmp_name'], 'r');

		if(!feof($arquivo)) fgets($arquivo);

		$qtd_registros = 0;

		while(!feof($arquivo)):
			$linha = fgetcsv($arquivo, 0, '	');
			$qtd_registros++;
			
			if($linha !== FALSE):
				$this->TratarDadosTurma($linha[3]);
				$this->TratarDadosTurma($linha[4]);
				$this->TratarDadosTurma($linha[5]);
				$this->TratarDadosTurma($linha[6]);
				$this->TratarDadosCargo($linha[7]);

				if(isset($linha[0])) $this->montarQuery($linha);
			endif;

			if($qtd_registros == 100 || feof($arquivo)):
				$qtd_registros = 0;
				$this->SalvarParticipante();
			endif;
		endwhile;

		return TRUE;	
	}

	/*
	* Busca pela existencia de um cargo, se o cargo ainda não existir ele sera criado no banco de dados.
	*/
	function TratarDadosCargo(&$cargo){
		$cargo_id = $this->BuscarCargo($cargo);
		if(!$cargo_id) $cargo_id = $this->matrizModal->SalvarCargo($cargo, $this->lista_cargo);
		$cargo = $cargo_id;
	}

	/*
	* Busca pela existencia de uma turma, se a turma ainda não existir ela sera criada no banco de dados.
	*/
	function TratarDadosTurma(&$turma){
		$turma_id = $this->BuscarTurma($turma);
		if(!$turma_id) $turma_id = $this->matrizModal->SalvarTurma($turma, $this->lista_turma);	
		$turma = $turma_id;
	}

	/*
	* Busca pela existencia de um cargo no array $lista_cargo, se o cargo não existir sera realizada uma busca no banco de dados
	*/
	function BuscarCargo($nome_cargo){
		$cargo = array_search($nome_cargo, $this->lista_cargo);
		if(!$cargo) $cargo = $this->matrizModal->BuscarCargo($nome_cargo, $this->lista_cargo);
		return $cargo;
	}

	/*
	* Busca pela existencia de uma turma no array $lista_turma, se a turma não existir sera realizada uma busca no banco de dados
	*/
	function BuscarTurma($nome_turma){
		$turma = array_search($nome_turma, $this->lista_turma);
		if(!$turma) $turma = $this->matrizModal->BuscarTurma($nome_turma, $this->lista_turma);
		return $turma;
	}

	/*
	* Acessa o model para salvar os participantes no banco de dados
	*/
	function SalvarParticipante(){
		$this->matrizModal->SalvarParticipante($this->query_inserir_participante);
		$this->query_inserir_participante = '';
	}

	function montarQuery($participante){
		$sql = " INSERT INTO 
					participante (participanteid, cpf, nome_razao_social, login, email, telefone, fk_cargo, fk_turma_curso_amarelo, fk_turma_curso_verde, fk_turma_curso_vermelho, fk_turma_curso_azul) 
				VALUES
								($participante[0], $participante[1], '$participante[2]', '$participante[10]', '$participante[9]', '$participante[8]', $participante[7], $participante[3], $participante[4], $participante[5], $participante[6]); ";
		
		$this->query_inserir_participante .= $sql;
	}
}