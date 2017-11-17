$(document).ready(function() {
  var container = $('body');

  $("#article_dropdown").on("click", function(e) {
    e.preventDefault();
    var scrollTo = $('#article-header');

    // Or you can animate the scrolling:
    container.animate({
      scrollTop: scrollTo.offset().top - 190
    }, 1000);
  });
  $("#image_dropdown").on("click", function(e) {
    e.preventDefault();
    var scrollTo = $('#images');

    // Or you can animate the scrolling:
    container.animate({
      scrollTop: scrollTo.offset().top - 190
    }, 1000);
  });
  $("#audio_dropdown").on("click", function(e) {
    e.preventDefault();
    var scrollTo = $('#audios');

    // Or you can animate the scrolling:
    container.animate({
      scrollTop: scrollTo.offset().top - 190
    }, 1000);
  });
  $("#video_dropdown").on("click", function(e) {
    e.preventDefault();
    var scrollTo = $('#videos');

    // Or you can animate the scrolling:
    container.animate({
      scrollTop: scrollTo.offset().top - 190
    }, 1000);
  });
  $("#editors_link").on("click", function(e) {
    e.preventDefault();
    var scrollTo = $('#editors');

    // Or you can animate the scrolling:
    container.animate({
      scrollTop: scrollTo.offset().top - 190
    }, 1000);
  });
  $("#introduction_link").on("click", function(e) {
    e.preventDefault();
    var scrollTo = $('#intro');

    // Or you can animate the scrolling:
    container.animate({
      scrollTop: scrollTo.offset().top - 190
    }, 1000);
  });
    
    $(".Search").on("click",function(e){
        console.log("hello");
       $(".boxSearch").css("display","block");
       $(".searchText").css("display","none");
       $(".searchIcon").css("padding-left","104px");
    });

  $(window).scroll(function() {
    if ($("#images").length != 0 && isScrolledIntoView($('#images'))) {
      $(".sidebar-text").removeClass("active");
      $('#image_dropdown').addClass("active");
    }
    if ($("#videos").length != 0 && isScrolledIntoView($('#videos'))) {
      $(".sidebar-text").removeClass("active");
      $('#video_dropdown').addClass("active");
    }
    if ($("#audios").length != 0 && isScrolledIntoView($('#audios'))) {
      $(".sidebar-text").removeClass("active");
      $('#audio_dropdown').addClass("active");
    }
    if ($("#article-header").length != 0 && isScrolledIntoView($('#article-header'))) {
      $(".sidebar-text").removeClass("active");
      $('#article_dropdown').addClass("active");
    }
    if ($("#intro").length != 0 && isScrolledIntoView($('#intro'))) {
      $(".sidebar-text").removeClass("active");
      $('#introduction_link').addClass("active");
    }
    if ($("#editors").length != 0 && isScrolledIntoView($('#editors'))) {
      $(".sidebar-text").removeClass("active");
      $('#editors_link').addClass("active");
    }
    if ($(window).scrollTop() + $(window).height() == $(document).height()) {
      //$("aside").fadeOut("fast");
      $("aside").hide();
    } else {
      //$("aside").fadeIn("fast");
      $("aside").show();
    }
  });
});

function isScrolledIntoView(elem) {
  var docViewTop = $(window).scrollTop();
  var docViewBottom = docViewTop + $(window).height();
  var elemTop = $(elem).offset().top;
  var elemBottom = elemTop + $(elem).height();
  return ((elemBottom >= docViewTop) && (elemTop <= docViewBottom) && (elemBottom <= docViewBottom) && (elemTop >= docViewTop));
}
