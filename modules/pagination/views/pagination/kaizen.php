<p class="pagination form">
    <?if ($first_page){?>
        <a class="bar_button round" href="<?php echo HTML::chars($page->url($first_page)) ?>" rel="reload-panel" data-panel="#tabs_content">primeira</a>
    <?}?>
    <?if ($previous_page){?>
        <a class="bar_button round" href="<?php echo HTML::chars($page->url($previous_page)) ?>" rel="reload-panel" data-panel="#tabs_content">anterior</a>
    <?}?>
    <select name="pages" class="round" id="pagination" data-panel="#tabs_content">
    <?for ($i = 1; $i <= $total_pages; $i++){?>
        <option <?=($i == $current_page)? 'selected': ''?> value="<?php echo HTML::chars($page->url($i)) ?>" ><?php echo $i ?></option>
    <?}?>
    </select>
    <?if ($next_page){?>
        <a class="bar_button round" href="<?php echo HTML::chars($page->url($next_page)) ?>" rel="reload-panel" data-panel="#tabs_content">próxima</a>
    <?}?>
    <?if($last_page){?>
        <a class="bar_button round" href="<?php echo HTML::chars($page->url($last_page)) ?>" rel="reload-panel" data-panel="#tabs_content">última</a>
    <?}?>

</p>