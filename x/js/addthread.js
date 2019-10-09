
  $('.hpcntr_addBtn').click(function()
    {
      let ctitle = $('#hcntr_title').val();
      let cat = $('#hcntr_cat').val();
      let type = $('#hcntr_type').val();
      let text = $('#hcntr_text').val();
      let desc = $('#hcntr_desc').val();
      let tag = $('#hcntr_url_tag').val();
      if(ctitle.length > 0 && cat.length > 0 && type.length > 0 && text.length > 0 && desc.length > 0 && tag.length > 0)
      {
        $.ajax
          ({
            type: "POST",
            url: "func/addThread.php",
            data: {title:ctitle, cat:cat, type:type, text:text, desc:desc, tag:tag},
            success: function(data)
              {
                if(data == 1)
                  {
                    $('.orderBar.newBar.help').removeClass('newBar').remove();
                    location.reload();
                  }
              }
          })
      }
      else {
        alert('Empty fields');
      }

    })
