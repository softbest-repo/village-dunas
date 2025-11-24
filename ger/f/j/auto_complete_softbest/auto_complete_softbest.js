	function getKey(event){	
		return event?(event.keyCode?event.keyCode:(event.which?event.which:event.charCode)):null;
	}

	var buscaAuto = null;

	function auto_complete(value, arquivo, e){
		var $tr = jQuery.noConflict();
		if(value != ""){
			if(e.which != 40 && e.which != 38 && e.which != 37 && e.which != 39 && e.which != 13){
				$tr("#exibe_busca_autocomplete_softbest_"+arquivo).css("display", "block");	
				
				clearTimeout(buscaAuto);
				buscaAuto = setTimeout(function(){
					$tr.post("https://markanimoveis.com.br/ger/auto_complete_softbest_"+arquivo+".php", {value: value}, function(data){	
						$tr("#exibe_busca_autocomplete_softbest_"+arquivo).html(data);
					});
				}, 200);
											
			}
		}else{
			$tr("#exibe_busca_autocomplete_softbest_"+arquivo).html("");
			$tr("#exibe_busca_autocomplete_softbest_"+arquivo).css("display", "none");
		}
	}
	
	function novoItem(value, arquivo){
		var $ni = jQuery.noConflict();
		if(value != ""){
			$ni.post("https://markanimoveis.com.br/ger/novo_item_"+arquivo+".php", {value: value}, function(data){										
				$ni("#exibe_busca_autocomplete_softbest_"+arquivo).html("");
				$ni("#exibe_busca_autocomplete_softbest_"+arquivo).css("display", "none");

				if(arquivo == "clientes_c"){
					buscaInfo(value);
				}	
			});				
		}
	}
	
	function fechaAutoComplete(arquivo){
		var $sss9 = jQuery.noConflict();
		
		if(document.getElementById("atual_autocomplete_softbest").value==0){
			$sss9("#exibe_busca_autocomplete_softbest_"+arquivo).html("");
			$sss9("#exibe_busca_autocomplete_softbest_"+arquivo).css("display", "none");
		}
	}
	
	function executaClick(cod){
		var $ttg = jQuery.noConflict();
		
		var arquivo = document.getElementById("id_autocomplete_softbest").value;

		pegarValue = document.getElementById("autocomplete_"+cod).value;
		document.getElementById("busca_autocomplete_softbest_"+arquivo).value=pegarValue;
		
		$ttg("#exibe_busca_autocomplete_softbest_"+arquivo).html("");
		$ttg("#exibe_busca_autocomplete_softbest_"+arquivo).css("display", "none");

		if(arquivo == "clientes_c"){
			buscaInfo(pegarValue);
		}	
		
		if(arquivo == "tipoPagamentoRA_c" || arquivo == "tipoPagamentoPA_c"){
			executaFuncaoEdita(pegarValue);
		}	
	}
	
	function enviarFormAutoComplete(){
		document.getElementById("form_autoComplete_softbest").submit();
	}

	var $ttddf = jQuery.noConflict();
	document.onkeyup=function(e){
		var arquivo = document.getElementById("id_autocomplete_softbest").value;
		if(document.getElementById("exibe_busca_autocomplete_softbest_"+arquivo).style.display=="block"){
			if(e.which == 40){
				var pegaAtual = document.getElementById("atual_autocomplete_softbest").value;
				var pegaTotal = document.getElementById("total_autocomplete_softbest").value;
				if(pegaAtual == 0){
					$ttddf(".selecionado").removeClass("selecionado");
					$ttddf(".sec1").addClass("selecionado");
					document.getElementById("atual_autocomplete_softbest").value=1;
				}else{
					soma = parseInt(pegaAtual) + 1;
					if(soma <= pegaTotal){
						$ttddf(".selecionado").removeClass("selecionado");
						$ttddf(".sec"+soma).addClass("selecionado");
						document.getElementById("atual_autocomplete_softbest").value=soma;
					}else{
						$ttddf(".selecionado").removeClass("selecionado");
						$ttddf(".sec1").addClass("selecionado");
						document.getElementById("atual_autocomplete_softbest").value=1;
					}
				}
			}else
			if(e.which == 38){
				var pegaAtual = document.getElementById("atual_autocomplete_softbest").value;
				var pegaTotal = document.getElementById("total_autocomplete_softbest").value;
				if(pegaAtual == 0){
					$ttddf(".selecionado").removeClass("selecionado");
					$ttddf(".sec"+pegaTotal).addClass("selecionado");
					document.getElementById("atual_autocomplete_softbest").value=pegaTotal;
				}else{
					soma = parseInt(pegaAtual) - 1;
					if(soma >= 1){
						$ttddf(".selecionado").removeClass("selecionado");
						$ttddf(".sec"+soma).addClass("selecionado");
						document.getElementById("atual_autocomplete_softbest").value=soma;
					}else{
						$ttddf(".selecionado").removeClass("selecionado");
						$ttddf(".sec"+pegaTotal).addClass("selecionado");
						document.getElementById("atual_autocomplete_softbest").value=pegaTotal;
					}
				}							   
			}else
			if(e.which == 13){
				var pegaAtual = document.getElementById("atual_autocomplete_softbest").value;
				if(pegaAtual != 0){
					var pegaValor = $ttddf(".val"+pegaAtual).val();

					document.getElementById("busca_autocomplete_softbest_"+arquivo).value=pegaValor;									
					document.getElementById("atual_autocomplete_softbest").value=0;
					$ttddf("#exibe_busca_autocomplete_softbest_"+arquivo).html("");
					$ttddf("#exibe_busca_autocomplete_softbest_"+arquivo).css("display", "none");

					if(arquivo == "clientes_c"){
						buscaInfo(pegaValor);
					}
				}
			}
		}	
	}
	
	function mouseOverAutoComplete(cont){
		var $dssds = jQuery.noConflict();

		$dssds(".selecionado").removeClass("selecionado");
		$dssds(".sec"+cont).addClass("selecionado");
		document.getElementById("atual_autocomplete_softbest").value=cont;	
								
	}
	
	function mouseOverNovoItem(){
		document.getElementById("atual_autocomplete_softbest").value="N";			
	}
						
