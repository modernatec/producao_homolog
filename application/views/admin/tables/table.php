<div class="list_bar">
    <p class="left"><b><?=$table->name;?></b></p>
	<div class="filter left" >
        <ul>
            <li class="round" >
                <span id="edit"><div class="icon icon_edit" title="editar nome da mesa de luz">edit</div></span>
                <div class="filter_panel_arrow"></div>
                <div class="filter_panel round" >
                    <ul>
                        <li>
                            <form name="frmEditTable" id="frmEditTable" action="<?=URL::base();?>admin/tables/salvar/<?=$table->id?>" method="post" class="form" style='width:253px;'>
                                <input type="text" class="text required round" placeHolder="novo nome" name="name" id="name" value="<?=$table->name?>" />
                                <input type="submit" class="right round" name="btnSubmit" id="btnSubmit" value="renomear" />                                
                            </form>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>
    </div>
    <a class="icon icon_delete left" href='<?=URL::base();?>/admin/tables/delete/<?=$table->id?>' title="excluir mesa de luz">Excluir</a>
    <a class="icon icon_xls left" href='<?=URL::base();?>/admin/tables/export/<?=$table->id?>' title="exportar mesa de luz">exportar</a>
</div>
<div class="clear scrollable_content list_body">
    <?foreach($objectsList as $table_obj){?>
    <div class="acervo_item round" id="obj_<?=$table_obj->object->id?>">
        <a class="right icon icon_excluir" href="<?=URL::base().'admin/tables/deleteOED/'.$table_obj->id;?>" data-message="<?=$delete_msg?>">Excluir</a>
        <a class="popup" href="<?=URL::base().'admin/acervo/view/'.$table_obj->object->id?>" data-select="obj_<?=$table_obj->object->id?>" >
            <div class="acervo_item_top">
                <p class="text_cyan"><b><?=$table_obj->object->title?></b></p>
                <p><?=$table_obj->object->collection->name?></p>
            </div>
        </a>
    </div>
    <?}?>
</div>