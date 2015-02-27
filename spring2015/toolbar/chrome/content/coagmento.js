// Coagmento Collaboratory Firefox extension
// Beta 1.0.1
// Author: Roberto Gonzalez-Ibanez
// Last update: May 21, 2012

// Toolbar related functions
// Add a listener to the current window.
window.addEventListener("load", function() {
  coagmentoToolbar.init();
  toggleSidebar('viewSidebar',true);
  toggleSidebar('viewSidebar',false);
  }, false);
//window.addEventListener("load", function() { coagmentoToolbar.init(); }, false);

var action = "";
//This should be in an external file containing all the settings
//var globalUrl = "http://coagmento.rutgers.edu/pilot2/";
var globalUrl = "http://coagmento.org/spring2015/";
//var globalUrl = "http://coagmento.rutgers.edu/spring2013/pilot1/";


function localTime(){
  var currentTime = new Date();
  var hours = currentTime.getHours();
  var minutes = currentTime.getMinutes();
  var seconds = currentTime.getSeconds();
  return hours + "%3A" + minutes + "%3A" + seconds;
}

function localTimestamp(){
  var currentTime = new Date();
  return currentTime.getTime();
}

function localDate(){
  var currentTime = new Date();
  var month = currentTime.getMonth() + 1;
  var day = currentTime.getDate();
  var year = currentTime.getFullYear();
  return year + "%2F" + month + "%2F" + day;
}
//Function to load a URL
function loadURL(url) {
    // Set the browser window's location to the incoming URL
    window._content.document.location = url;
    // Make sure that we get the focus
    window.content.focus();
}


var lastCopyURL = "";
var lastTitle = "";
var lastSnippet = "";
var copied = false;
var first = true;

var googleURL = "	";

function search() {
	var url = googleURL;
	loadURL(url);
}

function home(){

//    If you want to save local time stamp
//    var currentTime = new Date();
//    var month = currentTime.getMonth() + 1;
//    var day = currentTime.getDate();
//    var year = currentTime.getFullYear();
//    var localDate = year + "%2F" + month + "%2F" + day;
//    var hours = currentTime.getHours();
//    var minutes = currentTime.getMinutes();
//    var seconds = currentTime.getSeconds();
//    var localTime = hours + "%3A" + minutes + "%3A" + seconds;
//    var localTimestamp = currentTime.getTime();

//    var url = globalUrl+"services/getHome.php?localTimestamp="+localTimestamp+"&localTime="+localTime+"&localDate="+localDate;
    var url = globalUrl+"services/getHome.php";

    loadURL(url);
}


//var flagGoogle = false;
//var flagSearchEngine = false;

//var redirected = false;

function onChange()
{
	if(coagmentoToolbar.oldTitle!==document.title)
	{
		coagmentoToolbar.oldTitle=document.title;
		savePQ();
	}
}

function tabSelected(event)
{

	action = "tabSelected";
	savePQ();
}

function tabAdded(event)
{

	action = "tabAdded";
	savePQ();
}

function tabClosed(event) {

	action = "tabClosed";
	savePQ();
}

function checkStageBrowsability()
{
	var xmlHttpTimeout;
	if (isExclusive==false)
	{
     isExclusive = true;
     var xmlHttpConnection = new XMLHttpRequest();
     xmlHttpConnection.open('GET', globalUrl+'services/checkStage.php', true);
     xmlHttpConnection.onreadystatechange=function(){
           if (xmlHttpConnection.readyState == 4 && xmlHttpConnection.status == 200) {
                 var serverResponse = xmlHttpConnection.responseText;
                 var url = window.content.document.location;
//                alert ("stageBrowsability " + toString(serverResponse));
                 if (serverResponse==1)
                 {
                	 allowBrowsingFlag = true;
                     xmlHttpConnection.abort();
                     clearTimeout(xmlHttpTimeout);
                     //updateToolbarButtons();
                     disableButtons(false);
                     isExclusive = false;
                 }
                 else
                 {
                	 if (loggedIn)
                		 CloseAllButton.runScript();
                	 allowBrowsingFlag = false;
                     clearTimeout(xmlHttpTimeout);
                     //serverDown();
                     disableButtons(true);
                     xmlHttpConnection.abort();
                     isExclusive = false;
                 }
           }
     };

     xmlHttpConnection.send(null);
     xmlHttpTimeout = setTimeout(function (){
                                     serverDown();
                                     xmlHttpConnection.abort();
                                     clearTimeout(xmlHttpTimeout);
                                 },5000);
	}

	/***---ADDED on 06/04/14-----*/
	else
	{
		setTimeout(checkStageBrowsability,10);

	}
}


