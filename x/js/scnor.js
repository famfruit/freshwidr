$(document).ready(function()
  {



    var obj = document.createElement("audio");
    obj.src = "job-done.mp3";
    obj.volume = 0.1;
    obj.autoPlay = false;
    obj.preLoad = true;
    obj.controls = true;

      // obj.pause();

    let curOrd = $('.hiddenCount')[0].id
    setInterval(function()
      {
        $.ajax
        ({
          cache: false,
          type: "POST",
          url: 'func/ordEval.php',
          data: {oldNum: curOrd, s:true},
          success: function(coData)
          {
            if(coData != 'f')
              {
                let titleNum = $('.newBar').length;
                obj.play();
                var isOldTitle = true;
                var oldTitle = "Admin Panel";
                var newTitle = '(' + coData + ') | Admin Panel';
                var interval = null;
                interval = setInterval(changeTitle, 700);
                function changeTitle() {
                  document.title = isOldTitle ? oldTitle : newTitle;
                  isOldTitle = !isOldTitle;
                }
                $(window).focus(function () {
                    clearInterval(interval);
                    $("title").text(oldTitle);
                });

                $('.clAb').click(function()
                  {
                    $(this).parent().toggleClass('brd');
                    $(this).prev().toggleClass('pos')
                    $(this).next().toggleClass('hidden');
                  })
              }
          }
        })
      }, 10000)

    // CLICK ON ORDERBAR
    $('.clAb').click(function()
      {
        $(this).parent().toggleClass('brd');
        $(this).prev().toggleClass('pos');
        $(this).next().toggleClass('hidden');
        $(this).parent().find('.rmv').toggleClass('show')
      })

      $('.fas.fa-plus-circle.help').click(function()
        {
          let c = $('#addThread');
          if(c.length === 0)
            {
                $('.hcntr').prepend('<div class="orderBar newBar help"><span>Title</span><input id="hcntr_title" type="text" name="" value="" placeholder="Syns i <title> & som Header"><span>Kategori</span><input id="hcntr_cat" type="text" name="" value="" placeholder="start/enkortsdator/boxer/pc/tv"><span>Type</span><input id="hcntr_type" type="text" name="" value="" placeholder="guide/faq/issue"><span>Content</span><textarea id="hcntr_text" name="name" rows="8" cols="80"></textarea><span>Description</span><input id="hcntr_desc" type="text" name="" value="" placeholder="Installguide/kanaler/system/epg/undertexter"><span>URL Tag</span><input id="hcntr_url_tag" type="text" name="" value="" placeholder="/prefix/ladda-ner-m3u"><button type="button" class="hpcntr_addBtn">Lägg till tråd</button><script src="js/addthread.js"></script></div>');

            }

        })

  })
