$(document).ready(function () {


    addCopyAndDeleteButtons();
    addEventListners();

    //fill left sidebar with block info
    initializeFixedLeft();

    //make content editable
    MakeStuffEditable();

    //set event to call function onscroll
    $(document).on("scroll", onScroll);

    //update changes to block from left sidebar (background)
    $( document ).on( 'click', '.pasToeKnop', function() {

        var pasToeId = $(this).attr("id");
        var refNum = parseInt(pasToeId.replace(/[^0-9]/g, ''));

        var backgroundType = $("#ImgVidOrColor-" + refNum).val();

        var updatedSrc = $("#bgImage-" + refNum).attr("src");
        var updatedColor = $("#backgroundColor-" + refNum).siblings( ".sp-container" ).find(".sp-input").val();

        var updateStyleAttachment = "background-attachment";
        var updateStyleAttachmentValue = "scroll";

        if(backgroundType == "img") {

            if($("#bgImageFixed-" + refNum).is(':checked')) {
                updateStyleAttachment = "background-attachment";
                updateStyleAttachmentValue = "fixed";
            }

            var updateStyle = "background-image";
            var updateStyleValue = "url(" + updatedSrc + ")";
            var updateStyleColor = "background-color";
            var updateStyleColorValue = updatedColor;


            if($("#SectionToEdit-" + refNum).find('.fullscreen-bg-video').find("source").length) {
                $("#SectionToEdit-" + refNum).find('.fullscreen-bg-video').remove();
            }
        }

        if(backgroundType == "video") {

            if($("#SectionToEdit-" + refNum).find('.fullscreen-bg-video').find("source").length) {

                //find the background video
                var videoURL = $("#bgVideoUrl-" + refNum).val();

                var sourceType = "video/mp4";

                switch (videoURL) {
                  case (videoURL.match(/.ogv/) || {}).input:
                    sourceType = "video/ogg";
                    break;
                  case (videoURL.match(/.ogg/) || {}).input:
                    sourceType = "video/ogg";
                    break;
                  case (videoURL.match(/.mp4/) || {}).input:
                    sourceType = "video/mp4";
                    break;
                  case (videoURL.match(/.webm/) || {}).input:
                    sourceType = "video/webm";
                    break;
                  case (videoURL.match(/.3gp/) || {}).input:
                    sourceType = "video/3gp";
                    break;
                }

                var theVideoElement = $("#SectionToEdit-" + refNum).find(".fullscreen-bg-video");
                var theVideoSource = theVideoElement.find("source");

                theVideoSource.attr("type", sourceType);
                theVideoSource.attr("src", videoURL);
                theVideoElement.load();

            }else {
                $("#SectionToEdit-" + refNum).addClass("");

                var backgroundHTML = '<div class="fullscreen-bg-video"><video loop="" muted="" autoplay="" class="fullscreen-bg-video"><source src="/uploads/files/Cows%20-%201018.mp4" type="video/mp4"></video><canvas class="fullscreen-bg-video-canvas" id="fullscreen-bg-video-canvas-1"></canvas></div>';

                $("#SectionToEdit-" + refNum).children(":nth-child(2)").prepend(backgroundHTML);

                //find the background video
                var videoURL = $("#bgVideoUrl-" + refNum).val();
                var theVideoElement = $("#SectionToEdit-" + refNum).find(".fullscreen-bg-video");
                var theVideoSource = theVideoElement.find("source");

                theVideoSource.attr("src", videoURL);
                theVideoElement.load();

            }

            // background color as fallback
            var updateStyle = "background-image";
            var updateStyleValue = "none";
            var updateStyleColor = "background-color";
            var updateStyleColorValue = "transparent";
        }

        if(backgroundType == "color") {
            var updateStyle = "background-image";
            var updateStyleValue = "none";
            var updateStyleColor = "background-color";
            var updateStyleColorValue = updatedColor;

            if($("#SectionToEdit-" + refNum).find('.fullscreen-bg-video').find("source").length) {
                $("#SectionToEdit-" + refNum).find('.fullscreen-bg-video').remove();
            }
        }

        if($("#SectionToEdit-" + refNum).find("header").html() != undefined) {
            $("#SectionToEdit-" + refNum).find("header").css(updateStyle, updateStyleValue);
            $("#SectionToEdit-" + refNum).find("header").css(updateStyleColor, updateStyleColorValue);
            $("#SectionToEdit-" + refNum).find("header").css(updateStyleAttachment, updateStyleAttachmentValue);
        }
        if($("#SectionToEdit-" + refNum).find("section").html() != undefined) {
            $("#SectionToEdit-" + refNum).find("section").css(updateStyle, updateStyleValue);
            $("#SectionToEdit-" + refNum).find("section").css(updateStyleColor, updateStyleColorValue);
            $("#SectionToEdit-" + refNum).find("section").css(updateStyleAttachment, updateStyleAttachmentValue);
        }
        if($("#SectionToEdit-" + refNum).find("aside").html() != undefined) {
            $("#SectionToEdit-" + refNum).find("aside").css(updateStyle, updateStyleValue);
            $("#SectionToEdit-" + refNum).find("aside").css(updateStyleColor, updateStyleColorValue);
            $("#SectionToEdit-" + refNum).find("aside").css(updateStyleAttachment, updateStyleAttachmentValue);
        }
    });

    //make changes to block's html
    $( document ).on( 'click', '.bewerkBlokHTML', function() {

        var bewerkBlokHTMLId = $(this).attr("id");
        var refNum = parseInt(bewerkBlokHTMLId.replace(/[^0-9]/g, ''));

        EditHTMLBlock(refNum);

    });

    //make changes to the page's css
    $( document ).on( 'click', '.bewerkCSS', function() {
        EditPageCSS();
    });

    $( document ).on( 'click', '.overlay', function() {
        $(".actionBox").hide("fade");
        $(".SelectSnippet").hide("fade");
        $(".overlay").hide("fade");
        $('body').removeClass('stop-scrolling');
        setTimeout(function(){
            $(".overlay").remove();

            //Check if already initialized
            addCopyAndDeleteButtons();
            addEventListners();
            //Reinitialize all inline editors
            CKEDITOR.inlineAll();
        }, 500);
    });

    $( document ).on( 'change', '#backgroundTypeChanger select', function() {

        var pasToeId = $(this).attr("id");
        var refNum = parseInt(pasToeId.replace(/[^0-9]/g, ''));

        if($(this).val() == "img") {
            $("#bgColor-" + refNum).hide();
            $("#bgVideo-" + refNum).hide();
            $("#bgImg-" + refNum).show();
        }

        if($(this).val() == "video") {
            $("#bgColor-" + refNum).hide();
            $("#bgVideo-" + refNum).show();
            $("#bgImg-" + refNum).hide();
        }

        if($(this).val() == "color") {
            $("#bgColor-" + refNum).show();
            $("#bgVideo-" + refNum).hide();
            $("#bgImg-" + refNum).hide();
        }

    });

    $( document ).on( 'click', '.backgroundPrevImg', function() {
        $dumpvar = openKCFinder_singleImage($(this).attr("id"));
        $("#uploadFrame").show("drop");

    });
    $( document ).on( 'click', '.bgVideoDivWrapper', function() {
        openKCFinder_singleVideo($(this).attr("id"));
        $("#uploadFrame").show("drop");

    });
    $( document ).on( 'click', '#closeUploadFrame', function() {
        $("#uploadFrame").hide("drop");
    });

    //Hier wordt de pagina opgeslagen...
    $( document ).on( 'click', '#SaveButton', function() {
        savePage();
    });

    function savePage() {
        $(".LoadingOverlay").show();

        //Kill all inline editors
        for(k in CKEDITOR.instances){
            var instance = CKEDITOR.instances[k];
            instance.destroy();
        }

        removeEventListners();
        removeCopyAndDeleteButtons();

        var customCSS = $("#customCSS").html();

        //save de custom css van deze page
        try {
            $.ajax({
                type: "POST",
                url: website_root + "/cms/includes/ajax/SavePageCustomCSS.php",
                data: { currentPage: currentPage, customCSS: customCSS},
                success: function(data) {

                    if(data.search("{error}") !== -1) {
                        alert(data);
                    }

                }
            });
        } catch(e) {
            alert(e.message);
        }

        //Wat is het laatste blok?
        var highest = -Infinity;
        $(".Blok").each(function() {
            highest = Math.max(highest, this.id.match(/\d+/)[0]);
        });

        //Save every blok
        $( ".Blok" ).each(function( index ) {

            var blokId = $(this).attr("id");
            var blokNum = $(this).attr("id").match(/\d+/)[0];

            //var blokHTML = CKEDITOR.instances[blokId].getData();
            var blokHTML = $(this).html();

            //Hier moet een secret code bij voor veiligheid
            var secretCode = 1234;

            //Is dit het laatste blok?
            if(blokNum == highest) {
                var isLastBlok = 1;
            }else {
                var isLastBlok = 0;
            }

            try {
                $.ajax({
                    type: "POST",
                    url: website_root + "/cms/includes/ajax/SaveSnippetToDatabase.php",
                    data: { currentPage: currentPage, secretCode: secretCode, blokHTML: blokHTML, blokNum: blokNum, isLastBlok: isLastBlok },
                    success: function(data) {

                        if(data.search("{error}") !== -1) {
                            alert(data);
                        }

                        if(data.search("{done}") !== -1) {

                            setTimeout(function(){
                                $(".LoadingOverlay").hide("fade");
                            }, 300);
                        }
                    }
                });
            } catch(e) {
                alert(e.message);
            }
        });

        addEventListners();
        addCopyAndDeleteButtons();

        //Reinitialize all inline editors
        CKEDITOR.inlineAll();
    }

    //Vul linker box als er nog niet gescrold is
    blokOnHover("#SectionToEdit-1");

    if(isPageNew == "true") {
        $("#actionBox").remove();
        $("<div id='actionBox' class='actionBox'><iframe src=\"" + website_root + "/cms/editmenu/index.php\"></iframe><div class='footer-buttons-action-box'><a id='sluitMenuEditor'>Klaar met menu bewerken</a><a id='sluitActionBox' style='margin-top: 0px;'>Sluit</a></div></div>").appendTo("body");
        $(".overlay").show("fade");
        $('body').addClass('stop-scrolling');
        $("#actionBox").show("drop");
    }

    //pagina is geladen
    setTimeout(function(){
        $(".LoadingOverlay").hide("fade");
    }, 1500);

});

