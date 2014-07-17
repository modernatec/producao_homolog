<div style="padding:10px;">
	<p style="color:#333333"><?=$data['mensagem']?></p>
	<div style="margin-top:20px;color:#333333">
		<p>
			<span style="color:#008fc7;"><b>título:</b></span> <?=$data['titulo']?><br/>
			<span style="color:#008fc7;"><b>data de entrega:</b></span> <?=$data['entrega']?><br/>
			<span style="color:#008fc7;"><b>criada por:</b></span> <?=$data['por']?><br/>
			<span style="color:#008fc7;"><b>descrição:</b></span>
			<span style='mso-fareast-font-family:"Times New Roman"'><pre style='mso-fareast-font-family:"Times New Roman"'><?=$data['descricao']?></pre></span>
		</p>
		<br/>
		<a style="color:#fff; text-decoration:none; " href="<?=$data['link']?>" >
		<img src="<?=URL::base()?>public/image/common/enviar.png">
		</a>
	</div>
</div>