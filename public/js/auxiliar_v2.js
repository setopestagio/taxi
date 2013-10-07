
$('#grantee_new').typeahead({
  source: function(query, process) {
      $('#removeGranteeNew').css('display','none');
      objects = [];
      map = {};
      $.getJSON('/auxiliar/return-grantee', { query: query }, function(data) {
        $.each(data, function(i, object) {
            map[object.label] = object;
            objects.push(object.label);
        });
        process(objects);
      });
    },
    updater: function(item) {
        $('#grantee_new_id').val(map[item].id);
        $('#grantee_new').attr('disabled',true);
        $('#removeGranteeNew').css('display','');
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

$('#removeGranteeNew').click(function(){
  $('#grantee_new_id').val('');
  $('#grantee_new').attr('disabled',false);
  $('#grantee_new').val('');
  $('#removeGranteeNew').hide();
});

$('#existsGrantee').change(function(){
  console.log(this.value);
  if(this.value == 2){
    $('.groupNotExists').show();
    $('.groupExists').hide();
  }else{
    $('.groupExists').show();
    $('.groupNotExists').hide();
  }
});