$("#CMSLeftPanelOpener").click(function() {
    $("#CMSLeftPanelOpener").hide("fade", "fast");
    $("#CMSLeftPanel").show('slide', {direction: 'left'});
});
$("#CMSRightPanelOpener").click(function() {
    $("#CMSRightPanelOpener").hide("fade", "fast");
    $("#CMSRightPanel").show('slide', {direction: 'right'});
});
$("#CMSLeftPanel #close").click(function() {
    $("#CMSLeftPanelOpener").show('slide', {direction: 'left'});
    $("#CMSLeftPanel").hide("fade", "fast");
});
$("#CMSRightPanel #close").click(function() {
    $("#CMSRightPanelOpener").show('slide', {direction: 'right'});
    $("#CMSRightPanel").hide("fade", "fast");
});

$( document ).on( 'click', '.removeThisSection', function() {
    var CurrentSection = $(this).parent().attr("id");
    var CurrentNumber = parseInt(CurrentSection.replace(/[^0-9]/g, ''));

    $("#SectionToEdit-" + CurrentNumber).remove();
    $("#NewElementLine-" + CurrentNumber).remove();

    var tLoop = CurrentNumber;
    while(tLoop <= 20) {
        $("#SectionToEdit-" + parseInt(tLoop + 1)).attr({"id": "SectionToEdit-" + tLoop, "class": "SectionToEdit-" + tLoop + " EditableSection Blok"});
        $("#NewElementLine-" + parseInt(tLoop + 1)).attr({"id": "NewElementLine-" + tLoop, "onclick": "NewElement(" + tLoop + ")", "class": "NieuwElementLine NewElementLine-" + tLoop});
        tLoop++;
    }

    initializeFixedLeft();
});

