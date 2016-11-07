// habilitar o input após o select ser selecionado , no lightbox do assunto.

$('#slcCodArea').click(function(){
	if($('#slcCodArea').val() <= 0){
		$('#txtAssuntoDesc').prop( "disabled", true );		
	}else{
		$('#txtAssuntoDesc').prop( "disabled", false);
	}
});