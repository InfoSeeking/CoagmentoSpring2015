var bustcachevar = 1; //bust potential caching of external pages after initial request? (1=yes, 0=no)
var loadedobjects = "";
var rootdomain = "http://"+window.location.hostname+"/";

//var rootdomain = "http://"+window.location.hostname+"/userstudy2014/";
var bustcacheparameter = "";

// Function to load an external URL in a container
function ajaxpage(url, containerid) {
//	alert('hello');
	var page_request = false;
	if (window.XMLHttpRequest) // if Mozilla, Safari etc
		page_request = new XMLHttpRequest();
	else if (window.ActiveXObject){ // if IE
		try {
			page_request = new ActiveXObject("Msxml2.XMLHTTP");
		} 
		catch (e){
			try{
				page_request = new ActiveXObject("Microsoft.XMLHTTP");
			}
			catch (e){}
		}
	}
	else
		return false;

//	page_request.onreadystatechange=function() {
//		loadpage(page_request, containerid)
//	}


	//I added this condition for making only ajax requests without showing the result on a certain DIV section
	if (containerid!=null)
	{
		page_request.onreadystatechange=function() {
			loadpage(page_request, containerid)
		}
	}

	if (bustcachevar) //if bust caching of external page
		bustcacheparameter=(url.indexOf("?")!=-1)? "&"+new Date().getTime() : "?"+new Date().getTime();
	page_request.open('GET', url+bustcacheparameter, true);
	page_request.send(null);
}

// Function to load a page in a container by making a HTTP request
function loadpage(page_request, containerid){
	if (page_request.readyState == 4 && (page_request.status==200 || window.location.href.indexOf("http")==-1))
		document.getElementById(containerid).innerHTML=page_request.responseText;
}

function addAction (action, value) {
	//req = new phpRequest("http://www.coagmento.org/CSpace/addAction.php");
	req = new phpRequest(rootdomain+"services/insertAction.php");
	req.add('action', action);
	req.add('value', value);

	 var currentTime = new Date();
     var month = currentTime.getMonth() + 1;
     var day = currentTime.getDate();
     var year = currentTime.getFullYear();
     var localDateVal = year + "/" + month + "/" + day;
     var hours = currentTime.getHours();
     var minutes = currentTime.getMinutes();
     var seconds = currentTime.getSeconds();
     var localTimeVal = hours + ":" + minutes + ":" + seconds;
     var localTimestampVal = currentTime.getTime();
     
	req.add('localTime', localTimeVal);
	req.add('localDate', localDateVal);
	req.add('localTimestamp', localTimestampVal);	
	var response = req.execute();
}

//From http://www.netlobo.com/url_query_string_javascript.html
function gup(name) {
    name = name.replace(/[\[]/,"\\\[").replace(/[\]]/,"\\\]");
    var regexS = "[\\?&]"+name+"=([^&#]*)";
    var regex = new RegExp( regexS );
    var results = regex.exec(window.location.href);
    if(results == null) {
        return "";
    }
    return results[1];
}

function reload(webpage,region) {
	ajaxpage(webpage, region);

	/*var actionBox = document.getElementById(region);
	var scrollHeight = actionBox.scrollHeight;
	actionBox.scrollTop = 5000;	*/
}

//Start phpRequest Object
function phpRequest(serverScript) {
	//Set some default variables
	this.parms = new Array();
	this.parmsIndex = 0;

	//Set the server url
	this.server = serverScript;

	//Add two methods
	this.execute = phpRequestExecute;
	this.add = phpRequestAdd;
}

function phpRequestAdd(name,value) {
    //Add a new pair object to the params
    this.parms[this.parmsIndex] = new pair(name,value);
    this.parmsIndex++;
}

//var lastURL = "";

function phpRequestExecute() {
    //Set the server to a local variable
    var targetURL = this.server;

    //Try to create our XMLHttpRequest Object
    try {
        var httpRequest = new XMLHttpRequest();
    }
    catch (e) {
        alert('Error creating the connection!');
        return;
    }

    //Make the connection and send our data
    try {
        var txt = "?1";
        for(var i in this.parms) {
            txt = txt+'&'+this.parms[i].name+'='+this.parms[i].value;
        }
        //Two options here, only uncomment one of these
        //GET REQUEST
		var currentURL = targetURL+txt;
//		if (currentURL != lastURL) {
//			lastURL = currentURL;
	        httpRequest.open("GET", currentURL, false, null, null);
	        httpRequest.send('');
//		}
    }
    catch (e) {
//        alert('An error has occured calling the external site: '+e);
        return false;
    }

    //Make sure we received a valid response
    switch(httpRequest.readyState) {
        case 1,2,3:
 //           alert('Bad Ready State: '+httpRequest.status);
            return false;
            break;
        case 4:
            if(httpRequest.status !=200) {
 //               alert('The server respond with a bad status code: '+httpRequest.status);
                return false;
            }
            else {
                var response = httpRequest.responseText;
            }
            break;
    }
    return response;
}

function pair(name,value) {
    this.name = name;
    this.value = value;
}


