<?php

ini_set('default_charset', 'iso8859-1');	

require('../acesso.php');
require('../db/db.php');

$msg = '';
$result = ' ';

include ("../db/msg.php");
// ----------------------------------------------------------------------PAGINA ----------------------------------------------------------------------------
if(isset($_GET['pesq'])){
	$pesquisa = $_GET['pesq'];
	$pesquisa = str_replace("'","",$pesquisa);
	$query = odbc_exec($db, "SELECT 
								codAssunto
							FROM
								Assunto
							WHERE descricao LIKE '%$pesquisa%'
						");
}else{
	$query = odbc_exec($db, "SELECT 
								codAssunto
							FROM
								Assunto
							");
}

$num = odbc_num_rows($query);
$numPagina = ceil($num/10);
$i = 0;
if(!isset($_GET['pg']))$pagina = 1;else $pagina = intval($_GET['pg']);
$limite = (10 * $pagina); 

// --------------------------------------------------------------------------Pesquisa --------------------------------------------------------------------------
if(isset($_GET['pesq'])) {
	if (!empty($_GET['pesq'])) {
		$pesquisa = $_GET['pesq'];
		$pesquisa = str_replace("'","",$pesquisa);
		$query = odbc_exec($db, "SELECT 
										ass.codAssunto, 
										ass.descricao as assdescricao,
										ass.codArea ,
										ar.descricao as ardescricao,
										count(q.codQuestao) as 'qtd'
									FROM 
										assunto as ass
									LEFT JOIN
										area as ar 
									ON ar.codArea = ass.codArea
									LEFT JOIN
										questao as q
									ON 
										ass.codAssunto = q.codAssunto
									WHERE ass.descricao LIKE '%$pesquisa%' or ar.descricao LIKE '%$pesquisa%'
									GROUP BY
										ass.codAssunto,
										ass.codArea ,
										ar.descricao,
										ass.descricao
									ORDER BY codAssunto
										OFFSET $limite-10 ROWS  
										FETCH NEXT 10 ROWS ONLY"); 
			//Bot�o para voltar ap�s fazer pesquisa							
			$butt = "<button id='btnVoltar' ><a href='index.php?pesq'>Voltar</a></button>";
	} else {
		$query = odbc_exec($db, "SELECT 
										ass.codAssunto, 
										ass.descricao as assdescricao,
										ass.codArea ,
										ar.descricao as ardescricao,
										count(q.codQuestao) as 'qtd'
									FROM 
										assunto as ass
									LEFT JOIN
										area as ar 
									ON ar.codArea = ass.codArea
									LEFT JOIN
										questao as q
									ON 
										ass.codAssunto = q.codAssunto
									GROUP BY
										ass.codAssunto,
										ass.codArea ,
										ar.descricao,
										ass.descricao
									ORDER BY codAssunto
										OFFSET $limite-10 ROWS  
										FETCH NEXT 10 ROWS ONLY");
	}
} else {
	// Valor default
				$query = odbc_exec($db, "SELECT 
											ass.codAssunto, 
											ass.descricao as assdescricao,
											ass.codArea ,
											ar.descricao as ardescricao,
											count(q.codQuestao) as 'qtd'
										FROM 
											assunto as ass
										LEFT JOIN
											area as ar 
										ON ar.codArea = ass.codArea
										LEFT JOIN
											questao as q
										ON 
											ass.codAssunto = q.codAssunto
										GROUP BY
											ass.codAssunto,
											ass.codArea ,
											ar.descricao,
											ass.descricao
										ORDER BY codAssunto
											OFFSET $limite-10 ROWS  
											FETCH NEXT 10 ROWS ONLY");
}

// ---------------------------------------------------------- GRADES ---------------------------------------------------------------------
//AREA
$queryArea = odbc_exec($db, "SELECT
								codArea,
								descricao
							FROM
								Area");

while($resultArea = odbc_fetch_array($queryArea)){
	$areas[$resultArea['codArea']] = $resultArea['descricao'];
}

$num = odbc_num_rows($query);

while($result = odbc_fetch_array($query)){
	$assuntos[$result['codAssunto']]['assdescricao'] = $result['assdescricao'];
	$assuntos[$result['codAssunto']]['codArea'] = $result['codArea'];
	$assuntos[$result['codAssunto']]['ardescricao'] = $result['ardescricao'];
	$assuntos[$result['codAssunto']]['qtd'] = $result['qtd'];
}

// --------------------------------------------------------------------------DELETE--------------------------------------------------------------------------
if(isset($_GET['dcod'])){
	if(is_numeric($_GET['dcod'])){
		//verifica se existe dependencia
		
		if(!odbc_exec($db, "DELETE FROM 
								Assunto
							WHERE 
								codAssunto = ".$_GET['dcod'])){
			$msg .= "N&atilde;o foi poss&iacute;vel deletar.";
		}else{
			header("Location: index.php?dd");
		}
		
	}else{
		$msg .= "ERRO : ID n&atilde;o valido";
	}
}

// -------------------------------------------------------------------------------INSERT ------------------------------------------------------------------------
if(isset($_POST['btnInclude'])) {
	$assunto = $_POST['txtInclude'];
	$codArea = intval($_POST['codArea']);

	$queryCod = odbc_exec($db,"SELECT codArea FROM Area WHERE codArea = '$codArea'");

	if(!odbc_num_rows($queryCod) > 0){
		$msg .= "Area inexistente";
	}else{ 
		if(!empty($assunto)){
			$queryAssunto = odbc_exec($db, "SELECT descricao, codArea FROM Assunto WHERE descricao = '$assunto' AND codArea = $codArea");
			
			if(odbc_num_rows($queryAssunto) > 0){
				$msg .= "Assunto j&aacute; cadastrado nessa &aacute;rea";
			}else{
				$prepare = odbc_prepare($db, "INSERT INTO 
												Assunto (descricao, codArea) 
											VALUES 
												(?, $codArea)");
				if(!odbc_execute($prepare, array($assunto))){
					$msg = "N&atilde;o foi possivel inserir";

				}else {
					header("Location: index.php?ic");
				}
			}
		}else{
			$msg .= "N&atilde;o &eacute; possivel inserir assuntos em branco.";
		}
	}
}

//-------------------------------------------------------------------------------EDITAR--------------------------------------------------------------------------
if(isset($_GET['ecod']) && is_numeric($_GET['ecod'])){
	$select = odbc_exec($db, "SELECT 
								ass.codAssunto, 
								ass.descricao as assdescricao,
								ass.codArea ,
								ar.descricao as ardescricao
							FROM 
								assunto as ass
							LEFT JOIN
								area as ar ON ar.codArea = ass.codArea
							WHERE 
								ass.codAssunto = ".$_GET['ecod']);
	$result = odbc_fetch_array($select);
} else {
	$result = '';
}

// --------------------------------------------------------------------------UPDATE-------------------------------------------------------------------
if(isset($_POST['btnAssuntoUpdate']  )){
	if(is_numeric($_GET['ecod'])){
		$assunto = $_POST['txtAssuntoUpdate'];
		$codArea = intval($_POST['codArea']);
		
		$prepare = odbc_prepare($db, "UPDATE
										Assunto
									SET
										descricao = ?
										codArea = $codArea
									WHERE
										codAssunto = {$_GET['ecod']}");
		if(odbc_execute($prepare, array($assunto))){
			header("Location: index.php?uc");
		}
	}else{
		$msg .= "N&atilde;o foi poss&iacute;vel atualizar";
	}
}

if(isset($_POST['btnNovo']) || isset($_GET['ecod']) ){
	include_once("templats/crudAssunto.php");
} else {
	include("templats/assunto.php");	
}

?>