$(document).ready(function(){

    let b = window.location.href;
    b = b.slice(-3)
    if(b == 'php' || '')
      {
        console.log('ahp');
      } else
      {
        $('.ui_content').removeClass('active');
        $(b).addClass('active');
      }


 $('.ui_leftBar').find('i').click(function(){
   let id = $(this).attr('nav-attr');
   let con = $('#' + id);
   $('.ui_content').removeClass('active');
   $('#' + id).addClass('active');
   let c1or = $('.orders');
   let popleft = $('.popLeft');
   if(popleft.hasClass('inputHidden') != true)
    {
      popleft.addClass('inputHidden');
    }
    if(c1or.hasClass('small') != false)
      {
        c1or.removeClass('small');
      }
 })



 $('.breakExpand').click(function(){
   if($(this).hasClass('hidden')) {
     count = $('.hiddenCount')[0].id
     $(this).find('.txt').html('Visa mindre ('+count+')')
   } else {
     $(this).find('.txt').html('Visa alla ('+count+')')
   }
   $(this).toggleClass('hidden')

   $('#all_orders').toggleClass('hidden')
 })
})
