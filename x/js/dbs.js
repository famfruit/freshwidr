$(document).ready(function()
  {
    //check url for queries, make async call to db

    $('.dbadmS').keyup(function()
      {
        let input = $(this).val();
        $('.popLeft').removeClass('vis');
        if(input == '')
          {
            $('.resultBox').removeClass('vis');
          } else {
            $.ajax({
              type: "GET",
              url: "func/sea.php",
              data: {data:input},
              success: function(data)
              {
                $('.resultBox').html(data).addClass('vis');

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



                              $('.goback').click(function(){
                                $(this).parent().addClass('inputHidden');
                                $('.orders').removeClass('small');
                              })


                            }
                        })

                })



              }
            })

          }
      })
  })
