const { indexOf, now } = require("lodash");

window.Livewire.emit('initFn');
window.Livewire.emit('sendTime', true);
window.Livewire.emit('updateCycleNumber');
let isLock = false;
let countdownNumber = 0;
const air = document.getElementById('airplaneDiv').querySelectorAll('.air');
const airplaneDivBg = document.getElementById('airplaneDivBg');
const bar = document.getElementById('bar');
const menuList = document.getElementById('menuList');
let isMenuOpen = false;
const countdown = document.getElementById('countdown');
const countdownSec = document.getElementById('countdownSec');
const countdownSec_md = document.getElementById('countdownSec_md');
const gameLoading = document.getElementById('gameLoading');
const airTopThree = document.getElementById('airTopThree');
const airTopTen = document.getElementById('airTopTen');
const fiveNumber = document.getElementById('fiveNumber');
const gameBtn1 = document.getElementById('gameBtn1');
const gameBtn2 = document.getElementById('gameBtn2');
// const gameBtn3 = document.getElementById('gameBtn3');
// const gameBtn4 = document.getElementById('gameBtn4');
// const gameBtn5 = document.getElementById('gameBtn5');
// const betMoney = document.getElementById('betMoney');
let totalBet = 0;
const playBox = document.getElementById('playBox');
const diamondBtn = document.querySelectorAll('.diamondBtn');
const diamondBoxLeft = document.getElementById('diamondBoxLeft');
const diamondBoxRight = document.getElementById('diamondBoxRight');
let dimondListNum = 0;
const diamondBtnDiv = document.getElementsByClassName('diamondBtnDiv');
const doubleBtn = document.getElementById('doubleBtn');
const reBtn = document.getElementById('reBtn');
const chkBtn = document.getElementById('chkBtn');
const rank = document.getElementsByClassName('rank');
const beyMoney = document.getElementById('beyMoney');
const cycleNumber = document.getElementById('cycleNumber');
const betListIssue = document.getElementById('betListIssue');
const loadingDiv = document.getElementById('loading-div');
let answer = [];
let riskAnswerArr = [];
let reverseanswer = [];
let nowAnswer = [];
let secondsArr = [
    [10,'1'],
    [10.1,'2'],
    [10.11,'3'],
    [10.12,'4'],
    [10.13,'5'],
    [10.14,'6'],
    [10.15,'7'],
    [10.16,'8'],
    [10.17,'9'],
    [10.18,'10']
];
let game_name_arr = ['定位膽', '大小單雙', '冠亞二星', '冠亞和', '龍虎'];
let game_name_num = 1;
const myDoller = document.getElementById('myDoller');
const rankingImg = document.getElementsByClassName('rankingImg');
let chkBetBool = true;
let isBetTime = true;
let isBeted = false;
let issetAirArr = [];
let contentArr = [
    null, "01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "大", "小", "單", "雙"
];
let betListOpen = false;
let betArr = [];
let betIdx = 0;
// let listIdx = 0;
let deleteBet = null;
const totalBetNmuber = document.getElementById('totalBetNmuber');
const totalBetMoney = document.getElementById('totalBetMoney');
let totalBetNumberCalc = 0;
const listAll = document.getElementById('listAll');
let listAllHtml = '';
const airNum = document.getElementsByClassName('airNum');
const topThreeAir = document.getElementsByClassName('topThreeAir');
let chooseRank = 1;
let bsChooseRank = 1;
const oddsArr = [0,0];
const openBetListBtn = document.getElementById('openBetListBtn')
const openGameBtn = document.getElementById('openGameBtn');
let playBoxisOpen = true;
let bethtmlArr = [];
const trendModal = document.getElementById('trendModal');
const closeTrendModalBtn = document.getElementById('closeTrendModalBtn');
const openTrendModalBtn = document.getElementById('openTrendModalBtn');
const trendModalList = document.getElementById('trendModalList');
const openRuleModalBtn = document.getElementById('openRuleModalBtn');
const openRecordModalBtn = document.getElementById('openRecordModalBtn');
const recordModal = document.getElementById('recordModal');
const closeRecordModalBtn = document.getElementById('closeRecordModalBtn');
const ruleModal = document.getElementById('ruleModal');
const closeRuleModalBtn = document.getElementById('closeRuleModalBtn');
const bigBtn = document.getElementById('bigBtn');
const smallBtn = document.getElementById('smallBtn');
const oddBtn = document.getElementById('oddBtn');
const evenBtn = document.getElementById('evenBtn');
const bsBtn = document.getElementsByClassName('bsBtn');

let bsGrandTotalMoneyArr = [0,0,0,0];
let bsGrandTotalMoneyBetedArr = [0,0,0,0];

let betLoading = false;
let betArrString = "";
//lock
let bigLock = false;
let smallLock = false;
let oddLock = false;
let evenLock = false;

const otrank = document.getElementsByClassName('otrank');
const otBetBtn = document.getElementById('otBetBtn');
let all_totalBet = 0;
let all_totalBetNumberCalc = 0;
let all_betArr = [];
let bsChoose = 1;
let betLimitObj = {
    single_term:0,
    single_bet_limit:0,
    bs_single_term:0,
    bs_single_bet_limit:0
}
// let gameStyleNum = 1;
let gameStyleNum = Math.floor(Math.random()*2) + 99;
const rankingImgBs = document.getElementsByClassName('rankingImg-bs');
document.getElementById(`rankingImg${chooseRank}`).src = `/images/airplane/no${chooseRank}chk.png`;
document.getElementById(`rankingImg${bsChooseRank}-bs`).src = `/images/airplane/no${chooseRank}chk.png`;
window.addEventListener('setOdds', e=>{
    oddsArr[0] =  e.detail.odds;
    oddsArr[1] = e.detail.bsOdds
});
window.addEventListener('setBetLimit', e=>{
    betLimitObj.single_term =  e.detail.single_term;
    betLimitObj.single_bet_limit = e.detail.single_bet_limit
    betLimitObj.bs_single_term = e.detail.bs_single_term
    betLimitObj.bs_single_bet_limit = e.detail.bs_single_bet_limit
});
const startDiv = document.getElementById('startDiv');
const initSecondsArr = ()=>{
    secondsArr = [
        [12,'1'],
        [12.1,'2'],
        [12.11,'3'],
        [12.12,'4'],
        [12.13,'5'],
        [12.14,'6'],
        [12.15,'7'],
        [12.16,'8'],
        [12.17,'9'],
        [12.18,'10']
    ];
}
window.addEventListener('updateCycle', e=>{
    cycleNumber.innerHTML = `期號: ${e.detail.number}`;
    betListIssue.innerHTML = `期號: ${e.detail.number}`;
})
window.addEventListener('sendAnswer', e=>{
    answer = e.detail.answer;
    nowAnswer = answer[4].ranking.split(',');
    fiveNumberFn();
    riskAnswerArr = e.detail.riskAnswer[0].ranking.split(',');
    // cycleNumber.innerHTML = `期號: ${e.detail.riskAnswer[0].number}`;
    // betListIssue.innerHTML = `期號: ${e.detail.riskAnswer[0].number}`;

    initSecondsArr();
    secondsArr.forEach((item, key)=>{
        item[1] = nowAnswer[key];
    })
    setTimeout(()=>{
        fiveNumberFn();
    },1000)
});
function sortFn(){
    secondsArr.sort((a, b)=>{
        return a[1] - b[1];
    })
}
let fiveHtml = '';

