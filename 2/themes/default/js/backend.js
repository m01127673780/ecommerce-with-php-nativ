$(function() {
	'use strict';
    
    $("select").selectBoxIt( { autoWidth: false } );
    
    /////////////////////////////////////////////////
    
	$('[placeholder]').focus(function(){
		$(this).attr('data-text',$(this).attr('placeholder'));
		$(this).attr('placeholder','');
	})
    
	.blur(function(){
        $(this).attr('placeholder',$(this).attr('data-text'));
	})
    
     ////////////////////////////////////////////////
    
	$('input').each(function (){
        if($(this).attr('required') === 'required'){
            $(this).after('<span class="asterisk">*</span>');
        }
    
    })
    
     ////////////////////////////////////////////////
    
    $('.confirm').click(function(){
        return confirm('Are you sure?');
        
    })
    
     ////////////////////////////////////////////////

    $('.log span').click(function(){
        $(this).addClass('selected').siblings().removeClass('selected');
        $('.log form').hide();
        $('.' + $(this).data('class')).fadeIn(10);
    })
    
    
    ////////////////////////////////////////////////
    
    
    $('.newads .live-name').keyup(function(){
       $('.items .card-title').text($(this).val());
    })
    
    
     ////////////////////////////////////////////////
    
    
       $('.newads .live-desc').keyup(function(){
       $('.items .card-text').text($(this).val());
    })
    
     ////////////////////////////////////////////////
    
    $('.newads .live-price').keyup(function(){
        $('.items .price').text($(this).val());
    })
    
    ////////////////////////////////////////////////
    
  

    $('.container').imagesLoaded( function() {
  $("#exzoom").exzoom({
        autoPlay: false,
    });
  $("#exzoom").removeClass('hidden')
});

  
  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-36251023-1']);
  _gaq.push(['_setDomainName', 'jqueryscript.net']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();
 
    
    
});