function onPageLoad()
{
	//validSearchEngine();
	//checkStageBrowsability();
	cleanAlert();
	savePQ();
}

var TOPIC_MODIFY_REQUEST = "http-on-modify-request";

var coagmentoCheckStageObserver = {
register: function() {
    var observerService = Components.classes["@mozilla.org/observer-service;1"]
    .getService(Components.interfaces.nsIObserverService);
    observerService.addObserver(this, TOPIC_MODIFY_REQUEST, false);
//    observerService.addObserver(this, "http-on-examine-response", false);
},
    //observe function to capture the changed event
    observe : function(aSubject, aTopic, aData) {
        if (TOPIC_MODIFY_REQUEST == aTopic ) {
            var url;
            aSubject.QueryInterface(Components.interfaces.nsIHttpChannel);

            url = aSubject.URI.spec;
            url = encodeURIComponent(url);

            //aSubject.setRequestHeader("Host", "google.com", false);
            //validSearchEngine(url);

            var oHttp = aSubject.QueryInterface(Components.interfaces.nsIHttpChannel);
            if (oHttp.loadFlags & Components.interfaces.nsIHttpChannel.LOAD_INITIAL_DOCUMENT_URI) {
                //is top level load
//                alert("checkbrowsobserver" + isExclusive);
                checkStageBrowsability();
//                alert("done - checkbrowsobserver" + isExclusive);
                cleanAlert();
//                alert("done - clean" + isExclusive);
                savePQ();
//                alert("done - savePQ" + isExclusive);
            }
        }
    }

}


var coagmentoObserver = {
        register: function() {
        var observerService = Components.classes["@mozilla.org/observer-service;1"]
                                                  .getService(Components.interfaces.nsIObserverService);
        observerService.addObserver(this, TOPIC_MODIFY_REQUEST, false);
        },
        //observe function to capture the changed event
        observe : function(aSubject, aTopic, aData) {
          if (TOPIC_MODIFY_REQUEST == aTopic) {
                var url;
                aSubject.QueryInterface(Components.interfaces.nsIHttpChannel);

				url = aSubject.URI.spec;

				//alert("Data received: " + url + aData);

							//aSubject.setRequestHeader("Host", "google.com", false);
				//validSearchEngine(url);

			if (loggedIn)
			{
				/*if (!flagSearchEngine)
				{

					flagSearchEngine = true;
					//if (!flagSearchEngine)
					//{*/
					/*if ((url.indexOf("www.google.com",0) != -1)&&(url.indexOf("complete=0",0) != -1))

						aSubject.cancel(Components.results.NS_BINDING_ABORTED);
						search();
					}
					/*flagSearchEngine = false;

				}*/

				// This is not required since in user study 2014 you can go to any search engine. No restrictions.
				/*
				if (sessionNumber==2)
				{
					//url = encodeURIComponent(url);
					//Here check if this is Google images .. that is fine if they want to use that.
					if ((url.indexOf("bing.com",0) != -1)||
						(url.indexOf("ask.com",0) != -1)||
						(url.indexOf("excite.com",0) != -1)||
						(url.indexOf("zakta.com",0) != -1)||
						(url.indexOf("lycos.com",0) != -1)||
						(url.indexOf("info.com",0) != -1)||
						(url.indexOf("ehow.com",0) != -1)||
						(url.indexOf("answers.wikia.com",0) != -1)||
						(url.indexOf("answerbag.com",0) != -1)||
						(url.indexOf("yahoo.co",0) != -1)||
						(url.indexOf("altavista.com",0) != -1)||
						(url.indexOf("wiki.answers.com",0) != -1)
					  )
					{
							//Add condition to restricted date range search based on session 1 or 2
						aSubject.cancel(Components.results.NS_BINDING_ABORTED);
						//aSubject.setRequestHeader("Referer", "https://www.google.com/webhp?hl=en&output=search&tbs=cdr:1,cd_min:1/1/1990,cd_max:3/31/2011&bav=on.2,or.r_gc.r_pw.r_qf.,cf.osb&ech=1&psi=LuOLT5GbE4L50gGPmszhCg.1334567726497.3&emsg=NCSR&noj=1&ei=LuOLT5GbE4L50gGPmszhCg&complete=0", false);
						//aSubject.setRequestHeader("Host", "google.com", false);
						//search();
					}

				}
				*/
			}


               /*

                //check if the url matches any of the regula expressions mentioned above and then redirect to google.com
                if (RE_URL_TO_MODIFY_1.test(url) || RE_URL_TO_MODIFY_2.test(url) || RE_URL_TO_MODIFY_3.test(url)|| RE_URL_TO_MODIFY_4.test(url)||RE_URL_TO_MODIFY_5.test(url) || RE_URL_TO_MODIFY_6.test(url) || RE_URL_TO_MODIFY_7.test(url)|| RE_URL_TO_MODIFY_8.test(url)||
				    RE_URL_TO_MODIFY_9.test(url) || (RE_URL_TO_MODIFY_10.test(url)&&(!RE_URL_TO_MODIFY_11.test(url))&&(!RE_URL_TO_MODIFY_12.test(url))&&(!RE_URL_TO_MODIFY_13.test(url))))
                {
                aSubject.setRequestHeader("Referer", "https://www.google.com/webhp?hl=en&output=search&tbs=cdr:1,cd_min:1/1/1990,cd_max:3/31/2011&bav=on.2,or.r_gc.r_pw.r_qf.,cf.osb&ech=1&psi=LuOLT5GbE4L50gGPmszhCg.1334567726497.3&emsg=NCSR&noj=1&ei=LuOLT5GbE4L50gGPmszhCg", false);
                aSubject.setRequestHeader("Host", "google.com", false);
                }

          }
        },
        //unregister function and remove observer
        unregister: function() {
        var observerService = Components.classes["@mozilla.org/observer-service;1"]
                                                        .getService(Components.interfaces.nsIObserverService);
        observerService.removeObserver(this, "http-on-modify-request");  */
        }
}

}



