const thousandths = document.getElementsByClassName('thousandths');

for(let i=0;i<thousandths.length;i++){
    thousandths[i].innerText=  numbeComma(Number(thousandths[i].innerText))
}
function numbeComma(num){
    let comma=/\B(?<!\.\d*)(?=(\d{3})+(?!\d))/g
    return num.toString().replace(comma, ',')
}
