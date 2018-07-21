
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
        url: '/api/miners/yearly',
        data: {},
        inited: false,
        type: 'yearly',
        typeField: 'year'
    },
    'optypes-monthly': {
        url: '/api/miners/monthly',
        data: {},
        inited: false,
        type: 'monthly',
        typeField: 'month'
    },
    'optypes-weekly': {
        url: '/api/miners/weekly',
        data: {},
        inited: false,
        type: 'weekly',
        typeField: 'week'
    },
    'optypes-daily': {
        url: '/api/miners/daily',
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

function initTable(table, data, type, typeField)
{
    let dataTable = new DataTable(table);

    let allData = [];
    let labels = [];
    let row = null;
    data.forEach((item) => {
        if(labels.indexOf(item[typeField]) === -1) {
            if(row !== null) {
                allData.push(row);
            }
            row = [0,0,0,0];

            labels.push(item[typeField]);
            row[0] = item[typeField];
        }

        if(item.type === 'nanopool') {
            row[1] = item.ct;
        }
        if(item.type === 'coinotron') {
            row[2] = item.ct;
        }
        if(item.type === 'others') {
            row[3] = item.ct;
        }
    });

    allData.push(row);
    dataTable.rows().add(allData);
}

function initChart(ctx, data, type, typeField)
{
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

    ctx.parentElement.removeChild(ctx.parentElement.querySelector('.sk-cube-grid'));
}