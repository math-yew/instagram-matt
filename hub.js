let influencerArr = [
  'paulinarygiert',

'pozytywny_domek',

'jamie_banfield_design'
];

let list = [];

function nextInflu(){
  if(influencerArr.length > 0){
    let inf = influencerArr[0];
    influencerArr.shift();
    getScore(inf)
  } else(
  	console.log("$scores = array(" + list + ");")
  )
}

nextInflu();

function getScore(influ){
  let myInput = document.querySelectorAll(".pinkBlock input")[0];
  myInput.value = influ;
  document.querySelectorAll(".pinkBlock button")[0].click();
  let numberResult = 0;
  let intervalCount = 0;
  let checkingRes = setInterval(()=>{
    intervalCount++;
    if(intervalCount > 8){
      clearInterval(checkingRes); //add timer to end when hung up
      nextInflu();
    }
    let lastResult = numberResult;
    numberResult = document.getElementsByClassName("sumRes")[0].getAttribute("number");
    if(lastResult == numberResult && numberResult != 0){
      clearInterval(checkingRes); //add timer to end when hung up
      // alert(numberResult);
      if(numberResult*1 > -1){
        list.push('"' + influ + '"=>' + numberResult);
      }
      nextInflu();
    }
  },1000);
}

// document.querySelectorAll("img").addEventListener("click", nextInflu);
