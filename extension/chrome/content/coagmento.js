// Coagmento Firefox extension
// Beta 2.2
// Author: Chirag Shah
// Date: January 10, 2020

// Toolbar related functions

// Add a listener to the current window.
window.addEventListener("load", function() { coagmentoToolbar.init(); }, false);

function tabSelected(event) {
	var cookieManager = Components.classes["@mozilla.org/cookiemanager;1"].getService(Components.interfaces.nsICookieManager2);
	var iter = cookieManager.enumerator;
	var loggedIn = false;
	while (iter.hasMoreElements()) {
		var cookie = iter.getNext();
		if (cookie instanceof Components.interfaces.nsICookie) {
			if (cookie.name == "CSpace_userID" && cookie.value) {
				loggedIn = true;
				var userID = cookie.value;
			} // if (cookie.name == "CSpace_userID" && cookie.value)
		}  // if (cookie instanceof Components.interfaces.nsICookie)
	} // while (iter.hasMoreElements())

	if (loggedIn) {
		req = new phpRequest("http://www.coagmento.org/CSpace/checkStatus.php");
		req.add('version','203');
		var response = req.execute(); 
		var res = response.split(":");
		if (res[0]>0) {
			// Check if the button label was 'Deactivate', which means it was activated
			// And if it was, execute the request.
			var url = gBrowser.selectedBrowser.currentURI.spec;
			url = encodeURIComponent(url);
			var title = encodeURIComponent(document.title);
	        var button = document.getElementById("coagmento-Activate-Button");
	        var value = button.label;
			if (button.label == "Turn Off") {
				// Create the request for saving the page (and query) and execute it
				req = new phpRequest("http://www.coagmento.org/CSpace/savePQ.php");
				req.add('URL',url);
				req.add('title', title);
				req.add('version', '203');
				var response = req.execute();  
			} // if (button.label == "Deactivate")
			updateToolbar(url,title);
		} // if the user is logged in	
	} // if (loggedIn)
	else {
		var button = document.getElementById("coagmento-Activate-Button");
		button.label = "Turn On";
		var button = document.getElementById("coagmento-Views-Status-Button");
		button.label = "";
		var button = document.getElementById("coagmento-Notes-Status-Button");
		button.label = "";
		var button = document.getElementById("coagmento-Snippets-Status-Button");
		button.label = "";
		var button = document.getElementById("coagmento-Project-Status-Button");
		button.label = "Project: N/A";
	} // else with if (loggedIn)
}

function updateToolbar(url, title) {
	var req = new phpRequest("http://www.coagmento.org/CSpace/pageStatus.php");
	req.add('URL', url);
	req.add('title', title);
	req.add('version', '203');
	var response = req.execute(); 
	var button = document.getElementById("coagmento-Save-Button");
	var res = response.split(";");
	if (res[0]==1)
	    button.label = "Remove";
	else 
	    button.label = "Bookmark";
	var button = document.getElementById("coagmento-Views-Status-Button");
	button.label = res[1];
	var button = document.getElementById("coagmento-Notes-Status-Button");
	button.label = res[2];
	var button = document.getElementById("coagmento-Snippets-Status-Button");
	button.label = res[3];
	var button = document.getElementById("coagmento-Project-Status-Button");
	button.label = res[4];
}

