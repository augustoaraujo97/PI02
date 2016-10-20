<?php
require("../db/db.php");
	
// ------------------------------------------------- SELECT GRADE PROF -------------------------------

$query = odbc_exec($db, "SELECT codProfessor,
								nome,	
								email,
								senha,
								idSenac,
								tipo
							FROM
								Professor");
while($result = odbc_fetch_array($query)){
		
	$prof[$result['codProfessor']]['nome'] = utf8_encode($result['nome']);	
	$prof[$result['codProfessor']]['email'] = utf8_encode($result['email']);	
	$prof[$result['codProfessor']]['senha'] = utf8_encode($result['senha']);	
	$prof[$result['codProfessor']]['idSenac'] = $result['idSenac'];	
	$prof[$result['codProfessor']]['tipo'] = $result['tipo'];	
	
}

// -------------------------------------------------------- DELETE -------------------------------------------------
if(isset($_GET['dcod'])){
	if(is_numeric($_GET['dcod'])){
			if(!odbc_exec($db, "DELETE FROM 
									Professor 
								WHERE 
									codProfessor =".$_GET['dcod'])){
				$msg = "Não foi possivel apagar o dado";
			}else{
				header("Location: index.php");
			}
	}else{
		$msg = "ERRO : ID não valido";
	}
}
// ---------------------------------------- FIM DELETE ---------------------------------------------------------------
// ---------------------------------------- INSERT PROF ---------------------------------------------------------------

if(isset($_POST['btnInclude'])) {

	$nome = preg_replace("/[^a-zA-Z0-9 -]/",'',$_POST['txtNomeProf']);
	$email = $_POST['txtEmailProf'];
	$senha = $_POST['txtSenhaProf'];
	$id = $_POST['txtIDProf'];
	$tipo = preg_replace("/[^a-zA-Z0-9 -]/",'',$_POST['rdTipo']);
	//Verifica se os dados entrados estão corretos
	
	if(!is_numeric($id))$msg .= "ID inserido não é numerico <br>";
	if(strlen($id) <> 6)$msg .= "ID inserido não contem exatos 6 digitos <br>";
	if($tipo <> 'A' && $tipo <> 'P')$msg .= "Tipo inserido não é valido <br>";
	if (!filter_var($email, FILTER_VALIDATE_EMAIL))$msg .= "Email não é valido <br>";
	
	// Verifica se algum erro foi encontrado para então fazer a inserção
	if(!isset($msg)){
		if(!odbc_exec($db, "INSERT INTO 
								Professor (nome, email, senha, idSenac, tipo)
							VALUES
								('$nome', '$email', HASHBYTES('SHA1','$senha'), '$id', '$tipo')")){
		$msg = "Não foi possivel inserir";
		}else {
			header("Location: index.php");
		}
	}
	
}
// ---------------------------------------- FIM INSERT PROF ---------------------------------------------------------------
// ------------------------------------------------- COMEÇO UPDATE ----------------------------------------------------------
//Consulta do ID
if(isset($_GET['ecod'])){
	if(!is_numeric($_GET['ecod']))$msg .= 'Código invalido.';
	if(!isset($msg)){
		$query = odbc_exec($db, "SELECT 
							codProfessor,
							nome,	
							email,
							senha,
							idSenac,
							tipo
						FROM
							Professor
						WHERE
							codProfessor = ".$_GET['ecod']."");
		$result = odbc_fetch_array($query);
	}
	if(isset($_POST['btnUpdate'])){
		$nome = preg_replace("/[^a-zA-Z0-9 -]/",'',$_POST['txtNomeProf']);
		$email = $_POST['txtEmailProf'];
		$senha = $_POST['txtSenhaProf'];
		$id = $_POST['txtIDProf'];
		$tipo = preg_replace("/[^a-zA-Z0-9 -]/",'',$_POST['rdTipo']);
		//Verifica se os dados entrados estão corretos
		
		if(!is_numeric($id))$msg .= "ID inserido não é numerico <br>";
		if(strlen($id) <> 6)$msg .= "ID inserido não contem exatos 6 digitos <br>";
		if($tipo <> 'A' && $tipo <> 'P')$msg .= "Tipo inserido não é valido <br>";
		if (!filter_var($email, FILTER_VALIDATE_EMAIL))$msg .= "Email não é valido <br>";
		
		// Verifica se algum erro foi encontrado para então fazer a inserção
		if(!isset($msg)){
			if($query = odbc_exec($db, "UPDATE 
											Professor
										SET
											nome = '$nome',
											email = '$email',
											senha = $senha,
											idSenac = $id,
											tipo = $tipo
										WHERE
											codProfessor = ".$_GET['ecod']."")){
				header("Location: index.php");
			}else{
				$msg = "Não foi possivel atualizar";
			}
		
		}
	}
}
//-------------------------------------------------------- FIM UPDATE ------------------------------------------
if(isset($_POST['btnNovo']) || isset($_GET['ecod']) ){
	include("templats/crudProf.php");
}else{
	include("templats/prof.php");	
}

?>