<?php
# Find the pointer to self
$self = $_SERVER['PHP_SELF'];

# The hyperlinks created here contains information about what to display
# This includes information about page number as well as the field to sort
# Print 'previous' link only if we're not on page one
if ($pageNum > 1)
{
    $page = $pageNum - 1;
    $prev = " <a href=\"$self?cid=$cid&source=$source&qid=$qid&page=$page&sortby=$fieldToSort\">[Prev]</a> ";
    $first = " <a href=\"$self?cid=$cid&source=$source&qid=$qid&page=1&sortby=$fieldToSort\">[First Page]</a> ";
} 
else
{
  $prev  = ' [Prev] ';       # If we're on first page, don't hyperlink [Prev]
  $first = ' [First Page] '; # Also, don't hyperlink [First Page]
}

# Print 'next' link only if we're not on the last page
if ($pageNum < $maxPage)
{
  $page = $pageNum + 1;
  $next = " <a href=\"$self?cid=$cid&source=$source&qid=$qid&page=$page&sortby=$fieldToSort\">[Next]</a> ";
  $last = " <a href=\"$self?cid=$cid&source=$source&qid=$qid&page=$maxPage&sortby=$fieldToSort\">[Last Page]</a> ";
} 
else
{
  $next = ' [Next] ';      # If we're on last page, don't hyperlink [Next]
  $last = ' [Last Page] '; # Also, don't hyperlink [Last Page]
}

# Print the page navigation link
echo $first . $prev . " Showing page <strong>$pageNum</strong> of <strong>$maxPage</strong> pages " . $next . $last;
?>
