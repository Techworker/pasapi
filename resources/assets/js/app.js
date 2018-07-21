
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
axios.get('/api/timeline/daily').then((data) => {
    initTypeChart(data.data, 'daily', 'day');
    initVolumeChart(data.data, 'daily', 'day');
    initFeeChart(data.data, 'daily', 'day');
    initDurationChart(data.data, 'daily', 'day');
});

axios.get('/api/timeline/weekly').then((data) => {
    initTypeChart(data.data, 'weekly', 'week');
    initVolumeChart(data.data, 'weekly', 'week');
    initFeeChart(data.data, 'weekly', 'week');
    initDurationChart(data.data, 'weekly', 'week');
});

axios.get('/api/timeline/monthly').then((data) => {
    initTypeChart(data.data, 'monthly', 'month');
    initVolumeChart(data.data, 'monthly', 'month');
    initFeeChart(data.data, 'monthly', 'month');
    initDurationChart(data.data, 'monthly', 'month');
});

axios.get('/api/timeline/yearly').then((data) => {
    initTypeChart(data.data, 'yearly', 'year');
    initVolumeChart(data.data, 'yearly', 'year');
    initFeeChart(data.data, 'yearly', 'year');
    initDurationChart(data.data, 'yearly', 'year');
});

axios.get('/api/miners/daily').then((data) => {
    initMinerChart(data.data, 'daily', 'day');
});
axios.get('/api/miners/weekly').then((data) => {
    initMinerChart(data.data, 'weekly', 'week');
});
axios.get('/api/miners/monthly').then((data) => {
    initMinerChart(data.data, 'monthly', 'month');
});
axios.get('/api/miners/yearly').then((data) => {
    initMinerChart(data.data, 'yearly', 'year');
});

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
    if(ctx === null) {
        return;
    }
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
    }
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

    let options = {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        }
    };

    new Chart(ctx, {
        type: 'line',
        responsive: true,
        data: {
            labels: labels,
            datasets: datasets2
        },
        options: options
    });
    document.querySelectorAll('.sk-cube-grid').forEach(($el) => $el.parentElement.removeChild($el));

}

function initVolumeChart(data, type, typeField)
{
    const ctx = document.getElementById("volume_" + type);
    if(ctx === null) {
        return;
    }
    const labels = [];

    datasets = [];
    datasets.push({
        label: 'PASC Volume',
        data: [],
        borderWidth: 1,
        backgroundColor: 'rgba(255,255,255,0)'
    });
    datasets.push({
        label: 'PASC Fees',
        data: [],
        borderWidth: 1,
        backgroundColor: 'rgba(255,255,255,0)'
    });
//    datasets.push({
//        label: 'Molina',
//        data: [],
//        borderWidth: 1,
//        backgroundColor: 'rgba(255,255,255,0)'
//    });

    data.forEach((item) => {
        labels.push(item[typeField]);
        //datasets[0].data.push(item.sum_volume_molina);
        datasets[0].data.push(item.sum_volume_pasc);
        datasets[1].data.push(item.sum_fee_pasc);
    });

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: datasets
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


function initDurationChart(data, type, typeField)
{
    const ctx = document.getElementById("duration_" + type);
    if(ctx === null) {
        return;
    }
    const labels = [];

    datasets = [];
    datasets.push({
        label: 'AVG block duration in seconds',
        data: [],
        borderWidth: 1,
        backgroundColor: 'rgba(255,255,255,0)'
    });

    data.forEach((item) => {
        labels.push(item[typeField]);
        //datasets[0].data.push(item.sum_volume_molina);
        datasets[0].data.push(item.avg_duration);
    });

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: datasets
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


function initFeeChart(data, type, typeField)
{
    const ctx = document.getElementById("fee_" + type);
    if(ctx === null) {
        return;
    }
    const labels = [];

    datasets = [];
    datasets.push({
        label: 'PASC Fees',
        data: [],
        borderWidth: 1,
        backgroundColor: 'rgba(255,255,255,0)'
    });

    data.forEach((item) => {
        labels.push(item[typeField]);
        //datasets[0].data.push(item.sum_volume_molina);
        datasets[0].data.push(item.sum_fee_pasc);
    });

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: datasets
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


function initMinerChart(data, type, typeField)
{
    const ctx = document.getElementById("miner_" + type);
    if(ctx === null) {
        return;
    }
    const labels = [];

    const datasets = [];
    datasets.push({
        label: 'Nanopool',
        data: [],
        borderWidth: 1,
        backgroundColor: 'rgba(255,255,255,0)'
    });
    datasets.push({
        label: 'Coinotron',
        data: [],
        borderWidth: 1,
        backgroundColor: 'rgba(255,255,255,0)'
    });
    datasets.push({
        label: 'Others',
        data: [],
        borderWidth: 1,
        backgroundColor: 'rgba(255,255,255,0)'
    });

    data.forEach((item) => {
        if(labels.indexOf(item[typeField]) === -1) {
            labels.push(item[typeField]);
        }
        if(item.type === 'nanopool') {
            datasets[0].data.push(item.ct);
        }
        if(item.type === 'coinotron') {
            datasets[1].data.push(item.ct);
        }
        if(item.type === 'others') {
            datasets[2].data.push(item.ct);
        }
    });

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: datasets
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