window.addEventListener('startRun', e=>{
    answer = e.detail.answer;
    nowAnswer = answer[4].ranking.split(',');
    riskAnswerArr = e.detail.riskAnswer[0].ranking.split(',');
    initSecondsArr();
    secondsArr.forEach((item, key)=>{
        item[1] = nowAnswer[key];
    })
    if(screen.width <= 1000 && (/Mobi|Android|iPhone/i.test(navigator.userAgent))){
        if((new Date().getSeconds() <=59 && new Date().getSeconds() >=37) || new Date().getSeconds()==0){
            countdownSec_md.innerHTML =   "<img src='/images/airplane/lottery.png' width='200' />";
            openGameBtn.style.display = "block";
            playBox.style.display = 'block';
            playBoxisOpen = true;
            playBox.style.opacity = 1;
            openGameBtn.classList.remove('fa-circle-up');
        }
    }
    if(new Date().getSeconds() < 50 &&  new Date().getSeconds()>=37){

        loading2.style.display = "block";
        setTimeout(()=>{
            loadingDiv.style.display = "none";
        }, (50 - new Date().getSeconds())*1000)
        // countdown.style.opacity = '0';
        airTopThree.style.opacity = '0';
        airTopTen.style.opacity = '0';
        for(let i=0;i<airNum.length;i++){
            airNum[i].style.animation = 'none';
            airNum[i].style.animationDelay = '0s';
        }
        sortFn();
        airplaneDiv.style.opacity = "1";
        airplaneDivBg.classList.add('start');
        airplaneDivBg.style.animationDelay =  `-${ new Date().getSeconds()}s`;
        let startSec = (10-new Date().getSeconds())*1000;
        for(let i=0;i<air.length;i++){
            air[i].style.animation = `airNo${gameStyleNum} ${secondsArr[i][0]}s linear`;
            air[i].style.animationDelay = `-${ new Date().getSeconds()}s`;
            setTimeout(()=>{
                air[i].style.animationDelay = '0s';
                air[i].style.opacity = '0';
            },secondsArr[i][0]*1000 - (new Date().getSeconds() * 1000))
        }
        setTimeout(()=>{
            // airTopTen.innerHTML = nowAnswer.join(',');
            airTopTenHTML(nowAnswer);
            airTopTen.style.opacity = "1";
            for(let i=0;i<airNum.length;i++){
                airNum[i].style.animation = 'airRankIn .1s linear';
                airNum[i].style.animationDelay = `.${i}s`;
            }
            // countdown.style.opacity = '1';
            airplaneDivBg.style.animationDelay = '0s';
            setInterval(timeRun,1000);
            // var id =setInterval(timeRun,1000,id);
        }, startSec)
    }else{
        if(new Date().getSeconds() >=50 && new Date().getSeconds() < 54){
            airTopTenHTML(nowAnswer);
            airTopTen.style.opacity = "1";
            for(let i=0;i<airNum.length;i++){
                airNum[i].style.animation = 'airRankIn .1s linear';
                airNum[i].style.animationDelay = `.${i}s`;
            }
        }
        if((new Date().getSeconds() >=54 && new Date().getSeconds() < 59) || new Date().getSeconds() ==0){
            airTopTenHTML(nowAnswer);
            airTopTen.style.opacity = "1";
            for(let i=0;i<airNum.length;i++){
                airNum[i].style.animation = 'airRankIn .1s linear';
                airNum[i].style.animationDelay = `.${i}s`;
            }
            // countdown.style.opacity = '1';
            airTopThreeHTML(nowAnswer);
            airTopThree.style.opacity = "1";
        }
        // var id =setInterval(timeRun,1000,id);
        setInterval(timeRun,1000);
    }
    if((new Date().getSeconds() <= 50 && new Date().getSeconds()>=37)){
        isBetTime = false;
        chkBtn.src = '/images/airplane/chkdisable.png';
        reBtn.src = '/images/airplane/redisable.png';
        doubleBtn.src = '/images/airplane/doubledisable.png';
    }

})
window.Livewire.emit('updateTrend');

