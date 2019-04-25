$("body").on( "click", "#adlist", function(){
  var nomQuartier = document.getElementById("quartiername").text;
  $.ajax({
      url: "PHP/RequeteAjaxGraphiqueGeneral.php",
      type : 'POST',
      data: 'nom_q='+nomQuartier,
      success: function(donnees, status, xhr){
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Quartiers');
        data.addColumn('number', 'Nombre Habitants');
        data.addColumn('number', 'Nombre Bornes Wi-Fi');

        var ajaxData = donnees.split(' ');
        data.addRows([[ajaxData[0],(ajaxData[1]*1),(ajaxData[2]*1)]]);

        var options = {
      title: 'Nombre d\'habitants et de Bornes par Quartiers',
      seriesType : 'bars',
      legend: { position: 'bottom' },
          series: {
            0: {axis: 'Nombre Habitants', targetAxisIndex: 0},
            1: {axis: 'Nombre Bornes Wi-Fi', targetAxisIndex: 1, type: 'line'}
          },
          hAxis: {
            title: 'Quartiers',
        textPosition: 'none',
            viewWindow: {
              min: [7, 30, 0],
              max: [17, 30, 0]
            }
       }
        };

        var GeneralChart = new google.visualization.ComboChart(document.getElementById('chart_div'));

        function selectHandler() {
          var selectedItem = GeneralChart.getSelection()[0];
          if (selectedItem) {
            var quartier = data.getValue(selectedItem.row, 0);
            quartier = quartier.split(' ').join('_');
            quartier = quartier.split('\'').join('_');
            quartier = quartier.split('-').join('_');
            var zoom = eval(quartier);
            map.fitBounds(zoom.getBounds());

          }
        }

        google.visualization.events.addListener(GeneralChart, 'select', selectHandler);
        GeneralChart.draw(data, options);
      }
  });
});
