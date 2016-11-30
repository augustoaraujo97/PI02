<?php 
	//require("../../db/BarraAcesso.php"); 
?>
<!DOCTYPE html> 
<html lang="pt-br">
	<head>
		<link rel="icon" type="image/png" sizes="16x16" href="../img/logopag.png">
		<link rel="stylesheet" type="text/css" href="../css/estilo.css">
		<meta html lang="pt-br">
		<meta http-equiv="Content-Type" content="text/html;charset=ISO-8859-1">
		<title>SENAQUIZ - PAINEL QUESTAO</title>
	</head>
	
	<body>
		
		<?php // Cabeçalho
			include "../db/menuCruds.php";
		?>

		<div id="frmarea">
			<div id="msg">
				<p>
					<!-- Log de mensagens  -->
					<?php if(isset($msg))echo $msg; ?>
				</p>
			</div>

			<section id="form-content">
				<h3>Cadastro de quest&atilde;o</h3>

				<!-- Campo de pesquisa -->	
				<form id="frma" method="get">
					<?php 
						if(isset($_GET['pesq'])) {
							if (!empty($_GET['pesq'])) {
								echo "<input type='text' name='pesq' id='pesq' value='".$pesquisa."'>";
								echo $butt;
							}else{
								echo '<input type="text" name="pesq" id="pesq" placeholder="Pesquisar quest&atilde;o...">';
							}
						}else{
							echo '<input type="text" name="pesq" id="pesq" placeholder="Pesquisar quest&atilde;o...">';
							
						}
					?>				
					<input type="submit" id="btnPesquisar" value="Pesquisar"/>
				</form>
				<form id="frma" action="" method="post">
					<input type="submit" id="btnNovo" name="btnNovo" value="Incluir"> 
				</form>
				<!--- campo de inclusão -->
			</section><!-- form-content - Fim -->

			<div id="area-content">
				<table>
					<thead>
						<tr>
							<td class="cmcodigo"><strong>C&oacute;digo</strong></td>
							<td class="cmdescricao"><strong>Quest&atilde;o</strong></td>
							<td class="cmdescricao"><strong>Assunto</strong></td>
							<td class="cmdescricao"><strong>Imagem</strong></td>
							<td class="cmdescricao"><strong>Professor</strong></td>
							<td class="cmdescricao"><strong>dificuldade</strong></td>
							<td colspan="2"><strong>A&ccedil;&otilde;es</strong></td>
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
							if (isset($questao)){
									$zebra = 0;
									foreach($questao as $campo => $value){
										
										if($zebra % 2 <> 0) {
											$cor = '#EEE';
										} else {
											$cor = '#fff';
										}
										echo "
											<tr>
												<td class='cmcodigo' style='background-color: $cor;'>{$campo}</td>
												<td class='cmdescricao' style='background-color: $cor;'>{$value['textoQuestao']}</td>
												<td class='cmdescricao' style='background-color: $cor;'>{$value['descricao']}</td>";
											if($value['bitmapImagem'] != 0 || !empty($value['bitmapImagem'])){
												echo "<td class='cmdescricao' style='background-color: $cor;'><img width='30' height='30' src='data:image/jpeg;base64,".base64_encode($value['bitmapImagem'])."' /></td>";
											}else{
												echo "<td class='cmdescricao' style='background-color: $cor;'></td>";
											}
											echo"<td class='cmdescricao' style='background-color: $cor;'>{$value['nome']}</td>
												 <td class='cmdescricao' style='background-color: $cor;'>{$value['dificult']}</td>";
											if($_SESSION['codProfessor'] == $value['codProfessor'] || $_SESSION['tipoProfessor'] == 'A'){
												echo "
													<td style='background-color: $cor;' class='delet'><a href='?dcod={$campo}' class='adel'>Desativar</a></td>
													<td style='background-color: $cor;' class='edit'><a href='?ecod={$campo}' class='aedit'>Editar</a></td>";
											}else{
												echo "<td colspan='2' style='background-color: $cor;' class='edit'><a href='?ecod={$campo}&?view' class='aedit'>Visualizar</a></td>";
											}
											echo "</tr>";
										$zebra++;
									}
							}else{
								echo " 	<tr>
											<td colspan='5'><center>Nenhum resultado encontrado :( </center></td>
										</tr>";
							}
							
						?>
					</tbody>
				</table>
			</div><!---content - Fim -->
		</div>
	</body>
</html>