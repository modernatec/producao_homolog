$(function(){
	$("select#estado_id").change(function(){loadCidade($(this));});
	function loadCidade(element)
	{
		if($(element).val())
		{
			$.get('../../cidade',{uf: $(element).val(), ajax: 'true'}, function(data) {
				$("select#cidade_id").html(data);
			});
		}
	}
});