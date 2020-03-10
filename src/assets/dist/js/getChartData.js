$(document).ready(function () {
    $(document).on('change', '.chart-filter-input', function (e) {
        updateChartData(e.target);
    });
    $('.metrika-widget-chart').each(function (e) {
        updateChartData(this);
    });
});

function updateChartData(el) {
    let container = $(el).closest('.metrika-widget-container');
    let chartId = container.data('chartid');
    let url = container.data('url');
    let data = container.find('form').serialize();

    $.ajax({
        url: url,
        data: data,
        success: function (response) {
            Highcharts.chart(chartId, {
                chart: {
                    type: 'line',
                },
                yAxis: {
                    title: {
                        text: ''
                    }
                },
                title: {
                    text: ''
                },
                xAxis: {
                    categories: response.labels,
                },
                tooltip: {
                    headerFormat: '<span style="font-size: 10px">{point.key}</span><br/>',
                    pointFormat: '<span style="color:{point.color}">●</span><b> {point.y}</b><br/>',
                },
                series: [{
                    name: '',
                    showInLegend: false,
                    data: response.data,
                }],
            });
        },
        error: function (jqXHR, exception, error) {
            console.log(jqXHR.responseText);
            alert(jqXHR.responseText);
        }
    });
}
