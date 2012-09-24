<div class="form-adm">
<form id="createMap" action="" method="post" accept-charset="utf-8" enctype="multipart/form-data">
    <fieldset>
    <?php 
		if(isset($errors)){
			foreach ($errors as $error){
				echo '<p class="error">'.$error.'.</p>';
			}
		}
	?>
        <legend></legend>
        <label for="title"> Titulo: </label>
        <input type="text" name="title" id="title" value="<?=$plan['title']?>" class="big" /><br />
        
        <label for="loop"> Número de voltas: </label>
        <input type="text" name="loop" id="loop" value="<?=$plan['loop']?>" class="big" /><br />
        
        <label for='hittest'> Hittest: </label>
        <input type='file' name='hittest' id='hittest' class="big" /><br />
        <?php if($plan['image']):?>
        <div class='cover'>
            <img src='<?=URL::site()."public/upload/plans/hittest/".$plan['image']; ?>' width='100' height='100' />	
        </div>
        <?php endif;?>
        
        <label for='view'> View: </label>
        <input type='file' name='view' id='view' class="big" /><br />
        <?php if($plan['image']):?>
        <div class='cover'>
            <img src='<?=URL::site()."public/upload/plans/view/".$plan['image']; ?>' width='100' height='100' />	
        </div>
        <?php endif;?>
        
        <label for='background'> Background: </label>
        <input type='file' name='background' id='background' class="big" /><br />
        <?php if($plan['image']):?>
        <div class='cover'>
            <img src='<?=URL::site()."public/upload/plans/background/".$plan['image']; ?>' width='100' height='100' />	
        </div>
        <?php endif;?>
        
        <label for='check_pointer'> Check Pointer: </label>
        <input type='file' name='check_pointer' id='check_pointer' class="big" /><br />
        <?php if($plan['image']):?>
        <div class='cover'>
            <img src='<?=URL::site()."public/upload/plans/background/".$plan['image']; ?>' width='100' height='100' />	
        </div>
        <?php endif;?>
        
        <p class="left"><input type="submit" name="submit" id="submit" value="Salvar" class="btn-salvar" /></p>
    </fieldset>
</form>
</div>