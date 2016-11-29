<!DOCTYPE html> 
<html lang="pt-br">
	<head>
		<link rel="icon" type="image/png" sizes="16x16" href="../img/logopag.png">
		<link rel="stylesheet" type="text/css" href="../css/estilo.css">
		<meta http-equiv="Content-Type" content="text/html;charset=ISO-8859-1">
		<title>Estrutura - PI II</title>
	</head>
	
	<body>
		
		<?php // Cabeçalho
			include "../db/menuCruds.php";
		?>
		<div id="frmarea">
			<section id="form-content">
			
				<h3>Cadastro de professores</h3>
				<?php if(isset($msg))echo$msg;?>

				<!-- Campo de pesquisa -->	
				<form id="frma" action="" method="get">
					<!--- caso uma pesquisa seja feita, o botão de voltar será habilitado -->
					<?php 
						if(isset($_GET['pesq'])) {
							if (!empty($_GET['pesq'])) {
								echo "<input type='text' name='pesq' id='pesq' value='".$pesquisa."'>";
								echo $butt;
							}else{
								echo '<input type="text" name="pesq" id="pesq" placeholder="Pesquisar nome ...">';
							}
						}else{
							echo '<input type="text" name="pesq" id="pesq" placeholder="Pesquisar nome ...">';	
						}
					?>
					<input type="submit" id="btnPesquisar" value="Pesquisar"/>
				</form>
				<form id="frma" action="" method="post">
					<?php
						if($_SESSION['tipoProfessor'] == 'A'){
							echo'<input type="submit" id="btnNovo" name="btnNovo" value="Incluir">';
						}
					?>
				</form>
					<!--- campo de inclusão -->
			</section><!-- form-content - Fim -->
			<div id="area-content">
				<table>
					<thead>
						<tr>
							<td class="cmcodigo"><strong>C&oacute;digo</strong></td>
							<td class="cmNome"><strong>Nome</strong></td>
							<td class="cmEmail"><strong>Email</strong></td>
							<td class="cmID"><strong>ID</strong></td>
							<td class="cmTipo"><strong>Tipo</strong></td>
						<?php
							if($_SESSION['tipoProfessor'] == 'A'){
								echo '<td colspan="2"><strong>A&ccedil;&otilde;es</strong></td>';
							}
						?>
						</tr>
					</thead>
					<tfoot>
					<?php 
						//Inserir paginação
						include ("../db/paginacao.php");
					?>
					</tfoot>
					<tbody>
						<?php 
						if($num > 0){
							$zebra = 0;
							foreach($prof as $campo => $value){
								if($zebra % 2 <> 0) {
									$cor = '#EEE';
								} else {
									$cor = '#fff';
								}
								echo "
									<tr>
										<td class='cmcodigo' style='background-color: $cor;'>{$campo}</td>
										<td class='cmNome' style='background-color: $cor;'>{$value['nome']}</td>
										<td class='cmEmail' style='background-color: $cor;'>{$value['email']}</td>
										<td class='cmID' style='background-color: $cor;'>{$value['idSenac']}</td>
										<td class='cmTipo' style='background-color: $cor;'>{$value['tipo']}</td>";
									if($_SESSION['tipoProfessor'] == 'A'){
										echo "
											<td class='delet' style='background-color: $cor;'><a href='?dcod={$campo}' class='adel'>Deletar</a></td>
											<td class='edit' style='background-color: $cor;'><a href='?ecod={$campo}' class='aedit'>Editar</a></td>";
									}
								echo"</tr>";
								$zebra++;
							}
						}else{
							echo " 	<tr>
										<td colspan='6' ><center>Nenhum resultado encontrado :(</center></td>
									</tr>";							
							}
						?>
					</tbody>
				</table>
			</div><!-- area-content - Fim -->
		</div><!-- frmarea - Fim -->
		<!---- scripts ---->
		<script type="text/javascript" src="../js/jquery-2.1.1.min.js"></script>
		<script type="text/javascript" src="../js/scripts.js"></script>
	</body>
</html>