$( "<li><div class='editMenuWrench' id=\"editMainMenu\"><i class=\"fa fa-wrench\" aria-hidden=\"true\"></i></div></li><li><div class='addNewPageButton' id=\"addNewPage\"><i class=\"fa fa-plus\" aria-hidden=\"true\"></i></div></li>" ).prependTo( ".navbar-nav" ).attr("class", "menuButton");

$( document ).on( 'click', '#editMainMenu', function() {
    $(".overlay").remove();
    $("#actionBox").remove();
    $("<div id='actionBox' class='actionBox'><iframe src=\"" + website_root + "/cms/editmenu/index.php\"></iframe><div class='footer-buttons-action-box'><a id='sluitMenuEditor'>Klaar met menu bewerken</a><a id='sluitActionBox' style='margin-top: 0px;'>Sluit</a></div></div>").appendTo("body");
    $('<div class="overlay"></div>').appendTo("body");
    $(".overlay").show("fade");
    $('body').addClass('stop-scrolling');
    $("#actionBox").show("drop");
});

$( document ).on( 'click', '#PageSettingsButton', function() {

    try {
        $.ajax({
        type: "POST",
        url: website_root + "/cms/includes/ajax/GetPageInfoFromDatabase.php",
        data: { p: currentPage },
        success: function(data) {

            var pageInfo = JSON.parse(data);

            $("#actionBox").remove();
            $("<div id='actionBox' class='actionBox'><div class='actionBoxInnerWrapper'><table><tr><td colspan='2'><h3>Website instellingen</h3></td></tr><tr><td><label>Website logo:</label> </td><td><div id='logo-preview' class='logo-preview'><label for='logo-upload' id='logo-label'><img src='https://server.dutchwebs.com/cms/img/upload-icon.png' id='uploadIcon'><img src='" + website_root + "/uploads/images/logo.png' id='logoPrev'></label><input type='file' name='logo' id='logo-upload' style='display:none;'/></div><div id='progressBarLogo'><div id='uploadStatus'></div></div></td></tr><tr><td><label>Website naam:</label> </td><td><input type='text' id='websiteNaam' placeholder='Naam' value='" + pageInfo.websiteName + "'></td></tr><tr><td><label>Contact email:</label> </td><td><input type='email' id='websiteEmail' placeholder='E-mailadres' value='" + pageInfo.websiteEmail + "'></td></tr><tr><td colspan='2'><h3>Pagina instellingen</h3></td></tr><tr><td><label>Pagina titel:</label> </td><td><input type='text' id='paginaTitel' placeholder='Titel' value='" + pageInfo.pageTitle + "'></td></tr><tr><td><label>Menu titel:</label> </td><td><input type='text' id='paginaMenuTitel' placeholder='Titel' value='" + pageInfo.pageMenuTitle + "'></td></tr><tr><td><label>Pagina url:</label> </td><td><label style='display: inline-block;position: absolute;margin-left: 10px;color: #999999;font-weight: normal;margin-top: 10px;'>" + websiteRootUrl + "</label><input type='text' style='width: 100%;display: inline-block;padding-left: 250px;' id='paginaUrl' placeholder='URL' value='" + pageInfo.pageUrl + "'></td></tr><tr><table><tr><td><br><label>Pagina omschrijving:</label> <textarea placeholder='Omschrijf hier waar deze pagina over gaat.' id='paginaOmschrijving'>" + pageInfo.pageDescription + "</textarea></td><td><br><label>Pagina keywords:</label><textarea placeholder='Noteer hier zoektermen waarmee u wilt dat deze pagina gevonden wordt.' id='paginaKeyWords'>" + pageInfo.pageKeyWords + "</textarea></td></tr></table></tr></table></div><div class='footer-buttons-action-box'><a id='verwijderPagina'>Verwijder</a><a id='sluitPaginaInstellingen'>Opslaan en sluiten</a><a id='sluitActionBox' style='margin-top: 0px;'>Sluit</a></div></div>").appendTo("body");

            $(".overlay").remove();
            $('<div class="overlay"></div>').appendTo("body");

            $("#actionBox").show("drop", {direction: "bottom"});
        }
    });
    } catch(e) {
        alert(e.message);
    }
});

function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#logoPrev').attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    }
}

$( document ).on( 'change', '#logo-upload', function() {

    readURL(this);

    $("#uploadStatus").css("transition", "all 0s");
    $("#uploadStatus").css("width", "5%");
    $("#uploadStatus").css("transition", "all 17s");
    $("#progressBarLogo").show("fade");
    $("#uploadStatus").css("width", "70%");

    var file_data = $('#logo-upload').prop('files')[0];
    var form_data = new FormData();

    form_data.append('file', file_data);

    $.ajax({
        url: website_root + "/cms/includes/ajax/UploadLogo.php",
        dataType: 'text',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(response){
            if(response == true) {
                $("#uploadStatus").css("transition", "all 1s");
                $("#uploadStatus").css("width", "100%");
                $("#progressBarLogo").hide("fade");
            }else {
                alert("Error tijdens uploaden: " + response);
            }
        }
     });

});

