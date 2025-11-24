         <div id="paginacao">
            <div id="itens-pagina">
                <ul>

<?php

	$numPag  = ceil($registros / $regPorPag);
	
if($registros > $regPorPag){	
	if($numPag > 5 && $pagina > 1){
?>
            <li><a href="<?php echo $configUrlGer;?><?php echo $area; ?>/1/" title="Primeira Página">Primeira Página</a></li>
<?php
	}
	if($pagina > 1){
?>            
            <li><a href="<?php echo $configUrlGer;?><?php echo $area; ?>/<?php echo $pagina - 1; ?>/" title="Anterior">Anterior</a></li>
<?php
	}
	
	for ($i=0;  $i<$numPag; $i++){
		$n = $i + 1;
		if($n == $url[6]){
?>       
            <li><span class="branco"><?php echo $n ?></span></li>
<?php
		}else
			if($numPag > 5 && $n+3 == $pagina || $n+2 == $pagina || $n+1 == $pagina || $n-1 == $pagina || $n-2 == $pagina || $n-3 == $pagina){
?>            
				<li><a href="<?php echo $configUrlGer;?><?php echo $area; ?>/<?php echo $n ?>/" title="<?php echo $n ?>" ><?php echo $n ?></a></li>

<?php
			}else
				if($numPag <= 5){
?>
				<li><a href="<?php echo $configUrlGer;?><?php echo $area; ?>/<?php echo $n ?>/" title="<?php echo $n ?>" ><?php echo $n ?></a></li>
<?php
				}
	}
	if($pagina < $numPag){
?>
            <li><a href="<?php echo $configUrlGer;?><?php echo $area; ?>/<?php echo $pagina + 1; ?>/" title="Próxima">Próxima</a></li>
<?php
	}
	
	if($pagina < $numPag && $numPag > 5){
		
?>
			<li><a href="<?php echo $configUrlGer;?><?php echo $area; ?>/<?php echo $numPag; ?>/" title="Última Página">Última Página</a></li>
			
                </ul>
<?php
	}
}
?>
            </div>

<?php
	if($registros >= 1){
		$mostrar = $mostrando + $pgInicio;
		if($pgInicio == 0){
			$mostraPGInicio = $pgInicio + 1;
		}else{
			$mostraPGInicio = $pgInicio;
		}
?>
            <p>Mostrando <?php echo '<strong>'.$mostraPGInicio.'</strong> - <strong>'.$mostrar.'</strong>'; ?> cadastros. Total de <?php echo '<strong>'.$registros.'</strong> em <strong>'.$numPag.'</strong>'; ?> página(s).</p>
<?php
	}else{
?>
			<p>Nenhum item cadastrado!</p>			
<?php
	}
?>
        </div>
