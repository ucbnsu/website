/*
    This code is for the NiCE page on the NSU website.
    - John Okahata (2015)
*/  

$(document).ready(function() {
    // To fill in the Roster using a spreadsheet, using roster.js
    // This is a link to the publish on the NiCE Roster spreadsheet
    var spreadsheetUrl = "https://docs.google.com/spreadsheets/d/17NuXZCsvnJIYcTu9MyCBHtpYIe8TieJ3RdNKd89PTtU/pub?output=csv";
    var page = "nice";
    fillRosterSelect(spreadsheetUrl, page);
    // When the selected semester changes, fill in the roster
    $("#roster_select").on('change', function() {
        updateRoster(spreadsheetUrl, page);
    });
});