<div class="content">
    <div class="bar">
        <a href="<?=URL::base();?>admin/objects/view/<?=$obj->id?>" class="bar_button round">voltar</a>        
    </div>    
    <div class="left" style="width:280px;">
        <div class="box round">
            <b>título:</b> <span class="wordwrap"><?=@$obj->title;?></span><br/>
            <b>taxonomia:</b> <span class="wordwrap"><?=@$obj->taxonomia;?></span><br/>
            <b>tipo:</b> <?=@$obj->typeobject->name;?><br/>
            <b>classificação:</b> <?=($obj->reaproveitamento == 0) ? "Novo" : "Reaproveitamento" ?><br/>
            <b>fechamento:</b> <?=Utils_Helper::data($obj->crono_date,'d/m/Y')?><br/>
            <hr style="margin:8px 0;" />
            <b>produtora:</b> <?=@$obj->supplier->empresa?><br/>
            <b>contato:</b> <?=@$obj->supplier->contato->nome?><br/>
            <b>email:</b> <?=@$obj->supplier->contato->email?><br/>
            <b>tels:</b> <?=@$obj->supplier->contato->telefone?><br/><br/>

            <b>estúdio:</b> <?=@$obj->audiosupplier->empresa?><br/>
            <b>locutor(a):</b> <?=@$obj->speaker?><br/>
            
            <hr style="margin:8px 0;" />
            <b>obs:</b> <span class="wordwrap"><?=@$obj->obs?></span><br/>
        </div>
    </div>
    <div class="left">
        <div style="padding-bottom:4px;">              
            <a data-show="form_assign" class="bar_button round show right">+ custo</a>        
        </div>
        <div class="clear" style="padding:4px 0;">
            <?=@$form_custo?>
        </div>
        <div>             
            <? 
                if(count($custos) > 0){
                    foreach ($custos as $custo){?>
                        <div style='clear:both' >
                            <div style='width:25px; float:left; margin-top:5px'>
                                <img class='round_imgList' src='<?=URL::base();?><?=$custo->userInfo->foto?>' height="25"  title="<?=ucfirst($custo->userInfo->nome);?>" /> 
                            </div>
                            <div class='hist round <?=($custo->pago > 0) ? 'step' : 'yellow'?>' style='float:left;'>
                                <div class='line_bottom'>
                                    <?if($custo->userInfo_id == $user->id || $current_auth == "admin"){?>
                                        <a href="<?=URL::base();?>admin/custos/edit/<?=$custo->id?>" class="popup edit black">
                                    <?}?>
                                    <b>valor: <?=Utils_Helper::money_format($custo->valor)?></b></a> para <?=$custo->supplier->empresa?><br/>
                                    <b>solicitado por:</b> <?=$custo->userInfo->nome?> em <?=Utils_Helper::data($custo->created_at,'d/m/Y')?><br/>
                                    <b>status:</b> <?=($custo->pago > 0) ? "pago em ".Utils_Helper::data($custo->pago_em,'d/m/Y') : "em aberto"?>
                                </div>

                                <?if(!empty($custo->description)){ ?>
                                    <span class="wordwrap description"><?=$custo->description;?></span>
                                <?}?>
                             </div>                        
                        </div>
                    <?}
                }else{?>
                    <div class='hist round step' style='float:left;'>
                        <span style="text-align:center; display: block">não há custos relacionados a este objeto</span>
                    </div>
                <?}?>
        </div>
    </div>  
    
</div>
