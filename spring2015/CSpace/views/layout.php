<html>
  <head>
    <title>CSpace - Coagmento</title>
    <style>
    *{
      padding: 0;
      margin: 0;
      font-family: "Open Sans";
    }
    a{
      color: black;
    }
    #container{
      width: 800px;
      margin: 10px auto;
    }
    .page_header nav ul{
      margin-bottom: 20px;
      border-bottom: 1px black solid;
    }
    .page_header nav li{
      display: inline-block;
    }
    .page_header nav li a{
      display: inline-block;
      padding: 1px 10px;
      text-decoration: none;
    }
    .page_header nav li a:hover{
      text-decoration: underline;
    }
    ul{
      list-style-type: none;
    }
    .more .top{
      position: relative;
    }
    .more .close{
      position: absolute;
      top: 0px;
      right: 0px;
      text-decoration: none;
    }
    .more .close:hover{
      text-decoration: underline;
    }
    #feed li .sub{
      font-size: 14px;
      position: relative;
    }
    #feed li .showmore{
      position: absolute;
      bottom: 0px;
      right: 0px;
      font-size: 14px;
    }
    #feed li{
      padding: 10px;
      position: relative;
    }
    #feed li:hover{
      /*background: #D6FFDA;*/
    }
    #feed li .showmore{
      text-decoration: none;
    }
    #feed li .showmore:hover{
      text-decoration: underline;
    }
    .more{
      margin-top: 15px;
      background: rgba(0,0,0,.1);
      font-size: 14px;
      display: none;
      padding: 10px;

    }
    .label{
      padding: 2px 4px;
      border-radius: 5px;
      font-size: 10px;
      margin-right: 10px;
    }
    .label.bookmark{
      background: #FFF15C;
    }
    .label.page{
      background: #FF5C5C;
    }
    .label.snippet{
      background: #40FF59;
    }
    .clear{
      clear: both;
    }
    .left_col{
      float: left;
      width: 20%;
    }
    .right_col{
      width: 80%;
      float: right;
    }
    .item-snippet .preview{
      font-size: 14px;
    }
    .item-bookmark .tag{
      border: 1px black solid;
      border-radius: 3px;
      padding: 1px 3px;
      font-size: 12px;
      margin-left: 5px;
    }
    </style>
  </head>
  <body>
    <div id="container">
      <header class="page_header">
        <h1>CSpace</h1>
        <nav>
          <ul>
            <li><a href="?page=ALL">All</a></li>
            <li><a href="?page=PAGE_VISITS">Page Visits</a></li>
            <li><a href="?page=BOOKMARKS">Bookmarks</a></li>
            <li><a href="?page=SNIPPETS">Snippets</a></li>
            <li><a href="?page=SEARCHES">Searches</a></li>
          </ul>
        </nav>
      </header>
      <div class="left_col">
        Here be filters
      </div>
      <div class="right_col">
        <ul id="feed"></ul>
      </div>
      <br class="clear" />
    </div>
    <script type="text/html" id="bookmark_template">
      <li class="item-<%= label.toLowerCase() %>">
        <span class="label <%= label.toLowerCase() %>"> <%= label %> </span>
        <span><a href="<%= url %>"><%= pretty_url %></a></span>
        <div class="tagList">
        <% if(tags.length > 0){ %>
          Tags:
          <% for(var i = 0; i < tags.length; i++){ %>
            <span class="tag"><%= tags[i] %></span>
          <% } %>
        </div>
        <% } %>
        <div class="sub">
          <span class="added_by">Added by <b><%= username %></b></span>
          <span class="date"><%= pretty_date %></span>
          <a href="#" class="showmore">Show more</a>
        </div>

        <div class="more">
          <div class="top">
            <a href="#" class="close">Close</a>
          </div>
          <h4>Notes</h4>
          <%= note || "No note" %>
          <br/>
          <button>Edit</button>
          <button>Delete</button>
        </div>
      </li>
    </script>
    <script type="text/html" id="page_template">
      <li class="item-<%= label.toLowerCase() %>">
        <span class="label <%= label.toLowerCase() %>"> <%= label %> </span>
        <span><a href="<%= url %>"><%= pretty_url %></a></span>
        <div class="sub">
          <span class="added_by">Added by <b><%= username %></b></span>
          <span class="date"><%= pretty_date %></span>
          <a href="#" class="showmore">Show more</a>
        </div>

        <div class="more">
          <div class="top">
            <a href="#" class="close">Close</a>
          </div>
          <button>Edit</button>
          <button>Delete</button>
        </div>
      </li>
    </script>
    <script type="text/html" id="snippet_template">
      <li class="item-<%= label.toLowerCase() %>">
        <span class="label <%= label.toLowerCase() %>"> <%= label %> </span>
        <span><%= title %></span>
        <p class="preview"><%= shortened_snippet %></p>
        <div class="sub">
          <span class="added_by">Added by <b><%= username %></b></span>
          <span class="date"><%= pretty_date %></span>
          <a href="#" class="showmore">Show more</a>
        </div>

        <div class="more">
          <div class="top">
            <a href="#" class="close">Close</a>
          </div>
          <button>Edit</button>
          <button>Delete</button>
        </div>
      </li>
    </script>
    <script src="assets/js/jquery-2.1.3.min.js"></script>
    <script src="assets/js/jquery.loadTemplate-1.4.5.min.js"></script>
    <script src="assets/js/simple_template.js"></script>
    <script src="assets/js/utils.js"></script>

    <script>
    (function(){

      <?php
      printf("var PAGE = '%s';", $PAGE);
      printf("var feed_data = %s;" , json_encode($feed_data));
      ?>

      var feed = $("#feed");
      //display data
      for(var i = 0; i < feed_data.length; i++){
        var t = feed_data[i]["type"];
        var d = feed_data[i]["data"];
        switch(t){
          case "bookmark":
            var ed = $.extend({}, d); //extended data
            var url = ed["url"];
            ed["pretty_url"] = url.length > 150 ? url.substring(0,150) + "..." : url;
            ed["pretty_date"] = prettyDate(ed["localDate"] + "T" + ed["localTime"]);
            ed["label"] = "Bookmark";
            ed["tags"] = ed["tagList"] ? ed["tagList"].split(",") : [];
            feed.append(tmpl("bookmark_template", ed));
            break;
          case "page":
            var ed = $.extend({}, d); //extended data
            var url = ed["url"];
            ed["pretty_url"] = url.length > 150 ? url.substring(0,150) + "..." : url;
            ed["pretty_date"] = prettyDate(ed["localDate"] + "T" + ed["localTime"]);
            ed["label"] = "Page";
            feed.append(tmpl("page_template", ed));
            break;
          case "snippet":
            var ed = $.extend({}, d); //extended data
            ed["pretty_date"] = prettyDate(ed["localDate"] + "T" + ed["localTime"]);
            ed["shortened_snippet"] = ed["snippet"].length > 50 ? ed["snippet"].substring(0,50) + "..." : ed["snippet"];
            ed["label"] = "Snippet";
            feed.append(tmpl("snippet_template", ed));
            break;
        }
      }

      $("#feed li .showmore").on("click", function(e){
        //show more
        e.preventDefault();
        $(this).parent().parent().find(".more").show();
      });
      $(".more .close").on("click", function(e){
        $(this).parents(".more").hide();
      })
    }());
    </script>
  </body>
</html>
