<html>
 <head>
  <title>ScrollIntoView() example</title>

  <script type="text/javascript">
    function showIt(elID)
    {
      var el = document.getElementById(elID);
      el.scrollIntoView(alignWithBottom);
    }
  </script>

 </head>
 <body>
  <div style="height: 10em; width: 30em; overflow: scroll;
              border: 1px solid blue;">
    <div style="height: 100px"></div>
    <p id="pToShow">The para to show<br/>The para to show<br/>The para to show<br/>The para to show<br/>The para to show<br/>The para to show<br/>The para to show<br/>The para to show<br/>The para to show<br/>The para to show<br/></p>
    <div style="height: 100px"></div>
  </div>
  <input type="button" value="Show para" 
   onclick="showIt('pToShow');">

 </body>
</html>
