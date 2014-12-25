<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Coagmento</title>
<link rel="stylesheet" href="css/styles.css">

<style type="text/css">
/*margin and padding on body element
  can introduce errors in determining
  element position and are not recommended;
  we turn them off as a foundation for YUI
  CSS treatments. */
body {
	margin:0;
	padding:0;
}
</style>

<!-- for default tab skin, which includes tabview-core.css and skins/sam/tabview-skin.css -->
<link rel="stylesheet" type="text/css" href="yui/build/tabview/assets/skins/sam/tabview.css" />

<!-- utilities includes all dependencies for this example -->
<script type="text/javascript" src="yui/build/utilities/utilities.js"></script>
<script type="text/javascript" src="yui/build/tabview/tabview.js"></script>
<script type="text/javascript" src="../yui/build/utilities/utilities.js"></script> 

<script type="text/javascript" src="../yui/build/tabview/tabview-min.js"></script> 
<script src="http://us.js2.yimg.com/us.js.yimg.com/i/ydn/yuiweb/js/dpsyntax-min-2.js"></script>
<script type="text/javascript">

(function() {
    var myTabs = new YAHOO.widget.TabView("demo");    
    var url = location.href.split('#');
    if (url[1]) {
        //We have a hash
        var tabHash = url[1];
        var tabs = myTabs.get('tabs');
        for (var i = 0; i < tabs.length; i++) {
            if (tabs[i].get('href') == '#' + tabHash) {
                myTabs.set('activeIndex', i);
                break;
            }
        }
    }

    dp.SyntaxHighlighter.HighlightAll('code');
    YAHOO.util.Event.onAvailable('demoLinks', function() {
        YAHOO.util.Event.on('demoLinks', 'click', function(ev) {
            var tar = YAHOO.util.Event.getTarget(ev);
            if (tar.tagName.toLowerCase() == 'a') {
                var hash = tar.getAttribute('href', 2);
                YAHOO.util.Dom.get('demoForm').setAttribute('action', 'sidebar.php' + hash);
                YAHOO.util.Dom.get('demoForm').submit();
            }
        });
    });
})()
</script>
</head>

<body class="yui-skin-sam">
	<div id="demo" class="yui-navset">
		<ul class="yui-nav">
			<li class="selected"><a href="#tab1"><em>Chat</em></a></li>
			<li><a href="#tab2"><em>Results</em></a></li>
			<li><a href="#tab3"><em>Queries</em></a></li>
		</ul>          
	</div>
	<div>
		Something goes here.
	</div>
	<div style="display: none">
		Something else here.
	</div>
</body>
</html>
  