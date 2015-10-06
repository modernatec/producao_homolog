	<div class="list_bar">
		<a href="<?=URL::base();?>admin/suppliers/edit" rel="load-content" data-panel="#direita" class="bar_button round">cadastrar fornecedor</a>
	</div>

	<span class='list_alert'>
	<?
        if(count($suppliersList) <= 0){
            echo 'não encontrei fornecedores com estes critérios.';    
        }else{
            echo count($suppliersList).' fornecedores encontrados';
        }
    ?>
	</span>
	<div class="list_body scrollable_content">
		<ul class="list_item">
			<? foreach($suppliersList as $supplier){?>
			<li>
				<div class="item_content">
				<a href="<?=URL::base().'admin/suppliers/view/'.$supplier->id;?>" rel="load-content" data-panel="#direita" title="+ informações">
					
						<p><b><?=$supplier->empresa?></b></p>					
						<div class="line_itens">
				            <? 
				            	$formats = $supplier->formats->find_all();
				            	foreach ($formats as $format) {?>
				                <span class="line_itens"><?=$format->name?></span> 
				            <?}?>  
				        </div>
					
				</a>
				</div>
			</li>
			<?}?>
		</ul>
	</div>
