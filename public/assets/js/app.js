/* APP WIDE JS */
jQuery(document).ready(function($){

	/**
	 * HTML5 Placeholder fallback
	 */
	$('[placeholder]').defaultValue();

	$('.cb').colorbox({
                width:"98%",
		height:"80%"
	});
        
        

	$('.cb.iframe').colorbox({
		iframe:true, width:"98%", height:"80%",resizable:true
                
                
	});
        
        parent.$.fn.colorbox.resize({
            innerWidth: $(document).width(),
            innerHeight: $(document).height()
        });
	
	$('.cb.inline').colorbox({
		inline: true,
                 buttonImage: "../img/calendar.gif",
                buttonImageOnly: true,
		onComplete: function(){
			$('.datepicker').datepicker({"dateFormat" : "dd/mm/yy"});
                               

		}
                
    
  
	});

        
        /*
         *HTML5 Validation
         */
        $('form').h5Validate({
            errorClass:'black_h5validate'
        });

	/**
	 * Close iframe popups, used inside iframe
	 */
	$('.cb.close.iframe').click(function(){
		parent.$('.cb').colorbox.close();
	});
        
        /*
         *field value format
         */
        $('.currency').change(function(){
            var number = $(this).val();
            number = number.replace('$','');
            number = number.replace(',','');
            number = $.formatNumber(number, {format:"$#,###.00", locale:"au"});
            $(this).val(number);
        })

        $('.currency').each(function(){
            var number = $(this).val();
            number = number.replace('$','');
            number = number.replace(',','');
            number = $.formatNumber(number, {format:"$#,###.00", locale:"au"});
            $(this).val(number);
        });
        
        
        
	/**
	 * Close non iframes
	 */
	$('.cb.close').not('.iframe').click(function(){
		$('.cb').colorbox.close();
	});
	
	 
	 /*
	  * Quote form employee
	  */
	 
	 $('.employee .emp_view').click(function(){
				var id = $(this).siblings('select').val();
				if(id == '') {
						alert('Please select an Employee from the list');
						return false;
				}else{
						return true;
				}
		});
	 
	 /*
	  * calculate letters in texarea
	  */

     	$('.cal_size textarea').each(function(){
				var length = $(this).val().length;
				$(this).siblings().children('span').children('i:first-child').text(length);
		});	
	 
	 $('.cal_size .click').click(function(){
            var length = $(this).parent().parent().siblings('textarea').val().length;
            $(this).siblings('i').text(length);
	 });
         
       
    $('button.ui-datepicker-current').live('click', function() {
        $.datepicker._curInst.input.datepicker('setDate', new Date());
    });
   // button.ui-datepicker-close {display: none;}​

//	if(typeof($.datepicker) != 'undefined')
//             $( ".datepicker" ).datepicker({
//                 buttonImage: "../img/calendar.gif",
//      showButtonPanel: true
//    });
//		$('.datepicker').datepicker({dateFormat : "dd/mm/yy"});
//		//Jquery datepicker default value
//                $( ".datepicker" ).datepicker({ defaultDate: '01/01/2013' });
//
//                //$( ".selector" ).datepicker({ dateFormat: 'yy-mm-dd' });
//                
		
		
	
	 if(typeof($.datepicker) != 'undefined')
           // var img_path =APP.date_pic 
            $( ".datepicker" ).datepicker({
                showButtonPanel: true,
//                changeMonth: true,
//                changeYear: true,
//                showOn: "button",
//                //buttonImage: img_path+"calendar.gif",
//                buttonImageOnly: true,
                dateFormat: 'dd/mm/yy',
                defaultDate:'01/01/2013'
              });
  
  $('.datepicker').each(function(){
    if ($(this).val() !== '')
     $(this).val( moment($(this).val()).format('DD/MM/YYYY') );
 });
        
       
        
        $('button.ui-datepicker-current').on('click', function() {
              $.datepicker._curInst.input.datepicker('setDate', new Date());
        });

	//standard button actions
	$('.action-delete').click(function(e){
		var obj = $(this).data('object');
		if(confirm("Are you sure you want to delete this "+obj)){
			return true;
		}
		else {
			e.preventDefault();
			return false;
		}
	});

	/**
	 * Highglighter, define data-highlight_target in click element
	 */
	$('.highlighter').live('click', function(){
               if($(this).attr('checked')){
                   $( $(this).data('hl_target') ).toggleClass('highlight');
               }else{
                   $( $(this).data('hl_target') ).removeClass('highlight');
               }
	});
        
        
        if($('.highlighter').attr('checked')) {
             $( $('.highlighter').data('hl_target') ).addClass('highlight');
        }

	/**
	 * Rnge filter button
	 */
	$('.range-filter').live('click', function(){
		var val = $(this).val(); 
		$('select[name=by_letter]').val(val).change();
	});

	$('.range-filter-reset').live('click', function(){
		$('select[name=by_letter]').val('').change();
	});


	/**
	 * Select current employee
	 */
	$('.select_current_employee').live('click', function(){
		var emp_id   = $(this).data('emp_id');
		var dropdown = $(this).data('dropdown');
                //alert(emp_id);
		$(dropdown).val(emp_id);
	});
        
        
        
        $('.testSelectBtn').live('click', function(){
           // $("#form_clear_test_officer").click();
                 var emp_id   = $(this).data('emp_id');
                 $('#wdb_officer').append('<option value="'+emp_id+'">'+emp_id+'</option>');
                // alert(emp_id);
		var dropdown = $(this).data('dropdown');
		$(dropdown).val(emp_id);
                dt.fnDraw();
                 // $(dropdown).val('dd');
         
	});
        
        $('.testSelectBtn1').live('click', function(){
           // $("#form_clear_test_officer").click();
           
           var getid =$(this).data('emp_id');
           var n=getid.split(" ");
          // alert(n[0]);
           var emp_id=n[1]+', '+n[0];
                 //var emp_id   = $(this).data('emp_id');
                 $('#wdb_officer').append('<option value="'+emp_id+'">'+emp_id+'</option>');
                // alert(emp_id);
		var dropdown = $(this).data('dropdown');
		$(dropdown).val(emp_id);
                dt.fnDraw();
                 // $(dropdown).val('dd');
         
	});
        
        $('.rangeB').click(function(){
            $('#rangDiv input').css("font-weight",'');
            $(this).css("font-weight",'bold');
            $('#btnReset').css("font-weight",'bold');
        });
        $('.btnReset').click(function(){
            $('#rangDiv input').css("font-weight",'');
        });
	
	
	/*
	 * Convert dropdowsto editable
	 */
	if(typeof($.jec) != 'undefined') {
		$('select.editable').jec();
	}
	

	/**
	 * Dropdown value clearer
	 */
	$('.clear-dd').live('click', function(){
		var select = $(this).data('dropdown');
		$('select[name='+select+']').val('').change();
	});
        $('.clear-dd1').live('click', function(){
		var select = $(this).data('dropdown');
		$('select[name='+select+']').prop("selectedIndex",0);
	});
	/**
	 * Dropdown value clearer, appender
	 * Append the clear button to a dropdown
	 */
	$('.add_reset_filter').each(function(){
		var ele = $(this);
		ele.after('<input type="button" data-dropdown="'+ele.attr('name')+'" value="..." class="clear-dd1" />');
	}); 
        
        $('.add_reset_filter_Sections').each(function(){
		var ele = $(this);
		ele.after('<input type="button"  value="" id="clear_Sections" class="clear_Sections " style="height:19px;" />');
	});
        $('.add_reset_filter_Projects').each(function(){
		var ele = $(this);
		ele.after('<input type="button"  value="" id="clear_Projects" class="clear_Projects " style="height:19px;" />');
	});
        $('.add_reset_filter_Areas').each(function(){
		var ele = $(this);
		ele.after('<input type="button"  value="" id="clear_Areas" class="clear_Areas " style="height:19px;"/>');
	});
        /*
         *Message Close
         */
        $('.close').click(function(){
            $('.alert-message').fadeOut("slow");
        });
        
        if($('.alert-message')){
             setTimeout(function(){
                 $('.alert-message').fadeOut("slow");}, 5000); 
        }
        
        /*
         *Confirm MSG
         */
        $('.confirm').click(function(){
            $("#yesno").easyconfirm({locale: { title: 'Select Yes or No', button: ['No','Yes']}});
            $("#yesno").click(function() {
		//alert("You clicked yes");
                return ture;
            });
            return false;
        })
        
        
        
        


	/**
	 * Linkify buttons
	 */
	$('button, input[type=button]').live('click', function(e){
		if(!$(this).hasClass('cb')) { 
			if($(this).attr('href') && !$(this).attr('target')) {

				window.location.replace($(this).attr('href'));
				e.preventDefault();
				return false;
		
			} else if($(this).attr('target')) {

				window.open($(this).attr('href'), $(this).attr('target'));
  				window.focus();
			
			}

		}
		else {
			return true;
		}
	});
	
	//advaced search
	$('table.advance_search .select').each(function(){
			$(this).change(function(){
				if(this.value == 'N/A'){
					$(this).parent().parent().siblings().find('.filter_field').each(function(){
						$(this).attr('disabled', 'disabled');
                                                $("table.advance_search #PField").css('color',"#B8B8B8");
                                                 $("table.advance_search #PEquality").css('color','#B8B8B8');
                                                  $("table.advance_search #PCriteria").css('color','#B8B8B8');
					});
                                        
				}else{
					$(this).parent().parent().siblings().find('.filter_field').each(function(){
						$(this).removeAttr('disabled');
                                                $(this).removeAttr('readonly');
                                                $("table.advance_search #PField").css('color','#000000');
                                                 $("table.advance_search #PEquality").css('color','#000000');
                                                  $("table.advance_search #PCriteria").css('color','#000000');
					});
				}
			});
		});
		
		$('table.advance_search .select').each(function(){
			if(this.value == 'N/A'){
				$(this).parent().parent().siblings().find('.filter_field').each(function(){
					$(this).attr('disabled', 'disabled');
				});
			}
		});
		
		$('.leftside .checkbox').change(function(){
			if(this.checked){
				$('.leftside').css('background-color', '#FD8181');
                                 $('.leftside #switch').css("font-weight","bold");
				$('.leftside #switch').text('ON');
                               
				
			}else{
				$('.leftside').css('background-color', '#fff');
                                 $('.leftside #switch').css("font-weight","bold");
				$('.leftside #switch').text('OFF');
			}
		});
                


	
	/**
	 * Global Disable submit buttons inmiddle of ajax calls
	 */
	$('input[type=submit]').ajaxStart(function() {
	  $(this).attr('disabled', 'disabled');
	}).ajaxComplete(function() {
	  $(this).removeAttr('disabled');
	});

	$('#ajax-load').ajaxStart(function() {
	  	$(this).stop(true, true).animate({'right': 0});
	}).ajaxComplete(function(){
		$(this).stop(true, true).animate({'right': -100});	
	});
        
        
 //--------------------------------------------------------------------------------------       
        // find all disabled fields
        /*
        $("input[type='text']:disabled, textarea:disabled").each(function(index){
            // add the class is_disabled
            $(this).addClass("is_disabled");
           // if($(this).hasClass("datepicker")){
                //Remove Datepiker 
              $(this).removeClass("datepicker"); 
                $(this).removeClass("hasDatepicker");
            //}
                 // remove the attribut disabled
                $(this).removeAttr('disabled');
                // add new attribut readonly
                $(this).attr('readonly', 'readonly');
            

        });*/
        // on submit remove all fields which are still with class is_disabled
        $('form').submit(function() {
            // find all fields with class is_isabled
            $("input.is_disabled, textarea.is_disabled, select.is_disabled").each(function(index){
                //  and remove them entirely
               // $(this).remove();
                 $(this).attr('disabled', 'disabled');
            });
            return true;
        });
        // now don't let anyone click into the fields
        // this will simulate the 'disabled' functionality
        $('.is_disabled').click(function() {
          $('.is_disabled').blur();
        });

//----------------------------------------------------------------------------

});