$(document).on( 'click', '#PageSEOButton', function() {

    try {
        $.ajax({
        type: "POST",
        url: website_root + "/cms/includes/ajax/GetPageSEOInfoFromDatabase.php",
        data: { p: currentPage },
        success: function(data) {

            var pageInfo = JSON.parse(data);

            $("#actionBox").remove();
            $("<div id='actionBox' class='actionBox'><div class='actionBoxInnerWrapper'><table><tr><td colspan='2'><h3>Website instellingen</h3></td></tr><tr><td><label>Website naam:</label> </td><td><input type='text' id='websiteNaam' placeholder='Naam' value='" + pageInfo.websiteName + "'></td></tr><tr><td><label>Contact email:</label> </td><td><input type='email' id='websiteEmail' placeholder='E-mailadres' value='" + pageInfo.websiteEmail + "'></td></tr><tr><td colspan='2'><h3>Pagina instellingen</h3></td></tr><tr><td><label>Pagina titel:</label> </td><td><input type='text' id='paginaTitel' placeholder='Titel' value='" + pageInfo.pageTitle + "'></td></tr><tr><td><label>Menu titel:</label> </td><td><input type='text' id='paginaMenuTitel' placeholder='Titel' value='" + pageInfo.pageMenuTitle + "'></td></tr><tr><td><label>Pagina url:</label> </td><td><label style='display: inline-block;position: absolute;margin-left: 10px;color: #999999;font-weight: normal;margin-top: 10px;'>" + websiteRootUrl + "</label><input type='text' style='width: 100%;display: inline-block;padding-left: 250px;' id='paginaUrl' placeholder='URL' value='" + pageInfo.pageUrl + "'></td></tr><tr><table><tr><td><br><label>Pagina omschrijving:</label> <textarea placeholder='Omschrijf hier waar deze pagina over gaat.' id='paginaOmschrijving'>" + pageInfo.pageDescription + "</textarea></td><td><br><label>Pagina keywords:</label><textarea placeholder='Noteer hier zoektermen waarmee u wilt dat deze pagina gevonden wordt.' id='paginaKeyWords'>" + pageInfo.pageKeyWords + "</textarea></td></tr></table></tr></table></div><div class='footer-buttons-action-box'><a id='verwijderPagina'>Verwijder</a><a id='sluitPaginaInstellingen'>Opslaan en sluiten</a><a id='sluitActionBox' style='margin-top: 0px;'>Sluit</a></div></div>").appendTo("body");
            $("#actionBox").show("drop", {direction: "bottom"});
        }
    });
    } catch(e) {
        alert(e.message);
    }
});

$(document).on( 'click', '#PageLicenseButton', function() {
    openPageLicenseInfo();

});

function openPageLicenseInfo(website_created = false) {
    try {
        $.ajax({
        type: "POST",
        url: website_root + "/cms/includes/ajax/GetPageLicenseInfoFromServer.php",
        data: { p: currentPage },
        success: function(data) {

            $(".overlay").remove();
            $('<div class="overlay"></div>').appendTo("body");

            $("#actionBox").remove();
            $("<div id='actionBox' class='actionBox'><div class='actionBoxInnerWrapper'><h3>Website/domeinnaam licentie</h3>" + data + "</div><div class='footer-buttons-action-box'><a id='sluitPaginaLicentie'>Interactieve uitleg</a><a id='sluitActionBox' style='margin-top: 0px;'>Website bewerken</a></div></div>").appendTo("body");
            $("#actionBox").show("drop", {direction: "bottom"});
        }
    });
    } catch(e) {
        alert(e.message);
    }
}

$( document ).on( 'click', '#addNewPage', function() {

    $("#actionBox").remove();

    var newPageForm = "<div class=newPageWrapper><table class=newPageTable id=newPageTableStepOne><tr><td colspan=2><h1>Nieuwe pagina</h1></td></tr><tr><td>Pagina naam:</td><td><input type=text name=paginaNaam id=paginaNaam placeholder='Over ons'></td></tr><tr><td colspan=2><h3>Template:</h3><table><tr><td><input type=radio id=templateCheckbox name=templateCheckbox value=1>&emsp;<label>Homepage</label></td></tr><tr><td><input type=radio id=templateCheckbox name=templateCheckbox value=2>&emsp;<label>Contact</label></td></tr><tr></td><td><input type=radio id=templateCheckbox name=templateCheckbox value=3 checked=checked>&emsp;<label>Artiekel</label></td></tr></table></td></tr></table></div>";

    $("<div id='actionBox' class='actionBox'>" + newPageForm + "<div class='footer-buttons-action-box'><a id='createNewPageActionBox'>Maak nieuwe pagina</a><a id='sluitActionBox'>Sluit</a></div></div>").appendTo("body");

    $(".overlay").remove();
    $('<div class="overlay"></div>').appendTo("body");

    $("#actionBox").show("drop");
});

