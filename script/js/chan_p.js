$(document).ready(function()
  {
    let urlcheck = window.location.pathname;
    console.log(urlcheck);
    url = new URL(window.location.href);

    if (!url.searchParams.get('l')) {
      console.log('No query string, pass goback button');
    }

    $('.ch_l').click(function()
      {
        let x = $(this)[0].id;
        window.location = 'kanaler/' + x;

      })
  })
