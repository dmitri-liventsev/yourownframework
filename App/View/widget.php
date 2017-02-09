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
        statusClass = getStatusClass(value.status)
        var row = $('<tr></tr>',{class: statusClass});
        var td = $('<td></td>').append($('<a href="/profile?id=' + value.id + '"> ' + value.userId +'</a>'));
        row.append(td);
        row.append($('<td></td>', {'text': value.text1}));
        row.append($('<td></td>', {'text': value.statistics.view}));
        row.append($('<td></td>', {'text': value.statistics.uic}));

        body.append(row);
    });
    table.append(body);
    $("#widget").html(table);

    function getStatusClass(status)
    {
        switch (status) {
            case "valid":
                var statusClass = 'success'
            break
            case "invalid":
                var statusClass = 'danger'
            break
            default:
                var statusClass = 'active'
        };

        return statusClass;
    }

    function HtmlEncode(s)
    {
      var el = document.createElement("div");
      el.innerText = el.textContent = s;
      s = el.innerHTML;
      return s;
    }
});

JS;
