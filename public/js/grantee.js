$(document).ready(function(){
  $('.editGrantee').tooltip();
  $('.printDataGrantee').tooltip();
  $('.printLicenseGrantee').tooltip();
  $('.removePermission').tooltip();
  $('.retireGrantee').tooltip();
  $('.datepicker').datepicker()
  	.on('changeDate', function(){
	 		$('.datepicker').datepicker('hide');
		});
});