$( document ).on( 'click', '#sluitMenuEditor', function() {

    var menuId = 1;

    $.ajax({
        type: "POST",
        url: website_root + "/cms/includes/ajax/GetMenu.php",
        data: { menuId: menuId, currentPage: currentPage },
        success: function(data) {
            $(".navbar-nav").html(data);
            $(".overlay").hide("fade");
            $("#actionBox").hide("drop");
            $( "<li><div class='editMenuWrench' id=\"editMainMenu\"><i class=\"fa fa-wrench\" aria-hidden=\"true\"></i></div></li><li><div class='addNewPageButton' id=\"addNewPage\"><i class=\"fa fa-plus\" aria-hidden=\"true\"></i></div></li>" ).prependTo( ".navbar-nav" );
        }
    });
});
$( document ).on( 'click', '#sluitPaginaInstellingen', function() {

    $(".LoadingOverlay").show();

    var websiteNaam = $("#websiteNaam").val();
    var websiteEmail = $("#websiteEmail").val();

    var paginaTitel = $("#paginaTitel").val();
    var paginaMenuTitel = $("#paginaMenuTitel").val();
    var paginaURL = $("#paginaUrl").val();
    var paginaOmschrijving = $("#paginaOmschrijving").val();
    var paginaKeyWords = $("#paginaKeyWords").val();

    try {
        $.ajax({
            type: "POST",
            url: website_root + "/cms/includes/ajax/UpdateWebsiteSettings.php",
            data: { currentPage: currentPage, websiteNaam: websiteNaam, websiteEmail: websiteEmail, paginaTitel: paginaTitel, paginaMenuTitel: paginaMenuTitel, paginaURL: paginaURL, paginaOmschrijving: paginaOmschrijving, paginaKeyWords: paginaKeyWords },
            success: function(data) {

                //hier laden we gelijk het menu opnieuw in
                var menuId = 1;
                $.ajax({
                    type: "POST",
                    url: website_root + "/cms/includes/ajax/GetMenu.php",
                    data: { menuId: menuId, currentPage: currentPage },
                    success: function(data) {
                        $(".navbar-nav").html(data);
                        $("#actionBox").hide("drop");
                        $(".overlay").hide("fade");
                        $( "<li><div class='editMenuWrench' id=\"editMainMenu\"><i class=\"fa fa-wrench\" aria-hidden=\"true\"></i></div></li><li><div class='addNewPageButton' id=\"addNewPage\"><i class=\"fa fa-plus\" aria-hidden=\"true\"></i></div></li>" ).prependTo( ".navbar-nav" );
                        $("#websiteLogo").attr("src", "/uploads/images/logo.png?" + Date.now());
                        $(".LoadingOverlay").hide("fade");
                    }
                });
            }
        });
    }catch(e) {
        alert(e.message);
        $(".LoadingOverlay").hide("fade");
    }
});

$( document ).on( 'click', '#sluitPaginaLicentie', function() {
    $(".LoadingOverlay").show();
    try {
        //hier laden we gelijk het menu opnieuw in
        var menuId = 1;
        $.ajax({
            type: "POST",
            url: website_root + "/cms/includes/ajax/GetMenu.php",
            data: { menuId: menuId, currentPage: currentPage },
            success: function(data) {
                $(".navbar-nav").html(data);
                $("#actionBox").hide("drop");
                $(".overlay").hide("fade");
                $( "<li><div class='editMenuWrench' id=\"editMainMenu\"><i class=\"fa fa-wrench\" aria-hidden=\"true\"></i></div></li><li><div class='addNewPageButton' id=\"addNewPage\"><i class=\"fa fa-plus\" aria-hidden=\"true\"></i></div></li>" ).prependTo( ".navbar-nav" );
                $("#websiteLogo").attr("src", "/uploads/images/logo.png?" + Date.now());
                $(".LoadingOverlay").hide("fade");
            }
        });
    }catch(e) {
        alert(e.message);
        $(".LoadingOverlay").hide("fade");
    }
});

//verwijder een pagina
$( document ).on( 'click', '#verwijderPagina', function() {

    if(confirm("Weet u zeker dat u deze pagina wilt verwijderen?")) {
        $(".LoadingOverlay").show();
        try {
            $.ajax({
                type: "POST",
                url: website_root + "/cms/includes/ajax/RemovePage.php",
                data: { currentPage: currentPage, removePage: true },
                success: function(data) {
                    var result = $.parseJSON(data);
                    if(result.status == "done") {
                        window.location.href = website_root + "/cms/";
                    }
                }
            });
        }catch(e) {
            alert(e.message);
        }
    }
});

$( document ).on( 'click', '#createNewPageActionBox', function() {

    $(".LoadingOverlay").show();

    var paginaNaam = $("#paginaNaam").val();
    var templateNum = $("#templateCheckbox").val();

    if(paginaNaam == '') {
        alert("U moet wel een naam aan uw pagina geven.");
    }else {

        try {
            $.ajax({
                type: "POST",
                url: website_root + "/cms/includes/ajax/AddNewPage.php",
                data: { paginaNaam: paginaNaam, templateNum: templateNum },
                success: function(data) {
                    var result = $.parseJSON(data);
                    if(result.status == "done") {
                        window.location.href = website_root + "/cms/" + result.url + "?new=true";
                    }
                }
            });
        }catch(e) {
            alert(e.message);
            $(".LoadingOverlay").hide("fade");
        }
    }
});

$( document ).on( 'click', '#sluitActionBox', function() {
    $("#actionBox").hide("drop");
    $(".overlay").hide("fade");
    $('body').removeClass('stop-scrolling');
    setTimeout(function(){
        $(".overlay").remove();
    }, 500);
});

$(document).on('keydown', function(e) {
    if(e.metaKey && e.which === 83) { // Check for the Ctrl key being pressed, and if the key = [S] (83)
        e.preventDefault();
        savePage();
        return false;
    }
});

function openKCFinder_singleImage(inputId) {
    window.KCFinder = {};
    window.KCFinder.callBack = function(url) {
        // Actions with url parameter here
        window.KCFinder = null;

        $("#" + inputId).attr("src", url.replace(document_root, ''));
        $("#uploadFrame").hide("drop");

    };
    window.open(website_root + '/cms/includes/kcfinder/browse.php?type=images&lang=nl&dir=uploads', 'uploadFrame');
}
function openKCFinder_singleVideo(inputId) {
    window.KCFinder = {};
    window.KCFinder.callBack = function(url) {
        // Actions with url parameter here
        window.KCFinder = null;
        $("#" + inputId).find("input").val(url.replace(document_root, ''));
        $("#uploadFrame").hide("drop");

    };
    window.open(website_root + '/cms/includes/kcfinder/browse.php?type=videos&lang=nl&dir=uploads', 'uploadFrame');
}

function ExitSnippetSelection() {

    $(".SelectSnippet").hide("fade");
    $(".overlay").hide("fade");
    $('body').removeClass('stop-scrolling');

    setTimeout(function(){
        $(".SelectSnippet").remove();
        $(".overlay").remove();
    }, 500);
}

