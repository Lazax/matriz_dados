<?php
include 'matriz_dados_controller.php';

if(isset($_FILES['arquivo'])):	
	$arquivo = $_FILES['arquivo'];

	if($arquivo['error']):
		echo "<h4>Ocorreu um erro durante o envio do arquivo. Tente novamente.</h4>";
	else:
		$matrizController = new MatrizDadosController();
		$resultado = $matrizController->IniciarParseDados($arquivo);
	endif;
endif;

?>
<html>
	<head>
		<title>Matriz de Dados</title>
	</head>

	<body>
		<?php if(isset($resultado)) echo "<h3>Matriz salva com sucesso.</h3>" ?>
		
		<label>Selecione um arquivo</label>
		<form action="#" method="POST" enctype="multipart/form-data">
			<input type='file' name='arquivo' />
			<button type='submit'>Realizar Upload</button>
		</form>
	</body>
</html>