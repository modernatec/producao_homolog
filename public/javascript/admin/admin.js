function temMensagens(){
    setInterval(function(){
        $.getJSON('/admin/tasks/searchNew/',function(data){
            var mss = data.mss;
            if(mss.length>0)
            {		
                for(var i=0; i<mss.length; i++)
                {
                    $.jGrowl(mss[i],{position:'bottom-right'}); 
                } 
            }
        });
    },1000); //5 min (1000 * 60 * 5)
}

$(document).ready(function() {	
	if(msgs.length>0)
	{		
		for(var i=0; i<msgs.length; i++)
		{
			$.jGrowl(msgs[i],{position:'bottom-right'}); 
		} 
	}
        //temMensagens();
});

