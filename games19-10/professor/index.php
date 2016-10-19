<?php
require("../db/db.php");

	$msg = "Em produção";
	
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

	include("templats/prof.php");
?>