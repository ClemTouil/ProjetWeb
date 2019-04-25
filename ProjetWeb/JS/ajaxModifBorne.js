$("body").on( "click", "#sauvegarder", function(){
  var disponibilite = document.getElementById("dispo_brn").value;
  var adresse = document.getElementById("adresse").innerHTML;
  $.ajax({
      url: "PHP/ModifierBorne.php",
      type : 'POST',
      data: 'dispo='+disponibilite+ '&adresse=' + adresse,
      success: function(status){
        if (status == "success") {
            document.getElementById("dispo").innerHTML = disponibilite;
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
