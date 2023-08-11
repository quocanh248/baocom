<!doctype html>
<html lang="en" translate="no">

<head>
    <meta charset="utf-8">
    <title>Leanwell System</title>
    <base href="/">
    <link rel="stylesheet" href="/dist/css/modal.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <head>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <script type="text/javascript">
            google.charts.load('current', {
                packages: ["orgchart"]
            });
            google.charts.setOnLoadCallback(drawChart);

            function drawChart() {
                var data = new google.visualization.DataTable();
                var baseUrl = window.location.origin;
               
                data.addColumn('string', 'Name');
                data.addColumn('string', 'Manager');
                data.addColumn('string', 'ToolTip');

                // For each orgchart box, provide the name, manager, and tooltip to show.
                data.addRows([
                    @foreach ($dsnhansu as $data)
                        [{
                                v: '{{ $data->machucdanh }}',
                                f: '<div style="color:red; font-style:italic"><img src="{{ $data->hinhanh }}" alt="" id="htimg" style="width: 60px; height: 60px"><br><button id="1" value="{{ $data->id }}" class="buton1" onclick="handleButtonClick(this)" style="color:red; background-color: transparent; border: none;">{{ $data->mota }}</button></div>{{ $data->tennhanvien }}'
                            },
                            '{{ $data->chucdanhql }}', '{{ $data->mota }}'
                        ],
                    @endforeach

                ]);
                // Create the chart.
                var chart = new google.visualization.OrgChart(document.getElementById('chart_div'));
                // Draw the chart, setting the allowHtml option to true for the tooltips.
                chart.draw(data, {
                    'allowHtml': true
                });
            }
        </script>
    </head>

<body>    
    <div class="container" id="con2">
        <div class="scroll-wrapper">
            <div class="scrollable-content">
                <button class="search" style=" margin: 15px;background-color: #af6c1a;" onclick="goBack()">Quay về</button>
                <div id="chart_div"></div>
            </div>
        </div>
    </div>
</body>
<script>
    function goBack() {
        history.back();
    }
</script>
</html>