function timeRun(){
    countdownNumber = 37 - new Date().getSeconds() ;
    let maxSec = 0;
    if(countdownNumber < 10){
        countdownSec.innerHTML =  "<p>00:0"+countdownNumber + "</p>";
        countdownSec_md.innerHTML =  "<p>00:0"+countdownNumber + "</p>";
    }else{
        countdownSec.innerHTML =   "<p>00:" + countdownNumber + "</p>";
        countdownSec_md.innerHTML =   "<p>00:" + countdownNumber + "</p>";
    }
    if(countdownNumber <= 0 ){  //開獎
        countdownSec_md.innerHTML =   "<img src='/images/airplane/lottery.png' width='200' />";
        // openGameBtn.style.display = "block";
        if(screen.width <= 1000){
            playBox.style.display = 'block';
            playBox.style.zIndex = 1050;
        }
    }else{ //倒數
        openGameBtn.style.display = "none";
        if(screen.width <= 1000){
            playBox.style.display = 'none';
        }
    }
    if(new Date().getSeconds() >=0 && new Date().getSeconds() <= 1){
        window.Livewire.emit('updateCycleNumber');
        if(isBeted){
            window.Livewire.emit('updateMyMoney');
        }
        isBeted = false;
    }
    if(new Date().getSeconds() == 37){

        winMessage.innerHTML = "";
        startDiv.style.opacity = 1;
        startDiv.style.zIndex = 1000;
        isBetTime = false;
        chkBtn.src = '/images/airplane/chkdisable.png';
        reBtn.src = '/images/airplane/redisable.png';
        doubleBtn.src = '/images/airplane/doubledisable.png';

        betListOpen = true;
        openBetListFn()
    }

    if(new Date().getSeconds() == 40){
        window.Livewire.emit('sendTime', false);
        // bethtmlArr = [];
        playBoxisOpen = true;
        playBox.style.opacity = 1;
        openGameBtn.classList.remove('fa-circle-up');
    }
    if(new Date().getSeconds() == 42){

        startDiv.style.opacity = 0;
        startDiv.style.zIndex = -10;
        sortFn();
        airplaneDiv.style.opacity = "1";
        airplaneDivBg.classList.add('start');
        maxSec = 0;
        for(let i=0;i<air.length;i++){
            air[i].style.animation = `airNo${gameStyleNum} ${secondsArr[i][0]}s linear `;
            if( secondsArr[i][0] > maxSec){ maxSec = secondsArr[i][0] }
            setTimeout(()=>{
                air[i].style.opacity = '0';
            },secondsArr[i][0]*1000);
        }


        if(isBeted){
            // calcBetFn();
            all_betArr = [];
            all_totalBet = 0;
            all_totalBetNumberCalc = 0;
        }

        betArr = [];

        all_totalBet = 0;
        all_totalBetNumberCalc = 0;
        all_betArr = [];

    }
    if(new Date().getSeconds() == 52){
        loading2.style.display = "none";
        airTopTenHTML(nowAnswer);
        airTopTen.style.opacity = "1";
        for(let i=0;i<airNum.length;i++){
            airNum[i].style.animation = 'airRankIn .1s linear';
            airNum[i].style.animationDelay = `.${i}s`;
        }
    }
    if(new Date().getSeconds() > 53 || new Date().getSeconds() < 37 ){
        window.Livewire.emit('watchStatu');
    }
    if(new Date().getSeconds() == 56){
        airTopThreeHTML(nowAnswer);
        airTopThree.style.opacity = "1";
    }
    if(new Date().getSeconds() == 59){
        totalBet = 0;
        totalBetNumberCalc = 0;
        totalBetNmuber.innerHTML = totalBetNumberCalc;
        totalBetMoney.innerHTML = totalBet;
        listAll.innerHTML = "";
        issetAirArr = [];

        betArr = [];

        all_totalBet = 0;
        all_totalBetNumberCalc = 0;
        all_betArr = [];
        airLightFn(issetAirArr)

        bsGrandTotalMoneyArr = [0,0,0,0];
        bsGrandTotalMoneyBetedArr = [0,0,0,0]
        bsGrandTotalMoneyFn();

        smallLock = false
        bigLock = false
        oddLock = false
        evenLock = false
        smallBtn.classList.remove('lock')
        bigBtn.classList.remove('lock')
        evenBtn.classList.remove('lock')
        oddBtn.classList.remove('lock')
    }
    if((new Date().getSeconds()<=59 && new Date().getSeconds()>=37) || new Date().getSeconds()==0){
       if(screen.width <=1000){
            countdown.style.opacity = "0";
       }else{
            if(new Date().getSeconds() ==0 ){
                countdown.style.opacity = "1";
                // fiveNumberFn();
            }else{
                countdown.style.opacity = "0";
            }
       }

    }else{
        if(screen.width <=1000){
            countdown.style.opacity = "0";
        }else{
            countdown.style.opacity = "1";
        }

    }
    if(new Date().getSeconds() == 0){
        // fiveNumberFn();
        isBetTime = true;
        chkBtn.src = '/images/airplane/chk.png';
        reBtn.src = '/images/airplane/re.png';
        doubleBtn.src = '/images/airplane/double.png';

        window.Livewire.emit('updateTrend');
        airplaneDiv.style.opacity = "0";
        airplaneDivBg.classList.remove('start');
        airTopThree.style.opacity = "0";
        airTopTen.style.opacity = "0";
        for(let i=0;i<airNum.length;i++){
            airNum[i].style.animation = 'none';
            airNum[i].style.animationDelay = '0s';
        }
        for(let a=0;a<air.length;a++){
            air[a].style.opacity = '1';
            air[a].style.animation = 'none';
        }
    }
}
window.addEventListener('updateTrendFn', e=>{
    let trendhtml = '';
    for(let i=0;i<e.detail.answer.length;i++){
        let rank = e.detail.answer[i].ranking.split(',');
        trendhtml += `<div class="item"><div class="number">${e.detail.answer[i].number}</div><div class="imgList">`
        for(let j=0;j<rank.length;j++){
            trendhtml += `<img src='/images/airplane/air${rank[j]}.png'>`
        }
        trendhtml += '</div></div>';

    }
    trendModalList.innerHTML = trendhtml;
})
window.addEventListener('watchStatu', e=>{
    if(e.detail.statu == 0){
        loadingDiv.style.display = "flex";
        setTimeout(()=>{
            document.getElementById('exitModal').style.display = "block";
        },3000)
        setTimeout(()=>{
            document.getElementById('loaing-logout').submit();
        },4000)
    }else{
        loadingDiv.style.display = "none";
    }
})
function fiveNumberFn(){
    fiveHtml = "";
    fiveNumber.innerHTML = ""
    answer.forEach(item=>{
        fiveHtml += `
            <div class="item">
                <p class="num">${item.number}</p>
                <div class="rankBox">
                    <img src="/images/airplane/num${item.ranking.split(',')[0]}.png" class="number">
                    <img src="/images/airplane/num${item.ranking.split(',')[1]}.png" class="number">
                    <img src="/images/airplane/num${item.ranking.split(',')[2]}.png" class="number">
                    <img src="/images/airplane/num${item.ranking.split(',')[3]}.png" class="number">
                    <img src="/images/airplane/num${item.ranking.split(',')[4]}.png" class="number">
                    <img src="/images/airplane/num${item.ranking.split(',')[5]}.png" class="number">
                    <img src="/images/airplane/num${item.ranking.split(',')[6]}.png" class="number">
                    <img src="/images/airplane/num${item.ranking.split(',')[7]}.png" class="number">
                    <img src="/images/airplane/num${item.ranking.split(',')[8]}.png" class="number">
                    <img src="/images/airplane/num${item.ranking.split(',')[9]}.png" class="number">
                </div>
              </div>
        `
    })
    fiveNumber.innerHTML = fiveHtml;
}

