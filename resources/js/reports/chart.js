import Chart from 'chart.js/auto';
var ctx = document.getElementById('myChart').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
        datasets: [{
            data: [5, 4, 4, 3, 4, 2, 1, 2, 3, 4, 3, 2, 2, 2, 3],
            fill: "start",
            backgroundColor: "rgba(22, 197, 104,.3)",
            borderColor: "#16C568",
            borderWidth: 2,
            lineTension: 0,
            pointBorderColor: "#93EBBC",
            pointBackgroundColor: "#93EBBC",
        }]
    },
    options: {
        responsive: false,
        maintainAspectRatio: false,
        animation: {
            duration: 0,
        },
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: false,
                    padding: 25,
                    precision: 0,
                    reverse: true,
                    min: 1,
                    max: 6,
                    fontColor: "#F7F8FB",
                },
                gridLines: {
                    drawBorder: false,
                    color: "#434646",
                },
                scaleLabel: {
                    display: true,
                    labelString: 'test',
                    fontColor: "#95969D",
                    fontSize: 12,
                },
            }, ],
            xAxes: [{
                ticks: {
                    fontColor: "#F7F8FB",
                    maxRotation: 0,
                    autoSkip: false,
                },
                gridLines: {
                    color: "#434646",
                    zeroLineColor: "#434646",
                },
                scaleLabel: {
                    display: true,
                    labelString: 'test',
                    fontColor: "#95969D",
                    fontSize: 12,
                },
            }, ],
        },
    }
});
