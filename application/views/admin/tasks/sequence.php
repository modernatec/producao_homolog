
    <div style="width:220px">
        <div class="clear"><label class="list_alert light_blue round">sugestão de sequência</label></div>
        <div class="scrollable_content" style="padding: 0 5px;">
            <div class="suggestions">
                <?
                $x = 0;
                foreach ($status_tagList as $status_tag) {
                    $class = ($status_tag->sync == '0') ? 'list_view' : 'list_view_sub';
                    if($status_tag->sync == '0'){$x++;}
                    $display = ($status_tag->sync == '0') ? $x : '';
                ?>
                    <span class="<?=$class?> round clear"><span class="left ball" style="background: <?=$status_tag->tag->color;?>"><?=$display;?></span><?=$status_tag->tag->tag;?></span>
                <?}?>
            </div>
       </div>     
    </div>