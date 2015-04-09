<form id="formEndTask" name="formEndTask" action="<?=URL::base();?>admin/taskstatus/end" method="post" class="form">
    <input type="hidden" name='task_id' value="<?=$task->id?>" />
    <input type="hidden" name='object_id' value="<?=$task->object_id?>" />
    <input type="hidden" name='next_step' id="next_step" value="0" />
    <dd>
        <textarea placeholder="observações" class="text round" name="description" id="description" style="width:550px; height:300px;"></textarea>
        <span class='error'><?=Arr::get($errors, 'description');?></span>
    </dd>
    <? if($task->tag_id == '1'){?>
        <input type="submit" value="liberar" id="submit_btn" class="green round" />
        <!--a href='#' class="bar_button round red" id="correcao" >solicitar correção</a-->
    <?}else{?>
        <input type="submit" value="entregar" class="green round" />
        <a href="javascript:void(0)" class="close_pop bar_button round">cancelar</a> 
    <?}?>
</form>