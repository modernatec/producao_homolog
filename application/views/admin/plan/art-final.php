<div class="form-adm">
	<form id="plan" name="plan" action="" method="post" accept-charset="utf-8" enctype="multipart/form-data">
        <fieldset>
			<?php 
                if(isset($errors)){
                    foreach ($errors as $error){
                        echo '<p class="error">'.$error.'.</p>';
                    }
                }
            ?>
            <legend></legend>
            
            <label for='teste'> Arquivo: </label>
            <input type='file' name='drawing_final' id='drawing_final' class="big" /><br />
            
            <p class="left"><input type="submit" name="submit" id="submit" value="Salvar" class="btn-salvar" /></p>
        </fieldset>
    </form>
</div>