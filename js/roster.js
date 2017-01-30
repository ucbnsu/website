/*
    This code is to fill in the roster on the NSU website by reading from a spreadsheet URL
    - John Okahata (2015)
*/  

/*
    This function will fill in the select button so that the user can pick "Spring 2016", "Fall 2015", etc.
*/
function fillRosterSelect(spreadsheetUrl, page)
{
    // Takes the outputted html from roster_generator.php and spits it out to the #roster_select div
    $.post('../pages/roster_generator.php', {"command": "fill_select", "url": spreadsheetUrl, "page": page}, function(data)
    {
        $("#roster_select").html(data);
    });

    // After filling in the select, it will automatically populate the most recent roster
    // The 1000 ms (1 second) delay is because without it, it would attempt to updateRoster before the select is filled 
    setTimeout(function() {
        updateRoster(spreadsheetUrl, page);
    }, 1000);
}

/*
    This function will update the members list in the roster based on the selected semester
*/
function updateRoster(spreadsheetUrl, page)
{
    var selected = $("#roster_select").children(":selected").val();
    var res = selected.split(":");
    var semester = res[0];
    var year = res[1];

    // Takes the outputted html from roster_generator.php and spits it out to the #roster div
    $.post('../pages/roster_generator.php', {"command": "update_roster", "selected": selected, "url": spreadsheetUrl, "page": page}, function(data)
    {
        $("#roster").html(data);
    });
}