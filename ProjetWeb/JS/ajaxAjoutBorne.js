$("body").on( "click", "#soumettre", function(){

  var data = $("#ajoutBorne").serialize();
  $.ajax({
      url: "PHP/AjouterBornes.php",
      type : 'POST',
      data: data,
      success: function(status){
        if (status == "success") {
          document.location.reload(true);
        }
      }
  });
});
