<div class="content">
    <?
    if($message!=''){
    ?>
    <div class="<? if(count($errors)>0){ ?>error<? }else{ ?>ok<? }?>">
    <p><?=$message?></p>
    </div>
    <?
    }
    ?>
    <div class="bar">
            <a href="<?=URL::base();?>admin/projects" class="bar_button round">OK</a>
    </div>        	
</div>
