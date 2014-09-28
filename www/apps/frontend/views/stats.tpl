<div class="container">
<div class="row">
  <div style="height: 500px;" class="col-md-6" id="piechart1"></div>
  <div style="height: 500px;" class="col-md-6" id="piechart2"></div>
</div>

 <script type="text/javascript" src="//www.google.com/jsapi"></script>
<script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
	options =  {pieHole:0.4,titleTextStyle:{color:'#c8c8c8',fontSize:'20'},title: 'No title',is3D: false,backgroundColor:'transparent',legend:{textStyle:{color:'#c8c8c8'}}};
          var data1 = google.visualization.arrayToDataTable([
          ['Leak type', 'Affected hosts'],
          {{ BEGIN statsByTags }}
		[{{ json_encode($term) }}, {{ json_encode($count)}}]{{ UNLESS $_last }},{{ END }}
	  {{ END }}
	]);

        var options1 = options;
        options1.title = 'Leak types';

        var chart1 = new google.visualization.PieChart(document.getElementById('piechart1'));

        chart1.draw(data1, options1);

        var data2 = google.visualization.arrayToDataTable([
          ['Affected port', 'Affected hosts'],
          {{ BEGIN statsByPorts }}
                [{{ json_encode($term) }}, {{ json_encode($count)}}]{{ UNLESS $_last }},{{ END }}
          {{ END }}
        ]);

        var options2 = options;
        options1.title = 'Leak by ports';

        var chart2 = new google.visualization.PieChart(document.getElementById('piechart2'));

        chart2.draw(data2, options2);

      }
    </script>

</div>
