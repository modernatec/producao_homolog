<div class="content">
	<div class="bar">
		<a href="<?=URL::base();?>admin/objects" class="bar_button round">Voltar</a>
		<a href="<?=URL::base();?>admin/objects/edit/<?=$obj->id?>" class="bar_button round">Editar</a>
	</div>
	
	<div class="box round left">
   		<b>título:</b> <?=@$obj->title;?><br/>
   		<b>taxonomia:</b> <?=@$obj->taxonomia;?><br/>
   		<b>produtora:</b> <?=@$obj->supplier->empresa?><br/>
   		<b>tipo:</b> <?=@$obj->typeobject->name;?><br/>
		<b>obs:</b> <?=@$taskVO['sinopse']?><br/>
	</div>
	<div class="left">
		<?=@$assign_form?>
		<?=@$reply_form?>
		<div>	
			<?
				if(isset($taskflows)){
					foreach($taskflows as $status_task){
						echo View::factory('admin/tasks/hist_task')
							->bind('statusList', $statusList)
							->bind('status_task', $status_task)
							->bind('cntStsTsk', $cntStsTsk); 
							
					}	
				}
			?>
		</div>
	</div>	
	
</div>
