$(document).ready(function(){
  $('.obS').click(function(){
    let val = $(this)[0].classList[1];
    $('#' + val).toggleClass('visible');

  })
  $('.search').keyup(function(){
    let input = $(this).val();
    $.ajax({
      type: "GET",
      url: "script/func/search.php",
      data: {data:input},
      success: function(data)
        {
          $('.resultBox').html(data);
        }
    })
  })
})
