<div class="left foto_form team_<?=@$user->team_id?>" >
<?if($user->foto != ''){?>
	<img id="foto_atual" src="<?=URL::base();?><?=@$user->foto?>?c=<?=date('H:i:s');?>" />
<?}?>
</div>

<div class="left">
      <p><b><?=$user->nome;?></b></p>
      <p><?=$user->email?> | <?=$user->ramal?></p>
      <?if(strpos('coordenador', $current_auth) !== false || strpos('admin', $current_auth) !== false){?>
      <p><?=$user->telefone?></p>
      <?}?>
      <?if(strpos('assistente', $current_auth) === false){?>
      <a href="<?=URL::base();?>admin/users/edit/<?=$user->id?>" class="bar_button round" rel="load-content" data-panel="#direita" >editar</a>
      <?}?>
</div>
