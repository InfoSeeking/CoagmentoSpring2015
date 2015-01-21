<html>
<head>
  <title>Bookmark</title>
  <link href="../styles.css" rel="stylesheet" type="text/css" />
  <script src="../lib/jquery-2.1.3.min.js"></script>
  <link href="../lib/select2/select2.css" rel="stylesheet" type="text/css" />
  <script src="../lib/select2/select2.full.min.js"></script>
  <style>
  #tag-input {
    width: 500px;
  }
  </style>
</head>
  <body class="body" onload="document.f.annotation.focus();">
    <br/><center>
    <form name="f" action="saveBookmarkAux.php" method=POST>
      <table class="body" width=90%>
        <tr><th>Bookmark the following page: <a href="<?php echo $originalURL ?>"><?php echo $title ?></a><br/><br/></th></tr>
        <tr><td align=center><em>What is useful about this source? How would you use it in writing your paper?</em><br/><textarea cols=35 rows=6 name="annotation"></textarea><input type="hidden" name="originalURL" value="<?php echo $originalURL ?>"/><input type="hidden" name="source" value="<?php echo $url ?>"/><input type="hidden" name="title" value="<?php echo $title ?>"/><input type="hidden" name="site" value="<?php echo $site ?>"/><input type="hidden" name="queryString" value="<?php echo $queryString ?>"/>'</td></tr>
        <input type="hidden" name="localDate" value="<?php echo $localDate ?>"/>
        <input type="hidden" name="localTime" value="<?php echo $localTime ?>"/>
        <input type="hidden" name="localTimestamp" value="<?php echo $localTimestamp ?>"/>
        <tr><td align=center><br>How good is this page? Rate it:</td></tr></table>
          <table><tr><td><input type="radio" name="rating" value="1"></td>
            <td><input type="radio" name="rating" value="2"></td>
            <td><input type="radio" name="rating" value="3"></td>
            <td><input type="radio" name="rating" value="4"></td>
            <td><input type="radio" name="rating" value="5"></td></tr>
            <tr align=center><td>1</td><td>2</td><td>3</td><td>4</td><td>5</td></tr>
          </table>

          <label>Add tags (separate with comma)</label>
          <select name="tags[]" id="tag-input" multiple="multiple">
            <?php
            //show all user tags
            ?>
          </select>

          <table>
            <tr>
              <td align=center><br><input type="submit" value="Save" /> <input type="button" value="Cancel" onclick="window.close();" /></td>
              </tr>
          </table>

        </table>
      </form>

      <script>
        $("#tag-input").select2({
          tags: true,
          tokenSeparators: [',']
        });
      </script>
    </body>
</html>
