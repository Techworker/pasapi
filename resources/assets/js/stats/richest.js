
require('../bootstrap');
const axios = require('axios');
const DataTable = require("vanilla-datatables");

console.log(document.getElementById('richest-table'));
let dataTable = new DataTable(document.getElementById('richest-table'));

axios.get('/api/stats/richest').then((data) => {
    let allData = [];
    data.data.forEach((item) => {
        let row = [];
        console.log(item);
        row.push(item.account);
        row.push(item.name);
        row.push(item.balance_pasc + ' PASC');
        row.push(item.type);
        row.push(item.nops);
        allData.push(row);
    });
    dataTable.rows().add(allData);

});