$("body").on( "click", "#supprimer", function(){

  var nomBorne = document.getElementById("nom_borne").innerHTML;
  $.ajax({
      url: "PHP/SupprimerBornes.php",
      type : 'POST',
      data: 'nom='+nomBorne,
      success: function(status){
        if (status == "success") {
          document.location.reload(true);
        }
      }
  });
});
