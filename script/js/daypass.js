
function dpclick(){
  user = $('.dpu').val()
  email = $('.epu').val()
  if(user.length <= 0){
    //error
  } else if (email.length <= 0) {

  } else {
    $.ajax({
      type: "POST",
      url: "script/func/dpass.php",
      data: {s:true, user:user, email:email},
      success: function(data){
        if(data == 'stru'){
          $('.confmsg').addClass('show')
          $('.pp_block.info').addClass('unlocked')
        }
      }
    })
  }
}
