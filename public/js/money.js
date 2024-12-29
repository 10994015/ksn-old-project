/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!*******************************!*\
  !*** ./resources/js/money.js ***!
  \*******************************/
var thousandths = document.getElementsByClassName('thousandths');
for (var i = 0; i < thousandths.length; i++) {
  thousandths[i].innerText = numbeComma(Number(thousandths[i].innerText));
}
function numbeComma(num) {
  var comma = /\B(?<!\.\d*)(?=(\d{3})+(?!\d))/g;
  return num.toString().replace(comma, ',');
}
/******/ })()
;