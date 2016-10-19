// <!DOCTYPE html> 
<html lang="pt-br">
	<head>
		<link rel="icon" type="image/png" sizes="16x16" href="../img/logopag.png">
		<link rel="stylesheet" type="text/css" href="../css/estilo.css">
		<meta html lang="pt-br">
		<meta charset='UTF-8'>
		<title>Estrutura - PI II</title>
	</head>
	
	<body>
		
		<?php // Cabeçalho
			include "../menuCruds.php";
		?>
		<div id="frmarea">
			<section id="form-content">
				<h3>Cadastro de professores</h3><?php if(isset($msg))echo$msg;?>
				<div id="crudProf">
					<form id="frmProf-crud" method="post">
						<?php 
						if(isset($_GET['ecod'])){
							echo '
								<label class="label-default">Nome:</label>
								<input type="text" name="txtNomeProf" id="txtNomeProf"  class="style-input-default" required="required" value="{/>
								
								<label class="label-default">Email:</label>
								<input type="email" name="txtEmailProf" id="txtEmailProf"  class="style-input-default" required="required" />
								
								<label class="label-default">Senha:</label>
								<input type="password" name="txtSenhaProf" id="txtSenhaProf"  class="style-input-default" required="required" />
								
								<label class="label-default">ID:</label>
								<input type="text" name="txtIDProf" id="txtIDProf"  class="style-input-default" maxlength="6" required="required" />
								
								<label class="label-default">Tipo:</label>
								<input type="radio" name="rdTipo" value="P"  class="style-input-default" />Professor
								<input type="radio" name="rdTipo" value="A"  class="style-input-default" />Admin';
						}else{
							echo '
								<label class="label-default">Nome:</label>
								<input type="text" name="txtNomeProf" id="txtNomeProf"  class="style-input-default" placeholder="Nome" required="required" />
								
								<label class="label-default">Email:</label>
								<input type="email" name="txtEmailProf" id="txtEmailProf"  class="style-input-default" placeholder="email@email.com.br" required="required" />
								
								<label class="label-default">Senha:</label>
								<input type="password" name="txtSenhaProf" id="txtSenhaProf"  class="style-input-default" placeholder="*****" required="required" />
								
								<label class="label-default">ID:</label>
								<input type="text" name="txtIDProf" id="txtIDProf"  class="style-input-default" placeholder="666666" maxlength="6" required="required" />
								
								<label class="label-default">Tipo:</label>
								<input type="radio" name="rdTipo" value="P"  class="style-input-default" checked />Professor
								<input type="radio" name="rdTipo" value="A"  class="style-input-default" />Admin';
						}
					?>
						<input type="submit" name="btnInclude" class="btArea" value="Enviar" />
					</form>	
				</div>
			</section>
		</div>
		<!---- scripts ---->
		<script type="text/javascript" src="../js/jquery-2.1.1.min.js"></script>
		<script type="text/javascript" src="../js/scripts.js"></script>
	</body>
</html>