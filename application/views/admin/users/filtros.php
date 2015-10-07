<div class="filters clear">
	<form action="<?=URL::base();?>admin/users/getUsers" id="frm_usuarios" data-panel="#tabs_content" method="post" class="form">
		<input type="text" class="round left" style="width:140px" placeholder="nome ou email" name="filter_search" value="<?=@$filter_search?>" >
		<input type="submit" class="round bar_button left" value="buscar"> 
	</form>	
	<form action='<?=URL::base();?>admin/users/getUsers' id="frm_reset_oeds" data-panel="#tabs_content" method="post" class="form">
		<input type="hidden" name="reset_form" value="true">
		<input type="submit" class="bar_button round" value="limpar filtros" />
	</form>
</div>