$(document).ready(function() {
    $('.sendToProcess').click(function(){
      itemSpan = $(this).parent().find('span')

      v_key = itemSpan[1].innerText
      $.ajax({
        type: "POST",
        url: "func/sendToProcess.php",
        data: {set:true, v_key:v_key},
        success: function(data){
          if(data){
            $('.processOrder').removeClass('hidden').html(data)
          }
        }
      })



    })
    $('.procBtn').click(function()
      {
        let  b = $(this);
        let c = $(this).parent()
        let id = c[0].childNodes[1].value;
        let usr = c[0].childNodes[3].value;
        let pw = c[0].childNodes[5].value;
        let eml = c[0].childNodes[7].value;
        let mat = 'process';
        console.log(c,usr, pw, id)
        $(this).addClass('loader');
        $.ajax
          ({
            type: "POST",
            url: "../script/mail/confirm_purchase/confirm.php",
            data: {sndml:true, orderID:id, username:usr, email:eml, password:pw, mailtype:mat},
            success: function(mdta)
              {
                b.removeClass('loader');
                b.parent().parent().addClass('hidden')
                orderbar = b.parent().parent().parent().find('.stBar');
                orderbar.addClass('Completed').html('Completed');
                b.parent().parent().parent().removeClass('pending').addClass('completed')
                if(b.parent().parent().parent().hasClass('newBar') == true)
                  {
                    b.parent().parent().parent().removeClass('newBar');
                    orderbar.removeClass('pos')
                  }

              }
          })
      })
  })
