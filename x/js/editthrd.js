$(document).ready(function()
  {
    $('.dbsv').click(function()
    {
      let pp = $(this).parent();
      let pid = pp.parent().find('.id').html();
      let ptext = pp.find('.xmpVal').html();
      let ptitle = pp.find('.db_title').val();
      let pcat = pp.find('.db_cat').val();
      let ptag = pp.find('.db_tags').val();
      let ptype = pp.find('.db_type').val();
      let pdesc = pp.find('.db_descr').val();
      let purltag = pp.find('.db_urltag').val();
      console.log(pp)
      $.ajax
        ({
          type: "POST",
          url: "func/editthrd.php",
          data: {text:ptext, title:ptitle, cat:pcat, tag:ptag, type:ptype, desc:pdesc, url:purltag, id:pid},
          success: function(edtData)
            {
              console.log(edtData)
            }
        });
    })
  })
