<?
IncludeModuleLangFile(__FILE__);
Class CYetiMashaJS
{
	function OnProlog()
	{
		CUtil::InitJSCore(array('jquery'));
		ob_start();
		?>
		<!--[IF IE]> 
			<script type="text/javascript" src="/bitrix/js/yeti.mashajs/js/ierange.js"></script> 
		<![ENDIF]-->
		<script type="text/javascript" src="/bitrix/js/yeti.mashajs/js/masha.min.js"></script>
		<link rel="stylesheet" type="text/css" href="/bitrix/js/yeti.mashajs/css/masha.css">
		<script>
		$(function(){
			$('html').live("click",function() {
				$("#mashajs-share-popup").removeClass("show");
			});
			
			$('#mashajs-share-popup,#mashajs-share-popup *').live("click",function(event){
				event.stopPropagation();
			});
		
		
			var timeoutHover = null;
			$("#mashajs-share-popup").hover(
				function(){
					window.clearTimeout(timeout_hover)
				},
				function(){
					timeout_hover=window.setTimeout(function(){
						mashaJSHideSharePopup();
					},2000);
				}
			);

			if($(".mashajs-selectable").length > 0)
			{
				var counter = 0;
				$(".mashajs-selectable").each(function(){
					var id = $(this).attr("id");
					if(typeof(id) == "undefined" || id == "")
					{
						$(this).attr("id","mashajs-selecteble-"+counter);
						counter++;
					}
				});
				
				function init_masha(){
			        var posts = document.querySelectorAll('.mashajs-selectable');
			        new MultiMaSha(posts, function(el){
			            return el.id;
			        }, {
			            "validate": true,
			            "ignored":"#bx-panel,#bx-admin-prefix",
			            "onMark":function(){
							mashaJSUpdateSharePopupContent();
							showSharePopup($(".num"+ (this.counter-1), $(this.selectable))[0])
						},
						"onUnmark": function(){
							"undefined"!=typeof mashaJSHideSharePopup && mashaJSHideSharePopup("",!0);
							mashaJSUpdateSharePopupContent()
						}
			        })
			    }

			    window.addEventListener('load', init_masha, false);
			}
			else
			{
				MaSha.instance = new MaSha({
					"selectable":$("body")[0],
					"ignored":"#bx-panel,#bx-admin-prefix",
					"onMark":function(){
						mashaJSUpdateSharePopupContent();
						showSharePopup($(".num"+ (this.counter-1), $(this.selectable))[0])
					},
					"onUnmark": function(){
						"undefined"!=typeof mashaJSHideSharePopup && mashaJSHideSharePopup("",!0);
						mashaJSUpdateSharePopupContent()
					}
			   });
			}

			mashaJSUpdateSharePopupContent();
		   
		   $("body").append(
			"<div id=\"mashajs-share-popup\">"+
				"<div class=\"social\">"+
					"<p><?=GetMessage("YETI_MJS_SHARELINK")?></p>"+
					"<ul><li><a target='_blank' href=\"#\" class=\"tw\"><span></span>Twitter</a></li>"+
						"<li><a target='_blank' href=\"#\" class=\"fb\"><span></span>Facebook</a></li>"+
						"<li><a target='_blank' href=\"#\" class=\"vk\"><span></span><?=GetMessage("YETI_MJS_VK")?></a></li>"+
						"<li><a target='_blank' href=\"#\" class=\"gp\"><span></span>Google+</a></li>"+
					"</ul>"+
				"</div>"+
				"<div class=\"link\">"+
					"<p><?=GetMessage("YETI_MJS_DIRECTLINK")?>:</p>"+
					"<a href=\"\"><ins></ins></a>"+
					"<span><?=GetMessage("YETI_MJS_TXTLINK")?></span>"+
				"</div>"+
			"</div>"
		   );
		});

		var shareLinkedTextIndex=null;
		function mashaJSUpdateSharePopupContent(){
			$("#mashajs-share-popup .link a").html(location+"<ins></ins>").attr("href",location);
			var b=encodeURI($("title").text());
			var a=encodeURIComponent(location);
			$("#mashajs-share-popup .social .tw").attr("href","http://twitter.com/share?url="+a+"&text="+b);
			$("#mashajs-share-popup .social .fb").attr("href","http://www.facebook.com/share.php?u="+a);
			$("#mashajs-share-popup .social .vk").attr("href","http://vkontakte.ru/share.php?url="+a);
			$("#mashajs-share-popup .social .gp").attr("href","https://m.google.com/app/plus/x/?v=compose&content="+ b);
			$("#mashajs-share-popup .social .gp").attr("onclick","window.open('https://m.google.com/app/plus/x/?v=compose&content="+b+" - "+a+"','gplusshare','width=450,height=300,left='+(screen.availWidth/2-225)+',top='+(screen.availHeight/2-150)+'');return false;")
		};
		function showSharePopup(b){
			a=$(b).offset();
			
			var topPosition = a.top-$("#mashajs-share-popup").height()-25;
			if(topPosition < 0) topPosition = a.top+25;
			
			$("#mashajs-share-popup").addClass('show').css({
				left:a.left+5+$("#mashajs-share-popup").width()>=$(window).width()?$(window).width()-$("#mashajs-share-popup").width()-15:a.left+5,
				top:topPosition
			});
		};
		function mashaJSHideSharePopup(b,a){
			$("#mashajs-share-popup").removeClass('show');
		};
		</script>
		<style>
		#mashajs-share-popup {z-index:2000;background: #fff;border: 1px solid #aaa;border-radius: 5px;box-shadow: 0 0 5px rgba(0,0,0,0.5);position: absolute;width: 414px;line-height: 1.4;visibility: hidden;font-size: 10px;padding: 10px 0;opacity: 0;-webkit-transition: opacity .4s, visibility .1s linear .4s;-moz-transition: opacity .4s, visibility .1s linear .4s;-o-transition: opacity .4s, visibility .1s linear .4s;transition: opacity .4s, visibility .1s linear .4s;}
		#mashajs-share-popup.show {visibility: visible;opacity: 1;-webkit-transition: opacity .4s, visibility 0s;-moz-transition: opacity .4s, visibility 0s;-o-transition: opacity .4s, visibility 0s;transition: opacity .4s, visibility 0s;opacity: 1;}
		#mashajs-share-popup .social {padding: 0 0 10px 17px;height: 40px;}
		#mashajs-share-popup .social p {padding-bottom: 10px;margin: 0;font-weight: bold;}
		#mashajs-share-popup .social ul {list-style: none;margin: 0;padding: 0;}
		#mashajs-share-popup .social ul li {float: left;margin-right: 20px;padding-top: 2px;position: relative;}
		#mashajs-share-popup .social ul a {text-decoration: none;font-size: 11px;display: inline-block;color: #aaa;padding-left: 25px;}
		#mashajs-share-popup .social ul a:hover {text-decoration: underline;color: #ea3e26;}
		#mashajs-share-popup .social a span{cursor: pointer;width: 20px;height: 20px;background: url(/bitrix/js/yeti.mashajs/img/textselect/social-icons.png) 20px 20px no-repeat;position: absolute;left: 0;top: 0;}
        #mashajs-share-popup .social .tw span{background-position: 0 -20px;}
        #mashajs-share-popup .social .tw:hover span{background-position: 0 0;}
        #mashajs-share-popup .social .fb span{background-position: -20px -20px;}
        #mashajs-share-popup .social .fb:hover span {background-position: -20px 0;}
        #mashajs-share-popup .social .vk span{background-position: -40px -20px;}
        #mashajs-share-popup .social .vk:hover span {background-position: -40px 0;}
        #mashajs-share-popup .social .gp span{background-position: -60px -20px;}
        #mashajs-share-popup .social .gp:hover span {background-position: -60px 0;}
		#mashajs-share-popup .link {clear: both;border-top: 1px solid #d9d9d9;padding: 10px 5px 0 10px;line-height: 1.2;overflow: hidden;margin: 0 7px;}
		#mashajs-share-popup .link p {font-weight: bold;padding: 0 0 3px 0;margin: 0;}
		#mashajs-share-popup .link span {color: #999;display: block;padding-top: 3px;}
		#mashajs-share-popup .link a {display: block;}
		</style>
		<?
		$html = ob_get_clean();
		
		$curPage = $GLOBALS["APPLICATION"]->GetCurPage();
		if(!preg_match("#^\/bitrix#",$curPage))
			$GLOBALS["APPLICATION"]->AddHeadString($html,true);
	}
}
?>
