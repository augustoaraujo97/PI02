<?php 
	// Controle de acesso 
	
	// Iniciar a sessão
	session_start();
	


	// Quando colocado no servidor, deixar como false
	$_SESSION['showMenu'] = FALSE;

	//INTEGRAÇÃO
	include('../integracao/loginFunc.php');
	lidaBasicAuthentication ('../../../portal/naoautorizado.php');

	if (!isset($_SESSION['codProfessor']) || @!is_numeric($_SESSION['codProfessor'])) {
		$acesso = 0;
		// header("Location: ../login.php");
		echo "Acesso negado";
		exit();
	}  else $acesso = 1;
?>