var coagmentoToolbar =
{
		oldTitle:document.title,
		oldURL:document.location,

		delay:function()
        {
			setTimeout(onChange,1);
        },

		init: function()
		{

			 var container = gBrowser.tabContainer;

			 //container.addEventListener('DOMSubtreeModified',coagmentoToolbar.delay, false);
			 container.addEventListener('DOMSubtreeModified',onChange, false);
//			 container.addEventListener("load", onPageLoad, true);
//            Attempt 2
             var appcontent = document.getElementById("appcontent");   // browser
             if(appcontent){
                appcontent.addEventListener("DOMContentLoaded", onPageLoad, true);
             }
//            Attempt 1
//             if(gBrowser) {gBrowser.addEventListener("DOMContentLoaded", onPageLoad, false);}

 			 container.addEventListener("TabOpen", tabAdded, false);
			 container.addEventListener("TabClose", tabClosed, false);
			 container.addEventListener("TabSelect", tabSelected, false);

             //Added 08/2014
             gBrowser.addEventListener("copy", copyData, false);

             //Added 1/2015
             gBrowser.addEventListener("paste", pasteData, false);



//             var appcontent = document.getElementById("appcontent");   // browser
//             if(appcontent)
//                 appcontent.addEventListener("DOMContentLoaded", coagmentoToolbar.onPageLoad, true);
//             var messagepane = document.getElementById("messagepane"); // mail
//             if(messagepane)
//                 messagepane.addEventListener("load", function () { coagmentoToolbar.onPageLoad(); }, true);

			 coagmentoObserver.register();

             coagmentoCheckStageObserver.register();

	         //populateSidebar();
			/*var appcontent = document.getElementById("appcontent");   // browser
		    if(appcontent)
		    	appcontent.addEventListener("DOMContentLoaded", onPageLoad, true);

		    var messagepane = document.getElementById("messagepane"); // mail
		    if(messagepane)
		    	messagepane.addEventListener("load", function () { onPageLoad(); }, true);*/



		}
};


function editor()
{
  var url = globalUrl+"services/getTextEditor.php";
  gBrowser.selectedTab = gBrowser.addTab(url);
  // loadURL(url);
  var actionReq = new XMLHttpRequest();
  actionReq.open('GET', globalUrl + "services/insertAction.php?action=ToolbarClickEditor&value=true&localTime=" + localTime() + "&localDate=" + localDate() + "&localTimestamp=" + localTimestamp());
  actionReq.send();
}

function activetask(){
	window.open(globalUrl+"services/viewMyStuff.php?=true",'Active Task View','directories=no, personalbar=no, resizable=yes, toolbar=no, location=no, status=no, menubar=no, scrollbars=yes,width=550,height=400,left=600');
  var actionReq = new XMLHttpRequest();
  actionReq.open('GET', globalUrl + "services/insertAction.php?action=ToolbarClickActiveTask&value=true&localTime=" + localTime() + "&localDate=" + localDate() + "&localTimestamp=" + localTimestamp());
  actionReq.send();
}

