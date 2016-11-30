<?php 
	//require("../../db/BarraAcesso.php"); 
?>
<!DOCTYPE html> 
<html lang="pt-br">
	<head>
		<link rel="icon" type="image/png" sizes="16x16" href="../img/logopag.png">
		<link rel="stylesheet" type="text/css" href="../css/estilo.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
		<meta html lang="pt-br">
		<meta http-equiv="Content-Type" content="text/html;charset=ISO-8859-1">
		<title>SENAQUIZ - PAINEL QUESTÃO</title>
	</head>
	<body>
		
		<?php // Cabeçalho
			include "../db/menuCruds.php";
		?>

		<div id="frmquestao-crud">
			<div class='crud-questao'>
				<section id="form-content">
					<?php if(isset($msg))echo$msg;?>

					<?php
						/* FORM DE UPDATE ----------------------------------------------*/
						if (isset($_GET['ecod'])) {	?>

							<center><h4 style="color: #2c3e50;font-size:25px;text-transform:uppercase;">Atualizar quest&atilde;o</h4></center>
							<form method="post"  action=<?php echo '?ecod='.$_GET['ecod'].''; ?> name="frmUpload" enctype="multipart/form-data">
								<div style="float:left; width:100%;height:200px;">
									<center>
										<span style="color:#385965">Imagem:</span>
										<p>Selecione a imagem...<input type="file" name="flArquivo" id="flArquivo" /></p>
										<output id="list">
											<?php
												echo "<img width='25%' height='25%' src='data:image/jpeg;base64,".base64_encode($result['bitmapImagem'])."' />"
											?>
										</output>
									</center>
								</div>
								<div style="float:left; width:100%;height:150px;">
									<label class="label-default">&Aacute;rea:</label>
									<select class="select-default" name='optArea' id='optArea'>
									<?php
										echo " <option value='". $arearesult. "'>". $arearesulta ."</option> " ;
										foreach ($area as $codigo => $value) {
											echo "<option value='$codigo' name='optArea'>".$value."</option>";
										}
									?>
									</select>

									<label class="label-default">Assunto:</label>
									<select class="select-default" name="optAssunto" id='optAssunto'> 	
									<?php
										echo " <option value='". $result['codAssunto']. "'>".$result['descricao']."</option> " ;
		
									?>
									</select>
								</div>
								<div style="float:left; width:100%;height:250px;">
									<label class="label-default">Quest&atilde;o:</label>
									<textarea name="edtQuestao"><?php echo $result['textoQuestao'] ?></textarea>
								</div>
								<div style="float:left; width:100%;height:20px;">
										<center><span style="color:#385965">Dificuldade:</span>
											<input type="radio" name="dificult" value="F" <?php if($result['dificuldade'] == 'F')echo "checked" ?> class="rdquestao" /><span style="color:#385965">F&aacute;cil</span>
											<input type="radio" name="dificult" value="M" <?php if($result['dificuldade'] == 'M')echo "checked" ?> class="rdquestao" /><span style="color:#385965">M&eacute;dio</span>
											<input type="radio" name="dificult" value="D" <?php if($result['dificuldade'] == 'D')echo "checked" ?> class="rdquestao" /><span style="color:#385965">Dif&iacute;c&iacute;l</span>
										</center>
								</div>
								<div style="float:left; width:100%;height:200px;margin-top:25px;">
									<center>
								<?php
									$i = 1;
									foreach ($alteranativas as $campo => $value) {
										// Verifica qual alternativa está correta
										if ($value['correta'] == 1) $correta = 'checked'; else $correta = '';
										echo "
											<span style='color:#385965'>Alternativa $i:</span>
											<input type='text' name='txtAlt".$i."' value='{$value['textoAlternativa']}' class='style-input-default'/>
											<input type='radio' name='rdAlt' value='".$i."' $correta /><br>
											";
										$i++;
									}
								?>
								<div style="float:left; width:100%;height:200px;">
								<?php
									if(!isset($_GET['view'])){
								?>
										<input type="submit" name="btnUpdate" value="Atualizar" class="btArea" style="position:relative;" />	
								<?php
									}else{
								 ?>
									<a href="index.php"><input type="button" name="btnVolt" class="btArea" value="Cancelar" style="position:relative;"/></a>
								<?php } ?>
								</div>
							</form>
						<?php
						} else {
							?>
								<center><h4 style="color: #2c3e50;font-size:25px;text-transform:uppercase;">Inserir quest&atilde;o</h4></center>
								<form method="post"  action="" name="frmUpload" enctype="multipart/form-data">
									<div style="float:left; width:100%;height:200px;">
										<center>
											<span style="color:#385965">Imagem:</span>
											<input type="file" name="flArquivo" id="flArquivo" />
											<output id="list"></output>
										</center>
									</div>
									<div style="float:left; width:100%;height:150px;">
							
											<label class="label-default">&Aacute;rea:</label>
											<select class="select-default" name='optArea' id='optArea'>
											<?php
												echo " <option value='0'> Escolha uma &aacute;rea... </option> ";
												echo load_area();
											?>
											</select>

											<label class="label-default">Assunto:</label>
											<select class="select-default" name="optAssunto" id='optAssunto'>
											<?php
												echo " <option value='0'> Escolha um assunto... </option> ";
											?>
											</select>
										
									</div>
									<div style="float:left; width:100%;height:250px;">
									
										<label class="label-default">Quest&atilde;o:</label>
										<textarea name="edtQuestao"></textarea>
								
									</div>
									<div style="float:left; width:100%;height:20px;">
										<center>
											<span style="color:#385965">Dificuldade:</span>
											<input type="radio" name="dificult" value="F" class="rdquestao"/><span style="color:#385965">F&aacute;cil</span>
											<input type="radio" name="dificult" value="M" checked class="rdquestao" /><span style="color:#385965">M&eacute;dio</span>
											<input type="radio" name="dificult" value="D" class="rdquestao" /><span style="color:#385965">Dif&iacute;c&iacute;l</span>
										</center>
									</div>

									<div style="float:left; width:100%;height:200px;margin-top:25px;">
										<!-- Alternativas -->
										<center>
											<span style="color:#385965">Alternativa 1:</span>
											<input type="text" id="txtAlt1" name="txtAlt1" class="style-input-default"/>
											<input type="radio" name="rdAlt" value="1" checked /><br>
											<span style="color:#385965">Alternativa 2:</span>
											<input type="text" id="txtAlt2" name="txtAlt2" class="style-input-default"/>
											<input type="radio" name="rdAlt" value="2"/><br>
											<span style="color:#385965">Alternativa 3:</span>
											<input type="text" id="txtAlt3" name="txtAlt3" class="style-input-default"/>
											<td><input type="radio" name="rdAlt" value="3"/><br>
											<span style="color:#385965">Alternativa 4:</span>
											<input type="text" id="txtAlt4" name="txtAlt4" class="style-input-default"/>
											<td><input type="radio" name="rdAlt" value="4"/><br>
										</center>
									</div>
									<div style="float:left; width:100%;height:200px;">
										<center>
											<input type="submit" name="btnQuestao" class="btArea" value="Enviar" style="position:relative;">
											<a href="index.php"><input type="button" name="btnVolt" class="btArea" value="Cancelar" style="position:relative;"/></a>
										</center>
									</div>
								</form>
						<?php
							}
					 ?>
				</section><!-- form-content - Fim -->
			</div>
			<script type="text/javascript" src='templats/loadimage.js'></script>
			<script type="text/javascript">
				 $(document).ready(function(){  
				      $('#optArea').change(function(){  
				           var area = $(this).val();  
				           $.ajax({  
				                url:"templats/processa.php",  
				                method:"POST",  
				                data:{codArea:area},  
				                dataType:"text",  
				                success:function(data)  
				                {  
				                     $('#optAssunto').html(data);  
				                }  
				           });  
				      });  
				 });  		
			</script>
		</div>
	</body>
</html>