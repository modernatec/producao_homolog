    <div style="width:200px">
        <label class="list_alert">sugestão de sequência</label>
        <div class="scrollable_content" style="padding: 0 5px;">
            <div class="suggestions">
                <?
                $x = 0;
                foreach ($status_tagList as $status_tag) {
                    //$class = ($status_tag->sync == '0') ? 'list_view' : 'list_view_sub';
                    //if($status_tag->sync == '0'){$x++;}
                    //$display = ($status_tag->sync == '0') ? $x : '';
                ?>
                    <span class="list_view clear"><span class="text_cyan">&bullet;</span> <?=$status_tag->tag->tag;?></span>
                <?}?>
            </div>
       </div>     
    </div>