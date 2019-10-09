ctx = document.getElementById('onlineGraph').getContext('2d');
dataArr = []
st = ""
var globData;
var pageData;
//get json send it to callback function chart and proccess data there insteadd
    $.ajax({
        url: "data/chartDt.json",
        type: "post",
        async: false,
        dataType: 'json',
        success: function(dt){
            // get the data syncronous
            globData = dt;
        }
    });
    $.ajax({
        url: "data/pagdt.json",
        type: "POST",
        async: false,
        dataType: "json",
        success: function(pgdt){
            pageData = pgdt;
        }
    })
    //process data func
    const dayOfMonth = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31]
    const counter = globData
    var gradientStroke = ctx.createLinearGradient(500, 0, 100, 0);
    gradientStroke.addColorStop(0, "#16d9e3");
    gradientStroke.addColorStop(1, "#46aef7");
    var Gfill = ctx.createLinearGradient(50, 0, 0, 100);
    Gfill.addColorStop(0, "rgb(227, 78, 107)");
    Gfill.addColorStop(1, "rgb(249, 135, 76)");
    const myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: dayOfMonth,
            datasets: [{
                label: 'Dagens träffar',
                yAxisID: 'Dagens Träffar',
                data: counter,
                lineTension: .0,
                backgroundColor: "transparent",
                pointBackgroundColor: "#fff",
                borderColor: Gfill,
                borderWidth: 3,
                zeroLineColor: 'rgba(0, 0, 0, 1)'
            }]
        },
        options: {
            tooltips: {
                mode: 'nearest',
                intersect: false,
                axis: 'x',
                displayColors: false,
                bodyFontSize: 13,
                bodyFontStyle: "bold",
                backgroundColor: Gfill,
                bodyFontColor: "#fff",
                titleFontSize: 38,
                yPadding: 10,
                xPadding: 10,
                caretSize: 20
            },
            elements: {
                point: {
                    pointStyle: 'circle',
                    radius: 3,
                    borderWidth: 0,
                    hitRadius: 1
                }
            },
            legend: {
                display: false
            },
            scales: {
                yAxes: [{
                    display: true,
                    id: 'Dagens Träffar',
                    type: 'linear',
                    position: 'left',
                    ticks: {
                        fontColor: "rgba(0,0,0,.5)",
                        fontStyle: "bold",
                        beginAtZero: true,
                        maxTicksLimit: 10,
                        padding: 20,
                        fontSize: 10,
                    },
                    gridLines: {
                        drawTicks: true,
                        color: "#f5f5f5",
                        zeroLineColor: "#f5f5f5"
                    }
                },
                {
                    display: true,
                    id: 'Annan',
                    type: 'linear',
                    position: 'left',
                    ticks: {
                        display: false,
                        fontColor: "rgba(0,0,0, .1)",
                        fontStyle: "normal",
                        beginAtZero: true,
                        maxTicksLimit: 5,
                        padding: 20,
                        fontSize: 0,
                    },
                    gridLines: {
                        drawTicks: false,
                        color: "transparent",
                        zeroLineColor: "transparent"
                    }
                }],
                xAxes: [{
                    gridLines: {
                        drawTicks: false,
                        display: true,
                        color: "#f5f5f5",
                        zeroLineColor: "#f5f5f5"
                    },
                    ticks: {
                        fontColor: "rgba(0,0,0,.3)",
                        fontStyle: "normal",
                        beginAtZero: true,
                        maxTicksLimit: 30,
                        padding: 10,
                        fontSize: 0,
                        maxRotation: 0,
                        minRotation: 0,
                        callback: function(value, index, values) {
                            return value + ':e';
                        }
                    }
                }]
            }
        }


    });


    // last of chart

    function cUpdate(chart, newval){
        // update last index with 1
        lastIndex = chart.data.datasets[0].data.length - 1;
        chart.data.datasets[0].data[lastIndex] = newval;
        chart.update();
    }
    function allDataUpdate(chart, data){
        chart.data.datasets[0].data = data;
        chart.update()
    }
