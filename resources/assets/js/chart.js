const Chart = require('chart.js');
const Tools = require('./tools');

Chart.pluginService.register({
    beforeUpdate(chart) {
        switch (chart.config.type) {
            case 'bar': {
                let idx = 0;
                for (const dataset of chart.data.datasets) {
                    if (!dataset.borderColor) {
                        const borderColor = [];
                        for (const _d of dataset.data) {
                            borderColor.push(Tools.pickColor(idx++));
                        }
                        dataset.borderColor = borderColor;

                        if (!dataset.backgroundColor) {
                            dataset.backgroundColor = borderColor.map(hex => {
                                const color = new Color(hex).alpha(0.5);
                                return color.string();
                            });
                        }
                    }
                }
                break;
            }
            case 'line': {
                let idx = 0;
                for (const dataset of chart.data.datasets) {
                    if (!dataset.borderColor) {
                        dataset.borderColor = Tools.pickColor(idx++);
                        if (!dataset.backgroundColor) {
                            dataset.backgroundColor = dataset.borderColor;
                        }
                    }
                }
                break;
            }
        }
    },
});

module.exports = Chart;