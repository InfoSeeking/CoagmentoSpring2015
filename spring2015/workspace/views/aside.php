<div class="searchbar">
  <input type="text" placeholder="Search" id="searchbar_input" />
</div>

<?php
if($PAGE == "BOOKMARKS"):
?>
<div id="bookmark_filters">
  <h4>Filter by tag</h4>
  <!-- <ul> -->
  <select onchange="location = this.options[this.selectedIndex].value;">
  <?php
    $all_param = array(
      "bookmark_tag_filter" => false,
      "page" => "BOOKMARKS"
    );
    printf("<option value='%s' %s>All Tags</option>", gen_url($all_param), $all_param["bookmark_tag_filter"] == $current_tag ? "selected" : "");
    foreach($tag_data as $tag){
      $param = array(
        "bookmark_tag_filter" => $tag["name"],
        "page" => "BOOKMARKS"
      );
      printf("<option value='%s' %s>", gen_url($param), $param["bookmark_tag_filter"] == $current_tag ? "selected" : "");
      printf("%s</option>", $tag["name"]);
      echo "</li>";
    }
    // printf("<li class='%s'><a href='%s'>All Tags</a></li>", $current_tag ? "" : "current ", gen_url($all_param));
    // foreach($tag_data as $tag){
    //   printf("<li class='%s'>", $tag["name"] == $current_tag ? "current " : " ");
    //   $param = array(
    //     "bookmark_tag_filter" => $tag["name"],
    //     "page" => "BOOKMARKS"
    //   );
    //   printf("<a href='%s'>%s</a>", gen_url($param), $tag["name"]);
    //   echo "</li>";
    // }
  ?>
  </select>
  <!-- </ul> -->
</div><!-- /#bookmark_filters -->
<?php
endif;
?>

<div class="sorting">
<?php
$has_sorting = false;
if($PAGE == "BOOKMARKS"):
  $has_sorting = true;
  $params = array(
    "page" => "BOOKMARKS",
    "sorting_order" => $sorting_order
  );
?>
<h4>Sort by</h4>
<select id="sorting">
  <?php
  $params["sorting"] = "timestamp";
  $params["sorting_order"] = "ASC";
  printf("<option value='%s' %s>Time saved [Most recent first]</option>", gen_url($params), $params["sorting"] == $sorting && $params["sorting_order"] == $sorting_order ? "selected" : "");
  $params["sorting_order"] = "DESC";
  printf("<option value='%s' %s>Time saved [Earliest first]</option>", gen_url($params), $params["sorting"] == $sorting && $params["sorting_order"] == $sorting_order ? "selected" : "");

  $params["sorting"] = "rating";
  $params["sorting_order"] = "ASC";
  printf("<option value='%s' %s>Rating [0 to 5]</option>", gen_url($params), $params["sorting"] == $sorting && $params["sorting_order"] == $sorting_order ? "selected" : "");
  $params["sorting_order"] = "DESC";
  printf("<option value='%s' %s>Rating [5 to 0]</option>", gen_url($params), $params["sorting"] == $sorting && $params["sorting_order"] == $sorting_order ? "selected" : "");

  $params["sorting"] = "title";
  $params["sorting_order"] = "ASC";
  printf("<option value='%s' %s>Page title [A to Z]</option>", gen_url($params), $params["sorting"] == $sorting && $params["sorting_order"] == $sorting_order ? "selected" : "");
  $params["sorting_order"] = "DESC";
  printf("<option value='%s' %s>Page title [Z to A]</option>", gen_url($params), $params["sorting"] == $sorting && $params["sorting_order"] == $sorting_order ? "selected" : "");
  ?>
</select>

<?php
elseif($PAGE == "SNIPPETS"):
  $has_sorting = true;
  $params = array(
    "page" => "SNIPPETS",
    "sorting_order" => $sorting_order
  );
?>
<h4>Sort by</h4>
<select id="sorting">
  <?php
  $params["sorting"] = "timestamp";
  $params["sorting_order"] = "DESC";
  printf("<option value='%s' %s>Time saved [Most recent first]</option>", gen_url($params), $params["sorting"] == $sorting && $params["sorting_order"] == $sorting_order ? "selected" : "");
  $params["sorting_order"] = "ASC";
  printf("<option value='%s' %s>Time saved [Earliest first]</option>", gen_url($params), $params["sorting"] == $sorting && $params["sorting_order"] == $sorting_order ? "selected" : "");

  $params["sorting"] = "snippet";
  $params["sorting_order"] = "ASC";
  printf("<option value='%s' %s>Snippet text [A to Z]</option>", gen_url($params), $params["sorting"] == $sorting && $params["sorting_order"] == $sorting_order ? "selected" : "");
  $params["sorting_order"] = "DESC";
  printf("<option value='%s' %s>Snippet text [Z to A]</option>", gen_url($params), $params["sorting"] == $sorting && $params["sorting_order"] == $sorting_order ? "selected" : "");
  ?>
</select>

<?php
elseif($PAGE == "SEARCHES"):
  $has_sorting = true;
  $params = array(
    "page" => "SEARCHES",
    "sorting_order" => $sorting_order
  );
?>
<h4>Sort by</h4>
<select id="sorting">
  <?php
  $params["sorting"] = "timestamp";
  $params["sorting_order"] = "ASC";
  printf("<option value='%s' %s>Time saved [Most recent first]</option>", gen_url($params), $params["sorting"] == $sorting && $params["sorting_order"] == $sorting_order ? "selected" : "");
  $params["sorting_order"] = "DESC";
  printf("<option value='%s' %s>Time saved [Earliest first]</option>", gen_url($params), $params["sorting"] == $sorting && $params["sorting_order"] == $sorting_order ? "selected" : "");

  $params["sorting"] = "query";
  $params["sorting_order"] = "ASC";
  printf("<option value='%s' %s>Search text [A to Z]</option>", gen_url($params), $params["sorting"] == $sorting && $params["sorting_order"] == $sorting_order ? "selected" : "");
  $params["sorting_order"] = "DESC";
  printf("<option value='%s' %s>Search text [Z to A]</option>", gen_url($params), $params["sorting"] == $sorting && $params["sorting_order"] == $sorting_order ? "selected" : "");
  ?>
</select>
<?php endif; ?>


<?php if($has_sorting): ?>
  <!-- <select id="sorting_order">
    <?php
    // $params = array(
    //   "page" => $PAGE,
    //   "sorting" => $sorting
    // );
    // $params["sorting_order"] = "DESC";
    // printf("<option value='%s' %s>Highest to lowest</option>", gen_url($params), $params["sorting_order"] == $sorting_order ? "selected" : "");
    // $params["sorting_order"] = "ASC";
    // printf("<option value='%s' %s>Lowest to highest</option>", gen_url($params), $params["sorting_order"] == $sorting_order ? "selected" : "");
    ?>
  </select> -->
<?php endif; ?>
</div>
