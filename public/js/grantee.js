$(document).ready(function(){
  $('.help').tooltip();
  $('.datepicker').datepicker({
    beforeShow: function() { $('.datepicker').css("z-index", 1051); }
  }).on('changeDate', function(){
	 		$('.datepicker').datepicker('hide');
		});
});

$('#myTab a').click(function (e) {
  e.preventDefault();
  $(this).tab('show');
})

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
