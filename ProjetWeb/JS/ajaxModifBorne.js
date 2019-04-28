$("body").on( "click", "#sauvegarder", function(){
  var disponibilite = document.getElementById("dispo_brn").value;
  var nomBorne = document.getElementById("nom_borne").innerHTML;
  var nomConnexion = document.getElementById("nom_c").value;
  $.ajax({
      url: "PHP/ModifierBorne.php",
      type : 'POST',
      data: 'dispo='+disponibilite+ '&nom=' + nomBorne+ '&nomC=' + nomConnexion,
      success: function(status){
        if (status == "success") {
            document.getElementById("dispo").innerHTML = disponibilite;
            document.getElementById("nomC").innerHTML = nomConnexion;
            var mod= document.getElementById("modifier");
            var sauv= document.getElementById("sauvegarder");
            var anu= document.getElementById("annuler");
            mod.style.visibility="visible";
            sauv.style.visibility="hidden";
            anu.style.visibility="hidden";
        }
      }
  });
});
