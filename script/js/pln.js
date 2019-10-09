$(document).ready(function()
  {
    setInterval(function()
      {
          let ur = window.location.pathname;
          $.ajax
            ({
              type: "POST",
              url: "script/func/pln.php",
              data: {path:ur, dst:true},
              success: function(){}
            })
      }, 10000);
  })
