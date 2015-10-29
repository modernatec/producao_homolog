	<div class="list_bar">
		<a href="<?=URL::base();?>admin/repositorios/edit/" rel="load-content" data-panel="#direita" class="bar_button round">cadastrar repositório</a>
	</div>
	<span class='list_alert'>
	<?
        if(count($repositoriosList) <= 0){
            echo 'não encontrei repositórios com estes critérios';    
        }else{
            echo count($repositoriosList).' repositórios encontrados';
        }
    ?>
	</span>
	<div id="tabs_content" class="scrollable_content clear">
		<ul class="list_item">
			<? foreach($repositoriosList as $repositorio){
				$qtd_oed = $repositorio->objects->count_all();
			?>
			<li>
				<?if($qtd_oed > 0){?>
					<a class="right icon icon_excluir popup" href="<?=URL::base().'admin/repositorios/deletePanel/'.$repositorio->id;?>">Excluir</a>
				<?}else{?>
					<a class="right icon icon_excluir" href="<?=URL::base().'admin/repositorios/delete/'.$repositorio->id;?>" data-message="<?=$delete_msg?>">Excluir</a>
				<?}?>
				<div class="item_content">
					<a style='display:block' href="<?=URL::base().'admin/repositorios/edit/'.$repositorio->id;?>" rel="load-content" data-panel="#direita"><?=$repositorio->name?></a>
				</div>
			</li>
			<?}?>
		</ul>
	</div>
