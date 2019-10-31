
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

    size = window.innerWidth / 1.2
    margin = window.innerWidth / 9.8
    // CAROUSEL
    var storeScrollValue = 0

    $('.scrolleft').click(function(){
      sleft = $(this).parent().find('.realwindow').scrollLeft()
      // get remainder from old and new, thats the scrollwidth
      scrollAmount = $(this).parent().find('.realwindow')[0].scrollWidth - $(this).parent().find('.realwindow')[0].clientWidth - margin;
      $(this).parent().find('.scrollright').removeClass('hidden')
      console.log(sleft)
      if(sleft < 200){
        $(this).parent().find('.scrolleft').addClass('hidden')
      }
      storeScrollValue = sleft
      $(this).parent().find('.realwindow').animate({
        scrollLeft: "-=" + size + "px"
      }, "fast");
    });




    $('.scrollright').click(function(){
      sleft = $(this).parent().find('.realwindow').scrollLeft()
      $(this).parent().find('.scrolleft').removeClass('hidden')
      // get remainder from old and new, thats the scrollwidth
      scrollAmount = $(this).parent().find('.realwindow')[0].scrollWidth - $(this).parent().find('.realwindow')[0].clientWidth - margin;
      if(sleft > scrollAmount * 0.95){
        $(this).parent().find('.scrollright').addClass('hidden')
      }
      storeScrollValue = sleft
      $(this).parent().find('.realwindow').animate({
        scrollLeft: "+=" + size + "px"
      }, "fast");
    });

    //





    $('.round').click(function(){
      $(this).addClass('load')
      $('.btnhloader').addClass('vis')
      $('.lnk').find('strong').html('')
      $('.disc').find('strong').html('')
      $('.hdnlink').removeClass('vis')
      inv = $(this)[0].dataset.dsk
      console.log(inv)
      if(inv == 0 || inv == '0'){
        console.log('asd')
        location.reload()
      }
      $.ajax({
        type: "POST",
        data: {generateInvite:true},
        dataType: "json",
        success: function(data){
          setTimeout(function(){
            if(data['vkey']){
              $('.lnk').find('strong').html(data['vkey'])
              $('.disc').find('strong').html(data['date'])
              $('.hdnlink').addClass('vis')
              $('.remaind').html(data['invitesLeft'] + '<strong>KVAR</strong>')
            } else {
              location.reload()
            }
            $('.round').removeClass('load')
            $('.btnhloader').removeClass('vis')

            // insert new table
            body = '<table class="on"><tr><td class="status on">AKTIV</td><td class="key">'+data['vkey']+'</td><td class="date">'+data['date']+'</td></tr></table>'
            $('.refhistory').prepend(body)


          }, 500)

        }
      })
    })
    $('.res').click(function(){
      location.reload()
    })
    $('.cnfChanges').click(function(){
      inputs = $('.inputContainer.static').find('input')
      console.log(inputs)
      username = inputs[0].value
      email = inputs[1].value
      password = inputs[2].value
      id = $(this)[0].dataset.userid
      if(!username || !email || !password){
        alert("Fyll i alla rutorna!")
     } else {
        confirm = confirm("Vill du verkligen ändra dina inställningar?")
        if(confirm == true){
          // Do changes here
          userinfo = [username, email, password, id]
          $.ajax({
            type: "POST",
            data: {userChangeSet: true, userChangeInfo:userinfo},
            success: function(data){
              location.reload()
            }
          })
          // kdl
        } else {
          location.reload()
        }
      }
    })

    $('.unlockinput').click(function(){
      $('.buttons').toggleClass('vis')
      if($(this).hasClass('uilocked')){
        // Unlock
        inputs = $(this).parent().find('input').removeAttr('readonly')
        $(this).removeClass('uilocked').addClass('uiunlock')
        $('#keepthis').attr('readonly', 'readonly')
        // Show btns
      } else {
        inputs = $(this).parent().find('input').attr('readonly', 'readyonly')
        $(this).removeClass('uiunlock').addClass('uilocked')
        $('#keepthis').attr('readonly', 'readonly')
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



  $('.reportBtn').click(function(){
    $('.reportContentOptions').toggleClass('vis')
  })

  $('.specRepBtn').click(function(){
    val = $(this)[0].dataset.vl
    vidId = $('.reportContentOptions')[0].dataset.vlid
    pageId = $('.reportContentOptions')[0].id
    usr = $('.reportBtn')[0].dataset.usr
    arr = [vidId, val, pageId, usr]

    $.ajax({
      type: "POST",
      data: {reportSet:true, reportValue:arr},
      success: function(data){
        $('.reportContentOptions').remove()
        $('.reportContent').append('<h2>Tack för din rapport!</h2>')
      }
    })
  })


  $('.toreg').click(function(){
    user = $('.iusr').val()
    email = $('.ieml').val()
    pw = $('.ipw').val()
    key = $('.getvlkey').val()
    if(user.length != 0 && email.length != 0 && pw.length != 0){
      $('.logoimg').attr('src', 'assets/img/animlogo.gif').addClass('anim')

      $.ajax({
        type: "POST",
        data: {regSet: true, username: user, email:email, password:pw, regKey:key},
        success: function(data){
          console.log(data);
          // Update page or whatever
          if(data != 'false'){
            loc = location.href.substring(0, location.href.indexOf('?'))
            location.href = loc
          }
        }
      })
    } else {
      // Mark the one thats empty
    }
  })
  $('.tolgn').click(function(){

    user = $('.iusr').val()
    pw = $('.ipw').val()
    if(user.length != 0 && pw.length != 0){

      $('.logoimg').attr('src', 'assets/img/animlogo.gif').addClass('anim')
      $.ajax({
        type: "POST",
        data: {loginSet:true, username:user, password:pw},
        success: function(data){
          if(data != 'false'){
            // Update page or whatever
            loc = location.href.substring(0, location.href.indexOf('?'))
            location.href = loc + "?profile=news"
          }
        }
      })


    } else {
      // Mark the one thats empty
    }
  })

})
