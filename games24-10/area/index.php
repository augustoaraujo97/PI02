<?php

require('../db/db.php');

$msg = '';
$result = '';

// --------------------------------------------------------------------Pesquisa --------------------------------------------------------------------
if(isset($_POST['btnPesquisar'])) {
	if (!empty($_POST['txtPesquisa'])) {
			$pesquisa = $_POST['txtPesquisa'];
			// Criar um fun��o para evitar injection

			$query = odbc_exec($db, "SELECT 
										codArea, 
										descricao 
									FROM 
										area 
									WHERE descricao LIKE '%$pesquisa%'" ); 
			$butt = "<button id='btnVoltar' name='btnVoltar'><a href='index.php'>Voltar</a></button>";
	} else {
		$query = odbc_exec($db, 'SELECT 
									codArea,
									descricao
								FROM 
									Area');
	}
} else {
	// Valor default
	$query = odbc_exec($db, 'SELECT 
								codArea,
								descricao
							FROM 
								Area');
}



//-------------------------------------------------------------------- Exibe na grade--------------------------------------------------------------------
while($result = odbc_fetch_array($query)){
	$areas[$result['codArea']] = utf8_encode($result['descricao']);
}

//--------------------------------------------------------------------DELETE--------------------------------------------------------------------
if(isset($_GET['dcod'])){
	if(is_numeric($_GET['dcod'])){
		//verifica se existe dependencia
		$descricao = odbc_exec($db,' SELECT 
										descricao 
									FROM 
										Assunto 
									WHERE codArea='.$_GET['dcod']);
		$num = odbc_num_rows($descricao);
		if($num > 0){
			$msg = "N�o foi possivel deletar <br> A area possui dependencia com o(s) campo(s): ";
			while($pega = odbc_fetch_array($descricao)){
				$msg .= "".$pega['descricao'].", ";
			}
		}else{
			if(!odbc_exec($db, "DELETE FROM 
									Area 
								WHERE 
									codArea =".$_GET['dcod'])){
				$msg = "N�o foi possivel apagar o dado";
			}else{
				header("Location: index.php");
			}
		}
	}else{
		$msg = "ERRO : ID n�o valido";
	}
}

//-------------------------------------------------------------------- COME�O DOS CRUDS--------------------------------------------------------------------
// --------------------------------------------------------------------INSERT--------------------------------------------------------------------
if(isset($_POST['btnInclude'])) {
	$area = $_POST['txtInclude'];
	$area = preg_replace("/[^a-zA-Z0-9 -]/",'',$_POST['txtInclude']);
	
	$prepare = odbc_prepare($db, "INSERT INTO 
									Area (descricao) 
								  VALUES 
									(?)");
	
	if(!odbc_execute($prepare, array($area))){
							
		$msg = "N�o foi possivel inserir";
	}else {
		header("Location: index.php");
	}
}

//--------------------------------------------------------------------EDITAR--------------------------------------------------------------------
if(isset($_GET['ecod']) && is_numeric($_GET['ecod'])){

	$select = odbc_exec($db, "SELECT 
								codArea, 
								descricao 
							FROM 
								Area 
							WHERE codArea = ".$_GET['ecod']);
	$result = odbc_fetch_array($select);
	include_once('templats/crudArea.php');
} else {
	$result = '';
}

//--------------------------------------------------------------------UPDATE--------------------------------------------------------------------
if(isset($_POST['btnAlterar']  )){
	if(is_numeric($_GET['ecod'])){
		$area = $_POST['txtDescricao'];
		$area = preg_replace("/[^a-zA-Z0-9 -]/",'',$_POST['txtDescricao']);
		
		$prepare = odbc_prepare($db, "UPDATE 
										Area 
									  SET 
										descricao = ? 
									  WHERE 
									   codArea = {$_GET['ecod']}");
		
		if(odbc_execute($prepare, array($area))){
			header("Location: index.php");
		}
	}else{
		$msg = "N�o foi poss�vel atualizar";
	}
}

//-------------------------------------------------------------------- FIM UPDATE--------------------------------------------------------------------
$msg = utf8_encode($msg);
if(isset($_POST['btnNovo']) || isset($_GET['ecod']) ){
	include_once('templats/crudArea.php');	
}else{
	include_once('templats/area.php');	
}
?>