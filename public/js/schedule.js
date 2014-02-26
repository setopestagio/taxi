
$(document).ready(function() {
	$(".phone").mask("(99) 9999-9999");
	$(".cpf").mask("999.999.999-99");
	$('#defaultReal').realperson({regenerate: 'Clique aqui para gerar outro código',length: 5});

	$.getJSON("/scheduling/return-all-events", function(data) {
		
		var events = [];
		$.each(data, function(error, value) { 
			var date = value.date.split('-');
			var obj = {
				'year': date[0],
				'month': date[1],
				'day': date[2]
			};
			events.push(obj);
		});

		var datepicker = $('#calendar div').datepicker({
			todayBtn: true,
			language: "PT-BR",
			todayHighlight: true,
			endDate: "+3m",
			daysOfWeekDisabled: "0,6",
			startDate: new Date(),
			beforeShowDay: function(date){
				for(var i=0;i<events.length;i++){
					if(date.getFullYear() == events[i].year){
						if(date.getMonth()+1 == events[i].month){
							if(date.getDate() == events[i].day){
								return false;
							}
						}
					}
				}
			}
		}).on('changeDate', function(ev) {
			var dateCur = new Date(ev.date);
			var month = dateCur.getMonth()+1;
			var en_Date = dateCur.getFullYear() + '-' + month + '-' + dateCur.getDate();
			var date = {'date': en_Date};
			$.ajax({
				url: '/scheduling/return-events',
				method: 'post',
				data: date, 
				success: function(result) {
					if(result.length) {
						$.each(result, function(error, data) {
							$("select#hour option").filter("[value='"+data.hour+"']").remove();
						});
					}
					$('#formSchedule').removeClass('hide');
					$('#date').val(en_Date);
				}
			})
		});
	});


	// function checkRequirements() {
	// 	var name = $('#name').val();
	// 	var cpf = $('#cpf').val();
	// 	if( $('#hour').val() > 0 && name.length > 3 && cpf.length == 14) {
	// 		$('#btnSchedule').removeClass('disabled');
	// 	} else {
	// 		if($('#btnSchedule').hasClass('disabled') === false) {
	// 			$('#btnSchedule').addClass('disabled');
	// 		}
	// 	}
	// }

	// $('#hour').change(function() {
	// 	checkRequirements();
	// });

	// $('#name').keyup(function() {
	// 	checkRequirements();
	// });

	// $('#cpf').keyup(function() {
	// 	checkRequirements();
	// });
});


	function fncReschedule(id) {
		$('#reschedule').removeClass('hide');
		$('#id').val(id);
	}
