////////////
// Select //
////////////
estiloSelect = {
	init: function(){
		var primeiro = 0;
		$("select.select").each(function(){
			var html  = '<div id="' + $(this).attr("id") + '" class="' + $(this).attr("class") + '">';
				html += '<div class="ativo"></div>';
				html += '<input id="' + $(this).attr("id") + '_select" name="' + $(this).attr("name") + '" type="hidden" value=""/>';
				html += '<div class="options">';
				for(i=0;i<$("option",this).length;i++)
				{
					if($(this).attr("id") != 'order')
						html += '<a href="javascript:void(0);" title="' + $("option:eq(" + i + ")",this).text() + '" rel="' + $("option:eq(" + i + ")",this).attr("value") + '">' + $("option:eq(" + i + ")",this).text() + '</a>';
					else
						html += '<a href="javascript:document.orderList.submit();" title="' + $("option:eq(" + i + ")",this).text() + '" rel="' + $("option:eq(" + i + ")",this).attr("value") + '">' + $("option:eq(" + i + ")",this).text() + '</a>';
				}
				html += '</div>';
				html += '</div>';
			
			$(this).replaceWith(html);
			$("option",this).each(function(i){
				primeiro = this.selected ? i : primeiro;
			});
		});
		$("div.select").css("visibility","visible").each(function(){
			var altura = $("a",this).length;
				altura = altura > 5 ? 5 : altura;
			$(".options",this).css({height:(altura * parseInt($("a:first",this).css("height"))) + "px", visibility:"visible", display:"none"});
			estiloSelect.change(this,primeiro);
		})
		$("div.select .ativo").unbind().click(function(){
			$(this).parent().parent().css("z-index","3");
			$(this).siblings(".options").slideDown('fast',function(){
				$("html").bind('click',estiloSelect.fecha);
			});
		});
		$("div.select").each(function(){
			$("a", this).each(function(i){
				$(this).unbind().click(function(){
					estiloSelect.change($(this).parents("div.select:eq(0)"),i);
				});
			});
		});
	},
	
	change: function(obj, option){
		$("a.optionAtivo", obj).removeClass("optionAtivo");
		$("a:eq(" + option + ")", obj).addClass("optionAtivo");
		var texto = $("a:eq(" + option + ")", obj).text();
		var valor = $("a:eq(" + option + ")", obj).attr("rel");
		$(".ativo", obj).html(texto);
		$("input", obj).val(valor);
		estiloSelect.fecha();
	},
	
	fecha: function(){
		$("div.select .options:visible").slideUp('fast',function(){$(this).parent().parent().css("z-index","2")});
		$("html").unbind('click',estiloSelect.fecha);
	}
}

$(document).ready( function(){
	estiloSelect.init();
});