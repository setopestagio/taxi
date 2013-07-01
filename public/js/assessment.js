$(document).ready(function(){
  $(".plate").mask("aaa-9999");
  $(".grantee").mask("aa 9999");
   var calendar = $('#calendar').calendar({events_url:'/js/events.json', tmpl_path: '/html/'});
});