function chengGameFn(e){
    let id = "";
    initGameFn();
    id = e.target.id.split('Btn')[1]
    e.target.src = e.target.src.replace('btn', 'btnchk');
    game_name_num = Number(id) -1;
    if(id == 1 || id==2 || id==3){
        document.getElementById(`game${id}`).style.display = "block";
    }else{
        document.getElementById(`game${id}`).style.display = "flex";
    }

}
function initGameFn(){
    for(let i=1;i<=2;i++){
        document.getElementById(`game${i}`).style.display = "none";
        document.getElementById(`gameBtn${i}`).src = `images/airplane/btn${i}.png`;
    }
}
gameBtn1.addEventListener('click', chengGameFn);
gameBtn2.addEventListener('click', chengGameFn);
// gameBtn3.addEventListener('click', chengGameFn);
// gameBtn4.addEventListener('click', chengGameFn);
// gameBtn5.addEventListener('click', chengGameFn);


const logoutFn = ()=>{
    Swal.fire({
        title: '確定要登出嗎？',
        text: "Are you sure you want to log out?",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#aaa',
        confirmButtonText: 'Yes!'
    }).then(chk=>{
        if(chk.isConfirmed){
            Swal.fire(
                '登出成功！',
                'Logout succeeded!',
                'success'
            ).then(result=>{
                if(result.isConfirmed){
                    document.getElementById('logoutForm').submit();
                }
            })
        }
    })
};
bar.addEventListener('mousedown', ()=>{
    bar.style.transform = 'scale(.9)';
})
bar.addEventListener('mouseup', ()=>{
    bar.style.transform = 'scale(1)';
})
bar.addEventListener('click',()=>{
    isMenuOpen = !isMenuOpen;
    if(isMenuOpen){
        menuList.style.display = "block";
    }else{
        menuList.style.display = "none";
    }
})

for(let i=0;i<diamondBtnDiv.length;i++){
    diamondBtnDiv[i].addEventListener('click', setBetMoney);
}

function setBetMoney(e){
    for(let i=0;i<diamondBtn.length;i++){
        diamondBtn[i].style.transform = "scale(.75)"
    }
    beyMoney.value = Number(e.target.alt);
    e.target.style.transform = "scale(1)"
}
diamondBoxRight.addEventListener('click', function(){
    if(dimondListNum<3){
        dimondListNum++;
    }
    for(let i=0;i<diamondBtnDiv.length;i++){
        diamondBtnDiv[i].style.transform = `translateX(-${dimondListNum*100}%)`;
    }
});
diamondBoxLeft.addEventListener('click', function(){
    if(dimondListNum>0){
        dimondListNum--;
    }
    for(let i=0;i<diamondBtnDiv.length;i++){
        diamondBtnDiv[i].style.transform = `translateX(-${dimondListNum*100}%)`;
    }
});
beyMoney.addEventListener('blur',()=>{
    beyMoney.value =  Number(beyMoney.value)
    if(beyMoney.value == "" || beyMoney.value < 0){
        beyMoney.value = Number(0);
    }
})

