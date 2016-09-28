<?php
include('../db/db.php');
//SELECT
$query = odbc_exec($db, 'SELECT * FROM Area');

while($result = odbc_fetch_array($query)){
	$areas[$result['codArea']] = utf8_encode($result['descricao']);
}
	//$area = $_POST['txtArea'];
	//delete
if(isset($_GET['d'])){
	if(is_numeric($_GET['d'])){
		if(!odbc_exec($db, "DELETE FROM Area WHERE codArea =".$_GET['d'])){
			$msg =+ "Não foi possivel apagar o dado<br>";
		}else{
			$msg =+ "Apagado com sucesso<br>";
		}
	}else{
		$msg =+ "ERRO : ID não valido<br> ";
	}
}


include('templats/index_tpl.php');
?>