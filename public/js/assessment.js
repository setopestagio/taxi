$(document).ready(function(){
  $(".grantee").mask("aa 9999");
   var calendar = $('#calendar').calendar({events_url:'/js/events.json', tmpl_path: '/html/'});
});