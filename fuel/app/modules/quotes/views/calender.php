<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
    <title>jMonthCalendar Sample</title>

    
    
         <?php echo Asset::css('calendar/core.css'); ?>
	<?php echo Asset::js('calendar/jMonthCalendar.js'); ?>


	<style type="text/css" media="screen">
		#jMonthCalendar .Meeting { background-color: #DDFFFF;}
		#jMonthCalendar .Birthday { background-color: #DD00FF;}
		#jMonthCalendar #Event_3 { background-color:#0000FF; }
	</style>
	
	
    <script type="text/javascript">
        $().ready(function() {
			var options = {
				height: 400,
				width: 500,
				navHeight: 25,
				labelHeight: 25,
				onMonthChanging: function(dateIn) {
					//this could be an Ajax call to the backend to get this months events
					//var events = [ 	{ "EventID": 7, "StartDate": new Date(2009, 1, 1), "Title": "10:00 pm - EventTitle1", "URL": "#", "Description": "This is a sample event description", "CssClass": "Birthday" },
					//				{ "EventID": 8, "StartDate": new Date(2009, 1, 2), "Title": "9:30 pm - this is a much longer title", "URL": "#", "Description": "This is a sample event description", "CssClass": "Meeting" }
					//];
					//$.jMonthCalendar.ReplaceEventCollection(events);
					return true;
				},
				onEventLinkClick: function(event) { 
					alert("event link click");
					return true; 
				},
				onEventBlockClick: function(event) { 
					alert("block clicked");
					return true; 
				},
				onEventBlockOver: function(event) {
					//alert(event.Title + " - " + event.Description);
					return true;
				},
				onEventBlockOut: function(event) {
					return true;
				},
				onDayLinkClick: function(date) { 
					//alert(date.toLocaleDateString());
					var testYear = resonable_date(date.getFullYear());
                                       if(testYear==1){
                                           var getMonth = date.getMonth();
                                           var getYear  = date.getFullYear();
                                           var getDate  = date.getDate();
                                            //open_dialog(getYear,getMonth,getDate);
                                            parent.set_ret(getYear,getMonth,getDate);
                                            parent.jQuery.fn.colorbox.close();
                                            return true;
                                       }else{
                                           return true;
                                       }
				},
				onDayCellClick: function(date) { 
					//alert(date.toLocaleDateString());
                                       var testYear = resonable_date(date.getFullYear());
                                       if(testYear==1){
                                           var getMonth = date.getMonth();
                                           var getYear  = date.getFullYear();
                                           var getDate  = date.getDate();
                                            //open_dialog(getYear,getMonth,getDate);
                                            parent.set_ret(getYear,getMonth,getDate);
                                            parent.jQuery.fn.colorbox.close();
                                            return true;
                                       }else{
                                           return true;
                                       }
				}
			};
			
    
                        
                 function open_dialog(getYear,getMonth,getDate){ 
                        
                        $('<div></div>').appendTo('body')
                        .html('<div><h6>'+getYear+' - '+getMonth+' - '+getDate+'</h6></div>')
                        .dialog({
                            modal: true, title: 'Are you sure you want to add this date?', zIndex: 10000, autoOpen: true,
                            width: 'auto', resizable: false,
                            buttons: {
                                Yes: function () {
                                    parent.set_ret(getYear,getMonth,getDate);
                                    parent.jQuery.fn.colorbox.close();
                                    $(this).dialog("close");
                                    
                                },
                                No: function () {
                                    //doFunctionForNo();
                                    $(this).dialog("close");
                                }
                            },
                            close: function (event, ui) {
                                $(this).remove();
                            }
                      });
                 }
                 
                 
                 function resonable_date(year){
                    //Check date, ensure reasonable
                    if((year< 1950)||(year > 2050)){
                        alert( "Please limit the date to years between 1950 and 2050.");
                        return 0;
                    }else{
                        return 1;
                    }
                 }
                        
                        
			var events = [ 	{ "EventID": 1, "Date": "new Date(2009, 3, 1)", "Title": "10:00 pm - EventTitle1", "URL": "#", "Description": "This is a sample event description", "CssClass": "Birthday" },
							{ "EventID": 1, "StartDateTime": new Date(2009, 3, 12), "Title": "10:00 pm - EventTitle1", "URL": "#", "Description": "This is a sample event description", "CssClass": "Birthday" },
							{ "EventID": 2, "Date": "2009-04-28T00:00:00.0000000", "Title": "9:30 pm - this is a much longer title", "URL": "#", "Description": "This is a sample event description", "CssClass": "Meeting" },
							{ "EventID": 3, "StartDateTime": new Date(2009, 3, 20), "Title": "9:30 pm - this is a much longer title", "URL": "#", "Description": "This is a sample event description", "CssClass": "Meeting" },
							{ "EventID": 4, "StartDateTime": "2009-04-14", "Title": "9:30 pm - this is a much longer title", "URL": "#", "Description": "This is a sample event description", "CssClass": "Meeting" }
			];
			
			var newoptions = { };
			var newevents = [ ];
			//$.jMonthCalendar.Initialize(newoptions, newevents);

			
			$.jMonthCalendar.Initialize(options, events);
			
			
			
			
			var extraEvents = [	{ "EventID": 5, "StartDateTime": new Date(2009, 3, 11), "Title": "10:00 pm - EventTitle1", "URL": "#", "Description": "This is a sample event description", "CssClass": "Birthday" },
								{ "EventID": 6, "StartDateTime": new Date(2009, 3, 20), "Title": "9:30 pm - this is a much longer title", "URL": "#", "Description": "This is a sample event description", "CssClass": "Meeting" }
			];
			
			$("#Button").click(function() {					
				$.jMonthCalendar.AddEvents(extraEvents);
			});
			
			$("#ChangeMonth").click(function() {
				$.jMonthCalendar.ChangeMonth(new Date(2008, 4, 7));
			});
        });
    </script>
</head>
<body>

	<center>
		<div id="jMonthCalendar"></div>

		<!--<button id="Button">Add More Events</button>

		<button id="ChangeMonth">Change Months May 2009</button>-->
	</center>

</body>
</html>