function openContactWindow(){
    window.open(globalUrl + "services/contactUs.php?=true","Contact Us",'directories=no, toolbar=no, location=no, status=no, menubar=no, resizable=no,scrollbars=yes,width=520,height=300,left=400');
    var actionReq = new XMLHttpRequest();
    actionReq.open('GET', globalUrl + "services/insertAction.php?action=ToolbarClickContact&value=true&localTime=" + localTime() + "&localDate=" + localDate() + "&localTimestamp=" + localTimestamp());
    actionReq.send();
}

//Save pages
function savePQ()
{
  //if (isVersionCorrect)
  //{
      // Create the request for saving the page (and query) and execute it
	  checkConnectivity();
      if (loggedIn)
      {
          var url = gBrowser.selectedBrowser.currentURI.spec;
          url = encodeURIComponent(url);
          var title = document.title;
          var xmlHttpTimeoutSavePQ;
          var xmlHttpConnectionSavePQ = new XMLHttpRequest();

          //Capturing local time
          var currentTime = new Date();
          var month = currentTime.getMonth() + 1;
          var day = currentTime.getDate();
          var year = currentTime.getFullYear();
          var localDate = year + "%2F" + month + "%2F" + day;
          var hours = currentTime.getHours();
          var minutes = currentTime.getMinutes();
          var seconds = currentTime.getSeconds();
          var localTime = hours + "%3A" + minutes + "%3A" + seconds;
          var localTimestamp = currentTime.getTime();

          //Saving page
          xmlHttpConnectionSavePQ.open('GET', globalUrl+'services/savePQ.php?URL='+url+'&title='+title+'&localTimestamp='+localTimestamp+'&localTime='+localTime+'&localDate='+localDate+'&action='+action, true);
          action = "";

          xmlHttpConnectionSavePQ.onreadystatechange=function(){
              if (xmlHttpConnectionSavePQ.readyState == 4 && xmlHttpConnectionSavePQ.status == 200) {
                      clearTimeout(xmlHttpTimeoutSavePQ);
                    }
              };

          xmlHttpConnectionSavePQ.send(null);
          xmlHttpTimeoutSavePQ = setTimeout(function(){
                                              xmlHttpConnectionSavePQ.abort();
                                              clearTimeout(xmlHttpTimeoutSavePQ);
                                          }
                                          ,3000);
      }


  //}
		//flagGoogle = false;
		//flagSearchEngine = false;
};



function pasteData()
{

	checkConnectivity();
	if (loggedIn && copied)
	{
		/*var snippet = document.commandDispatcher.focusedWindow.getSelection().toString();
         var url = window.content.document.location;
         url = encodeURIComponent(url);
         var title = encodeURIComponent(document.title);*/

		var snippet = lastSnippet;
        var currentUrl = gBrowser.selectedBrowser.currentURI.spec;
        currentUrl = encodeURIComponent(currentUrl);
        //1/12/15 - copy data for paste
        var prevUrl = lastCopyURL;
        var currentTitle = document.title;
        var prevTitle = lastTitle;
        var xmlHttpTimeoutCopyData;
        var xmlHttpConnectionPasteData = new XMLHttpRequest();

//        alert("okay1"+globalUrl);
//                alert("okay1"+prevUrl);
//                alert("okay1"+currentUrl);
//                alert("okay1"+snippet);
//                alert("okay1"+prevTitle);
//                alert("okay1"+currentTitle);
        //Capturing local time
        var currentTime = new Date();
        var month = currentTime.getMonth() + 1;
        var day = currentTime.getDate();
        var year = currentTime.getFullYear();
        var localDate = year + "%2F" + month + "%2F" + day;
        var hours = currentTime.getHours();
        var minutes = currentTime.getMinutes();
        var seconds = currentTime.getSeconds();
        var localTime = hours + "%3A" + minutes + "%3A" + seconds;
        var localTimestamp = currentTime.getTime();

        //Saving page
        xmlHttpConnectionPasteData.open('GET', globalUrl+'services/savePasteData.php?'+'fromURL='+prevUrl+'&toURL='+currentUrl+'&snippet='+snippet+'&fromtitle='+prevTitle+'&totitle='+currentTitle+'&localTimestamp='+localTimestamp+'&localTime='+localTime+'&localDate='+localDate, true);
        action = "";


        xmlHttpConnectionPasteData.onreadystatechange=function(){
            if (xmlHttpConnectionPasteData.readyState == 4 && xmlHttpConnectionPasteData.status == 200) {
                clearTimeout(xmlHttpTimeoutPasteData);
            }
        };

        xmlHttpConnectionPasteData.send(null);
        xmlHttpTimeoutPasteData = setTimeout(function(){
                                            xmlHttpConnectionPasteData.abort();
                                             clearTimeout(xmlHttpTimeoutPasteData);
                                            }
                                            ,3000);

//                document.getElementById('msgs').textContent = " Snippet Saved!";
//                setTimeout('cleanAlert()', 3000);
	}
};

