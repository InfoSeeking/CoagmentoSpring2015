<?php
function gen_url($param){
  global $PAGE, $sorting, $sorting_order, $current_tag;
  $defaults = array(
  "page" => $PAGE,
  "bookmark_tag_filter" => $current_tag,
  "sorting" => $sorting,
  "sorting_order" => $sorting_order,
  "only_mine" => false
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
  <body class="pg_<?php echo $PAGE ?>">
    <div id="header_container">
      <header class="page_header">

        <hgroup class='left-side'>
          <img src="assets/img/clogo.png" alt="Coagmento Logo" />
          <h2>Welcome <?php echo $username ?></h2>
        </hgroup>
        <div class='left-side'>
          Questionaire deadlines will go here
        </div>
        <div class='right-side'>
          <?php require_once("../contributions.php"); ?>
        </div>
        <nav class='clear'>
          <ul>
            <li><a class="<?php if($PAGE == 'ALL') echo 'current ' ?>" href="?page=ALL">All</a></li>
            <!--<li><a class="<?php if($PAGE == 'PAGE_VISITS') echo 'current ' ?>" href="?page=PAGE_VISITS">Page Visits</a></li>-->
            <li><a class="<?php if($PAGE == 'BOOKMARKS') echo 'current ' ?>" href="?page=BOOKMARKS">Bookmarks</a></li>
            <li><a class="<?php if($PAGE == 'SNIPPETS') echo 'current ' ?>" href="?page=SNIPPETS">Snippets</a></li>
            <li><a class="<?php if($PAGE == 'SEARCHES') echo 'current ' ?>" href="?page=SEARCHES">Search History</a></li>
            <li><a class="<?php if($PAGE == 'SOURCES') echo 'current ' ?>" href="?page=SOURCES">Sources</a></li>
            <!-- <li><a class="<?php if($PAGE == 'CONTRIBUTIONS') echo 'current ' ?>" href="?page=CONTRIBUTIONS">User Contributions</a></li> -->
          </ul>
        </nav>
      </header>
    </div>

    <div id="container">
      <div class="left_col">
        <?php require_once("views/aside.php"); ?>
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
      <li data-lunr="<%= lunr_id %>" class="item-<%= label.toLowerCase() %>">
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

          <a href="#" class="bookmark-related">See related snippets</a>

          <% if(editable){ %>
          <div class="sub-right">
            <a href="#" class="delete" data-id="<%= bookmarkID %>">Delete</a>
            <a href="#" class="edit" data-state="closed">Edit</a>
          </div>
          <% } %>
        </div>
        <div class="bookmark-related-section">
          <h4>Related Snippets</h4>
          <div class="bookmark-snippets"></div>
        </div>
        <% if(editable){ %>
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
        <% } %>
      </li>
    </script>
    <script type="text/html" id="page_template">
      <li data-lunr="<%= lunr_id %>" class="item-<%= label.toLowerCase() %>">
        <div class="top">
          <span class="label <%= label.toLowerCase() %>"> <%= label %> </span>
          <span><a href="<%= url %>"><%= pretty_url %></a></span>
        </div>
        <div class="sub">
          <span class="added_by">Added by <b><%= username %></b></span>
          <span class="date"><%= pretty_date %></span>
          <div class="sub-right">
            <% if(editable){ %>
            <a class="delete" href="#" data-id="<%= pageID %>">Delete</a>
            <% } %>
          </div>
        </div>
      </li>
    </script>
    <script type="text/html" id="snippet_template">
      <li data-lunr="<%= lunr_id %>" class="item-<%= label.toLowerCase() %>">
        <div class="top">
          <span class="label <%= label.toLowerCase() %>"> <%= label %> </span>
          <a href="<%= url %>"><%= title %></a>
          <p class="preview"><%= snippet %></p>
        </div>
        <div class="sub">
          <span class="added_by">Added by <b><%= username %></b></span>
          <span class="date"><%= pretty_date %></span>
          <div class="sub-right">
            <% if(editable){ %>
            <a class="delete" href="#" data-id="<%= snippetID %>">Delete</a>
            <% } %>
          </div>
        </div>
      </li>
    </script>
    <script type="text/html" id="query_template">
      <li data-lunr="<%= lunr_id %>" class="item-<%= label.toLowerCase() %>">
        <div class="top">
          <span class="label <%= label.toLowerCase() %>"> <%= label %> </span>
          <a href="<%= url %>"><%= query %></a>
        </div>
        <div class="sub">
          <span class="added_by">Added by <b><%= username %></b></span>
          <span class="date"><%= pretty_date %></span>
          <div class="sub-right">
            <% if(editable){ %>
            <a class="delete" href="#" data-id="<%= queryID %>">Delete</a>
            <% } %>
          </div>
        </div>
      </li>
    </script>
    <script type="text/html" id="source_template">
      <li data-lunr="<%= lunr_id %>" class="item-<%= label.toLowerCase() %>">
        <div class="top">
          <span class="label <%= label.toLowerCase() %>"> <%= label %> </span>
          <span> <%= source %></span>
        </div>
        <div class="sub">
          <a href="#" class="related">See related bookmarks and snippets</a>
        </div>
        <div class="related-section">
          <h4 class="bookmarks_heading">Related Bookmarks</h4>
          <div class="bookmarks">
          </div>
          <h4 class="snippets_heading">Related Snippets</h4>
          <div class="snippets">
          </div>
        </div>
      </li>
    </script>
    <script src="assets/js/jquery-2.1.3.min.js"></script>
    <script src="assets/js/simple_template.js"></script>
    <script src="assets/js/utils.js"></script>
    <script src="assets/js/CSPACE.js"></script>
    <script src="assets/js/lunr.js"></script>
    <script type="text/javascript" src="../lib/select2/select2.full.min.js"></script>

    <script>
    (function(){
      <?php
      printf("CSPACE.init('%s',%s,%s,%s);", $PAGE,json_encode($feed_data),json_encode($tag_data), $userID);
      ?>

      $(".tag-input").select2({
    		tags: true
    	})

    }());
    </script>
  </body>
</html>