$(window).load(function(){

	$('#header').animate({top:15}, 800);

});


/**
 * Build a URL relative to base
 * @return {[type]} [description]
 */
function url(path) {
	return APP.base_url + path;
}



function selecter(id){
             //alert("df");
      var divName='NMB'+id;
      var range = document.body.createTextRange();
      range.moveToElementText(document.getElementById(divName));
      range.select();
      }

$('.datepicker').change(function(){
    //alert('cvcv');
            if($(this).val()!=''){
                if(!/^\d{2}\/\d{2}\/\d{4}$/.test($(this).val())){
                    alert('Date format incorrect (MM/DD/YYYY)');
                    $(this).val(' ');
                    return false;
                }
             }
        });
        
  (function( $ ) {
    $.widget( "custom.combobox", {
      _create: function() {
        this.wrapper = $( "<span>" )
          .addClass( "custom-combobox" )
          .insertAfter( this.element );
 
        this.element.hide();
//        alert(this.element.css('height'));
        this._createAutocomplete();
        this._createShowAllButton();
      },
 
      _createAutocomplete: function() {
        var selected = this.element.children( ":selected" ),
          value = selected.val() ? selected.text() : "";

        this.input = $( "<input>" )
         
          .appendTo( this.wrapper )
          .val( value )
          .attr( "title", "" )
  
          .addClass( "custom-combobox-input ui-widget ui-widget-content ui-state-default ui-corner-left" )
          .autocomplete({
            delay: 0,
            minLength: 0,
            source: $.proxy( this, "_source" )
            
          });
          
          
          
 
       
    
      },
 
      _createShowAllButton: function() {
      ;
        var input = this.input,
          wasOpen = false;
 
        $( "<a>" )
        
          .attr( "tabIndex", -1 )
          .attr( "title", "Show All Items" )
          
          .appendTo( this.wrapper )
     
          .button({
            icons: {
              primary: "ui-icon-triangle-1-s"
            },
            text: false
            
          })
           
          .removeClass( "ui-corner-all" )
          .addClass( "custom-combobox-toggle ui-corner-right" )
  
          .mousedown(function() {
            wasOpen = input.autocomplete( "widget" ).is( ":visible" );
          })
          
          .click(function() {
            input.focus();
 
            // Close if already visible
            if ( wasOpen ) {
              return;
            }
            
 
            // Pass empty string as value to search for, displaying all results
            input.autocomplete( "search", "" );
          });
      },
 
      _source: function( request, response ) {
        var matcher = new RegExp( $.ui.autocomplete.escapeRegex(request.term), "i" );
        response( this.element.children( "option" ).map(function() {
          var text = $( this ).text();
          if ( this.value && ( !request.term || matcher.test(text) ) )
            return {
              label: text,
              value: text,
              option: this
            };
        }) );
      },
 
      _removeIfInvalid: function( event, ui ) {
 
        // Selected an item, nothing to do
        if ( ui.item ) {
          return;
        }
 
        // Search for a match (case-insensitive)
        var value = this.input.val(),
          valueLowerCase = value.toLowerCase(),
          valid = false;
        this.element.children( "option" ).each(function() {
          if ( $( this ).text().toLowerCase() === valueLowerCase ) {
            this.selected = valid = true;
            return false;
          }
        });
 
        // Found a match, nothing to do
        if ( valid ) {
          return;
        }
 
        // Remove invalid value
        this.input
          .val( "" )
          .attr( "title", value + " didn't match any item" )
          .tooltip( "open" );
        this.element.val( "" );
        this._delay(function() {
          this.input.tooltip( "close" ).attr( "title", "" );
        }, 2500 );
        this.input.data( "ui-autocomplete" ).term = "";
      },
 
      _destroy: function() {
        this.wrapper.remove();
        this.element.show();
      }
    });
  })( jQuery );
 
  $(function() {
    $( ".selectEditableJqury" ).combobox();
    
  });