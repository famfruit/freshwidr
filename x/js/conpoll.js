$(document).ready(function()
{
  setInterval(function()
    {
      $.ajax({
        type: "POST",
        data: {s:true},
        url: "func/uscon.php",
        success: function(data)
          {
            $('.currentlyOn').html(data);

          }
      })
    }, 99990000);

    setInterval(function()
      {
        $.ajax({
          type: "POST",
          data: {s:true},
          url: "func/updmod.php",
          success: function(upddata)
            {
            }
        })
      }, 60000 * 5)
})