function copyData()
{

	checkConnectivity();
	if (loggedIn)
	{
		/*var snippet = document.commandDispatcher.focusedWindow.getSelection().toString();
         var url = window.content.document.location;
         url = encodeURIComponent(url);
         var title = encodeURIComponent(document.title);*/

		var snippet = document.commandDispatcher.focusedWindow.getSelection().toString().trim();
        if(snippet.length <= 0){
            return;
        }
        lastSnippet = snippet;
        var url = gBrowser.selectedBrowser.currentURI.spec;
        url = encodeURIComponent(url);

        //1/12/15 - copy data for paste
        copied = true;
        lastCopyURL = url;
        var title = document.title;
        lastTitle = title;

        var xmlHttpTimeoutCopyData;
        var xmlHttpConnectionCopyData = new XMLHttpRequest();

        //Capturing local time
        var currentTime = new Date();
        var month = currentTime.getMonth() + 1;
        var day = currentTime.getDate();
        var year = currentTime.getFullYear();
        var localDate = year + "%2F" + month + "%2F" + day;
        var hours = currentTime.getHours();
        var minutes = currentTime.getMinutes();
        var seconds = currentTime.getSeconds();
        var localTime = hours + "%3A" + minutes + "%3A" + seconds;
        var localTimestamp = currentTime.getTime();

        //Saving page
        xmlHttpConnectionCopyData.open('GET', globalUrl+'services/saveCopyData.php?'+'URL='+url+'&snippet='+snippet+'&title='+title+'&localTimestamp='+localTimestamp+'&localTime='+localTime+'&localDate='+localDate, true);
        action = "";

        xmlHttpConnectionCopyData.onreadystatechange=function(){
            if (xmlHttpConnectionCopyData.readyState == 4 && xmlHttpConnectionCopyData.status == 200) {
                clearTimeout(xmlHttpTimeoutCopyData);
            }
        };

        xmlHttpConnectionCopyData.send(null);
        xmlHttpTimeoutCopyData = setTimeout(function(){
                                               xmlHttpConnectionCopyData.abort();
                                               clearTimeout(xmlHttpTimeoutCopyData);
                                               }
                                               ,3000);

//        document.getElementById('msgs').textContent = " Snippet Saved!";
//        setTimeout('cleanAlert()', 3000);
	}
};



//Function to collect highlighted passage from the page as a snippet.
function snip()
{
	checkConnectivity();
	if (loggedIn)
	{
		/*var snippet = document.commandDispatcher.focusedWindow.getSelection().toString();
		var url = window.content.document.location;
		url = encodeURIComponent(url);
		var title = encodeURIComponent(document.title);*/

		var snippet = document.commandDispatcher.focusedWindow.getSelection().toString().trim();
        if(snippet.length <= 0){
            return;
        }
        var url = gBrowser.selectedBrowser.currentURI.spec;
        url = encodeURIComponent(url);
        var title = document.title;
        var xmlHttpTimeoutSaveSnippet;
        var xmlHttpConnectionSaveSnippet = new XMLHttpRequest();

        //Capturing local time
        var currentTime = new Date();
        var month = currentTime.getMonth() + 1;
        var day = currentTime.getDate();
        var year = currentTime.getFullYear();
        var localDate = year + "%2F" + month + "%2F" + day;
        var hours = currentTime.getHours();
        var minutes = currentTime.getMinutes();
        var seconds = currentTime.getSeconds();
        var localTime = hours + "%3A" + minutes + "%3A" + seconds;
        var localTimestamp = currentTime.getTime();

        //Saving page
        xmlHttpConnectionSaveSnippet.open('GET', globalUrl+'services/saveSnippet.php?'+'URL='+url+'&snippet='+snippet+'&title='+title+'&localTimestamp='+localTimestamp+'&localTime='+localTime+'&localDate='+localDate, true);
        action = "";

        xmlHttpConnectionSaveSnippet.onreadystatechange=function(){
            if (xmlHttpConnectionSaveSnippet.readyState == 4 && xmlHttpConnectionSaveSnippet.status == 200) {
                    clearTimeout(xmlHttpTimeoutSaveSnippet);
                  }
            };

        xmlHttpConnectionSaveSnippet.send(null);
        xmlHttpTimeoutSaveSnippet = setTimeout(function(){
                                            xmlHttpConnectionSaveSnippet.abort();
                                            clearTimeout(xmlHttpTimeoutSaveSnippet);
                                        }
                                        ,3000);

        document.getElementById('msgs').textContent = " Snippet Saved!";
        setTimeout('cleanAlert()', 5000);
	}
};


