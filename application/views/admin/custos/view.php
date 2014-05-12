<div class="content">
    <div class="bar">
        <a href="<?=URL::base();?>admin/objects/view/<?=$obj->id?>" class="bar_button round">voltar</a>        
    </div>    
    <div class="left" style="width:280px;">
        <div class="box round">
            <b>título:</b> <span class="wordwrap"><?=@$obj->title;?></span><br/>
            <b>taxonomia:</b> <span class="wordwrap"><?=@$obj->taxonomia;?></span><br/>
            <hr style="margin:8px 0;" />
            <b>produtora:</b> <?=@$obj->supplier->empresa?><br/>
            <b>contato:</b> <?=@$obj->supplier->contato->nome?><br/>
            <b>email:</b> <?=@$obj->supplier->contato->email?><br/>
            <b>tels:</b> <?=@$obj->supplier->contato->telefone?><br/><br/>

            <b>estúdio:</b> <?=@$obj->audiosupplier->empresa?><br/>
            <b>locutor(a):</b> <?=@$obj->speaker?><br/>
            
            <hr style="margin:8px 0;" />
            <b>tipo:</b> <?=@$obj->typeobject->name;?><br/>
            <b>classificação:</b> <?=($obj->reaproveitamento == 0) ? "Novo" : "Reaproveitamento" ?><br/>
            <b>fechamento:</b> <?=Utils_Helper::data($obj->crono_date,'d/m/Y')?><br/>
            <br/>
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
            <div class='hist_task step round' style='float:left;'>
                conteúdo
            </div>
        </div>
    </div>  
    
</div>
