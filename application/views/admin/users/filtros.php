<div class="filters clear">
	<form action="<?=URL::base();?>admin/users/getUsers" id="frm_usuarios" data-panel="#tabs_content" method="post" class="form">
		<input type="text" class="round left" style="width:300px" placeholder="nome ou email" name="filter_search" value="<?=@$filter_search?>" >
		<?if(strpos('assistente', $current_auth) === false){?>
		<div class="filter" >
		    <ul>
		        <li>
		            <span id="team" class="<?=(!empty($filter_status)) ? 'filter_active': '';?>">status <div class="icon_filtros <?=(!empty($filter_status)) ? 'icon_filter_active': 'icon_filter';?>"></div></span>
		            <div class="filter_panel_arrow"></div>
		            <div class="filter_panel round">
		            	<div class="scrollable_content" data-bottom="false"> 
			            <ul>
			                <li><input type="checkbox" class="filter_status" name="filter_status[]" value="1" id="o_1" <?if(isset($filter_status)){ if(in_array("1", $filter_status)){ echo "checked";}}?> ><label for="o_1">ativos</label></li>
			                <li><input type="checkbox" class="filter_status" name="filter_status[]" value="0" id="o_0" <?if(isset($filter_status)){ if(in_array("0", $filter_status)){ echo "checked";}}?> ><label for="o_0">inativos</label></li>
			                <p>
                                <input type="submit" class="round bar_button" value="buscar" /> 
                                <input type="button" class="round bar_button cancelar" value="cancelar" />  
                            </p> 
			            </ul>
			            </div>
			        </div>
		        </li>
		    </ul>
		</div>
		<?}?>
		<input type="submit" class="round bar_button left" value="buscar"> 
	</form>	
	<form action='<?=URL::base();?>admin/users/getUsers' id="frm_reset_oeds" data-panel="#tabs_content" method="post" class="form">
		<input type="hidden" name="reset_form" value="true">
		<input type="submit" class="bar_button round" value="limpar filtros" />
	</form>
</div>