function initRankFn(){
    for(let i=0;i<rankingImg.length;i++){
        rankingImg[i].src =  `/images/airplane/no${i+1}.png`
    }
}
function chengRankFn(e){
    initRankFn();
    e.target.src = `/images/airplane/no${e.target.alt}chk.png`;
    chooseRank = e.target.alt;
}
for(let i=0;i<rankingImg.length;i++){
    rankingImg[i].addEventListener('click', chengRankFn);
}
function notMoneyFn(){
    Swal.fire(
        '警告',
        '餘額不足',
        'error'
    );
}
for(let i=0;i<rank.length;i++){
    rank[i].querySelector('.air').addEventListener('click', guessFn,true);
}
function guessFn(e){
    if(e.target.classList[0] == "smallDiamond") return;
    if(Number(e.target.alt) == 11){
        if(bigLock) return
    }else if(Number(e.target.alt) == 12){
        if(smallLock) return
    }else if(Number(e.target.alt) == 13){
        if(oddLock) return
    }else if(Number(e.target.alt) == 14){
        if(evenLock) return
    }

    if(Number(beyMoney.value) <= 0){
        Swal.fire(
            '下注失敗',
            '請選擇下注金額',
            'error'
        );
        return;
    }
    if(Number(e.target.alt) <= 10){
        if(Number(beyMoney.value) > betLimitObj.single_bet_limit){
            Swal.fire(
                '下注失敗',
                `無法取得用戶資訊`,
                'error'
            );
            return;
        }
    }else if(Number(e.target.alt) <= 14){
        if(Number(beyMoney.value) > betLimitObj.bs_single_bet_limit){
            Swal.fire(
                '下注失敗',
                `無法取得用戶資訊`,
                'error'
            );
            return;
        }
    }
    let remain =  Number(myDoller.innerHTML) -  Number(beyMoney.value);
    if(remain < 0 ){
        notMoneyFn();
        return;
    }
    for(let i=0;i<rank.length;i++){
        rank[i].querySelector('.air').removeEventListener('click', guessFn,true);
    }
    totalBet += Number(beyMoney.value);
    totalBetNumberCalc++;
    let sd = e.target.parentNode;
    let diamond = document.createElement('img');
    diamond.setAttribute("src", "/images/airplane/diamond.png");
    diamond.setAttribute("class", `smallDiamond`);
    diamond.setAttribute("style", `display:block`);

    let betText = document.createElement('p')
    betText.textContent =  `+${beyMoney.value}`;
    sd.appendChild(diamond);
    sd.appendChild(betText);

    issetAirArr.push([Number(e.target.alt), false]) //
    airLightFn(issetAirArr) //

    setTimeout(()=>{
        sd.removeChild(diamond)
        sd.removeChild(betText)
    }, 1000)
    betIdx++;
    let obj = {};
    if(game_name_num == 0){
        //定位膽
        let rankGuessArr = [null, '冠軍', '亞軍', '季軍', '第四名', '第五名', '第六名', '第七名', '第八名', '第九名', '第十名'];
        let content = contentArr[Number(e.target.alt)];
        obj.id = betIdx;
        obj.game = game_name_arr[game_name_num];
        obj.rank = rankGuessArr[chooseRank];
        obj.content = content;
        obj.odds = oddsArr[0];
        obj.money = Number(beyMoney.value);
        obj.beted = false;
    }else if(game_name_num == 1){
        //大小單雙
        let rankGuessArr = [null, '冠軍', '亞軍', '季軍', '第四名', '第五名', '第六名', '第七名', '第八名', '第九名', '第十名'];
        let content = contentArr[Number(e.target.alt)];
        obj.id = betIdx;
        obj.game = game_name_arr[game_name_num];
        obj.rank = rankGuessArr[bsChooseRank];
        obj.content = content;
        obj.odds = oddsArr[1];
        obj.money = beyMoney.value;
        obj.beted = false;
        if(e.target.alt == 11){
            bsGrandTotalMoneyArr[0] += Number(beyMoney.value);
        }else if(e.target.alt == 12){
            bsGrandTotalMoneyArr[1] += Number(beyMoney.value);
        }else if(e.target.alt == 13){
            bsGrandTotalMoneyArr[2] += Number(beyMoney.value);
        }else if(e.target.alt == 14){
            bsGrandTotalMoneyArr[3] += Number(beyMoney.value);
        }
        bsGrandTotalMoneyFn();
    }
    betArr.push(obj);
    randerBetHtml(obj);

    if(document.getElementsByClassName('deleteBet').length > 0){
        for(let b=0;b<document.getElementsByClassName('deleteBet').length;b++){
            document.getElementsByClassName('deleteBet')[b].addEventListener('click', removeBetFn);
        }
    }
    for(let i=0;i<rank.length;i++){
        rank[i].querySelector('.air').addEventListener('click', guessFn,true);
    }
    lockBetFn(obj);
}
function lockBetFn(obj){
    if(obj.game != "大小單雙") return
    if(obj.content == "大"){
        smallLock = true
        smallBtn.classList.add('lock')
    }
    else if(obj.content == "小"){
        bigLock = true
        bigBtn.classList.add('lock')
    }
    else if(obj.content == "單"){
        evenLock = true
        evenBtn.classList.add('lock')
    }
    else if(obj.content == "雙"){
        oddLock = true
        oddBtn.classList.add('lock')
    }


}
function bsGrandTotalMoneyFn(){
    for(let i=0;i<bsBtn.length;i++){
        let m = 0;
        m = Number(bsGrandTotalMoneyArr[i]) + Number(bsGrandTotalMoneyBetedArr[i]);
        bsBtn[i].parentNode.querySelector('.grandTotal').innerHTML = `$${m}`;
    }
}
function airLightFn(arr){
    let airArr = airplaneRankBox.querySelectorAll('.air')
    arr = arr.map((item)=>{
        return item[0];
    })
    for(let i=0;i<airArr.length;i++){
        if(arr.includes(Number(airArr[i].alt))){
            // airArr[i].style.filter = "brightness(1.5)"
            airArr[i].style.opacity = "1"
        }else{
            // airArr[i].style.filter = "brightness(.6)"
            airArr[i].style.opacity = ".5"
        }
    }
    for(let i=0;i<bsBtn.length;i++){
        if(arr.includes(Number(bsBtn[i].alt))){
            // bsBtn[i].style.filter = "brightness(1.5)"
            bsBtn[i].style.opacity = "1"
        }else{
            bsBtn[i].style.opacity = ".5"
        }
    }
}
function removeBetFn(e){
    let node = e.target.parentNode.parentNode;
    let itemMoney = Number(e.target.parentNode.querySelectorAll('p')[3].innerText);
    arr = issetAirArr.map((item)=>{
        return item[0];
    })
    let idx = 0;
    let bsText = e.target.parentNode.querySelectorAll('p')[1].innerText.split('-')[1].trim();
    if(bsText == "大"){
        idx = indexOf(arr, 11);
        bsGrandTotalMoneyArr[0] -= itemMoney;
    }else if(bsText=="小"){
        idx = indexOf(arr, 12);
        bsGrandTotalMoneyArr[1] -= itemMoney;
    }else if(bsText=="單"){
        idx = indexOf(arr, 13);
        bsGrandTotalMoneyArr[2] -= itemMoney;
    }else if(bsText=="雙"){
        idx = indexOf(arr, 14);
        bsGrandTotalMoneyArr[3] -= itemMoney;
    }else{
        idx = indexOf(arr, Number(e.target.parentNode.querySelectorAll('p')[1].innerText.split('-')[1]))
    }
    bsGrandTotalMoneyFn()

    issetAirArr.splice(idx, 1);
    airLightFn(issetAirArr)
    node.removeChild(e.target.parentNode);
    let betIdx = e.target.parentNode.querySelector('.betIdx').value;
    betArr = betArr.filter((item)=>{
        if(item.id == betIdx){
            totalBet = totalBet - item.money
            totalBetNumberCalc -- ;
        }
        return item.id != betIdx;
    });
    removeLockFn()
}
function removeLockFn(){
    let issetBig = false
    let issetSmall = false
    let issetOdd = false
    let issetEven = false
    for(let i=0;i<betArr.length;i++){
        if(betArr[i].content == "大"){
            issetBig = true
        }else if(betArr[i].content == "小"){
            issetSmall = true
        }else if(betArr[i].content == "單"){
            issetOdd = true
        }else if(betArr[i].content == "雙"){
            issetEven = true
        }
    }
    for(let i=0;i<all_betArr.length;i++){
        if(all_betArr[i].content == "大"){
            issetBig = true
        }else if(all_betArr[i].content == "小"){
            issetSmall = true
        }else if(all_betArr[i].content == "單"){
            issetOdd = true
        }else if(all_betArr[i].content == "雙"){
            issetEven = true
        }
    }
    if(!issetBig){
        smallLock = false
        smallBtn.classList.remove('lock')
    }
    if(!issetSmall){
        bigLock = false
        bigBtn.classList.remove('lock')
    }
    if(!issetOdd){
        evenLock = false
        evenBtn.classList.remove('lock')
    }
    if(!issetEven){
        oddLock = false
        oddBtn.classList.remove('lock')
    }
}
function randerBetHtml(obj){
    let item = document.createElement('div');
    let input = document.createElement("input");
    let isBet = document.createElement("input");

    let span1 = document.createElement("span");
    let text1 = document.createTextNode("下注項目");
    span1.appendChild(text1)
    let p1 = document.createElement("p");
    let content1 = document.createTextNode(obj.game);
    p1.appendChild(content1);

    let span2 = document.createElement("span");
    let text2 = document.createTextNode("下注內容");
    span2.appendChild(text2)
    let p2 = document.createElement("p");
    let content2 = document.createTextNode(`${obj.rank} - ${obj.content}`);
    p2.appendChild(content2);

    let span3 = document.createElement("span");
    let text3 = document.createTextNode("賠率");
    span3.appendChild(text3)
    let p3 = document.createElement("p");
    let content3 = document.createTextNode(obj.odds);
    p3.appendChild(content3);

    let span4 = document.createElement("span");
    let text4 = document.createTextNode("投注金額");
    span4.appendChild(text4)
    let p4 = document.createElement("p");
    let content4 = document.createTextNode(obj.money);
    p4.appendChild(content4);

    let close = document.createElement('i');
    close.setAttribute('class', 'fas fa-times deleteBet')


    item.setAttribute("class", "item");
    item.appendChild(input);
    item.appendChild(isBet);
    item.appendChild(span1);
    item.appendChild(p1);
    item.appendChild(span2);
    item.appendChild(p2);
    item.appendChild(span3);
    item.appendChild(p3);
    item.appendChild(span4);
    item.appendChild(p4);
    item.appendChild(close);
    // input.setAttribute("class", "betIdx").setAttribute("type", "hidden").setAttribute("value", betIdx);
    input.setAttribute("class", "betIdx");
    input.setAttribute("type", "hidden");
    input.setAttribute("value", betIdx);

    isBet.setAttribute("class", "isBet");
    isBet.setAttribute("type", "hidden");
    isBet.setAttribute("value", 0);

    listAll.insertBefore(item, listAll.childNodes[0]);

}


