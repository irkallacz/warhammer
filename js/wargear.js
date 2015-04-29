$(function(){
  $('#ajax').click(function(){
    if (!$("#vizual").text().length){
          $('#vizual').addClass('spinner');
          $('#vizual').slideToggle();
          $.get(this.href, function(payload){
            $('#vizual').removeClass('spinner');
            $("#vizual").html(payload);
          },'html');
    }else $('#vizual').slideToggle();          
  return false;
  });
});
