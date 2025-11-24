<?php
	ob_start();
	session_start();
	
	ini_set('display_errors', '0');
	error_reporting(E_ALL | E_STRICT);
	
	include ('../../f/conf/config.php');
	include ('../../f/conf/functions.php');
	
	$codNegociacao = $_GET['codNegociacao'];	
	
	$sqlNegociacao = "SELECT nomeClienteNegociacao FROM negociacoes WHERE codNegociacao = ".$codNegociacao." ORDER BY codNegociacao DESC LIMIT 0,1";
	$resultNegociacao = $conn->query($sqlNegociacao);
	$dadosNegociacao = $resultNegociacao->fetch_assoc();	
?>		
						<form id="form-negociacao" action="" method="post" onSubmit="return cadastraComentario();">
							<div class="botao-expansivel" style="position:absolute; right:-15px; top:5px;" onClick="fecharComentario();"><div class="esquerda-botao"></div><input class="botao" type="button" value="X"/><div class="direita-botao"></div></div>
							<p class="titulo" style="margin-bottom:10px;">Finalização como Não Fechado</p>
							
							<p class="msg-negociacao">Negociação com o cliente <strong><?php echo $dadosNegociacao['nomeClienteNegociacao'];?></strong></p>

							<input type="hidden" value="<?php echo $codNegociacao;?>" name="codNegociacao" id="codNegociacao"/>

							<p class="bloco-campo"><label class="label">Motivo: <span class="obrigatorio"> * </span></label>
								<select class="campo" id="motivo" style="width:726px;" required name="motivo">
									<option value="">Selecione</option>
									<option value="Não atendeu">Não atendeu</option>
									<option value="Não tem interesse">Não tem interesse</option>
									<option value="Achou caro">Achou caro</option>
									<option value="Fechou com outro">Fechou com outro</option>
									<option value="Vai esperar mais um pouco">Vai esperar mais um pouco</option>
									<option value="Não temos o que ele procura">Não temos o que ele procura</option>
								</select>
							</p>	

							<p class="bloco-campo" style="margin-bottom:10px;"><label>Comentário Finalização: <span class="em" style="font-weight:normal; color:#666;">Opcional</span></label>
							<textarea class="desabilita campo" id="comentario" name="comentario" style="width:710px; height:50px; padding-top:5px; padding-bottom:5px;" value=""></textarea></p>
														
							<div class="botao-expansivel" style="display:table; float:none; margin: auto; padding-right:18px;"><div class="esquerda-botao"></div><input class="botao" type="submit" name="cadastrar" title="Cadastrar Finalização" value="Cadastrar Finalização" /><div class="direita-botao"></div></div>						
						</form>	
