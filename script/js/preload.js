$(document).ready(function()
{
      $('#ld-p_purchase').click(function()
        {
          window.location = window.location + '#learn';
        })
      $('.toProd').click(function()
        {
          window.location = 'products.php';

        })

    $('.posterBlock').click(function()
    {
      window.location = '#top';
      let vod = $(this).find('h1').html();

      $('.loader').addClass('on');

      $.ajax
      ({
        type: "GET",
        url: 'script/func/gvod.php',
        data: {vod:vod},
        success: function(data)
        {
          $('.loader').removeClass('on');
          $('.fsVod').html(data);
        }
      })
    })

    $('.fa-pause-circle').click(function()
      {
        $('#ytv').stopVideo();
      })
})