function bookmark()
{
	checkConnectivity();
	if (loggedIn)
	{
		/*var snippet = document.commandDispatcher.focusedWindow.getSelection().toString();
         var url = window.content.document.location;
         url = encodeURIComponent(url);
         var title = encodeURIComponent(document.title);*/

        var url = gBrowser.selectedBrowser.currentURI.spec;
        url = encodeURIComponent(url);
        var title = document.title;
        var xmlHttpTimeoutSaveSnippet;
        var xmlHttpConnectionSaveSnippet = new XMLHttpRequest();

        //Capturing local time
        var currentTime = new Date();
        var month = currentTime.getMonth() + 1;
        var day = currentTime.getDate();
        var year = currentTime.getFullYear();
        var localDate = year + "%2F" + month + "%2F" + day;
        var hours = currentTime.getHours();
        var minutes = currentTime.getMinutes();
        var seconds = currentTime.getSeconds();
        var localTime = hours + "%3A" + minutes + "%3A" + seconds;
        var localTimestamp = currentTime.getTime();

        var targetURL = globalUrl+'services/saveBookmark.php?'+'page='+url+'&title='+title+'&localTimestamp='+localTimestamp+'&localTime='+localTime+'&localDate='+localDate;
        var w = window.open(targetURL,'Bookmark','resizable=yes,scrollbars=yes,width=640,height=480,left=600');

        //Saving page
//        xmlHttpConnectionSaveSnippet.open('GET', globalUrl+'services/saveBookmark.php?'+'URL='+url+'&title='+title+'&localTimestamp='+localTimestamp+'&localTime='+localTime+'&localDate='+localDate, true);
//        action = "";
//
//        xmlHttpConnectionSaveSnippet.onreadystatechange=function(){
//            if (xmlHttpConnectionSaveSnippet.readyState == 4 && xmlHttpConnectionSaveSnippet.status == 200) {
//                clearTimeout(xmlHttpTimeoutSaveSnippet);
//            }
//        };
//
//        xmlHttpConnectionSaveSnippet.send(null);
//        xmlHttpTimeoutSaveSnippet = setTimeout(function(){
//                                               xmlHttpConnectionSaveSnippet.abort();
//                                               clearTimeout(xmlHttpTimeoutSaveSnippet);
//                                               }
//                                               ,3000);
//
//        document.getElementById('msgs').textContent = " Snippet Saved!";
//        setTimeout('cleanAlert()', 3000);
	}
};



function instructions(){
    var url = globalUrl+"services/getInstructions.php";
    // var url = globalUrl+"services/getInstructions.php?fromtoolbar=true";
    loadURL(url);
    var actionReq = new XMLHttpRequest();
    actionReq.open('GET', globalUrl + "services/insertAction.php?action=ToolbarClickHelp&value=true&localTime=" + localTime() + "&localDate=" + localDate() + "&localTimestamp=" + localTimestamp());
    actionReq.send();
}
function workspace(){
  var url = globalUrl+"workspace";
  gBrowser.selectedTab = gBrowser.addTab(url);
  var actionReq = new XMLHttpRequest();
  actionReq.open('GET', globalUrl + "services/insertAction.php?action=ToolbarClickWorkspace&value=true&localTime=" + localTime() + "&localDate=" + localDate() + "&localTimestamp=" + localTimestamp());
  actionReq.send();
}

function cleanAlert()
{
	document.getElementById('msgs').textContent = "";
}

var connectionFlag = false;
var loggedIn = false;
var isExclusive = false;
var allowBrowsingFlag = false;
var sessionNumber = 0;

