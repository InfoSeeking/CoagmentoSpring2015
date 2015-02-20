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
    <title>Coagmento Workspace</title>
    <link type="text/css" href="assets/css/styles.css?v2" rel="stylesheet" />
    <style></style>
    <link href="../lib/select2/select2.css" rel="stylesheet" type="text/css" />

  </head>
  <body>
    <div id="container">
      <header class="page_header">
        <hgroup>
          <h1>Coagmento Workspace</h1>
          <h2>Welcome <?php echo $username ?></h2>
        </hgroup>
        <nav>
          <ul>
            <li><a href="?page=ALL">All</a></li>
            <!--<li><a href="?page=PAGE_VISITS">Page Visits</a></li>-->
            <li><a href="?page=BOOKMARKS">Bookmarks</a></li>
            <li><a href="?page=SNIPPETS">Snippets</a></li>
            <li><a href="?page=SEARCHES">Search History</a></li>
            <li><a href="?page=SOURCES">Sources</a></li>
            <li><a href="?page=CONTRIBUTIONS">User Contributions</a></li>
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
        <?php
        if($PAGE == "CONTRIBUTIONS"){
          require_once("../contributions.php");
        }
        ?>
      </div>
      <br class="clear" />
    </div>
    <script type="text/html" id="bookmark_template">
      <li class="item-<%= label.toLowerCase() %>">
        <div class="top">
          <div>
            <span class="label <%= label.toLowerCase() %>"> <%= label %> </span>
            <span><a href="<%= url %>"><%= title %></a></span>
            <% if(tags.length > 0){ %>
              <div class="tagList">
              <b>Tags:</b>
              <% for(var i = 0; i < tags.length; i++){ %>
                <span class="tag"><%= tags[i] %></span>
              <% } %>
              </div>
            <% } %>
          </div>
          <% if(note) { %>
          <p><b>Notes:</b> <%= note %> </p>
          <% } %>
          <% if(rating > 0) { %>
            <p><b>Rating:</b> <span class="rating"><%= rating %>/5</span></p>
          <% } %>
        </div><!--/top-->
        <div class="sub">
          <span class="added_by">Added by <b><%= username %></b></span>
          <span class="date"><%= pretty_date %></span>
          <div class="sub-right">
            <a href="#" class="delete" data-id="<%= bookmarkID %>">Delete</a>
            <a href="#" class="edit" data-state="closed">Edit</a>
          </div>
        </div>
        <div class="more">
          <form>
            <p class="feedback"></p>
            <label>Tags (add tags with a comma)</label>
            <div class="row">
              <select name="tags" multiple="multiple" class="tag-input">
                <% for(var i = 0; i < tags.length; i++){ %>
                  <option selected value="<%= tags[i] %>"><%= tags[i] %></span>
                <% } %>
              </select>
            </div>
            <div class="row">
              <label>Notes</label><br/>
              <textarea name="note"><%= note %></textarea>
            </div>
            <a href="#" class="save" data-id="<%= bookmarkID %>">Save Changes</a>
          </form>
        </div>
      </li>
    </script>
    <script type="text/html" id="page_template">

      <li class="item-<%= label.toLowerCase() %>">
        <div class="top">
          <span class="label <%= label.toLowerCase() %>"> <%= label %> </span>
          <span><a href="<%= url %>"><%= pretty_url %></a></span>
        </div>
        <div class="sub">
          <span class="added_by">Added by <b><%= username %></b></span>
          <span class="date"><%= pretty_date %></span>
          <div class="sub-right">
            <a class="delete" data-id="<%= pageID %>">Delete</a>
          </div>
        </div>
      </li>
    </script>
    <script type="text/html" id="snippet_template">
      <li class="item-<%= label.toLowerCase() %>">
        <div class="top">
          <span class="label <%= label.toLowerCase() %>"> <%= label %> </span>
          <a href="<%= url %>"><%= title %></a>
          <p class="preview"><%= snippet %></p>
        </div>
        <div class="sub">
          <span class="added_by">Added by <b><%= username %></b></span>
          <span class="date"><%= pretty_date %></span>
          <div class="sub-right">
            <a class="delete" data-id="<%= snippetID %>">Delete</a>
          </div>
        </div>
      </li>
    </script>
    <script type="text/html" id="query_template">
      <li class="item-<%= label.toLowerCase() %>">
        <div class="top">
          <span class="label <%= label.toLowerCase() %>"> <%= label %> </span>
          <a href="<%= url %>"><%= query %></a>
        </div>
        <div class="sub">
          <span class="added_by">Added by <b><%= username %></b></span>
          <span class="date"><%= pretty_date %></span>
          <div class="sub-right">
            <a class="delete" data-id="<%= queryID %>">Delete</a>
          </div>
        </div>
      </li>
    </script>
    <script type="text/html" id="source_template">
      <li class="item-<%= label.toLowerCase() %>">
        <div class="top">
          <span class="label <%= label.toLowerCase() %>"> <%= label %> </span>
          <span> <%= source %></span>
        </div>
        <div class="sub">
          <a class="related">See related bookmarks and snippets</a>
        </div>
        <div class="related-section">
          <h4>Related Bookmarks</h4>
          <div class="bookmarks">
          </div>
          <h4>Related Snippets</h4>
          <div class="snippets">
          </div>
        </div>
      </li>
    </script>
    <script src="assets/js/jquery-2.1.3.min.js"></script>
    <script src="assets/js/simple_template.js"></script>
    <script src="assets/js/utils.js"></script>
    <script src="assets/js/CSPACE.js"></script>
    <script type="text/javascript" src="../lib/select2/select2.full.min.js"></script>

    <script>
    (function(){
      <?php
      printf("CSPACE.init('%s',%s,%s);", $PAGE,json_encode($feed_data),json_encode($tag_data));
      ?>

      $(".tag-input").select2({
    		tags: true
    	})
    }());
    </script>
  </body>
</html>
