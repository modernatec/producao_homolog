<div class="filters second_filter clear">
	<div class="left">
		<select class="required round" name="table_id" id="table_id_list" data-url='<?=URL::base();?>admin/tables/getObjectsTable' data-panel='#charts'>
	        <option value=''>selecione uma mesa</option>
	        <? foreach($list as $table){?>
	            <option value="<?=$table->id?>" ><?=$table->name?></option>
	        <?}?>
	    </select>
	</div>	
	<div class="filter left" >
        <ul>
            <li class="round" >
                <span id="add"><div class="icon icon_add" >add</div></span>
                <span class="filter_panel_arrow"></span>
                <div class="filter_panel round" >
                    <ul>
                        <li>
							<form name="frmCreateTable" id="frmCreateTable" action="<?=URL::base();?>admin/tables/salvar/" method="post" class="form" style='width:233px;'>
								<input type="text" class="text required round" placeHolder="nova mesa de luz" name="name" id="name" />
								<input type="submit" class="right round" name="btnSubmit" id="btnSubmit" value="salvar" />								
							</form>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>
    </div>
    <div class="filter left" >
        <ul>
            <li class="round" >
                <span id="add"><div class="icon icon_edit" >edit</div></span>
                <span class="filter_panel_arrow"></span>
                <div class="filter_panel round" >
                    <ul>
                        <li>
							<form name="frmEditTable" id="frmEditTable" action="<?=URL::base();?>admin/tables/salvar/" method="post" class="form" style='width:253px;'>
								<input type="text" class="text required round" placeHolder="novo nome" name="name" id="name" />
								<input type="submit" class="right round" name="btnSubmit" id="btnSubmit" value="renomear" />								
							</form>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>
    </div>
	<a class="icon icon_delete left" href='<?=URL::base();?>/admin/tables/delete/' data-rel="load-content" data-panel="#preview">visualizar</a>
	<a class="icon icon_xls left" href='<?=URL::base();?>/admin/tables/export/' data-rel="load-content" data-panel="#preview">visualizar</a>
</div>