var coagmentoToolbar = {
  init: function() {
	var container = gBrowser.tabContainer;
	container.addEventListener("TabSelect", tabSelected, false);
    var appcontent = document.getElementById("appcontent");   // browser
    if(appcontent)
      appcontent.addEventListener("DOMContentLoaded", coagmentoToolbar.onPageLoad, true);
    var messagepane = document.getElementById("messagepane"); // mail
    if(messagepane)
      messagepane.addEventListener("load", function () { coagmentoToolbar.onPageLoad(); }, true);

//	var timer = null;
//	var event = { notify: function(timer) {
	var event = { notify: function() {
		var cookieManager = Components.classes["@mozilla.org/cookiemanager;1"].getService(Components.interfaces.nsICookieManager2);
		var iter = cookieManager.enumerator;
		var loggedIn = false;
		while (iter.hasMoreElements()) {
			var cookie = iter.getNext();
			if (cookie instanceof Components.interfaces.nsICookie) {
				if (cookie.name == "CSpace_userID" && cookie.value) {
					loggedIn = true;
					var userID = cookie.value;
				} // if (cookie.name == "CSpace_userID" && cookie.value)
			}  // if (cookie instanceof Components.interfaces.nsICookie)
		} // while (iter.hasMoreElements())
	
		if (loggedIn) {
			req = new phpRequest("http://www.coagmento.org/CSpace/checkStatus.php");
			req.add('version','203');
			var response = req.execute(); 
			var res = response.split(":");
			if (res[0]>0) {
				// Create the request for identifying the page status and execute it
				var url = gBrowser.selectedBrowser.currentURI.spec;
				url = encodeURIComponent(url);
				var title = encodeURIComponent(document.title);
				var req = new phpRequest("http://www.coagmento.org/CSpace/pageStatus.php");
				req.add('URL', url);
				req.add('title', title);
				req.add('version', '203');
				var response = req.execute(); 
				var button = document.getElementById("coagmento-Save-Button");
				var res = response.split(";");
				if (res[0]==1)
				    button.label = "Remove";
				else 
				    button.label = "Bookmark";
				var button = document.getElementById("coagmento-Views-Status-Button");
				button.label = res[1];
				var button = document.getElementById("coagmento-Notes-Status-Button");
				button.label = res[2];
				var button = document.getElementById("coagmento-Snippets-Status-Button");
				button.label = res[3];
				var button = document.getElementById("coagmento-Project-Status-Button");
				button.label = res[4];
			} 	// if (res[0]>0)
			else {
				var button = document.getElementById("coagmento-Activate-Button");
				button.label = "Turn On";
				var button = document.getElementById("coagmento-Views-Status-Button");
				button.label = "";
				var button = document.getElementById("coagmento-Notes-Status-Button");
				button.label = "";
				var button = document.getElementById("coagmento-Snippets-Status-Button");
				button.label = "";
				var button = document.getElementById("coagmento-Project-Status-Button");
				button.label = "Project: N/A";
			} // else with if (res[0]>0)
		} // if (loggedIn)
	}
	}; // var event
	 // timer = Components.classes["@mozilla.org/timer;1"].createInstance(Components.interfaces.nsITimer);
	 // timer.initWithCallback(event, 3000, Components.interfaces.nsITimer.TYPE_REPEATING_SLACK);
  }, // init: function()
  
   onPageLoad: function(loadEvent) {
		// var ios = Components.classes["@mozilla.org/network/io-service;1"].getService(Components.interfaces.nsIIOService);
		// var cookieUri = ios.newURI("http://www.coagmento.org/", null, null);
		// var cookieSvc = Components.classes["@mozilla.org/cookieService;1"].getService(Components.interfaces.nsICookieService);
		// cookieSvc.setCookieString(cookieUri, null, 'CSpace_url='+url, null);
		// cookieSvc.setCookieString(cookieUri, null, 'CSpace_title='+title, null);
		var cookieManager = Components.classes["@mozilla.org/cookiemanager;1"].getService(Components.interfaces.nsICookieManager2);
		var iter = cookieManager.enumerator;
		var loggedIn = false;
		while (iter.hasMoreElements()) {
			var cookie = iter.getNext();
			if (cookie instanceof Components.interfaces.nsICookie) {
				if (cookie.name == "CSpace_userID" && cookie.value) {
					loggedIn = true;
					var userID = cookie.value;
				} // if (cookie.name == "CSpace_userID" && cookie.value)
			}  // if (cookie instanceof Components.interfaces.nsICookie)
		} // while (iter.hasMoreElements())

		if (loggedIn) {
			var url = gBrowser.selectedBrowser.currentURI.spec;
			url = encodeURIComponent(url);
			var title = document.title;
			req = new phpRequest("http://www.coagmento.org/CSpace/checkStatus.php");
			req.add('version','203');
			var response = req.execute(); 
			var res = response.split(":");
			if (res[0]>0) {
				// Check if the button label was 'Deactivate', which means it was activated
				// And if it was, execute the request.
		        var button = document.getElementById("coagmento-Activate-Button");
		        var value = button.label;
				if (button.label == "Turn Off") {
					var url = window.content.document.location;
					url = encodeURIComponent(url);
					var title = document.title;
				
					// Create the request for saving the page (and query) and execute it
					req = new phpRequest("http://www.coagmento.org/CSpace/savePQ.php");
					req.add('URL',url);
					req.add('title', title);
					req.add('version', '203');
					var response = req.execute();  
				} // if (button.label == "Deactivate")    
			
				// Create the request for identifying the page status and execute it
				var url = window.content.document.location;
				url = encodeURIComponent(url);
				req = new phpRequest("http://www.coagmento.org/CSpace/pageStatus.php");
				req.add('version', '203');
				req.add('URL',url);
				req.add('title', title);
				var response = req.execute(); 
				var button = document.getElementById("coagmento-Save-Button");
				var res = response.split(";");
				if (res[0]==1)
				    button.label = "Remove";
				else 
				    button.label = "Bookmark";
				var button = document.getElementById("coagmento-Views-Status-Button");
				button.label = res[1];
				var button = document.getElementById("coagmento-Notes-Status-Button");
				button.label = res[2];
				var button = document.getElementById("coagmento-Snippets-Status-Button");
				button.label = res[3];
				var button = document.getElementById("coagmento-Project-Status-Button");
				button.label = res[4];
			} // if (res[0]>0)
			else {
				var button = document.getElementById("coagmento-Activate-Button");
				button.label = "Turn On";
				var button = document.getElementById("coagmento-Views-Status-Button");
				button.label = "";
				var button = document.getElementById("coagmento-Notes-Status-Button");
				button.label = "";
				var button = document.getElementById("coagmento-Snippets-Status-Button");
				button.label = "";
				var button = document.getElementById("coagmento-Project-Status-Button");
				button.label = "Project: N/A";
			} // else with if (res[0]>0)
		} // if (loggedIn)
		else {
			var button = document.getElementById("coagmento-Activate-Button");
			button.label = "Turn On";
			var button = document.getElementById("coagmento-Views-Status-Button");
			button.label = "";
			var button = document.getElementById("coagmento-Notes-Status-Button");
			button.label = "";
			var button = document.getElementById("coagmento-Snippets-Status-Button");
			button.label = "";
			var button = document.getElementById("coagmento-Project-Status-Button");
			button.label = "Project: N/A";
		} // else with if (loggedIn)
	}, // onPageLoad: function(loadEvent)
 } // var coagmentoToolbar

