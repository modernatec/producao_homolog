
	<div class="boxwired round">
		<div class="table_info round">			
			<div class="left"><?=count($collectionsList)?> coleções encontradas </div>
			<div class="left">
				<form action='<?=URL::base();?>admin/collections/getList/<?=$ano?>' id="frm_reset_oeds" data-panel="#tabs_content" method="post" class="form">
					<input type="hidden" name="reset_form" value="true">
					<input type="submit" class="bar_button round green" value="limpar filtros" />
				</form>
			</div>
		</div>
		<div class="filters clear">
			<form action='<?=URL::base();?>admin/collections/getList/<?=$ano?>' id="frm_oeds" data-panel="#tabs_content" method="post" class="form">
				<div>
					<input type="text" class="round left" style="width:135px" name="name" placeholder="nome" value="<?=$filter_name?>" >
	       			<input type="submit" class="round bar_button left" value="OK"> 
	       		</div>

	       		<div class="clear filter" >
				    <ul>
				        <li class="round" >
				            <span class="round" id="segmento">segmento <?=(!empty($filter_segmento) ? "<img src='".URL::base()."public/image/admin/filter_active.png' />": "<img src='".URL::base()."public/image/admin/filter.png' />")?></span>
				            <div class="filter_panel round scrollable_content" data-bottom="false">
					            <ul>
					                <li class="round bar_button"><input type="checkbox" class="checkAll" id="filter_segmento" checked /><label for="filter_segmento">selecionar tudo</label></li>
					                <? foreach ($segmentoList as $segmento) {?>
					                	<li>
					                		<input class="filter_segmento" type="checkbox" name="segmento[]" value="<?=$segmento->id?>" id="col_<?=$segmento->id?>" <?if(empty($filter_segmento)){ echo "checked"; }?> <?=(in_array($segmento->id, $filter_segmento)) ? "checked" : ""?> />
					                		<label for="col_<?=$segmento->id?>"><?=$segmento->name?></label>
					                	</li>
					                <?}?>
					                <p>
						                <input type="submit" class="round bar_button" value="OK" /> 
						                <input type="button" class="round bar_button cancelar" value="Cancelar" /> 
						            </p> 
					            </ul>
					        </div>
				        </li>
				    </ul>
				</div>
			</form>	
		</div>
	</div>
	<div class="scrollable_content">
		<ul class="list_item">
			<? foreach($collectionsList as $collection){?>
			<li>				
				<a class="right excluir" href="<?=URL::base().'admin/collections/delete/'.$collection->id;?>" title="Excluir">Excluir</a>	
				<a class="check" href="<?=URL::base().'admin/collections/edit/'.$collection->id;?>" rel="load-content" data-panel="#direita" title="Editar">
					<b><?=$collection->name?></b><br/>
					<img src="<?=URL::base()?>/public/image/admin/calendar.png" height="16"> <span class="list_faixa round red"><?=Utils_Helper::data($collection->fechamento,'d/m/Y')?></span> &bullet; <?=$collection->segmento->name?>
				</a>
			</li>
			<?}?>
		</ul>
	</div>
