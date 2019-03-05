$(function() {
	'use strict';
    
     $("select").selectBoxIt( { autoWidth: false } );
    
	$('[placeholder]').focus(function(){
		$(this).attr('data-text',$(this).attr('placeholder'));
		$(this).attr('placeholder','');
	})

	.blur(function(){
        $(this).attr('placeholder',$(this).attr('data-text'));
	})
    
	$('input').each(function (){
        if($(this).attr('required') === 'required'){
            $(this).after('<span class="asterisk">*</span>');
        }
    
    })
    
    $('.confirm').click(function(){
        return confirm('Are you sure?');
        
    })
    
  	$('.cat h3').click(function () {
		$(this).next().fadeToggle(200);
	})
    
    $('.ordering span').click(function(){
        $(this).addClass('active').siblings('span').removeClass('active');
    })
    
    $('.categories .classic').click(function(){
        $('.full-view').fadeOut();
    })
    
    $('.categories .full').click(function(){
        $('.full-view').fadeIn();
    })
        
    $('.latest .toggle-info').click(function(){
        $(this).toggleClass('selected').parent().next().fadeToggle(100);
        if($(this).hasClass('selected')){
            $(this).html('<i class="fas fa-minus">')
        }
        else{
             $(this).html('<i class="fas fa-plus">')
        }
    })
    
  $(function() {
  $(".table-wrap").each(function() {
    var nmtTable = $(this);
    var nmtHeadRow = nmtTable.find("thead tr");
    nmtTable.find("tbody tr").each(function() {
      var curRow = $(this);
      for (var i = 0; i < curRow.find("td").length; i++) {
        var rowSelector = "td:eq(" + i + ")";
        var headSelector = "th:eq(" + i + ")";
        curRow.find(rowSelector).attr('data-title', nmtHeadRow.find(headSelector).text());
      }
    });
  });
});
    
});



