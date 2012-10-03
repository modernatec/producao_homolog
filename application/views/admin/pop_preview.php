<?
if($type_preview=='image'){
    list($width, $height, $type, $attr) = getimagesize(DOCROOT."/".$file->uri);
    ?>
    <div class="lightbox" id="img<?=time()?>">
        <a id="btFechar" class="bar_button round">X</a>
        <img src="/<?=$file->uri?>" <?=$attr?> />
    </div>
    <?
}elseif($type_preview=='audio'){
    ?>
    <div class="lightbox" id="au<?=time()?>">
        <a id="btFechar" class="bar_button round">X</a>
        <audio controls="controls">
            <source src="/<?=$file->uri?>">
        </audio>
    </div>
    <?
}elseif($type_preview=='video'){
    ?>
    <div class="lightbox" id="vid<?=time()?>">
        <a id="btFechar" class="bar_button round">X</a>
        <video width="640" height="480" controls="controls" id="video<?=time()?>">
            <source src="/<?=$file->uri?>?nocache=<?=time()?>">
        </video>
    </div>
    <?
}
exit;
?>
