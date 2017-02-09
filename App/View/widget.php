<?php
/**
 * @author Dmitri Liventsev <dmitri@credy.eu>
 * @var $activeProfiles \App\Model\Entity\Profile[]
 */
$activeProfilesJson = json_encode($activeProfiles);

echo <<<JS
$( document ).ready(function() {
    var activeProfiles = $activeProfilesJson;
    var table = $('<table class="table table-striped"></table>');
    var th = $('<thead><tr><th>UserId</th><th>Most Recent Data</th><th>View Count</th><th>Unique impression count</th></tr></thead>');
    table.append(th);

    var body = $('<tbody></tbody>');
    jQuery.each(activeProfiles, function( index, value ) {
        switch (value.status) {
            case "valid":
                var statusClass = 'danger'
            break
            case "invalid":
                var statusClass = 'success'
            break
            default:
                var statusClass = 'active'
        };
        var row = $('<tr></tr>',{class: statusClass});
        row.append($('<td></td>', {'text': value.userId}));
        row.append($('<td></td>', {'text': value.text1}));
        row.append($('<td></td>', {'text': value.statistics.view}));
        row.append($('<td></td>', {'text': value.statistics.uic}));

        console.log(row);
        body.append(row);
    });
    table.append(body);
    $("#widget").html(table);

    function HtmlEncode(s)
    {
      var el = document.createElement("div");
      el.innerText = el.textContent = s;
      s = el.innerHTML;
      return s;
    }
});

JS;
