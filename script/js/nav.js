


    $('#mobnavBars').click(function()
    {
      $(this).toggleClass('cross')
      $('.mbnContent').toggleClass('visible')
      $('.section.pp').toggleClass('hidden')
      $('#learn').toggleClass('hidden')
      $('.footer').toggleClass('hidden')
      $('.header').find('.connecting_block').toggleClass('hidden')
      $('#mobnavLogo').toggleClass('hidden');
      $('#mobnavLogoWhite').toggleClass('hidden');
    })