// Function to load a URL
function loadURL(url) {
    // Set the browser window's location to the incoming URL
    window._content.document.location = url;

    // Make sure that we get the focus
    window.content.focus();
}

// Function to load a URL in a popup window
function loadURLPopup(url, text) {
	var page = window.content.document.location;
    url = url+'?1&page='+page;
    window.open(url,text,'resizable=yes,scrollbars=yes,width=640,height=480,left=600');
}

// Function to load a URL in a popup window
function showSnippets() {
    var page = window.content.document.location;
	page = encodeURIComponent(page);
	var title = encodeURIComponent(document.title);
    url = 'http://www.coagmento.org/CSpace/snippets.php?1&page='+page+'&title='+title;
    window.open(url,'Snippets','resizable=yes,scrollbars=yes,width=640,height=480,left=600');
}

function search() {
	var searchString = document.getElementById("coagmento-SearchTerms").value;
	var url = 'http://www.coagmento.org/CSpace/index.php?search='+searchString;
	loadURL(url);
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

function phpRequestExecute() {
    //Set the server to a local variable
    var targetURL = this.server;

    //Try to create our XMLHttpRequest Object
    try {
        var httpRequest = new XMLHttpRequest();
    }
    catch (e) {
//        alert('Error creating the connection!');
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
	        httpRequest.open("GET", currentURL, false, null, null);  
	        httpRequest.send('');			
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

// Function to activate/deactive recording of user actions
function activate() {
	var cookieManager = Components.classes["@mozilla.org/cookiemanager;1"].getService(Components.interfaces.nsICookieManager2);
	var iter = cookieManager.enumerator;
	var loggedIn = false;
	while (iter.hasMoreElements()) {
		var cookie = iter.getNext();
		if (cookie instanceof Components.interfaces.nsICookie) {
			if (cookie.name == "CSpace_userID" && cookie.value) {
				loggedIn = true;
				var userID = cookie.value;
			} // if (cookie.name == "CSpace_userID" && cookie.value)
		}  // if (cookie instanceof Components.interfaces.nsICookie)
	} // while (iter.hasMoreElements())

	if (loggedIn) {
	    var button = document.getElementById("coagmento-Activate-Button");
	    var value = button.label;
		var	req = new phpRequest("http://www.coagmento.org/CSpace/checkStatus.php");
		req.add('version','203');
		var response = req.execute(); 
		var res = response.split(":");
		if (res[0]>0) {
			var userID = res[0];
			var projectID = res[1];		
			if (value == "Turn On") {
		       	button.label = "Turn Off";
				req = new phpRequest("http://www.coagmento.org/CSpace/addAction.php");
				req.add('userID', userID);
		   	 	req.add('projectID',projectID);
				req.add('action', 'activate');
				req.add('value', '');
				var response = req.execute();
		    }
		    else {
		        button.label = "Turn On";
				req = new phpRequest("http://www.coagmento.org/CSpace/addAction.php");
				req.add('userID', userID);
		   	 	req.add('projectID',projectID);
				req.add('action', 'deactivate');
				req.add('value', '');
				var response = req.execute();
		    }
		}
		else {
			alert(res[1]);
		}
	}
	else
		alert("Your session has expired. Please login again.");
} // function activate()

// Function to save or remove a page
function save() {
	var cookieManager = Components.classes["@mozilla.org/cookiemanager;1"].getService(Components.interfaces.nsICookieManager2);
	var iter = cookieManager.enumerator;
	var loggedIn = false;
	while (iter.hasMoreElements()) {
		var cookie = iter.getNext();
		if (cookie instanceof Components.interfaces.nsICookie) {
			if (cookie.name == "CSpace_userID" && cookie.value) {
				loggedIn = true;
				var userID = cookie.value;
			} // if (cookie.name == "CSpace_userID" && cookie.value)
		}  // if (cookie instanceof Components.interfaces.nsICookie)
	} // while (iter.hasMoreElements())

	if (loggedIn) {
	    var url = window.content.document.location;
		url = encodeURIComponent(url);
		var title = encodeURIComponent(document.title);
		req = new phpRequest("http://www.coagmento.org/CSpace/checkStatus.php");
		req.add('version','203');
		var response = req.execute(); 
		var res = response.split(":");
		if (res[0]>0) {
			var button = document.getElementById("coagmento-Save-Button");
			if (button.label == "Bookmark") {
				req = new phpRequest("http://www.coagmento.org/CSpace/saveResult.php");
				req.add('page', url);
				req.add('title', title);
				req.add('save','1');
				var response = req.execute();
				button.label = "Remove";
			} // if (button.label == "Bookmark")
			else {
				req = new phpRequest("http://www.coagmento.org/CSpace/saveResult.php");
				req.add('page', url);
				req.add('title', title);
				req.add('save','0');
				var response = req.execute();
				button.label = "Bookmark";
			} // else with if (button.label == "Bookmark")
		} // else with if (res[0]==0)
		else {
			alert(res[1]);
		}
	}
	else
		alert("Your session has expired. Please login again.");
} // function save()

function recommend() {
	var cookieManager = Components.classes["@mozilla.org/cookiemanager;1"].getService(Components.interfaces.nsICookieManager2);
	var iter = cookieManager.enumerator;
	var loggedIn = false;
	while (iter.hasMoreElements()) {
		var cookie = iter.getNext();
		if (cookie instanceof Components.interfaces.nsICookie) {
			if (cookie.name == "CSpace_userID" && cookie.value) {
				loggedIn = true;
				var userID = cookie.value;
			} // if (cookie.name == "CSpace_userID" && cookie.value)
		}  // if (cookie instanceof Components.interfaces.nsICookie)
	} // while (iter.hasMoreElements())

	if (loggedIn) {
		req = new phpRequest("http://www.coagmento.org/CSpace/checkStatus.php");
		req.add('version','203');
		var response = req.execute(); 
		var res = response.split(":");
		if (res[0]>0) {
			var url = window.content.document.location;
			url = encodeURIComponent(url);
			var title = encodeURIComponent(document.title);
		    var targetURL = 'http://www.coagmento.org/CSpace/recommend.php?'+'&page='+url+'&title='+title;
		    window.open(targetURL,'Recommend','resizable=yes,scrollbars=yes,width=640,height=480,left=600');
		} // if (loggedIn)
		else {
			alert(res[1]);
		}
	}
	else
		alert("Your session has expired. Please login again.");
} // function annotate()

function annotate() {
	var cookieManager = Components.classes["@mozilla.org/cookiemanager;1"].getService(Components.interfaces.nsICookieManager2);
	var iter = cookieManager.enumerator;
	var loggedIn = false;
	while (iter.hasMoreElements()) {
		var cookie = iter.getNext();
		if (cookie instanceof Components.interfaces.nsICookie) {
			if (cookie.name == "CSpace_userID" && cookie.value) {
				loggedIn = true;
				var userID = cookie.value;
			} // if (cookie.name == "CSpace_userID" && cookie.value)
		}  // if (cookie instanceof Components.interfaces.nsICookie)
	} // while (iter.hasMoreElements())

	if (loggedIn) {
		req = new phpRequest("http://www.coagmento.org/CSpace/checkStatus.php");
		req.add('version','203');
		var response = req.execute(); 
		var res = response.split(":");
		if (res[0]>0) {
			var url = window.content.document.location;
			url = encodeURIComponent(url);
			var title = encodeURIComponent(document.title);
		    var targetURL = 'http://www.coagmento.org/CSpace/annotations.php?'+'&page='+url+'&title='+title;
		    window.open(targetURL,'Annotations','resizable=yes,scrollbars=yes,width=640,height=480,left=600');
		} // if (loggedIn)
		else {
			alert(res[1]);
		}
	}
	else
		alert("Your session has expired. Please login again.");
} // function annotate()

function snip() {
	var cookieManager = Components.classes["@mozilla.org/cookiemanager;1"].getService(Components.interfaces.nsICookieManager2);
	var iter = cookieManager.enumerator;
	var loggedIn = false;
	while (iter.hasMoreElements()) {
		var cookie = iter.getNext();
		if (cookie instanceof Components.interfaces.nsICookie) {
			if (cookie.name == "CSpace_userID" && cookie.value) {
				loggedIn = true;
				var userID = cookie.value;
			} // if (cookie.name == "CSpace_userID" && cookie.value)
		}  // if (cookie instanceof Components.interfaces.nsICookie)
	} // while (iter.hasMoreElements())

	if (loggedIn) {	
		req = new phpRequest("http://www.coagmento.org/CSpace/checkStatus.php");
		req.add('version','203');
		var response = req.execute(); 
		var res = response.split(":");
		if (res[0]>0) {
			var snippet = document.commandDispatcher.focusedWindow.getSelection().toString();
			var url = window.content.document.location;
			url = encodeURIComponent(url);
			var title = encodeURIComponent(document.title);
			targetURL = 'http://www.coagmento.org/CSpace/saveSnippet.php?'+'&URL='+url+'&snippet='+snippet+'&title='+title;
			window.open(targetURL,'Snippet','resizable=yes,scrollbars=yes,width=640,height=480,left=600');
		}
		else {
			alert(res[1]);
		}
	}
	else
		alert("Your session has expired. Please login again.");
}

// Sidebar functions
function populateSidebar() {
	var sidebar = top.document.getElementById('sidebar');
	var urlplace = "http://www.coagmento.org/CSpace/sidebar.php";
	sidebar.setAttribute("src", urlplace);
}
