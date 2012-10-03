var ie6 = (navigator.userAgent.indexOf("MSIE 6")!= -1);
var ie8 = (navigator.userAgent.indexOf("MSIE 8")!= -1);

function Popup(args){
	var me = this;
	this.idPopup = (args.idPopup)?args.idPopup:'dialog';
	this.conteudo = (args.conteudo)?args.conteudo:'';
	this.Fixed = args.Fixed;
	this.fade = args.fade;
	this.Top = args.Top;
	this.Left = args.Left;
	this.posRelScroll = args.posRelScroll;
	this.mask = args.mask;
	this.zIndex = args.zIndex?args.zIndex:95;
	this.onOpen = args.onOpen;
	this.onClose = args.onClose;
	this.closeToEsc = args.closeToEsc;
	this.idMask = (args.idMask)?args.idMask:'popup-mask';
	this.maskColor = (args.maskColor)?args.maskColor:'#000';
	this.maskOpacity = (args.maskOpacity)?args.maskOpacity:0.7;
	
	this.criaElementos = function(){
            if(me.mask){
                me.objMask = $(document.createElement('div'));
                me.maskColor = (args.maskColor)?args.maskColor:'#000';
                me.objMask.attr('id',me.idMask);
                me.objMask.css({
                    "display":"none",
                    "position":"absolute",
                    "background":me.maskColor,
                    "top":'0',
                    "left":'0',
                    "z-index":(parseInt(me.zIndex)-2)
                });	
            }
            me.objPop = $(document.createElement('div'));
            me.objPop.attr('id',me.idPopup);
            me.posicao = "fixed";
            me.objPop.css({
                "z-index":me.zIndex,
                "display":"none"
            });
            if(me.objMask){
                $(document).find('body').prepend(me.objMask);
            }
            $(document).find('body').prepend(me.objPop);
	}
	var FadeTo = function(obj,vel,opac,callBack){
            obj.css("display","block");
            obj.animate({opacity: opac}, vel,callBack) 
	}
	this.posiciona = function(){
            if(!me.Top){
                me.Top = ((winH-me.objPop.height())/2);
            }
            if(!me.Left){
                me.Left = ((winW-me.objPop.width())/2);
            }
            if(me.objPop.height() > winH){
                me.Top =10;
            }
            if(me.Fixed){
                var posicao = (ie6)?"absolute":"fixed";
                if(ie6){						
                    $(window).scroll(function(){
                        me.objPop.css("top", (topo+$(window).scrollTop())+"px");
                    });
                }
                me.objPop.css({
                    "position":posicao,
                    "top":me.Top+"px",		  
                    "left":me.Left+"px"		
                });
            }else{
                    var Top = me.Top;
                    var Left = me.Left;	
                    if(me.posRelScroll){
                            Top += $(window).scrollTop();
                            Left += $(window).scrollLeft();	
                    }
                    if ((Top+me.objPop.height()) > docHeight){
                            Top -= ((Top+me.objPop.height())-docHeight)+30;
                    }
                    me.objPop.css({
                            "position":"absolute",
                            "top":Top+"px",		  
                            "left":Left+"px"		
                    });	
            }
            var onReadyShow = function(){
                    if(args.bt_close){
                            me.bt_close = $(args.bt_close);
                            me.bt_close.click(me.close);
                    }
                    if(me.onOpen)
                            me.onOpen();
            }
            if(me.fade){
                me.objPop.fadeIn(500,onReadyShow);	
            }else{
                me.objPop.css('display','block');	
                onReadyShow();
            }
	}
	this.open = function(conteudo){			
            docHeight = $(document).height();
            docWidth = $(document).width();	
            winH = $(window).height();
            winW = $(window).width();
            me.criaElementos();
            var conteudo = (conteudo)?conteudo:me.conteudo;	
            var mostrarPop = function(){
                me.objPop.html("").append(conteudo);	
                if(me.objPop.find("img").length > 0){
                    me.objPop.find("img").ready(function(){
                        me.posiciona();
                    })
                }else{
                    me.posiciona();	
                }
                //me.posiciona();
            }
            if(me.mask){
                docWidth = (ie8 || ie6)?docWidth-22:docWidth;
                me.objMask.css({
                        'width':docWidth,
                        'height':docHeight,
                        opacity: 0.0				
                });	
                if(me.fade){
                    FadeTo(me.objMask,400,me.maskOpacity,mostrarPop);
                }else{
                    me.objMask.css('display','block');
                    me.objMask.css({opacity: me.maskOpacity}); 
                    mostrarPop();
                }

            }else{
                    mostrarPop();	
            }		
	}
	this.close = function(){
            if(me.fade){
                me.objPop.fadeOut(300,function(){
                    if(me.mask){
                        me.objMask.fadeOut(500,function(){
                            me.objMask.remove();	
                        });
                    }
                    me.objPop.remove();
                });						
            }else{
                me.objPop.css('display','none');	
                if(me.mask) me.objMask.remove();	
                me.objPop.remove();
            }		
            if(me.onClose) me.onClose();
	}
	var pressedKey = function(e){
            if(!e){
                if(window.event){
                    e = window.event;
                }else{
                    return;
                }
            }
            if(typeof(e.keyCode) == 'number'){
                e = e.keyCode;
            }else if( typeof( e.which ) == 'number' ){
                e = e.which;
            } else if( typeof( e.charCode ) == 'number'  ){
                e = e.charCode;
            }else{
                return;
            }
            if(e==27){
                me.close();
            }
	}
	if(me.closeToEsc){
            document.onkeyup = pressedKey;
	}
}
