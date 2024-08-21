<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plotly Graph with Threshold Areas</title>
    <script src="https://cdn.plot.ly/plotly-latest.min.js"></script>
</head>
<body>
    <div id="myDiv" style="width: 600px; height: 400px;"></div>

    <script>
        // Sample data
        var trace1 = {
            x: [1, 2, 3, 4, 5],
            y: [10, 15, 13, 17, 10],
            type: 'scatter'
        };

        var data = [trace1];

        // Layout with threshold areas
        var layout = {
            title: 'Plot with Threshold Areas',
            shapes: [
                // Lower threshold
                {
                    type: 'rect',
                    x0: 0,
                    y0: 0,
                    x1: 1,
                    xref: 'paper',
                    y1: 12, // Y value for lower threshold
                    fillcolor: 'rgba(255, 0, 0, 0.2)',
                    line: {
                        width: 0
                    }
                },
                {
                    type: 'line',
                    x0: 0,
                    y0: 12,
                    x1: 1,
                    xref: 'paper',
                    y1: 12,
                    line: {
                        color: 'red',
                        width: 2,
                        dash: 'dashdot'
                    }
                },
                // Upper threshold
                {
                    type: 'rect',
                    x0: 0,
                    y0: 16, // Y value for upper threshold
                    x1: 1,
                    xref: 'paper',
                    y1: 20, // Max Y value
                    fillcolor: 'rgba(0, 255, 0, 0.2)',
                    line: {
                        width: 0
                    }
                },
                {
                    type: 'line',
                    x0: 0,
                    y0: 16,
                    x1: 1,
                    xref: 'paper',
                    y1: 16,
                    line: {
                        color: 'green',
                        width: 2,
                        dash: 'dashdot'
                    }
                }
            ],
            annotations: [
                {
                    x: 0.5,
                    y: 12,
                    xref: 'paper',
                    yref: 'y',
                    text: 'Lower Threshold',
                    showarrow: false,
                    font: {
                        color: 'red'
                    }
                },
                {
                    x: 0.5,
                    y: 16,
                    xref: 'paper',
                    yref: 'y',
                    text: 'Upper Threshold',
                    showarrow: false,
                    font: {
                        color: 'green'
                    }
                }
            ],
            yaxis: {
                range: [0, 20] // Adjust this based on your data
            }
        };

        Plotly.newPlot('myDiv', data, layout);
    </script>
</body>
</html>
