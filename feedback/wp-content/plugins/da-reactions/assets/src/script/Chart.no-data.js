export function chartNoData() {
    Chart.plugins.register({
        afterDraw: function (chart) {
            let has_data = false;
            for (let i = 0; i < chart.data.datasets.length; i++) {
                for (let ii = 0; ii < chart.data.datasets[i].data.length; ii++) {
                    if (chart.data.datasets[i].data[ii] > 0) {
                        has_data = true;
                    }
                }
            }
            if (!has_data) {
                // No data is present
                let ctx = chart.chart.ctx;
                let width = chart.chart.width;
                let height = chart.chart.height;
                chart.clear();

                ctx.save();
                ctx.textAlign = 'center';
                ctx.textBaseline = 'middle';
                ctx.font = "16px normal 'Helvetica Nueue'";
                ctx.fillText('No data to display', width / 2, height / 2);
                ctx.restore();
            }
        }
    });
}
