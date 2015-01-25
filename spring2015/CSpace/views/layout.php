<?php
function gen_url($param){
  $defaults = array(
  "page" => "ALL",
  "bookmark_tag_filter" => "",
  "sorting" => ""
  );
  $param = array_merge($defaults, $param);
  return "?" . http_build_query($param);
}
?>
<html>
  <head>
    <title>CSpace - Coagmento</title>
    <link type="text/css" href="assets/css/styles.css?v2" rel="stylesheet" />
    <style></style>
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
        <?php
        if($PAGE == "BOOKMARKS"):
        ?>
        <div id="bookmark_filters">
          <h4>Filter by tag</h4>
          <ul>
          <?php
            foreach($tag_data as $tag){
              echo "<li>";
              $param = array(
                "bookmark_tag_filter" => $tag["name"],
                "page" => "BOOKMARKS"
              );
              printf("<a href='%s'>%s</a>", gen_url($param), $tag["name"]);
              echo "</li>";
            }
          ?>
          </ul>
        </div><!-- /#bookmark_filters -->
        <?php
        endif;
        ?>
        <div class="sorting">
        </div>
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
        <% if(tags.length > 0){ %>
          <div class="tagList">
          Tags:
          <% for(var i = 0; i < tags.length; i++){ %>
            <span class="tag"><%= tags[i] %></span>
          <% } %>
          </div>
        <% } %>

        <div class="sub">
          <span class="added_by">Added by <b><%= username %></b></span>
          <span class="date"><%= pretty_date %></span>
          <a href="#" class="showmore" data-state="closed">Show details</a>
        </div>

        <div class="more">
          <% if(rating > 0) { %>
            <h4>Rating</h4>
            <span class="rating"><%= rating %>/5</span>
          <% } %>
          <h4>Notes</h4>
          <%= note || "No note" %>
          <br/>
          <button>Edit</button>
          <button class="delete" data-id="<%= bookmarkID %>">Delete</button>
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
          <a href="#" class="showmore" data-state="closed">Show details</a>
        </div>

        <div class="more">
          <button class="delete" data-id="<%= pageID %>">Delete</button>
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
          <a href="#" class="showmore" data-state="closed">Show details</a>
        </div>

        <div class="more">
          <button>Edit</button>
          <button class="delete" data-id="<%= snippetID %>">Delete</button>
        </div>
      </li>
    </script>
    <script type="text/html" id="query_template">
      <li class="item-<%= label.toLowerCase() %>">
        <span class="label <%= label.toLowerCase() %>"> <%= label %> </span>
        <span><%= query %></span>
        <div class="sub">
          <span class="added_by">Added by <b><%= username %></b></span>
          <span class="date"><%= pretty_date %></span>
          <a href="#" class="showmore" data-state="closed">Show details</a>
        </div>

        <div class="more">
          <button class="delete" data-id="<%= queryID %>">Delete</button>
        </div>
      </li>
    </script>
    <script src="assets/js/jquery-2.1.3.min.js"></script>
    <script src="assets/js/simple_template.js"></script>
    <script src="assets/js/utils.js"></script>
    <script src="assets/js/CSPACE.js"></script>

    <script>
    (function(){
      <?php
      printf("CSPACE.init('%s',%s);", $PAGE,json_encode($feed_data));
      ?>
    }());
    </script>
  </body>
</html>
