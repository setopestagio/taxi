$(document).ready(function(){
  $('.editGrantee').tooltip();
  $('.printDataGrantee').tooltip();
  $('.printLicenseGrantee').tooltip();
  $('.removePermission').tooltip();
  $('.retireGrantee').tooltip();
  $('.pendenciesGrantee').tooltip();
  $('.datepicker').datepicker()
  	.on('changeDate', function(){
	 		$('.datepicker').datepicker('hide');
		});
});