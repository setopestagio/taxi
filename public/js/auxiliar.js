$('#addGranteeInAuxiliar').click(function() { 
	console.log($('#tableGrantees').size());
  $('#tableGrantees tr:last').before(   '<tr> ' 
                                      + '<td> '
                                      + '<a class="removeGranteeAuxiliar" href="Javascript:removeGrantee()"><i style="color: gray" class="icon-remove-sign icon-large"></i></a></td>'
                                      + '<td colspan="2"><input type="text" name="permission[]" placeholder="número da permissão" maxlength="8"></td>'
                                      + '<td><input type="text" name="start_date[]" placeholder="data inicial" class="input-small datepicker dateMask" data-mask="99/99/9999" data-date-format="dd/mm/yyyy"></td>'
                                      + '<td><input type="text" name="end_date[]" placeholder="data de baixa" class="input-small datepicker dateMask" data-mask="99/99/9999" data-date-format="dd/mm/yyyy"></td>'
                                      + '</tr>');
});

$('.removeGranteeAuxiliar').click(function() {
  console.log(this);
});

$('input[name="start_date[]"]').livequery(function() {
  $(this).mask("99/99/9999");
});

$('input[name="end_date[]"]').livequery(function() {
  $(this).mask("99/99/9999");
});