function checkConnectivity()
{
	var xmlHttpTimeout;
	if (isExclusive==false)
	{
     isExclusive = true;
     var xmlHttpConnection = new XMLHttpRequest();
     xmlHttpConnection.open('GET', globalUrl+'services/checkConnectionStatus.php', true);
     xmlHttpConnection.onreadystatechange=function(){
           if (xmlHttpConnection.readyState == 4 && xmlHttpConnection.status == 200) {
                 var serverResponse = xmlHttpConnection.responseText;
//               alert("Connection Status " + serverResponse);
                 if (serverResponse!=0)
                 {
					if (serverResponse!=-1) //If response == 1 then session active
					 {
                         loggedIn = true;
						 sessionNumber = serverResponse;
						 initializeToolbarSession();
					 }
                     else
					{					 //If response == -1 then NO session active
                         loggedIn = false;
						 initializeToolbarSession();
					}
                     xmlHttpConnection.abort();
                     clearTimeout(xmlHttpTimeout);
                     connectionFlag = true;
                     updateToolbarButtons();
                     isExclusive = false;
                 }
                 else
                 {
                     clearTimeout(xmlHttpTimeout);
                     serverDown();
                     xmlHttpConnection.abort();
                     isExclusive = false;
                 }
           }
     };

     xmlHttpConnection.send(null);
     xmlHttpTimeout = setTimeout(function (){
                                     serverDown();
                                     xmlHttpConnection.abort();
                                     clearTimeout(xmlHttpTimeout);
                                 },5000);
	}

	// Added 06/04/14
	else
	{
		setTimeout(checkConnectivity,10);

	}
};

function serverDown()
{
  /*
    connectionFlag = false;
    loggedIn = false;
    disableButtons(true);
    isExclusive = false;
  */
};


function disableButtons(value)
{
	document.getElementById('coagmentoConnectDisconnectButton').disabled = value;
	document.getElementById('coagmentoSnipButton').disabled = value;
  document.getElementById('coagmentoBookmarkButton').disabled = value;
	document.getElementById('coagmentoEditorButton').disabled = value;
	document.getElementById('coagmentoActiveTaskButton').disabled = value;
  document.getElementById('coagmentoInstructionsButton').disabled = value;
  document.getElementById('coagmentoContactButton').disabled = value;
  document.getElementById('coagmentoWorkspaceButton').disabled = value;

  //FIX: Always enable home button
  document.getElementById('coagmentoConnectDisconnectButton').disabled = false;
}




function hideButtons(value)
{
    document.getElementById('coagmentoSnipButton').hidden = value;
    document.getElementById('coagmentoBookmarkButton').hidden = value;
    document.getElementById('coagmentoWorkspaceButton').hidden = value;
    document.getElementById('toolbarseparatorWorkspace').hidden = value;
    document.getElementById('coagmentoEditorButton').hidden = value;
    document.getElementById('coagmentoActiveTaskButton').hidden = value;
    document.getElementById('coagmentoInstructionsButton').hidden = value;
    document.getElementById('toolbarseparatorSnip').hidden = value;
    document.getElementById('toolbarseparatorBookmark').hidden = value;
    document.getElementById('coagmentoContactButton').hidden = value;
    document.getElementById('toolbarseparatorContact').hidden = value;

    document.getElementById('toolbarseparatorEditor').hidden = value;
    document.getElementById('toolbarseparatorActiveTask').hidden = value;
    document.getElementById('toolbarseparatorInstructions').hidden = value;

    //Always show home button
    document.getElementById('coagmentoConnectDisconnectButton').hidden = false;
    document.getElementById('toolbarseparatorConnectDisconnect').hidden = false;
}



function initializeToolbarSession()
{
	if (loggedIn)
	{

        if(first && top.document.getElementById('viewSidebar').getAttribute('checked')){
            first = false;
            gBrowser.selectedTab = gBrowser.addTab(globalUrl+"workspace/");
        }
		if (sessionNumber==1)
		{
//            alert('initialize to true 1');
			googleURL = "https://www.google.com/";
            hideButtons(false);
		}
		else if (sessionNumber==2)
		{
//            alert('initialize to true 2');
            googleURL = "https://www.google.com/";
            hideButtons(true);
		}
	}
	else
	{
        first = true;
//        alert('NOT LOGGED IN!  HIDE!');
        hideButtons(true);

	}
}

function updateToolbarButtons()
{
  if (connectionFlag)
  {
	if (loggedIn)
    {
        document.getElementById("coagmentoConnectDisconnectButton").label = "Logout of Coagmento";
//        alert('logged in');
		if (allowBrowsingFlag){
			disableButtons(false);
        }
	}
    else
    {
//        alert('not logged in');
        document.getElementById("coagmentoConnectDisconnectButton").label = "Login to Coagmento";
    	disableButtons(true);
	}
  }
}

//Sidebar functions
function populateSidebar() {
    var sidebar = top.document.getElementById('sidebar');
    //sidebar.width = 500;
    var urlplace = globalUrl+"sidebar/loginOnSideBar.php";
	sidebar.setAttribute("src", urlplace);
//    	var sidebar = top.document.getElementById('sidebar');
//        var urlplace = globalUrl+"sidebar/sidebar.php";
//    	sidebar.setAttribute("src", urlplace);
}

function updateLoginStatus()
{
    checkConnectivity();
    updateToolbarButtons();
}