chkBtn.addEventListener('click',chkBtnFn);
function chkBtnFn(){
    if(betLoading){
        Swal.fire(
            '下注失敗',
            '無法取得用戶資訊，請重試一遍',
            'error'
        );
        return;
    }
    if(isLock){
        Swal.fire(
            '下注失敗',
            '您的錢包已被鎖定',
            'error'
        );
        return;
    }
    if(!isBetTime){
        Swal.fire(
            '下注失敗！',
            '現在非下注時間',
            'error'
        );
        return;
    }
    if(totalBet <=0){
        Swal.fire(
            '警告',
            '您尚未下注！',
            'error'
        );
        return;
    }
    if(Number(totalBet) > Number(myDoller.innerHTML)){
        Swal.fire(
            '下注失敗！',
            '您的餘額不足',
            'error'
        );
        return;
    }
    if(Number(totalBet)> betLimitObj.bs_single_bet_limit || Number(totalBet)> betLimitObj.bs_single_bet_limit){
        Swal.fire(
            '下注失敗！',
            `無法取得用戶資訊`,
            'error'
        );
        return;
    }
    betArr.forEach(el=>{
        if(el.content == "大"){
            if(bigLock){
                Swal.fire(
                    '下注失敗！',
                    `無法取得用戶資訊`,
                    'error'
                );
                return;
            }
        }else if(el.content == "小"){
            if(smallLock){
                Swal.fire(
                    '下注失敗！',
                    `無法取得用戶資訊`,
                    'error'
                );
                return;
            }
        }else if(el.content == "單"){
            if(oddLock){
                Swal.fire(
                    '下注失敗！',
                    `無法取得用戶資訊`,
                    'error'
                );
                return;
            }
        }else if(el.content == "小"){
            if(evenLock){
                Swal.fire(
                    '下注失敗！',
                    `無法取得用戶資訊`,
                    'error'
                );
                return;
            }
        }

    });
    betLoading = true;
    isBeted = true
    betArr.forEach(el=>{
        el.beted = true;
    })
    let item = listAll.querySelectorAll('.item');

    all_totalBet += totalBet;
    all_totalBetNumberCalc += totalBetNumberCalc;
    all_betArr = [...all_betArr, ...betArr];
    let odds = oddsArr[0];
    let bsOdds = oddsArr[1];
    window.Livewire.emit('chkBet' ,totalBet, totalBetNumberCalc, betArr, odds, bsOdds); //totalBetNumberCalcv
    myDoller.innerHTML = Number(myDoller.innerHTML)  - Number(totalBet);
    for(let i=0;i<item.length;i++){
        if(item[i].querySelector('.deleteBet')){
            item[i].removeChild(item[i].querySelector('.deleteBet'))
        }
        item[i].querySelector(".isBet").value = 1;
    }
    totalBetNmuber.innerHTML = all_totalBetNumberCalc;
    totalBetMoney.innerHTML = all_totalBet;
    totalBet = 0;
    totalBetNumberCalc = 0;
    betArr = [];

    for(let i=0;i<bsGrandTotalMoneyBetedArr.length;i++){
        bsGrandTotalMoneyBetedArr[i] += bsGrandTotalMoneyArr[i]
    }
    bsGrandTotalMoneyArr = [0,0,0,0]

    issetAirArr.forEach(item=>{
        item[1] = true;
    })
}
window.addEventListener('betSuccess', e=>{
    if(e.detail.bool){
        Swal.fire(
            '投注成功！',
            '等待整點開獎',
            'success'
        );
    }else{
        Swal.fire(
            '下注失敗！',
            `無法取得用戶資訊！請再試一遍`,
            'error'
        );
    }
    betLoading = false;

})

function calcBetFn(){
    // let winMoney = 0;
    // let gameObj = {
    //     "冠軍":0, "第二名":1, "第三名":2, "第四名":3, "第五名":4, "第六名":5, "第七名":6, "第八名":7, "第九名":8, "第十名":9,
    // }
    //
    // all_betArr.forEach(item=>{
    //     if(item.game == "定位膽" && item.beted){
    //         if(nowAnswer[gameObj[item.rank]] == Number(item.content)){
    //             winMoney += (item.money*item.odds);
    //         }
    //     }else if(item.game == "大小單雙" && item.beted){
    //         if(item.content == "大" && nowAnswer[gameObj[item.rank]] >= 6){
    //             winMoney += (item.money*item.odds);
    //         }else if(item.content == "小" && nowAnswer[gameObj[item.rank]] <= 5){
    //             winMoney += (item.money*item.odds);
    //         }else if(item.content == "單" && (nowAnswer[gameObj[item.rank]] % 2) == 1){
    //             winMoney += (item.money*item.odds);
    //         }else if(item.content == "雙" && (nowAnswer[gameObj[item.rank]] % 2) == 0){
    //             winMoney += (item.money*item.odds);
    //         }
    //     }
    // })

    // window.Livewire.emit('calcMoney', winMoney, all_totalBet);
    all_betArr = [];
    all_totalBet = 0;
    all_totalBetNumberCalc = 0;
}

