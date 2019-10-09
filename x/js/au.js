$(document).ready(function()
  {
    $('#x_sub').click(function()
      {
        let un = $('#x_un').val();
        let pw = $('#x_pw').val();
        let key = $('#x_key').val();
        if(un.length > 0 && pw.length > 0 && key.length > 0)
          {
              $('.xloader').addClass('load');
              $('.whiteSpace').addClass('load');
              $.ajax
                ({
                  type: "POST",
                  url: "eval.php",
                  data: {user: un, pass: pw, key:key, auth:true},
                  success: function(eval)
                    {

                      if(eval == 1)
                        {
                          location.reload();
                        } else {
                          $('.xloader').removeClass('load');
                          $('.whiteSpace').removeClass('load');
                        }
                    }
                })
          }
          else
          {
            alert('Empty Fields');
          }
      })
  })
