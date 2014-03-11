<div class="content">
	<div class="bar">
		<a href="<?=URL::base();?>admin/suppliers/create" class="bar_button round">Cadastrar fornecedores</a>
	</div>    
    <div id="tabs" class="clear">
        <ul>
            <li id="tab_<?=$project->id?>"><a href='<?=URL::base();?>admin/suppliers/getSuppliers/?empresa=<?=$filter_empresa?>&contato=<?=$filter_contato?>'>fornecedores</a></li>
        </ul>
        
        <div id="tabs_content">
            
        </div>
    </div>
    <?=$page_links?>
</div>