function MakeStuffEditable() {
    $( ".intro-text" ).attr( "contenteditable", "true" );
    $( ".section-heading" ).attr( "contenteditable", "true" );
    $( ".section-subheading" ).attr( "contenteditable", "true" );
    $( ".service-heading" ).attr( "contenteditable", "true" );
    $( ".text-muted" ).attr( "contenteditable", "true" );
    $( ".fa-stack" ).attr( "contenteditable", "true" );
    $( ".portfolio-item" ).attr( "contenteditable", "true" );
    $( ".timeline-image" ).attr( "contenteditable", "true" );
    $( ".timeline-heading" ).attr( "contenteditable", "true" );
    $( ".container h1" ).attr( "contenteditable", "true" );
    $( ".container h2" ).attr( "contenteditable", "true" );
    $( ".container h3" ).attr( "contenteditable", "true" );
    $( ".container h4" ).attr( "contenteditable", "true" );
    $( ".team-member" ).attr( "contenteditable", "true" );
    $( ".col-sm-6" ).attr( "contenteditable", "true" );
    $( ".btn" ).attr( "contenteditable", "true" );
}

function ReinitializeCKEitor() {

    removeEventListners();
    removeCopyAndDeleteButtons();

    //Kill all inline editors
    for(k in CKEDITOR.instances){
        var instance = CKEDITOR.instances[k];
        instance.destroy();
    }

    addCopyAndDeleteButtons();
    addEventListners();

    //Reinitialize all inline editors
    CKEDITOR.inlineAll();

}

var blocksCounter = 1;

function NewElement(Position) {
    $.ajax({
        type: "POST",
        url: website_root + "/cms/includes/ajax/GetListOfSnippetsFromDatabase.php",
        data: { Position: Position },
        success: function(data) {

            var overlay = '<div class="overlay"></div>';

            var newHTMLBlock = "<div class=\"SelectSnippet\" id=\"SelectSnippet\"><div class=\"SelectSnippetExitButton\" onclick=\"ExitSnippetSelection()\"></div><div class=\"SelectSnippetTitle\">Nieuw websiteblok<p>Klik op een blok om dat element aan uw website toe te voegen.</p></div><div class=\"SnippetsList\">" + data + "</div></div>" + overlay;

            var htmlElement = $("body").after(newHTMLBlock);

            $("#SelectSnippet").hide();
            $("#SelectSnippet").show('slide');

        }
    });
}

function PasteNewElement(Position, SnippetNumber) {

    var PositieNieuweSectie = "#NewElementLine-" + Position;
    var HuidigePositie = "#NewElementLine-" + Position;
    var loopCounter =  parseInt(Position + 1);
    var secondLoopCounter = parseInt(Position + 2);

    while(loopCounter < 20) {
        var UpdatedNumber = parseInt(loopCounter + 1);
        $("#NewElementLine-" + loopCounter).attr("class","NieuwElementLine NewElementLine-" + UpdatedNumber);
        $("#SectionToEdit-" + loopCounter).attr("class","SectionToEdit-" + UpdatedNumber + " EditableSection Blok");
        loopCounter++;
    }
    while(secondLoopCounter < 20) {
        $(".NewElementLine-" + secondLoopCounter).attr("id","NewElementLine-" + secondLoopCounter);
        $(".NewElementLine-" + secondLoopCounter).attr("onclick","NewElement(" + secondLoopCounter + ")");
        $(".SectionToEdit-" + secondLoopCounter).attr("id","SectionToEdit-" + secondLoopCounter);
        secondLoopCounter++;
    }

    //make ajax call to get new snippet html
    $.ajax({
        type: "POST",
        url: website_root + "/cms/includes/ajax/GetSnippetFromDatabase.php",
        data: { SnippetNumber: SnippetNumber },
        success: function(data) {

            //wrap snippet in cms stuff
            var newHTMLBlock = '<div id="SectionToEdit-' + parseInt(Position + 1) + '" class="EditableSection Blok"><div class="removeThisSection"><span></span></div>' + data + "</div><span onclick='NewElement(" + parseInt(Position + 1) + ")' id='NewElementLine-" + parseInt(Position + 1) + "' class='NieuwElementLine NewElementLine-" + parseInt(Position + 1) + "'><div class=\"blobs\"><div class='blob' onclick='NewElement(" + parseInt(Position + 1) + ")'><i class=\"fa fa-plus\" aria-hidden=\"true\"></i></div></div></span>";

            //paste new block of html
            $( PositieNieuweSectie ).after(newHTMLBlock);

            //update sidebar left of cms
            initializeFixedLeft();

            //make new content editable
            MakeStuffEditable();

            //initialize CKEditor on all elements
            ReinitializeCKEitor();

            //close new snippet selection
            ExitSnippetSelection();
        }
    });
}

function onScroll(event){

    var scrollPos = $(document).scrollTop() + ($(window).height() / 2);

    $('.Blok').each(function () {

        var currBlok = $(this);

        if (currBlok.position().top + currBlok.height() >= scrollPos && currBlok.position().top < scrollPos) {
            blokOnHover("#" + currBlok.attr("id"));
        }
    });
}

