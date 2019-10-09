$(document).ready(function()
  {


    const urlParams = new URLSearchParams(window.location.search);
    const myParam = urlParams.get('v');
    function getParameterByName(name, url) {
        if (!url) url = window.location.href;
        name = name.replace(/[\[\]]/g, '\\$&');
        var regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)'),
            results = regex.exec(url);
        if (!results) return null;
        if (!results[2]) return '';
        return decodeURIComponent(results[2].replace(/\+/g, ' '));
    }
        let uparam = getParameterByName('v');
        if(uparam != null)
          {
              $.ajax
                ({
                  type: "GET",
                  url: "completed.php",
                  data: {ajg:true, v:uparam},
                  success: function(redirOrder)
                          {
                            console.log(redirOrder)
                            if(redirOrder != 0)
                              {
                                $('.connecting_block.general').addClass('step2');
                                $('.current').attr('class', '').next().addClass('current');
                                $('.ch_title').html('Slutför din order');
                                $('.finalstep').addClass('visible').html(redirOrder)

                              } else {
                                alert("Can't access expired data")
                              }
                          }
                })
          }
//////////////////


    $('.pb').click(function()
      {
        $('.pb').removeClass('set');
        $(this).toggleClass('set');
      })

    $('.chot_po').click(function()
      {

        let boa = $('.of_a');
        if(boa.length > 0)
          {
            let pay = $('.pb.set');
            if(pay.length > 0)
              {
              let usr = $('.ch_usnm').val(),
                  eml = $('.ch_eml').val(),
                  ctr = $('.ch_cnty').val(),
                  prod = $('.prodName').html()
                  if(usr.length < 0 || eml.length < 0 || ctr.length < 0)
                    {
                      alert('too short')
                    }
                    else  {
                            //cannot post element, turn pay value to string
                            pay = pay.attr('id');

                            //render btn useless till query is done
                            if($(this).hasClass('chot_po')){
                                $(this).removeClass('chot_po');
                                $('.orInput').addClass('disable');
                                  $.ajax({
                                    type: "POST",
                                    url: "script/func/chEval.php",
                                    data: {
                                      set:true,
                                      method:pay,
                                      user:usr,
                                      email:eml,
                                      country:ctr,
                                      prod:prod,
                                    },
                                    success: function(data)
                                          {

                                            $(this).addClass('chot_po');
                                            $('.footer').addClass('pushDown');
                                            $('.orInput').removeClass('disable');
                                            $('.connecting_block.general').addClass('step2');
                                            $('.current').attr('class', '').next().addClass('current');
                                            $('.ch_title').html('Slutför din beställning');
                                              $.ajax({
                                                type: "GET",
                                                url: "completed.php",
                                                data: {ajg:true, v:data},
                                                success: function(orderData)
                                                        {
                                                          $('.footer').removeClass('pushDown');
                                                          $('.finalstep').addClass('visible').html(orderData)
                                                          $.ajax ({
                                                              type: "POST",
                                                              url: 'script/mail/confirm_purchase/confirm.php',
                                                              data: {sndml: true, mailtype:'order', email:eml, orderID:data},
                                                              success: function(mdata)
                                                                {
                                                                }
                                                            })
                                                          setTimeout(function()
                                                            {
                                                              $('.fade').removeClass('fade');
                                                            }, 500)

                                                        }
                                              })

                                          }
                                  });
                            } else { console.log('donth ave class') }
                          }
            }
            else
            {
              alert('payment method')
            }
          }
      })

  })
