var CSPACE = (function(){
  var that = {};
  var all_tags = [];
  var lunr_index;
  var userID;
  that.init = function(PAGE,feed_data, at, uid){
    lunr_index = lunr(function () {
      this.field('title', {boost: 10})
      this.field('body', {boost: 5})
      this.field('url')
      this.ref('id')
    });
    userID = uid;
    window.lunr_index = lunr_index;
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
    var prev_search = null;
    var lunr_id = 0;
    for(var i = 0; i < feed_data.length; i++){
      var t = feed_data[i]["type"];
      var d = feed_data[i]["data"];
      lunr_id++;
      switch(t){
        case "bookmark":
          var ed = $.extend({}, d); //extended data
          var url = ed["url"];
          ed["pretty_url"] = url.length > 150 ? url.substring(0,150) + "..." : url;
          ed["pretty_date"] = prettyDate(ed["localDate"] + "T" + ed["localTime"]);
          ed["label"] = "Bookmark";
          ed["tags"] = ed["tagList"] ? ed["tagList"].split(",") : [];
          ed["all_tags"] = all_tags;
          ed["editable"] = ed["userID"] == userID;
          ed["lunr_id"] = lunr_id;

          //make searchable
          lunr_index.add({
            id: lunr_id,
            title: ed["title"],
            body: ed["note"],
            url: ed["url"]
          });
          var new_el = $(tmpl("bookmark_template", ed));
          root.append(new_el);
          if(!d["snippets"] || d["snippets"].length == 0){
            new_el.find(".bookmark-related").hide();
          } else {
            displayFeed(d["snippets"], $(new_el).find(".bookmark-snippets"));
          }
          break;
        case "page":
          var ed = $.extend({}, d); //extended data
          var url = ed["url"];
          ed["pretty_url"] = url.length > 150 ? url.substring(0,150) + "..." : url;
          ed["pretty_date"] = prettyDate(ed["localDate"] + "T" + ed["localTime"]);
          ed["label"] = "Page";
          ed["editable"] = ed["userID"] == userID;
          ed["lunr_id"] = lunr_id;
          root.append(tmpl("page_template", ed));
          lunr_index.add({
            id: lunr_id,
            title: ed["title"],
            url: ed["url"]
          });
          break;
        case "snippet":
          var ed = $.extend({}, d); //extended data
          ed["pretty_date"] = prettyDate(ed["localDate"] + "T" + ed["localTime"]);
          ed["shortened_snippet"] = ed["snippet"].length > 50 ? ed["snippet"].substring(0,50) + "..." : ed["snippet"];
          ed["label"] = "Snippet";
          ed["editable"] = ed["userID"] == userID;
          ed["lunr_id"] = lunr_id;
          root.append(tmpl("snippet_template", ed));
          lunr_index.add({
            id: lunr_id,
            title: ed["title"],
            body: ed["snippet"],
            url: ed["url"]
          });
          break;
        case "search":
          if(prev_search && prev_search["query"] == d["query"]){
            continue;
          }
          prev_search = d;
          var ed = $.extend({}, d); //extended data
          ed["pretty_date"] = prettyDate(ed["localDate"] + "T" + ed["localTime"]);
          ed["label"] = "Search";
          ed["editable"] = ed["userID"] == userID;
          ed["lunr_id"] = lunr_id;
          root.append(tmpl("query_template", ed));
          lunr_index.add({
            id: lunr_id,
            title: ed["title"],
            body: ed["query"]
          });
          break;
        case "source":
          var ed = $.extend({}, d); //extended data
          ed["label"] = "Source";
          ed["editable"] = ed["userID"] == userID;
          ed["lunr_id"] = lunr_id;
          var new_el = $(tmpl("source_template", ed));
          root.append(new_el);
          if(d["bookmarks"].length == 0){
            new_el.find(".bookmarks_heading").hide();
          } else {
            displayFeed(d["bookmarks"], $(new_el).find(".bookmarks"));
          }
          if(d["snippets"].length == 0){
            new_el.find(".snippets_heading").hide();
          } else {
            displayFeed(d["snippets"], $(new_el).find(".snippets"));
          }
          lunr_index.add({
            id: lunr_id,
            title: ed["source"]
          });
          break;
      }
    }
  }

  function initEventListeners(){
    $("#tag_filter").on("change", function(e){
      var url = $(this).val();
      window.location = url;
    });
    $("#sorting").on("change", function(e){
      var url = $(this).val();
      window.location = url;
    });
    $("#sorting_order").on("change", function(e){
      var url = $(this).val();
      window.location = url;
    });
    $("#searchbar_input").on("keyup", function(e){
      var text = $(this).val().trim();
      if(text == ""){
        $("#feed li").removeClass("search-hidden");
        return;
      }
      var results = lunr_index.search($(this).val());
      $("#feed li").addClass("search-hidden");
      for(var i = 0; i < results.length; i++){
        var res = results[i];
        $("#feed li[data-lunr=" + res.ref + "]").removeClass("search-hidden");
      }
    });
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
    $("#feed li.item-source .related").on("click", function(e){
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
    $("#feed li.item-bookmark .bookmark-related").on("click", function(e){
      var more = $(this).parents("li").find(".bookmark-related-section");
      var state = $(this).attr("data-state");
      if(state == "open"){
        $(this).html("Show related snippets");
        state = "closed";
        more.hide();
      } else {
        $(this).html("Hide related snippets");
        state = "open";
        more.show();
      }
      $(this).attr("data-state", state);
      e.preventDefault();
    });
    initDeleteListeners();
  }

  function initDeleteListeners(){
    $(".item-bookmark > .sub-right .delete").on("click", function(e){
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
          console.log("Bookmark deleted");
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
          console.log("Snippet deleted");
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
