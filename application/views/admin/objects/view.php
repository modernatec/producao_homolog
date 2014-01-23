<div class="content">
	<div class="bar">
		<a href="<?=URL::base();?>admin/objects" class="bar_button round">Voltar</a>
        <a href="<?=URL::base();?>admin/objects/edit/<?=$objVO['id']?>" class="bar_button round">Editar</a>
	</div>
    <div class="round boxwired left" >
        <?=$objVO['taxonomia']?><br/>
        <?=$objVO['title']?><br/>
        <?=$objVO['sinopse']?><br/>
    </div>
    <div class="left">
        <div class="round boxwired" >
            <?=$objVO['taxonomia']?><br/>
            <?=$objVO['title']?><br/>
        </div>
        <div class="round boxwired" >
            <?=$objVO['taxonomia']?><br/>
            <?=$objVO['title']?><br/>
        </div>

    </div>
</div>