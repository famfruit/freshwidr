
window.onload = function () {
  $('.wrapper').removeClass('notready');
  $('.wall').fadeOut(100);

  if($('#ifrmsrc').length > 0){
    $('.ifrmloder').addClass('load')
    vl = $('#ifrmsrc')[0].dataset.ifrmsrc;
    truelink = vl
    $('#ifrmsrc').attr('src', truelink);
    $('#ifrmsrc').on('load', function(){
      $('.orange').hide()
    })
  }

  vl = $('.trvid_src')[0].dataset.trailersrc;
  $('.trvid_src').attr('src', vl)
  $('.trailer_video').addClass('fadein')
  $('.spotlog').addClass('tuck')
 }









$(document).ready(function(){


    $('.cnfChanges').click(function(){
        confirm = confirm("Vill du verkligen ändra dina inställningar?")
        if(confirm == true){
          // Do changes here
          inputs = $('.inputContainer.static').find('input')
          console.log(inputs)
          username = inputs[0].value
          email = inputs[1].value
          password = inputs[2].value
        } else {
          location.reload()
        }
    })

    $('.unlockinput').click(function(){
      $('.buttons').toggleClass('vis')
      if($(this).hasClass('uilocked')){
        // Unlock
        inputs = $(this).parent().find('input').removeAttr('readonly')
        $(this).removeClass('uilocked').addClass('uiunlock')
        // Show btns
      } else {
        inputs = $(this).parent().find('input').attr('readonly', 'readyonly')
        $(this).removeClass('uiunlock').addClass('uilocked')
        // Hide btns
      }
    })
    $('.shbtnfpw').click(function(){
      attr = $(this).next().attr('type')
      $(this).toggleClass('on')
      if(attr != 'password'){
        $(this).next().attr('type', 'password')
      } else {

        $(this).next().attr('type', 'text')
      }
    })



  $('.genreselect').click(function(){
    $(this).toggleClass('down')
    $('.genreholder').toggleClass('vis')
  })
  $('.vidtoggle').click(function(){
    $(this).toggleClass('pause')
    $('video').prop('muted', function(index, attr){
    return attr == true ? false: true;
});
  })
  $('.search_btn').click(function(){
    $(this).toggleClass('active')
    $('.searchBar').toggleClass('hidden').find('input').select()
  })

  $('.searchBar').keyup(function(){
    data = $(this).find('input').val()
    input = $(this).find('input')
    console.log(data.length)
    if(data == 0){
      $('.searchResults').addClass('hidden')
    } else {
      $.ajax({
        type: "POST",
        dataType: "json",
        data: {searchBarKey:true, keyString:data},
        success: function(sd){
          console.log(sd)
          $('.searchResults').removeClass('hidden')
          body = ""
          if(sd['error'] != '404'){
            for(i = 0; i < sd.length;i++){
              contents = "<a href='"+sd[i][4]+"'><div class='bar'><div class='imgBlock'><img src='"+sd[i][1]+"'></div><h1>"+sd[i][0]+"</h1><span class='title'>"+sd[i][3]+"</span><span class='genre'>"+sd[i][2]+"</span></div></a>"
              body = body + contents
            }
          } else {
            body = "<span class='searcherror'>0 matchningar: <strong>'"+sd['input']+"'</strong></span>"
          }
          $('.searchResults').html(body)
        }
      })

    }
  })


  /// End of search functions
  $('.navmore').click(function(){
    $('.expanededNav').toggleClass('hidden')
    $(this).toggleClass('active')
  })


  // Determine episodes
  $('.epsd').click(function(){
    source = $(this)[0].dataset.lnk;
    $('.epsd').removeClass('active')
    $(this).addClass('active')
    $('iframe').attr('src', source)
  })


  $('.tolgn').click(function(){

    user = $('.iusr').val()
    pw = $('.ipw').val()
    if(user.length != 0 && pw.length != 0){
      console.log(user, pw)
      $('.logoimg').attr('src', 'assets/img/animlogo.gif').addClass('anim')
      $.ajax({
        type: "POST",
        data: {loginSet:true, username:user, password:pw},
        success: function(data){
          if(data != 'false'){
            // Update page or whatever
            loc = location.href.substring(0, location.href.indexOf('?'))
            location.href = loc
          }
        }
      })


    }
  })

})
