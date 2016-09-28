<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<meta charset="utf-8">
		<title></title>
	</head>
	<body>
		<div>
			<table>
				<tr>
					<td>Codigo</td>
					<td>Descricao</td>
				</tr>
				<tr>
					<?php 
						foreach($areas as $i => $arroy){
							echo"<tr>
									<td>{$i}</td>
									<td>{$arroy}</td>
									<td><a href='?d=$i'>X</a></td>
								</tr>";
								
						}
					?>
			</table>
		</div>
		<?php if(!empty($msg)){echo $msg;} ?>
		<form method="post" >
			<p>
				<label>Area:</label>
				<input type="text" id="txtArea" name="txtArea" />
			</p>
			<p>
				<input type="submit" value="Gravar"/>
			</form>
	</body>
</html>