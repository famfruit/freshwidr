//NOT IN USE
$('.resBar').click(function(){
    let cat = $(this).find('input').val();
    let id = $(this).find('.first').html();
    id = id.substr(1);

        $.ajax({
          type: "POST",
          url: "func/srlts.php",
          data: {table:cat, id:id},
          success: function(sdata)
            {
              if( $('.popLeft').hasClass('inputHidden') == true )
                {
                  $('.popLeft').removeClass('inputHidden');
                }
              $('.resultBox').removeClass('vis');
              $('.popLeft').addClass('vis').html(sdata);
              $('.orders').addClass('small');
            }
        })

})
