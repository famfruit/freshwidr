function getLCarr(){
  // Hämta orders, lägg i array
  // Skicka till client, lägg i localStorage på varje functionCall
  $.ajax({
    type: "POST",
    url: "txlook/egn.php",
    dataType: "JSON",
    data: {evalArray:true},
    success: function(data){
      if(!data){
        console.log('404')
      } else {
        localStorage.setItem('txl', JSON.stringify(data))
        console.log('lc', data)
      }
    }
  })
}
function markOrd(){
  // markera orderar med pengar på konto
  data = JSON.parse(localStorage.getItem('txl'))['data']
  //console.log(data)
  buffer = 500
  for(item in data){
    console.log(data[item])
    if(data[item]['value'] > buffer){
      $('#' + data[item]['id']).addClass('warning');
    }
  }
}

setInterval(function(){
  data = JSON.parse(localStorage.getItem('txl'))
  past = new Date(data['lastUpdate']).getTime()
  delay = 1000* 60 * 122 // 120 min + 2min
  isPast = (new Date().getTime() - past < delay)?false:true;
  console.log(data['lastUpdate'])
  console.log(past, ' - ', new Date().getTime())
  console.log(isPast)
  if(isPast != false){
    getLCarr();
    console.log('Changed the LC')
  }
}, 20000)


$(document).ready(function(){
  markOrd();
  setInterval(function(){
    markOrd();
  }, 60000)
})
