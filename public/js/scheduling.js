$(document).ready(function() {
    $.getJSON('/scheduling/return-schedulings', { }, function(data) {
  	var events = [];
  	$.each(data, function( index, value ) {
  		var aux = {
  			title : value.title,
  			start : new Date(value.start),
  			allDay: false
  		}
		  events.push(aux);
		});
  	$('#calendar').fullCalendar({
			editable: false,
			events: events
		});
  });
});
