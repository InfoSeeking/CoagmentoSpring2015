<html>
  <head>
    <title>Fun Scroll</title>
    <style type="text/css">
      #divTest{width:150px;height:200px;overflow:auto}
    </style>
    <script type="text/javascript">
      window.onload = function(){
        var strCook = document.cookie;
        if(strCook.indexOf("!~")!=0){
          var intS = strCook.indexOf("!~");
          var intE = strCook.indexOf("~!");
          var strPos = strCook.substring(intS+2,intE);
          document.getElementById("divTest").scrollTop = strPos;
        }
      }
      function SetDivPosition(){
        var intY = document.getElementById("divTest").scrollTop;
        document.title = intY;
        document.cookie = "yPos=!~" + intY + "~!";
      }
    </script>
  </head>
  <body>
    <div id="divTest" onscroll="SetDivPosition()">
      1<br/>1<br/>1<br/>1<br/>1<br/>1<br/>1<br/>1<br/>1<br/>
      1<br/>1<br/>1<br/>1<br/>1<br/>1<br/>1<br/>1<br/>1<br/>
      1<br/>1<br/>1<br/>1<br/>1<br/>1<br/>1<br/>1<br/>1<br/>
      1<br/>1<br/>1<br/>1<br/>1<br/>1<br/>1<br/>1<br/>1<br/>
      ERIC<br/>
      1<br/>1<br/>1<br/>1<br/>1<br/>1<br/>1<br/>1<br/>1<br/>
      1<br/>1<br/>1<br/>1<br/>1<br/>1<br/>1<br/>1<br/>1<br/>
      1<br/>1<br/>1<br/>1<br/>1<br/>1<br/>1<br/>1<br/>1<br/>
      1<br/>1<br/>1<br/>1<br/>1<br/>1<br/>1<br/>1<br/>1<br/>
    </div>
  </body>
</html>