window.addEventListener('updateMyMoneyHtml', e=>{
    myDoller.innerHTML = e.detail.money;
    if(e.detail.win <=0) return;
    winMessage.innerHTML = `+ ${Math.round(e.detail.win)}`
});
reBtn.addEventListener('click',()=>{
    totalBet = 0;
    totalBetNumberCalc = 0;
    betArr = [];
    let item = listAll.querySelectorAll('.item');

    issetAirArr = issetAirArr.filter(item=>{
        return item[1] === true;
    })
    airLightFn(issetAirArr)

    bsGrandTotalMoneyArr = [0,0,0,0];
    bsGrandTotalMoneyFn()
    for(let i=0;i<item.length;i++){
        if(item[i].querySelector('.isBet').value == 0){
            item[i].parentNode.removeChild(item[i])
        }
    }

})
doubleBtn.addEventListener('click',()=>{
    if(!isBetTime){
        Swal.fire(
            '警告',
            '現在非下注時間',
            'error'
        );
        return;
    }
    if(all_totalBet <= 0){
        Swal.fire(
            '警告',
            '您尚未下注',
            'error'
        );
        return;
    }
    let newMoney = Number(myDoller.innerHTML) - all_totalBet;
    if(newMoney < 0){
        Swal.fire(
            '警告',
            '餘額不足',
            'error'
        );
        return;
    }
    if(Number(all_totalBet*2)> betLimitObj.single_term || Number(all_totalBet*2)> betLimitObj.bs_single_term){
        Swal.fire(
            '下注失敗！',
            `無法取得用戶資訊`,
            'error'
        );
        return;
    }

    myDoller.innerHTML = Number(myDoller.innerHTML) - Number(all_totalBet);
    totalBet = all_totalBet;
    totalBetNumberCalc = all_totalBetNumberCalc;
    betArr = all_betArr;
    all_totalBet = all_totalBet + totalBet;
    all_totalBetNumberCalc = all_totalBetNumberCalc + totalBetNumberCalc;



    totalBetMoney.innerHTML = all_totalBet;
    totalBetNmuber.innerHTML = all_totalBetNumberCalc;
    all_betArr = [...all_betArr, ...betArr]

    listAll.innerHTML = listAll.innerHTML + listAll.innerHTML;

    let odds = oddsArr[0];
    let bsOdds = oddsArr[1];
    window.Livewire.emit('chkBet' ,totalBet, totalBetNumberCalc, betArr, odds, bsOdds); //totalBetNumberCalcv
    totalBet = 0;
    totalBetNumberCalc = 0;
    betArr = [];

    for(let i=0;i<bsGrandTotalMoneyBetedArr.length;i++){
        bsGrandTotalMoneyBetedArr[i] = bsGrandTotalMoneyBetedArr[i]*2
    }
    bsGrandTotalMoneyFn()

    Swal.fire(
        '投注成功',
        '加倍下注成功，等待整點開獎',
        'success'
    );
    return;
})

function airTopTenHTML(nowAnswer){
   for(let i=0;i<airNum.length;i++){
    airNum[i].src = `/images/airplane/airRank${nowAnswer[i]}.png`;
   }
}
let threeArr = [1,0,2];
function airTopThreeHTML(nowAnswer){
    for(let i=0;i<topThreeAir.length;i++){
        topThreeAir[i].src = `/images/airplane/airRank${nowAnswer[threeArr[i]]}.png`
    }
}
openTrendModalBtn.addEventListener('click', ()=>{
    trendModal.style.display = "flex";
})
closeTrendModalBtn.addEventListener('click', ()=>{
    trendModal.style.display = "none";
})
openGameBtn.addEventListener('click', ()=>{
    playBoxisOpen = !playBoxisOpen;

    if(playBoxisOpen){
        playBox.style.opacity = '1';
        openGameBtn.classList.remove('fa-circle-up');
    }else{
        playBox.style.opacity = '0';
        openGameBtn.classList.add('fa-circle-up');
    }

})
openRuleModalBtn.addEventListener('click', ()=>{
    ruleModal.style.display = "flex";
})
closeRuleModalBtn.addEventListener('click', ()=>{
    ruleModal.style.display = "none";
})

for(let i=0;i<bsBtn.length;i++){
    bsBtn[i].addEventListener('mousedown',downBsBtnFn)
}
for(let i=0;i<bsBtn.length;i++){
    bsBtn[i].addEventListener('mouseup',upBsBtnFn)
}
for(let i=0;i<bsBtn.length;i++){
    bsBtn[i].addEventListener('click',guessFn);
}
function downBsBtnFn(e){
    if(e.target.alt == 11){
        if(bigLock) return
        bigBtn.src = '/images/airplane/big-chk.png';
        return;
    }
    if(e.target.alt == 12){
        if(smallLock) return
        smallBtn.src=  '/images/airplane/small-chk.png';
        return;
    }
    if(e.target.alt == 13){
        if(oddLock) return
        oddBtn.src =  '/images/airplane/odd-chk.png';
        return;
    }
    if(e.target.alt == 14){
        if(evenLock) return
        evenBtn.src =  '/images/airplane/even-chk.png';
        return;
    }
}
function upBsBtnFn(e){
    let bsArr = ['big', 'small', 'odd', 'even'];
    // guessBsFn(bsArr[Number(e.target.alt)-1]);

    if(e.target.alt == 11){
        bigBtn.src = '/images/airplane/big.png';
        return;
    }
    if(e.target.alt == 12){
        smallBtn.src=  '/images/airplane/small.png';
        return;
    }
    if(e.target.alt == 13){
        oddBtn.src =  '/images/airplane/odd.png';
        return;
    }
    if(e.target.alt == 14){
        evenBtn.src =  '/images/airplane/even.png';
        return;
    }
}

for(let i=0;i<rankingImgBs.length;i++){
    rankingImgBs[i].addEventListener('click', chengBsRankFn);
}

function chengBsRankFn(e){
    initBsRankFn();
    e.target.src = `/images/airplane/no${e.target.alt}chk.png`;
    bsChooseRank = e.target.alt;
}
function initBsRankFn(){
    for(let i=0;i<rankingImgBs.length;i++){
        rankingImgBs[i].src =  `/images/airplane/no${i+1}.png`
    }
}

openRecordModalBtn.addEventListener('click', e=>{
    recordModal.style.display = "flex";
})

closeRecordModalBtn.addEventListener('click' , e=>{
    recordModal.style.display = "none";
})

for(let i=0;i<otrank.length;i++){
    otrank[i].addEventListener('click', betotFn);
}
const otGuessArr = {
    "no1":0,
    "no2":0,
};
function betotFn(e){
    let ot = e.target.parentNode.parentNode.querySelectorAll('.otrank');
    for(let i=0;i<ot.length;i++){
        ot[i].querySelector('.medal').style.display = "none";
    }
    e.target.parentNode.querySelector('.medal').style.display = "block";
    if(e.target.parentNode.classList[2] === "ot1"){
        otGuessArr["no1"] = Number(e.target.parentNode.querySelector('.air').alt);
    }else if(e.target.parentNode.classList[2] === "ot2"){
        otGuessArr["no2"] = Number(e.target.parentNode.querySelector('.air').alt);
    }

}


