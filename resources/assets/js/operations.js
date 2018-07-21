
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

const axios = require('axios');
const elementClass = require('element-class');
const Chart = require('./chart');
const flatpickr = require("flatpickr");
const DataTable = require("vanilla-datatables");

flatpickr("#date-select", {
    mode: "range",
    dateFormat: "Y-m-d"
});

const charts = {
    'optypes-yearly': {
        url: '/api/timeline/yearly',
        data: {},
        inited: false,
        type: 'yearly',
        typeField: 'year'
    },
    'optypes-monthly': {
        url: '/api/timeline/monthly',
        data: {},
        inited: false,
        type: 'monthly',
        typeField: 'month'
    },
    'optypes-weekly': {
        url: '/api/timeline/weekly',
        data: {},
        inited: false,
        type: 'weekly',
        typeField: 'week'
    },
    'optypes-daily': {
        url: '/api/timeline/daily',
        data: {},
        inited: false,
        type: 'daily',
        typeField: 'day'
    },
};


document.querySelectorAll('#filter-optypes a').forEach(($a) => {
    $a.addEventListener('click', (e) => {
        document.querySelectorAll('#chart-container .card').forEach($c => ($c.style.display = 'none'));
        document.querySelectorAll('#filter-optypes a.active').forEach($a => elementClass($a).remove('active'));
        const containerId = e.currentTarget.getAttribute('data-href');
        document.getElementById(containerId).style.display = 'block';
        elementClass(e.currentTarget).add('active');
        if(charts[containerId].inited === false) {
            axios.get(charts[containerId].url).then((data) => {
                charts[containerId].inited = true;
                charts[containerId].data = data;
                initChart(document.querySelector('#' + containerId + ' canvas'), data.data, charts[containerId].type, charts[containerId].typeField);
                initTable(document.querySelector('#' + containerId + ' table'), data.data, charts[containerId].type, charts[containerId].typeField);
            });
        };
    })
});

document.querySelector('#filter-optypes a').click();

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

function initTable(table, data, type, typeField)
{
    let dataTable = new DataTable(table);

    let allData = [];
    data.forEach((item) => {
        let row = [];
        row.push(item[typeField]);
        row.push(item.sum_n_operations);
        for (let i = 0; i < 10; i++) {
            row.push(item[`sum_n_type_${i}`]);
        }
        allData.push(row);
    });
    dataTable.rows().add(allData);
}

function initChart(ctx, data, type, typeField)
{
    const labels = [];

    const datasets = {};
    datasets.n_operations = {
        label: 'All Operations',
        data: [],
        pointRadius: 2,
    };
    for(let i = 0; i < 10; i++) {
        datasets[`n_type_${i}`] = {
            label: OPTYPES[i],
            data: [],
            pointRadius: 2,
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
        responsive: true,
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        },
        legend: {
            position: 'bottom',
            labels: {
                usePointStyle: true
            }
        }
    };

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: datasets2
        },
        options: options
    });

    ctx.parentElement.removeChild(ctx.parentElement.querySelector('.sk-cube-grid'));
}