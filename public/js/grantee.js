$('#myTab a').click(function (e) {
  e.preventDefault();
  $(this).tab('show');
});

$('#aux1').typeahead({
  source: function(query, process) {
      $('#removeAux1').css('display','none');
      objects = [];
      map = {};
      $.getJSON('/grantee/return-people', { query: query }, function(data) {
        $.each(data, function(i, object) {
            map[object.label] = object;
            objects.push(object.label);
        });
        process(objects);
      });
    },
    updater: function(item) {
        $('#aux1_id').val(map[item].id);
        $('#aux1').attr('disabled',true);
        $('#removeAux1').css('display','');
        return item;
    }, 
    matcher: function (item) {
      if (item == null)
            return false;
      return ~item.toLowerCase().indexOf(this.query.toLowerCase())
    }
});

$('#removeAux1').click(function(){
  $('#aux1_id').val('');
  $('#aux1').attr('disabled',false);
  $('#aux1').val('');
  $('#removeAux1').hide();
});

$('#aux2').typeahead({
  source: function(query, process) {
      $('#removeAux2').css('display','none');
      objects = [];
      map = {};
      $.getJSON('/grantee/return-people', { query: query }, function(data) {
        $.each(data, function(i, object) {
            map[object.label] = object;
            objects.push(object.label);
        });
        process(objects);
      });
    },
    updater: function(item) {
        $('#aux2_id').val(map[item].id);
        $('#aux2').attr('disabled',true);
        $('#removeAux2').css('display','');
        return item;
    }, 
    matcher: function (item) {
      if (item == null)
            return false;
      return ~item.toLowerCase().indexOf(this.query.toLowerCase())
    }
}).on('typeahead:opened', function() {
    $(this).closest('.accordion-body').css('overflow','visible');
}).on('typeahead:closed', function() {
    $(this).closest('.accordion-body').css('overflow','hidden');
});

$('#removeAux2').click(function(){
  $('#aux2_id').val('');
  $('#aux2').attr('disabled',false);
  $('#aux2').val('');
  $('#removeAux2').hide();
});

$('#removeAuxiliar1').click(function(){
  var id_aux = $('#aux1_id').val();
  var end_date = $('#end_date_auxiliar1').val();
  removeAuxiliar(id_aux,end_date);
});

$('#removeAuxiliar2').click(function(){
  var id_aux = $('#aux2_id').val();
  var end_date = $('#end_date_auxiliar2').val();
  removeAuxiliar(id_aux,end_date);
});

function removeAuxiliar(idAux,endDate){
  granteeId = $('#grantee_id').val();
  data = 'granteeId='+granteeId+'&idAux='+idAux+'&endDate='+endDate;
  $.ajax({
    type: "POST",
    url: "/grantee/remove-auxiliar",
    data: data
  }).done(function( result ) {
    if(result){
      alert('Auxiliar retirado com sucesso!');
      document.location.reload(true);
    }else{
      alert('Auxiliar não retirado.')
    }
  });
}

$('#operation').change(function() {
  if($(this).val() == 1){
    $('#transferGroup').show();
    $('#vehicleGroup').hide();
    $('#chassiGroup').hide();
    $('#reservationGroupStart').hide();
    $('#reservationGroupEnd').hide();
    $('#plateGroup').hide();
    $('#otherGroup').hide();
  }
  if($(this).val() == 2){
    $('#transferGroup').hide();
    $('#vehicleGroup').show();
    $('#chassiGroup').show();
    $('#reservationGroupStart').hide();
    $('#reservationGroupEnd').hide();
    $('#plateGroup').hide();
    $('#otherGroup').hide();
  }
  if($(this).val() == 3){
    $('#transferGroup').hide();
    $('#vehicleGroup').hide();
    $('#chassiGroup').hide();
    $('#reservationGroupStart').show();
    $('#reservationGroupEnd').hide();
    $('#plateGroup').hide();
    $('#otherGroup').show();
  }
  if($(this).val() == 4){
    $('#transferGroup').hide();
    $('#vehicleGroup').hide();
    $('#chassiGroup').hide();
    $('#reservationGroupStart').hide();
    $('#reservationGroupEnd').hide();
    $('#plateGroup').show();
    $('#otherGroup').show();
  }
  if($(this).val() == 5){
    $('#transferGroup').hide();
    $('#vehicleGroup').hide();
    $('#chassiGroup').hide();
    $('#reservationGroupStart').hide();
    $('#reservationGroupEnd').hide();
    $('#plateGroup').hide();
    $('#otherGroup').show();
  }
});
