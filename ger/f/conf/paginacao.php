         <div id="paginacao">
            <div id="itens-pagina">
                <ul>

<?php

	$numPag  = ceil($registros / $regPorPagina);
	
if($registros > $regPorPagina){	
	if($numPag > 2 && $pagina > 1){
?>
            <li><a href="<?php echo $configUrl;?><?php echo $area; ?>/1/" title="Primeira Página">Início</a></li>
<?php
	}
	if($pagina > 1){
?>            
            <li><a href="<?php echo $configUrl;?><?php echo $area; ?>/<?php echo $pagina - 1; ?>/" title="Anterior">Anterior</a></li>
<?php
	}
	
	for ($i=0;  $i<$numPag; $i++){
		$n = $i + 1;
		if($n == $pagina){
?>       
            <li><span class="branco"><?php echo $n ?></span></li>
<?php
		}else
			if($numPag > $regPorPagina && $n+3 == $pagina || $n+2 == $pagina || $n+1 == $pagina || $n-1 == $pagina || $n-2 == $pagina || $n-3 == $pagina){
?>            
				<li><a href="<?php echo $configUrl;?><?php echo $area; ?>/<?php echo $n ?>/" title="<?php echo $n ?>" ><?php echo $n ?></a></li>

<?php
			}else
				if($numPag <= 5){
?>
				<li><a href="<?php echo $configUrl;?><?php echo $area; ?>/<?php echo $n ?>/" title="<?php echo $n ?>" ><?php echo $n ?></a></li>
<?php
				}
	}
	if($pagina < $numPag){
?>
            <li><a href="<?php echo $configUrl;?><?php echo $area; ?>/<?php echo $pagina + 1; ?>/" title="Próxima">Próxima</a></li>
<?php
	}
	
	if($pagina < $numPag && $numPag > 5){
		
?>
			<li><a href="<?php echo $configUrl;?><?php echo $area; ?>/<?php echo $numPag; ?>/" title="Última Página">Fim</a></li>
			
                </ul>
<?php
	}
}
?>
            </div>

<?php
	if($registros >= 1){
		$mostrar = $mostrando + $paginaInicial;
		if($pgInicio == 0){
			$mostraPGInicio = $paginaInicial + 1;
		}else{
			$mostraPGInicio = $paginaInicial;
		}
?>
            <p>Mostrando <?php echo '<strong>'.$mostraPGInicio.'</strong> - <strong>'.$mostrar.'</strong>'; ?>. Total de <?php echo '<strong>'.$registros.'</strong> em <strong>'.$numPag.'</strong>'; ?> página(s).</p>
<?php
	}else{
?>
			<p>Nenhum item cadastrado!</p>			
<?php
	}
?>
        </div>
