var color = Chart.helpers.color;
function createConfig(legendPosition, colorName) {
    return {
        type: 'line',
        data: {
            labels: ["一月", "二月", "三月", "四月", "五月", "六月", "七月", "八月", "九月", "十月", "十一月", "十二月"],
            datasets: [{
                label: "demo資料",
                data: [
                    randomScalingFactor(),
                    randomScalingFactor(),
                    randomScalingFactor(),
                    randomScalingFactor(),
                    randomScalingFactor(),
                    randomScalingFactor(),
                    randomScalingFactor(),
                    randomScalingFactor(),
                    randomScalingFactor(),
                    randomScalingFactor(),
                    randomScalingFactor(),
                    randomScalingFactor()
                ],
                backgroundColor: color(window.chartColors[colorName]).alpha(0.5).rgbString(),
                borderColor: window.chartColors[colorName],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            legend: {
                position: legendPosition,
            },
            scales: {
                xAxes: [{
                    display: true,
                    scaleLabel: {
                        display: true,
                        labelString: '月份'
                    }
                }],
                yAxes: [{
                    display: true,
                    scaleLabel: {
                        display: true,
                        labelString: '數值'
                    }
                }]
            },
            title: {
                display: true,
                text: ''
            }
        }
    };
}

window.onload = function() {
    [{
        id: 'chart-legend-right',
        legendPosition: 'right',
        color: 'blue'
    }].forEach(function(details) {
        var ctx = document.getElementById(details.id).getContext('2d');
        var config = createConfig(details.legendPosition, details.color);
        new Chart(ctx, config)
    })
};