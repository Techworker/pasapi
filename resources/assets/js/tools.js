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

module.exports = { pickColor };