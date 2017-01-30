/*
    This code is for the Yosakoi page on the NSU website.
    - John Okahata (2015)
*/  

$(document).ready(function() {

    displayRoster();
    displayVideos();


});


function displayRoster() {
    // To fill in the Roster using a spreadsheet, using roster.js
    // This is a link to the publish on the Yosakoi Roster spreadsheet
    var spreadsheetUrl = "https://docs.google.com/spreadsheets/d/1UZfuQfWEczNBH_V7uEP33vmZ3tUpKfvBqh4k2sPmNTU/pub?output=csv";
    var page = "yosakoi";
    fillRosterSelect(spreadsheetUrl, page);
    // When the selected semester changes, fill in the roster
    $("#roster_select").on('change', function() {
        updateRoster(spreadsheetUrl, page);
    });
}

function displayVideos() {
    var spreadsheetUrl = "https://docs.google.com/spreadsheets/d/1Jg3vGUT6_WDkx6CPiEbxT2FV_DqqNSh-g7zLYetTEF4/pub?output=csv";
    // Takes the outputted html from video_generator.php and spits it out to the #videos div
    $.post('../pages/video_generator.php', {"url": spreadsheetUrl}, function(data)
    {
        $("#videos").html(data);
    });
}

