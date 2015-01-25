var CSPACE = (function(){
  var that = {};

  that.init = function(PAGE,feed_data){
    displayFeed(feed_data);
    initEventListeners();
  }

  function displayServiceError(msg){
    alert(msg + " Please contact developers for assistance.");
  }

  function displayFeed(feed_data){
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
        case "search":
          var ed = $.extend({}, d); //extended data
          ed["pretty_date"] = prettyDate(ed["localDate"] + "T" + ed["localTime"]);
          ed["label"] = "Query";
          feed.append(tmpl("query_template", ed));
          break;
      }
    }
  }

  function initEventListeners(){
    $("#feed li .showmore").on("click", function(e){
      var more = $(this).parent().parent().find(".more");
      var state = $(this).attr("data-state");
      if(state == "open"){
        $(this).html("Show details");
        state = "closed";
        more.hide();
      } else {
        $(this).html("Hide details");
        state = "open";
        more.show();
      }
      $(this).attr("data-state", state);
      e.preventDefault();
    });

    $(".item-bookmark .delete").on("click", function(e){
      var id = $(this).attr("data-id");
      var item = $(this).parents(".item-bookmark");
      //send ajax request
      $.ajax({
        url: "../api/index.php",
        data: {
          "entity": "Bookmark",
          "function":"Delete",
          "bookmarkID" : id
        },
        success: function(resp){
          item.fadeOut(500, function(){item.detach();});
        },
        error: function(){
          displayServiceError("Unknown error occurred when deleting bookmark.")
        }
      });
    });
  }
  return that;
}());
