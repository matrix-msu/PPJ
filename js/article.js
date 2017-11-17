function constructArticle() {
    cur_page = 1;

    max_page = parseInt($(".pageNums").children().get(-1).textContent.trim());

    injectArticleFooter(issue);
    insertPageNums();


    $(".foot").each(function(){
        $(this).html("<br>" + $(this).html() + "<br>");
    });

    $("#page1").show();
    $(".prev").css("opacity", 0.3);

    // changeHeight(cur_page);

    $.fn.scrollView = function () {
        return this.each(function () {
            $('html, body').animate({
                scrollTop: $(this).offset().top - 160
            }, 350);
        });
    }

    $(".block").each(function () {
        if ($(this).css("text-align") == "center") {
            $(this).css("display", "block");
            $(this).css("margin-bottom", "-16px");
        }
    });

    $(".pageNums").children().each(function () {
        if (this.className != "prev" && this.className != "next") {
            $(this).css("opacity", 0.5);
        }
    });
    $(".pagination .pge1").css("opacity", 1);

    $(".next").click(function () {
        if (cur_page == max_page) {
            return;
        }
        prev_page = cur_page;
        ++cur_page;

        $("#page" + cur_page).show();
        $("#page" + (cur_page - 1)).hide();
        $(".pge" + cur_page).css("opacity", 1);
        $(".pge" + (cur_page - 1)).css("opacity", 0.5);

        if (cur_page == max_page) {
            $(".next").css("opacity", 0.3);
        }
        else if (cur_page == 2) {
            $(".prev").css("opacity", 1);
        }

        showPages(cur_page, prev_page)

    });
    $(".prev").click(function () {
        if (cur_page == 1) {
            return;
        }
        console.log(cur_page);
        prev_page = cur_page;
        --cur_page;

        $("#page" + cur_page).show();
        $("#page" + (cur_page + 1)).hide();
        $(".pge" + cur_page).css("opacity", 1);
        $(".pge" + (cur_page + 1)).css("opacity", 0.5);

        if (cur_page == 1) {
            $(".prev").css("opacity", 0.3);
        }
        else if (cur_page == (parseInt(max_page) - 1)) {
            $(".next").css("opacity", 1);
        }
        showPages(cur_page, prev_page);
    });

    $(".pageSelect").click(function () {
        if ($(this).text() == "... " || $(this).text() == cur_page) {
            return;
        }

        prev_page = cur_page;
        cur_page = $(this).text();
        $("#page" + cur_page).show();
        $(".pge" + cur_page).css("opacity", 1);
        $(".pge" + prev_page).css("opacity", 0.5);
        $("#page" + prev_page).hide();

        if (cur_page == max_page) {
            $(".next").css("opacity", 0.3);
            $(".prev").css("opacity", 1);
        }
        else if (cur_page == 1) {
            $(".prev").css("opacity", 0.3);
            $(".next").css("opacity", 1);
        }
        else {
            $(".next").css("opacity", 1);
            $(".prev").css("opacity", 1);
        }

        showPages(cur_page, prev_page);
    });

    // $(window).resize(function(){
    //     changeHeight(cur_page);
    // });
}


function changeHeight(cur_page) {
    var childHeight = $($("#page" + cur_page).children()[0]).height()
    if (childHeight > 965) {
        $(".fullWrap").css("height", childHeight + 145);
    }
    else {
        $(".fullWrap").css("height", 1110);
    }
}

function showPages(cur_page, prev_page) {
    for ($i = 0; $i < 3; $i++) {
        if (parseInt(prev_page) + $i != max_page && parseInt(prev_page) + $i != 1) {
            $(".pge" + (parseInt(prev_page) + $i)).hide();
        }
        if (parseInt(prev_page) - $i != 1 && parseInt(prev_page) - $i != max_page) {
            $(".pge" + (parseInt(prev_page) - $i)).hide();
        }
    }
    if (prev_page == 1 || prev_page == 2) {
        $(".pge4").hide();
        $(".pge5").hide();
    }

    else if (prev_page == max_page || prev_page == (parseInt(max_page) - 1)) {
        $(".pge" + (parseInt(max_page) - 3)).hide();
        $(".pge" + (parseInt(max_page) - 4)).hide();
    }

    for ($i = 0; $i < 3; $i++) {
        $(".pge" + (parseInt(cur_page) + $i)).show();
        $(".pge" + (parseInt(cur_page) - $i)).show();
    }
    if (cur_page == max_page) {
        $(".pge" + (parseInt(max_page) - 3)).show();
        $(".pge" + (parseInt(max_page) - 4)).show();
    }
    else if (cur_page == parseInt(max_page) - 1) {
        $(".pge" + (parseInt(max_page) - 4)).show();
    }
    else if (cur_page == 1) {
        $(".pge4").show();
        $(".pge5").show();
    }
    else if (cur_page == 2) {
        $(".pge5").show();
    }
    if (cur_page > 4) {
        $("#firstDot").show();
    }
    else {
        $("#firstDot").hide();
    }
    if (max_page - cur_page > 3) {
        $("#lastDot").show();
    }
    else {
        $("#lastDot").hide();
    }

    $(".fullWrap").scrollTop(0);

    // changeHeight(cur_page);
    $(".fullWrap").scrollView();
}

function injectArticleFooter(issue) {
    $(".main").append("<div class='articleFooter'></div>");

    if (issue) {
        var volumeNumber = extendNum(issue.Issue);

        $(".articleFooter").append(
            "<div class='info'>" +
            "<em>Public Philosophy Journal</em> &nbsp&nbsp&nbsp&nbsp| &nbsp&nbsp&nbsp&nbsp" +
            "Volume " + issue.Volume + "," + volumeNumber + "&nbsp&nbsp&nbsp&nbsp| &nbsp&nbsp&nbsp&nbsp" +
            issue.Period[0] + " " + issue.Year.year +
            "</div>"
        );
    }


}

function extendNum(num){
    num = num.split(" ");
    return " Number " + num[1];
}

function insertPageNums(){
    var pageNum = 1;
    $(".pages").each(function() {
        if (pageNum === 1){
            pageNum++;
            return;
        }
        $(this).find(".articleFooter").append("<div class='num'><b>" + pageNum++ + "</b></div>");
    })
}