function logout()
{
	var xmlHttpTimeout;
	if (isExclusive==false)
	{
        isExclusive = true;
        var xmlHttpConnection = new XMLHttpRequest();
        xmlHttpConnection.open('GET', globalUrl+'logout.php', true);
        xmlHttpConnection.onreadystatechange=function(){
            if (xmlHttpConnection.readyState == 4 && xmlHttpConnection.status == 200) {
                var serverResponse = xmlHttpConnection.responseText;
                //               alert("Connection Status " + serverResponse);
                if (serverResponse!=0)
                {
					if (serverResponse==1) //If response == 1 then session active
                    {
                        loggedIn = false;
                        initializeToolbarSession();
                    }
                    xmlHttpConnection.abort();
                    clearTimeout(xmlHttpTimeout);
//                    updateToolbarButtons();
                    isExclusive = false;
                }
                else
                {
                    clearTimeout(xmlHttpTimeout);
                    serverDown();
                    xmlHttpConnection.abort();
                    isExclusive = false;
                }
            }
        };

        xmlHttpConnection.send(null);
        xmlHttpTimeout = setTimeout(function (){
                                    serverDown();
                                    xmlHttpConnection.abort();
                                    clearTimeout(xmlHttpTimeout);
                                    },5000);
	}

	// Added 06/04/14
	else
	{
		setTimeout(logout,10);

	}
};


var promptService = Components.classes["@mozilla.org/embedcomp/prompt-service;1"].getService(Components.interfaces.nsIPromptService);


//Change connection status from the toolbar
function changeConnectionStatus()
{
    if (loggedIn)
    {
        if(promptService.confirm(null, 'Coagmento', 'Are you sure you want to logout?'))
        {
            logout();
            var broadcaster = top.document.getElementById('viewSidebar');
            if (broadcaster.hasAttribute('checked'))
                toggleSidebar('viewSidebar',false);
            updateLoginStatus();
        }
    }
    else
    {
        toggleSidebar('viewSidebar',false);
        toggleSidebar('viewSidebar',true);
        populateSidebar();
    }
}




/***********************************************************************************************
 ***********************************************************************************************
 ***********************************************************************************************
 *                              			CLOSE ALL TABS
 ***********************************************************************************************
 ***********************************************************************************************
 */

/*
 *
 * CODE BELOW WAS ADAPTED FROM
 *
Title: Close All Tabs (Reloaded)
Author: Michael Grafl (https://addons.mozilla.org/en-US/firefox/user/5115653/)
Description: A toolbar button to close all open tabs. Improved and updated version of "Close All Tabs 1.1" (https://addons.mozilla.org/en/firefox/addon/2914).
License: Mozilla Public License Version 1.1, http://www.mozilla.org/MPL/
Version: 2.2.2
*/


// TODO: Key Shortcut

/* Note: CloseAllHelper has been loaded from common.js */
CloseAllButton = {

/* Install Button on the right end of the navigation bar. */
onLoad: function () {
	// If the completeInstall flag is true, the button has already been installed

},

/* Remove the event listeners. */
onUnload: function () {
	window.removeEventListener('load', CloseAllButton.onLoad, false);
	window.removeEventListener('unload', CloseAllButton.onUnload, false);
	CloseAllHelper.debug("unloading complete");
},

/* When the CloseAllTabs button is clicked, we try to close all tabs. */
runScript: function () {
	/*try {

	// Actually closing tabs...
	var lastTab = gBrowser.selectedTab;

	// NOTE: We cannot use gBrowser.removeAllTabsBut because the selected tab may be pinned (in which case the function would do nothing).
	//gBrowser.removeAllTabsBut(lastTab);
	if(gBrowser.warnAboutClosingTabs("AllBut", null, gBrowser.selectedTab._isProtected)) {
		var tabs  = gBrowser.mTabContainer.childNodes;
		for(var i=tabs.length-1; i >=0; --i) {
			if(tabs[i] != gBrowser.selectedTab && !tabs[i].pinned && !tabs[i]._isProtected) {
				gBrowser.removeTab(tabs[i]);
			}
		}
	}

	//loadURL(globalUrl+"index.php");

	/*var homePage = gHomeButton.getHomePage().split("|")[0];
	gBrowser.selectedTab = gBrowser.addTab(homePage);

	//Note: Do not close pinned tabs!
	//if(!lastTab.pinned) gBrowser.removeTab(lastTab);

	}catch(e) {alert("Error: " + e);}*/
  }

}
window.addEventListener('load', CloseAllButton.onLoad, false);
window.addEventListener('unload', CloseAllButton.onUnload, false);
