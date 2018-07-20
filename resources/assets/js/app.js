
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

const axios = require('axios')
const Chart = require('chart.js');
const Color = require('color');
const palette = require('json-loader!open-color/open-color.json');

const colors = [
    palette['red'],
    palette['blue'],
    palette['yellow'],
    palette['green'],
    palette['pink'],
    palette['cyan'],
    palette['orange'],
    palette['lime'],
    palette['grape'],
    palette['indigo'],
    palette['teal'],
    palette['violet'],
];

function pickColor(idx) {
    return colors[idx % colors.length][4 - Math.floor(idx / colors.length)];
}

Chart.pluginService.register({
    beforeUpdate(chart) {
        switch (chart.config.type) {
            case 'bar': {
                let idx = 0;
                for (const dataset of chart.data.datasets) {
                    if (!dataset.borderColor) {
                        const borderColor = [];
                        for (const _d of dataset.data) {
                            borderColor.push(pickColor(idx++));
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
                        dataset.borderColor = pickColor(idx++);
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

let dailyData = [];
let weeklyData = [];
let monthlyData = [];
let yearlyData = [];

axios.get('/api/timeline/daily').then((data) => {
    initTypeChart(data.data, 'daily', 'day');
});

axios.get('/api/timeline/weekly').then((data) => {
    initTypeChart(data.data, 'weekly', 'week');
});

axios.get('/api/timeline/monthly').then((data) => {
    initTypeChart(data.data, 'monthly', 'month');
});

axios.get('/api/timeline/yearly').then((data) => {
    initTypeChart(data.data, 'yearly', 'year');
});


/*axios.all([
    axios.get('/api/timeline/daily'),
    axios.get('/api/timeline/weekly'),
    axios.get('/api/timeline/monthly'),
    axios.get('/api/timeline/yearly')
]).then(axios.spread((daily, weekly, monthly, yearly) => {
    dailyData = daily.data;
    weeklyData = weekly.data;
    monthlyData = monthly.data;
    yearlyData = yearly.data;

    initCharts();
}));*/

function initCharts()
{
    initDaily();
}

const OPTYPES = [
    'Blockchain reward',
    'Transaction',
    'Change key',
    'Recover founds (lost keys)',
    'List account for sale',
    'Delist account (not for sale)',
    'Buy account',
    'Change key (signed by another account)',
    'Change account info',
    'Multioperation',
];

function initTypeChart(data, type, typeField)
{
    const ctx = document.getElementById("types_" + type);
    const labels = [];

    const datasets = {};
    datasets.n_operations = {
        label: 'All Operations',
        data: []
    };
    for(let i = 0; i < 10; i++) {
        datasets[`n_type_${i}`] = {
            label: OPTYPES[i],
            data: []
        };
    };
    data.forEach((item) => {
        labels.push(item[typeField]);
        for(let i = 0; i < 10; i++) {
            datasets[`n_type_${i}`].data.push(item[`sum_n_type_${i}`]);
            datasets[`n_type_${i}`].borderWidth = 1;
            datasets[`n_type_${i}`].backgroundColor = 'rgba(255,255,255,0)';
        }
        datasets.n_operations.data.push(item.sum_n_operations);
        datasets.n_operations.borderWidth = 1;
        datasets.n_operations.backgroundColor = 'rgba(255,255,255,0)';
    });
    
    let datasets2 = Object.keys(datasets).map((k) => datasets[k]);
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: datasets2
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero:true
                    }
                }]
            }
        }
    });
}