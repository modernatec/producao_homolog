<form id="formEndTask" name="formEndTask" action="<?=URL::base();?>admin/tasks_status/end" method="post" class="form">
    <input type="hidden" name='task_status_id' value="<?=$task_status->id?>" />
    <input type="hidden" name='object_id' value="<?=$task_status->task->object_id?>" />
    <input type="hidden" name='next_step' id="next_step" value="0" />
    <dt>
        <label for="description">observações</label>
    </dt>
    <dd>
        <textarea placeholder="observações" class="text round" name="description" id="description" style="width:470px; height:300px;"></textarea>
        <span class='error'><?=Arr::get($errors, 'description');?></span>
    </dd>
    <input type="submit" value="entregar" class="green round" />
    <a href="javascript:void(0)" class="close_pop bar_button round">cancelar</a> 
</form>