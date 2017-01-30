/*
    This code is for the Core page on the NSU website.
    - John Okahata (2016)
*/  

$(document).ready(function() {
    displayRoster();
});


function displayRoster() {
    // To fill in the Roster using a spreadsheet, using roster.js
    // This is a link to the publish on the Core Roster spreadsheet
    var spreadsheetUrl = "https://docs.google.com/spreadsheets/d/1Tw_KrwHSmhK7UoPWmbmvoPH0LgSP4pQyrI6DU6s7cY8/pub?output=csv";
    var page = "core";
    fillRosterSelect(spreadsheetUrl, page);
    // When the selected semester changes, fill in the roster
    $("#roster_select").on('change', function() {
        updateRoster(spreadsheetUrl, page);
    });
}

