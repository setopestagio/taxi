$(document).ready(function(){
	$(".phone").mask("(99) 9999-9999");
	$(".cpf").mask("999.999.999-99");  
	$(".permission").mask("aa 9999"); 
	$('.help').tooltip();
  $('.datepicker').datepicker({
    language: 'pt-BR',
    autoclose: true,
    format: 'dd/mm/yyyy'
  });
  $(".dateMask").mask("99/99/9999");
});