function initializeFixedLeft() {

    $("#backgroundSelectionWrapper").html("");

    $('.Blok').each(function () {

        var Blok = $(this);
        var BlokId = Blok.attr("id");
        var BlokIdNum = parseInt(BlokId.replace(/[^0-9]/g, ''));

        if($(this).children("section").css("background-image")) {
            var backgroundUrl = $(this).children("section").css("background-image");
            var BackgroundColor = $(this).children("section").css("background-color");
        }
        if($(this).children("header").css("background-image")) {
            var backgroundUrl = $(this).children("header").css("background-image");
            var BackgroundColor = $(this).children("header").css("background-color");
        }
        if($(this).children("aside").css("background-image")) {
            var backgroundUrl = $(this).children("aside").css("background-image");
            var BackgroundColor = $(this).children("aside").css("background-color");
        }

        var backgroundUrlClean = backgroundUrl.replace("url(", "").replace(")", "").replace('"', '');

        if(backgroundUrlClean == "none") {
            backgroundUrlClean = "http://dutchwebs.com/img/bg.jpg";
        }

        if($(this).children("header").css("background-attachment") == "fixed" || $(this).children("section").css("background-attachment") == "fixed" || $(this).children("aside").css("background-attachment") == "fixed") {
            var isFixed = "checked";
        }else {
            var isFixed = "";
        }

        //In het linker menu moet de achtergrond kleur worden weergegeven
        var bgImgDisplay = "none";
        var bgVidDisplay = "none";
        var bgColorDisplay = "block";

        var AfbeeldingSelected = "";
        var VideoSelected = "";
        var ColorSelected = "selected";

        if($(this).children("header").css("background-image") != "none" && $(this).children("section").css("background-image") != "none" && $(this).children("aside").css("background-image") != "none") {

            //In het linker menu moet de achtergrond afbeelding worden weergegeven
            bgImgDisplay = "block";
            bgVidDisplay = "none";
            bgColorDisplay = "none";

            AfbeeldingSelected = "selected";
            VideoSelected = "";
            ColorSelected = "";

        }

        if(Blok.find('.fullscreen-bg-video').find("source").length) {

            var bgImgUrl = Blok.find('.fullscreen-bg-video').find("source").attr("src");

            //In het linker menu moet de achtergrond video worden weergegeven
            bgImgDisplay = "none";
            bgVidDisplay = "block";
            bgColorDisplay = "none";

            AfbeeldingSelected = "";
            VideoSelected = "selected";
            ColorSelected = "";

        }else {
            var bgImgUrl = "";
        }

        var BlokBgDiv = '<div class="bgForBlok" id="gbFor-' + BlokIdNum + '"><table><tr id="backgroundTypeChanger"><td>Achtergrond: </td><td><select id="ImgVidOrColor-' + BlokIdNum + '"><option value="img" ' + AfbeeldingSelected + '>Afbeelding</option><option value="video" ' + VideoSelected + '>Video</option><option value="color" ' + ColorSelected + '>Kleur</option></select></td></tr><tr id="bgImg-' + BlokIdNum + '" style="display: ' + bgImgDisplay + ';"><td colspan="2"><div id="bgImageDiv-' + BlokIdNum + '" class="bgImgDivWrapper"><img class="backgroundPrevImg" id="bgImage-' + BlokIdNum + '" src="' + backgroundUrlClean + '"></div><span class="fixedCheckBoxSpan">Gefixeerd: <input type="checkbox" id="bgImageFixed-' + BlokIdNum + '" class="bgImageFixed" ' + isFixed + '></span></td></tr><tr id="bgVideo-' + BlokIdNum + '" style="display: ' + bgVidDisplay + ';"><td colspan="2"><div id="bgVideoDiv-' + BlokIdNum + '" class="bgVideoDivWrapper"><i class="fa fa-file-video-o" aria-hidden="true"></i><input id="bgVideoUrl-' + BlokIdNum + '" type="text" value="' + bgImgUrl + '" placeholder="Video url"></div></td></tr><tr id="bgColor-' + BlokIdNum + '" style="display: ' + bgColorDisplay + ';"><td colspan="2"><input type="color" id="backgroundColor-' + BlokIdNum + '" class="backgroundColorInput" value="' + BackgroundColor + '"></td></tr><tr><td colspan="2"><button class="pasToeKnop" id="pasToe-' + BlokIdNum + '" title="Wijzigingen doorvoeren op de pagina">Pas toe</button></td></tr><tr><td colspan="2"><button class="bewerkBlokHTML" id="bewerkBlokHTML-' + BlokIdNum + '" title="Bewerk HTML van blok ' + BlokIdNum + '"><i class="fa fa-code" aria-hidden="true"></i></button></td></tr></table></div>';

        $(BlokBgDiv).appendTo("#backgroundSelectionWrapper");

        $('#backgroundColor-' + BlokIdNum).spectrum({
            preferredFormat: "rgb",
            showPalette: true,
            palette: [
                ["#f4cccc","#fce5cd","#fff2cc","#d9ead3","#d0e0e3","#cfe2f3","#d9d2e9","#ead1dc"]
            ],
            flat: true,
            hideAfterPaletteSelect:true,
            showInput: true,
            color: BackgroundColor,
            move: function(color) {
                if($("#SectionToEdit-" + BlokIdNum).find("header").html() != undefined) {
                    $("#SectionToEdit-" + BlokIdNum).find("header").css("background-color", color.toHexString());
                }
                if($("#SectionToEdit-" + BlokIdNum).find("section").html() != undefined) {
                    $("#SectionToEdit-" + BlokIdNum).find("section").css("background-color", color.toHexString());
                }
                if($("#SectionToEdit-" + BlokIdNum).find("aside").html() != undefined) {
                    $("#SectionToEdit-" + BlokIdNum).find("aside").css("background-color", color.toHexString());
                }
            }
        });

    });

    var cssEditButton = '<button class="bewerkCSS" id="bewerkCSS" title="Inline CSS van deze pagina"><i class="fa fa-css3" aria-hidden="true"></i></button>';

    $(cssEditButton).appendTo("#backgroundSelectionWrapper");
}

function blokOnHover(blokId) {

    var refNum = parseInt(blokId.replace(/[^0-9]/g, ''));
    var blokNum = parseInt(blokId.replace(/[^0-9]/g, ''));

    $("#blokNaam").html("Blok " + blokNum);

    $(".bgForBlok").hide();
    $("#gbFor-" + refNum).show();

}

