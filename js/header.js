$(function () {
		
    //mobile menu functionality
    $(".mobileIco").click(function() {
        $(this).toggleClass("active");
        $("nav#mainNav").toggle("slide", { direction: "right"} );
        $("body").toggleClass("noOverflow");
        if ($(".mobileIco").hasClass("active")) {
            $("#main, a").click(function () {
                $(".mobileIco").removeClass("active");
                $("nav#mainNav").hide("slide", { direction: "right"} );
                $("body").removeClass("noOverflow");
            });
        }
    });


    // SumoSelects
    $("#originalFormat").SumoSelect();
    $("#dateDigital").SumoSelect();
    $(".userOptions").SumoSelect();


    //// Re-directs user, based on option selected ////
    $(".userOptions").change( function () {
        if ($(this).val() == 'invite') {
            window.location =  $(location).attr('pathname') + "/invite/";
        }

        else if ($(this).val() == 'keywords')  {
            window.location =  $(location).attr('pathname') + "/keywords/";
        }

        else if ($(this).val() == 'email')  {
            window.location =  $(location).attr('pathname') + "/email/";
        }

        else if ($(this).val() == 'permissions')  {
            window.location =  $(location).attr('pathname') + "/permissions/";
        }

        else if ($(this).val() == 'terms')  {
            window.location =  $(location).attr('pathname') + "/terms-and-conditions//";
        }

        else if ($(this).val() == 'profile')  {
            window.location =  $(location).attr('pathname') + "/profile-edit/";
        }

        else if ($(this).val() == 'logout')  {
            $.ajax({
                type: "POST",
                url: BASE_URL+"wp-content/themes/Zukra/ajax/logout.php",
                success: function() { window.location.replace(BASE_URL); }
            });
        }
    });


    //// Top bar on mobile ////
    $(document).scroll( function() {
        // If using mobile device, hide top bar on scroll
        if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
            $("#topbar").css( "visibility", "hidden" );

            // Show top bar, if at top of page
            if( $(document).scrollTop() <= 150 ) {
                $("#topbar").css( "visibility", "visible" );
            }
        }
    });


    //sticky header jQuery
    var headerHeight = $("header").height();

    var stickyNavTop = $('header').offset().top;

    var stickyNav = function(){
    var scrollTop = $(window).scrollTop();

    if (scrollTop > stickyNavTop) {
        $('header').addClass('sticky');
        //smother scrolling with main content area
        if ($('.videoWrap').length > 0) {
            $(".videoWrap").css("margin-top", headerHeight+"px");
        } else {
            $("#main").css("margin-top", headerHeight+"px");
        }
        $(window).resize(function () {
            var headerHeight = $("header").height();
            if ($('.videoWrap').length > 0) {
                $(".videoWrap").css("margin-top", headerHeight+"px");
            } else {
                $("#main").css("margin-top", headerHeight+"px");
            }
        });
    } else {
        $('header').removeClass('sticky');
        //smother scrolling with main content area
        if ($('.videoWrap').length > 0) {
            $(".videoWrap").css("margin-top", 0);
                $(window).resize(function () {
                    $(".videoWrap").css("margin-top", 0);
                });
        } else {
            $("#main").css("margin-top", 0);
                $(window).resize(function () {
                    $("#main").css("margin-top", 0);
                });
            }
        }
    };
    //call sticky nav fcn
    stickyNav();

    //call sticky nav fcn window resize
    $(window).scroll(function() {
        stickyNav();
    });


    //filter records by original format (image, article, video, audio)
    $('.originalFormat, .journalSelectLeft .SumoSelect > .optWrapper > .options > li').on('click', function(){
        var filter = $(this).attr('name');

        // SumoSelect Filter
        if( filter == undefined ) {
            filter = $(this).data('val');
        }

        var sorted = '';
        $.ajax({
            type: 'POST',
            url: THEME_URL + '/ajax/indexFilter.php', //hardcoded URL, change this later when BASE_URL constant works
            data: {originalFormat: filter},
            dataType: 'json',
            success: function(data, textStatus, jqXHR){

                var objects = data[0];
                var seasons = data[1];
                var years = data[2];

                //Build string for all objects
                for(var kid in objects){
                    console.log(kid);
                    var object = objects[kid];
                    var assoc = object['Issue Associator'];
                    var title = object['Title'];
                    var creator = object['Creator'];
                    var season = seasons[assoc];
                    var year = years[assoc];
                    var image = object['Image'];

                    if(title.length > 25){
                        var shortTitle = title.substring(0,25);
                        shortTitle += '...';
                    }
                    else{
                        shortTitle = title;
                    }

                    sorted += '<div class="imageBlock">';
                    if(image == ''){
                        sorted += '<a href="' + BASE_URL + '/record/?kid=' + kid.trim() + '"><img src="' + THEME_URL + '/images/journal/hedgehog.jpg"  width="580" height="388" /></a>';
                    }
                    else{
                        sorted += '<a href="' + BASE_URL + '/record/?kid=' + kid.trim() + '"><img src="' + BASE_URL_KORA + '/files/' + KORA_projectID.trim() + '/' + KORA_Object.trim() + '/' + image['localName'] + '" width="260" height="180" /></a>';
                    }
                    sorted += '<h3 title="' + title + '">' + shortTitle + '</h3>';
                    if((season != null) && (year != null)){
                        sorted += '<h5>' + season + ' ' + year + '</h5>';
                    }
                    else{
                        sorted += '<h5>Not Available<h5>';
                    }
                    if(creator != ''){
                        sorted += '<h5 class="imageAuthor">' + creator + '</h5></div>';
                    }
                    else{
                        sorted += '<h5 class="imageAuthor">Not Available</h5></div>';
                    }
                }
                $('#journalContent').html(sorted);
            },
            error: function(jqXHR, textStatus, errorThrown){
                console.log(jqXHR);
            }
        });
    });


    //filter records by digital date (2015, 2014, 2013, ...)
    $('.dateDigital, .journalSelectRight .SumoSelect > .optWrapper > .options > li').on('click', function(){
        var filter = $(this).attr('name');

        // SumoSelect Filter
        if( filter == undefined ) {
            filter = $(this).data('val');
        }

        var sorted = '';
        $.ajax({
            type: 'POST',
            url: THEME_URL + '/ajax/indexFilter.php', //hardcoded URL, change this later when BASE_URL constant works
            data: {dateDigital: filter},
            dataType: 'json',
            success: function(data, textStatus, jqXHR){

                var objects = data[0];
                var seasons = data[1];
                var years = data[2];

                //Build string for all objects
                for(var kid in data[0]){
                    var object = objects[kid];
                    var assoc = object['Issue Associator'];
                    var title = object['Title'];
                    var creator = object['Creator'];
                    var season = seasons[assoc];
                    var year = years[assoc];
                    var image = object['Image'];

                    if(title.length > 25){
                        var shortTitle = title.substring(0,25);
                        shortTitle += '...';
                    }
                    else{
                        shortTitle = title;
                    }

                    sorted += '<div class="imageBlock">';
                    if(image == ''){
                        sorted += '<a href="' + BASE_URL + '/record/?kid=' + kid.trim() + '"><img src="' + THEME_URL + '/images/journal/hedgehog.jpg" width="580" height="388" /></a>';
                    }
                    else{
                        sorted += '<a href="' + BASE_URL + '/record/?kid=' + kid.trim() + '"><img src="' + BASE_URL_KORA + '/files/' + KORA_projectID.trim() + '/' + KORA_Object.trim() + '/' + image['localName'] + '" width="260" height="180" /></a>';
                    }
                    sorted += '<h3 title="' + title + '">' + shortTitle + '</h3>';
                    sorted += '<h5>' + season + ' ' + year + '</h5>';
                    if(creator != ''){
                        sorted += '<h5 class="imageAuthor">' + creator + '</h5></div>';
                    }
                    else{
                        sorted += '<h5 class="imageAuthor">Not Available</h5></div>';
                    }
                }
                $('#journalContent').html(sorted);
            },
            error: function(jqXHR, textStatus, errorThrown){
                console.log(jqXHR);
            }
        });
    });

});
