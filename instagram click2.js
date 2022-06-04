let list = [];
document.addEventListener("click", (e)=>pauseIt(e));

function pauseIt(e){
  let path = e.path;
  for (var i = 0; i < path.length; i++) {
    // console.log(path[i].nodeName);
    if(path[i].nodeName == "A"){
      console.log(path[i].href);
      let url = path[i].href;
      if(!!url){
        list.push(url);
      }
      break;
    }
  }
  setTimeout(()=>closePopup(),1000);
}

function closePopup() {
  printList();
	try{
		var sv = document.querySelectorAll('[aria-label="Close"]');
		let closeButton = sv[0].parentElement.parentElement;
    closeButton.click();
	}
	catch(e){
		return;
	}
}

function printList(){
	// console.log("# Results: " + list.length);
	let trimmedDown = [...new Set(list)];
	let urls = trimmedDown.map((e)=>'"' + e + '"');
	console.log();
	console.log("$urls = array(" + urls + ");");
	console.log();
  console.log("Final Amount: " + urls.length);
}
