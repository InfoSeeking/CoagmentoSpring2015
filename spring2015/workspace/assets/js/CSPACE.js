var CSPACE = (function(){
  var that = {};
  var all_tags = [];
  that.init = function(PAGE,feed_data, at){
    for(var i = 0; i < at.length; i++){
      all_tags.push(at[i].name);
    }
    displayFeed(feed_data, $("#feed"));
    initEventListeners();
  }

  function displayServiceError(msg){
    alert(msg + " Please contact developers for assistance.");
  }

  function displayFeed(feed_data, root){
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
          ed["all_tags"] = all_tags;
          root.append(tmpl("bookmark_template", ed));
          break;
        case "page":
          var ed = $.extend({}, d); //extended data
          var url = ed["url"];
          ed["pretty_url"] = url.length > 150 ? url.substring(0,150) + "..." : url;
          ed["pretty_date"] = prettyDate(ed["localDate"] + "T" + ed["localTime"]);
          ed["label"] = "Page";
          root.append(tmpl("page_template", ed));
          break;
        case "snippet":
          var ed = $.extend({}, d); //extended data
          ed["pretty_date"] = prettyDate(ed["localDate"] + "T" + ed["localTime"]);
          ed["shortened_snippet"] = ed["snippet"].length > 50 ? ed["snippet"].substring(0,50) + "..." : ed["snippet"];
          ed["label"] = "Snippet";
          root.append(tmpl("snippet_template", ed));
          break;
        case "search":
          var ed = $.extend({}, d); //extended data
          ed["pretty_date"] = prettyDate(ed["localDate"] + "T" + ed["localTime"]);
          ed["label"] = "Search";
          root.append(tmpl("query_template", ed));
          break;
        case "source":
          var ed = $.extend({}, d); //extended data
          ed["label"] = "Source";
          var new_el = $(tmpl("source_template", ed));
          root.append(new_el);
          displayFeed(d["bookmarks"], $(new_el).find(".bookmarks"));
          displayFeed(d["snippets"], $(new_el).find(".snippets"));
          break;
      }
    }
  }

  function initEventListeners(){
    $("#feed li.item-bookmark .save").on("click", function(e){
      e.preventDefault();
      var bookmarkID = $(this).attr("data-id");
      var form = $(this).parents("form");
      var tags = form.find("[name=tags]").val();
      var note = form.find("[name=note]").val();
      $.ajax({
        url: "../api/index.php",
        data: {
          "entity": "Bookmark",
          "function":"Update",
          "bookmarkID" : bookmarkID,
          "notes" : note,
          "tags" : tags
        },
        success: function(resp){
          form.find(".feedback").html("Bookmark saved!").show();
        },
        error: function(){
          displayServiceError("Unknown error occurred when deleting snippet.")
        }
      });
    })
    $("#feed li .edit").on("click", function(e){
      var more = $(this).parents("li").find(".more");
      var state = $(this).attr("data-state");
      if(state == "open"){
        $(this).html("Edit");
        state = "closed";
        more.hide();
      } else {
        $(this).html("Hide Edit");
        state = "open";
        more.show();
      }
      $(this).attr("data-state", state);
      e.preventDefault();
    });
    $("#feed li .related").on("click", function(e){
      var more = $(this).parents("li").find(".related-section");
      var state = $(this).attr("data-state");
      if(state == "open"){
        $(this).html("Show related bookmarks and snippets");
        state = "closed";
        more.hide();
      } else {
        $(this).html("Hide related bookmarks and snippets");
        state = "open";
        more.show();
      }
      $(this).attr("data-state", state);
      e.preventDefault();
    });
    initDeleteListeners();
  }

  function initDeleteListeners(){
    $(".item-bookmark .delete").on("click", function(e){
      e.preventDefault();
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

    $(".item-snippet .delete").on("click", function(e){
      e.preventDefault();
      var id = $(this).attr("data-id");
      var item = $(this).parents(".item-snippet");
      //send ajax request
      $.ajax({
        url: "../api/index.php",
        data: {
          "entity": "Snippet",
          "function":"Delete",
          "snippetID" : id
        },
        success: function(resp){
          item.fadeOut(500, function(){item.detach();});
        },
        error: function(){
          displayServiceError("Unknown error occurred when deleting snippet.")
        }
      });
    });

    $(".item-page .delete").on("click", function(e){
      e.preventDefault();
      var id = $(this).attr("data-id");
      var item = $(this).parents(".item-page");
      //send ajax request
      $.ajax({
        url: "../api/index.php",
        data: {
          "entity": "Page",
          "function":"Delete",
          "pageID" : id
        },
        success: function(resp){
          item.fadeOut(500, function(){item.detach();});
        },
        error: function(){
          displayServiceError("Unknown error occurred when deleting page.")
        }
      });
    });

    $(".item-search .delete").on("click", function(e){
      e.preventDefault();
      var id = $(this).attr("data-id");
      var item = $(this).parents(".item-search");
      //send ajax request
      $.ajax({
        url: "../api/index.php",
        data: {
          "entity": "Query",
          "function":"Delete",
          "queryID" : id
        },
        success: function(resp){
          item.fadeOut(500, function(){item.detach();});
        },
        error: function(){
          displayServiceError("Unknown error occurred when deleting query.")
        }
      });
    });
  }
  return that;
}());