function EditHTMLBlock(refNum) {

    removeEventListners();
    removeCopyAndDeleteButtons();

    //Kill all inline editors
    for(k in CKEDITOR.instances){
        var instance = CKEDITOR.instances[k];
        instance.destroy();
    }

    var blokHTML = $("#SectionToEdit-" + refNum).html();
    var blokHTMLWithoutRemoveThisSection = blokHTML.replace('<div class="removeThisSection"><span></span></div>', "");

    var blokHTMLEditor = "<textarea class=blokHTMLEditor id=blokHTMLEditor-" + refNum + ">" + blokHTMLWithoutRemoveThisSection.replace("textarea>", "text---area>") + "</textarea>";

    var overlay = '<div class="overlay" style="display:none;"></div>';

    $("#actionBox").remove();
    $(".overlay").remove();

    $("<div id='actionBox' class='actionBox'>" + blokHTMLEditor + "<div class='footer-buttons-action-box'><a id='sluitHTMLEditor' onclick=UpdateHTMLFromEditor(" + refNum + ")>Klaar met HTML bewerken</a></div></div>" + overlay).appendTo("body");

    $(".overlay").show("fade");
    $('body').addClass('stop-scrolling');
    $("#actionBox").show("drop");

    var editor = CodeMirror.fromTextArea(document.getElementById("blokHTMLEditor-" + refNum), {
        lineNumbers: true,
        mode: "htmlmixed",
        matchBrackets: true
    });

    var totalLines = editor.lineCount();
    var totalChars = editor.getTextArea().value.length;
    editor.autoFormatRange({line:0, ch:0}, {line:totalLines, ch:totalChars});

    // store it
    $("#blokHTMLEditor-" + refNum).data('CodeMirrorInstance', editor);
}

function EditPageCSS() {

    var pageCustomCSS = $("#customCSS").html();

    var pageCSSEditor = "<textarea class=pageCSSEditor id=pageCSSEditor>" + pageCustomCSS + "</textarea>";

    var overlay = '<div class="overlay" style="display:none;"></div>';

    $("#actionBox").remove();
    $(".overlay").remove();

    $("<div id='actionBox' class='actionBox cssEditActionBox'>" + pageCSSEditor + "<div class='footer-buttons-action-box'><a id='sluitCSSEditor' onclick='UpdateCSSFromEditor()'>Klaar met CSS bewerken</a></div></div>" + overlay).appendTo("body");

    $(".overlay").show("fade");
    $('body').addClass('stop-scrolling');
    $("#actionBox").show("drop");

    var editor = CodeMirror.fromTextArea(document.getElementById("pageCSSEditor"), {
        lineNumbers: true,
        mode: "css",
        matchBrackets: true
    });

    var totalLines = editor.lineCount();
    var totalChars = editor.getTextArea().value.length;
    editor.autoFormatRange({line:0, ch:0}, {line:totalLines, ch:totalChars});

    // store it
    $("#pageCSSEditor").data('CodeMirrorInstance', editor);

}

function UpdateHTMLFromEditor(refNum) {

    $("#actionBox").hide("drop");
    $(".overlay").hide("fade");
    $('body').removeClass('stop-scrolling');

    setTimeout(function(){
        $(".overlay").remove();
    }, 500);

    var myInstance = $("#blokHTMLEditor-" + refNum).data('CodeMirrorInstance');

    var removeThisSection = '<div class="removeThisSection"><span></span></div>';

    var updatedHTML = myInstance.getValue().replace("text---area>", "textarea>");

    $("#SectionToEdit-" + refNum).html(removeThisSection + updatedHTML);

    setTimeout(function(){
        addCopyAndDeleteButtons();
        addEventListners();
        //Reinitialize all inline editors
        CKEDITOR.inlineAll();
    }, 500);

}

function UpdateCSSFromEditor() {

    $("#actionBox").hide("drop");
    $(".overlay").hide("fade");
    $('body').removeClass('stop-scrolling');

    setTimeout(function(){
        $(".overlay").remove();
    }, 500);

    var myInstance = $("#pageCSSEditor").data('CodeMirrorInstance');

    var updatedCSS = myInstance.getValue().replace("text---area>", "textarea>");

    $("#customCSS").html(updatedCSS);

}

function addCopyAndDeleteButtons() {

    //Find all copyable elements and add 'copy' and 'delete' buttons
    var copyables = document.querySelectorAll('.el-e');

    for (var i = 0; i < copyables.length; ++i) {
        var p = document.createElement('p');
        var cl = document.createAttribute('class');
        cl.value = 'editElementButtons';
        p.setAttributeNode(cl);

        copyables[i].appendChild(p);


        var a = document.createElement('a');
        var cl = document.createAttribute('class');
        cl.value = 'copybutton';
        $(a).attr("contenteditable", "false");
        a.setAttributeNode(cl);

        p.appendChild(a);

        a = document.createElement('a');
        cl = document.createAttribute('class');
        cl.value = 'deletebutton';
        $(a).attr("contenteditable", "false");
        a.setAttributeNode(cl);

        p.appendChild(a);
    }

}

function removeCopyAndDeleteButtons() {

    $(".editElementButtons").each(function() {
        $(this).remove();
    });

}

function addEventListners() {

    CKEDITOR.on('instanceReady', function(evt) {

        $(evt.editor.container.$).find('.copybutton').click(function() {
            copyelement($(this));
        });

        $(evt.editor.container.$).find('.deletebutton').click(function() {
            deleteelement($(this));
        });

    });

}
function removeEventListners() {

    CKEDITOR.on('instanceReady', function(evt) {

        $(evt.editor.container.$).find('.copybutton').unbind();
        $(evt.editor.container.$).find('.deletebutton').unbind();

    });

}

//Copy a clone of a DOM node after itself
function copyelement(copyButton) {

    var elementToCopy = copyButton.closest(".el-e");
    var copiedElement = elementToCopy.clone();

    copiedElement.find('.copybutton').click(function() {
        copyelement($(this));
    });

    copiedElement.find('.deletebutton').click(function() {
        deleteelement($(this));
    });

    elementToCopy.after(copiedElement);
}

//Delete a DOM node
function deleteelement(deleteButton) {

    var elementToDelete = deleteButton.closest(".el-e");

    elementToDelete.remove();
}