window.addEventListener('isbetedFn', e=>{
    let html = '';
    e.detail.blArr.forEach(item=>{
        totalBet += item.money;
        totalBetNumberCalc += item.chips;
        item.bet_info.forEach(el=>{
            betIdx++;
            html += `<div class="item">
            <i class="fas fa-times deleteBet"></i>
            <input type="hidden" value="${betIdx}" class='betIdx'>
            <span>下注項目:</span><br>
            <p>${item.bet_info[0]}</p>
            <span>下注內容:</span>
            <p></p>
            <span>賠率:</span>
            <p></p>
            <span>投注金額:</span>
            <p></p>
            </div>`;
        })

    })
    listAll.innerHTML = html;
    totalBetNmuber.innerHTML = totalBetNumberCalc;
    totalBetMoney.innerHTML = totalBet;
    // totalBet, totalBetNumberCalc, betArr
})

openBetListBtn.addEventListener('click',openBetListFn )

function openBetListFn(){
    betListOpen =!betListOpen;
    if(betListOpen){
        betList.classList.add('open')
        openBetListBtn.style.transform = "rotate(180deg)"
    }else{
        betList.classList.remove('open')
        openBetListBtn.style.transform = "rotate(0deg)"
    }
}
window.addEventListener('pointLockFn', e=>{
    isLock = true;
});


window.onload = ()=>{
    setTimeout(()=>{
        document.getElementById('loading').style.display = "none";
    }, 1000)
    initLockFn();
}

window.addEventListener('initBetArrFn', e=>{
    let initBetArr = e.detail.betArr.map(item=>{
        return JSON.parse(item).map(arr=>{
            return arr;
        })
    })
    all_betArr = initBetArr.flat()
    if(all_betArr.length > 0){
        isBeted = true
    }

})



function initLockFn(){
    all_betArr.forEach(item=>{
        all_totalBet += Number(item.money)
        all_totalBetNumberCalc++
        if(item.content == "大"){
            issetAirArr.push([11, true])
            bsGrandTotalMoneyBetedArr[0] += Number(item.money)
        }else if(item.content == "小"){
            issetAirArr.push([12, true])
            bsGrandTotalMoneyBetedArr[1] += Number(item.money)
        }else if(item.content == "單"){
            issetAirArr.push([13, true])
            bsGrandTotalMoneyBetedArr[2] += Number(item.money)
        }else if(item.content == "雙"){
            issetAirArr.push([14, true])
            bsGrandTotalMoneyBetedArr[3] += Number(item.money)
        }
        initRanderBetHtml(item)
    })
    let m = 0;
    for(let i=0;i<bsBtn.length;i++){
        m = 0;
        m = Number(bsGrandTotalMoneyBetedArr[i]);
        bsBtn[i].parentNode.querySelector('.grandTotal').innerHTML = `$${m}`;
    }
    airLightFn(issetAirArr)
    totalBetNmuber.innerHTML = all_totalBetNumberCalc;
    totalBetMoney.innerHTML = all_totalBet;
    for(let i=0;i<all_betArr.length;i++){
        if(all_betArr[i].content == '大'){
            smallLock = true
            smallBtn.classList.add('lock')
        }else if(all_betArr[i].content == "小"){
            bigLock = true
            bigBtn.classList.add('lock')
        }else if(all_betArr[i].content == "單"){
            evenLock = true
            evenBtn.classList.add('lock')
        }else if(all_betArr[i].content == "雙"){
            oddLock = true
            oddBtn.classList.add('lock')
        }
    }
}

function initRanderBetHtml(obj){
    let item = document.createElement('div');
    let input = document.createElement("input");
    let isBet = document.createElement("input");

    let span1 = document.createElement("span");
    let text1 = document.createTextNode("下注項目");
    span1.appendChild(text1)
    let p1 = document.createElement("p");
    let content1 = document.createTextNode(obj.game);
    p1.appendChild(content1);

    let span2 = document.createElement("span");
    let text2 = document.createTextNode("下注內容");
    span2.appendChild(text2)
    let p2 = document.createElement("p");
    let content2 = document.createTextNode(`${obj.rank} - ${obj.content}`);
    p2.appendChild(content2);

    let span3 = document.createElement("span");
    let text3 = document.createTextNode("賠率");
    span3.appendChild(text3)
    let p3 = document.createElement("p");
    let content3 = document.createTextNode(obj.odds);
    p3.appendChild(content3);

    let span4 = document.createElement("span");
    let text4 = document.createTextNode("投注金額");
    span4.appendChild(text4)
    let p4 = document.createElement("p");
    let content4 = document.createTextNode(obj.money);
    p4.appendChild(content4);

    // let close = document.createElement('i');
    // close.setAttribute('class', 'fas fa-times deleteBet')


    item.setAttribute("class", "item");
    item.appendChild(input);
    item.appendChild(isBet);
    item.appendChild(span1);
    item.appendChild(p1);
    item.appendChild(span2);
    item.appendChild(p2);
    item.appendChild(span3);
    item.appendChild(p3);
    item.appendChild(span4);
    item.appendChild(p4);
    // input.setAttribute("class", "betIdx").setAttribute("type", "hidden").setAttribute("value", betIdx);
    input.setAttribute("class", "betIdx");
    input.setAttribute("type", "hidden");
    input.setAttribute("value", betIdx);

    isBet.setAttribute("class", "isBet");
    isBet.setAttribute("type", "hidden");
    isBet.setAttribute("value", 1);

    listAll.insertBefore(item, listAll.childNodes[0]);

}
function watchStatus(status){
    if(status == 0){
        loadingDiv.style.display = "flex";


        setTimeout(()=>{
            alert('連線逾時。')
        }, 1000)
        setTimeout(()=>{
            document.getElementById('exitModal').style.display = "block";
        },3000)
        setTimeout(()=>{
            document.getElementById('loaing-logout').submit();
        },4000)
    }else{
        loadingDiv.style.display = "none";
    }
}
function setBetLimit(e){
    betLimitObj.single_term =  e.single_term;
    betLimitObj.single_bet_limit = e.single_bet_limit
    betLimitObj.bs_single_term = e.bs_single_term
    betLimitObj.bs_single_bet_limit = e.bs_single_bet_limit
}
setTimeout(() => {
    window.Echo.channel('game-status')
    .listen('.GameStatus', (e)=>{
        watchStatus(e.status)
    });
    window.Echo.channel('user-status')
    .listen('.UserStatus', (e)=>{
        if(e.user_id === authId){
            watchStatus(e.status)
        }
    });
    window.Echo.channel('users-status')
    .listen('.UsersStatus', (e)=>{
        watchStatus(e.status)
    });
    window.Echo.channel('set-bet-limit')
    .listen('.SetBetLimit', (e)=>{
        setBetLimit(e)
    });
}, 200);
