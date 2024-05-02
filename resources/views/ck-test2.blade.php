
  $(function(){
    $("#tabs").tabs({
      activate:function(event,ui){
        console.log(ui.newPanel.index());
        if(ui.newTab.index()==0){
           ClassicEditor
          .create(document.querySelector('#description1'))
          .catch( error => {
            console.error( error );
          });
        }else if(ui.newTab.index()==2){
          ClassicEditor
          .create(document.querySelector('#description2'))
          .catch( error => {
            console.error( error );
          });
        }
      }
    });
  });


$(document).ready(function() {

  var id;
  $('.description').each(function() {
      id = $(this).attr('id');
      if (id != '') {
          ClassicEditor
              .create(document.querySelector( '#' + id ))
              .catch( error => {
                  console.error( 'error' );
              } )
      }
  })

});