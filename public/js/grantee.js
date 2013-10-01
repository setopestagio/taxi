$('#myTab a').click(function (e) {
  e.preventDefault();
  $(this).tab('show');
});

$('#aux_new').typeahead({
  source: function(query, process) {
      $('#removeAuxNew').css('display','none');
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
        $('#aux_new_id').val(map[item].id);
        $('#aux_new').attr('disabled',true);
        $('#removeAuxNew').css('display','');
        return item;
    }, 
    matcher: function (item) {
      if (item == null)
            return false;
      return ~item.toLowerCase().indexOf(this.query.toLowerCase())
    }
}).on('typeahead:opened', function() {
    $(this).closest('.panel-body').css('overflow','visible');
}).on('typeahead:closed', function() {
    $(this).closest('.panel-body').css('overflow','hidden');
}); 

$('#removeAuxNew').click(function(){
  $('#aux_new_id').val('');
  $('#aux_new').attr('disabled',false);
  $('#aux_new').val('');
  $('#removeAuxNew').hide();
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
    $('#transferGroup').removeClass('hide');
    $('#vehicleGroup').addClass('hide');
    $('#chassiGroup').addClass('hide');
    $('#reservationGroupStart').addClass('hide');
    $('#reservationGroupEnd').addClass('hide');
    $('#plateGroup').addClass('hide');
    $('#otherGroup').removeClass('hide');
  }
  if($(this).val() == 2){
    $('#transferGroup').addClass('hide');
    $('#vehicleGroup').removeClass('hide');
    $('#chassiGroup').removeClass('hide');
    $('#reservationGroupStart').addClass('hide');
    $('#reservationGroupEnd').addClass('hide');
    $('#plateGroup').addClass('hide');
    $('#otherGroup').removeClass('hide');
  }
  if($(this).val() == 3){
    $('#transferGroup').addClass('hide');
    $('#vehicleGroup').addClass('hide');
    $('#chassiGroup').addClass('hide');
    $('#reservationGroupStart').removeClass('hide');
    $('#reservationGroupEnd').addClass('hide');
    $('#plateGroup').addClass('hide');
    $('#otherGroup').removeClass('hide');
  }
  if($(this).val() == 4){
    $('#transferGroup').addClass('hide');
    $('#vehicleGroup').addClass('hide');
    $('#chassiGroup').addClass('hide');
    $('#reservationGroupStart').addClass('hide');
    $('#reservationGroupEnd').addClass('hide');
    $('#plateGroup').removeClass('hide');
    $('#otherGroup').removeClass('hide');
  }
  if($(this).val() == 5){
    $('#transferGroup').addClass('hide');
    $('#vehicleGroup').addClass('hide');
    $('#chassiGroup').addClass('hide');
    $('#reservationGroupStart').addClass('hide');
    $('#reservationGroupEnd').addClass('hide');
    $('#plateGroup').addClass('hide');
    $('#otherGroup').removeClass('hide');
  }
});


$('.addAuxiliar').typeahead({
  source: function(query, process) {
      $('.addAuxiliarRemove').css('display','none');
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
        $('.auxiliar_id').val(map[item].id);
        $('.addAuxiliar').attr('disabled',true);
        $('.addAuxiliarRemove').css('display','');
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

$('.addAuxiliarRemove').click(function(){
  $('.auxiliar_id').val('');
  $('.addAuxiliar').attr('disabled',false);
  $('.addAuxiliar').val('');
  $('.addAuxiliarRemove').hide();
});