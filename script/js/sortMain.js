$(document).ready(function(){

  $('.sortMain').change(function(){
    let sortVal = this.value;

    $.ajax({
      type: "POST",
      url: 'movies.php',
      data: {sortVal:sortVal},
      success: function(data){
        console.log('should be done')
      }
    })


  })

});
