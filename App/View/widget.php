<?php
/**
 * @author Dmitri Liventsev <dmitri@credy.eu>
 * @var $widgets \App\Model\Entity\Widgets[]
 */
$widgetsJson = json_encode($widgets);

echo <<<JS
$( document ).ready(function() {
    var widgets = $widgetsJson;
    var table = $('<table class="table table-striped"></table>');
    var th = $('<thead><tr><th>UserId</th><th></th><th>Most Recent Data</th><th>View Count</th><th>Unique impression count</th><th>Status</th></tr></thead>');
    table.append(th);

    var body = $('<tbody></tbody>');
    jQuery.each(widgets, function( index, value ) {
        statusClass = getStatusClass(value.lastStatus)
        var row = $('<tr></tr>',{class: statusClass});
        row.append($('<td></td>', {'text': HtmlEncode(value.userId)}));
        var td = $('<td></td>').append($('<a href="/profile?id=' + value.userId + '"><button type="button" class="btn btn-default">View Profile</button></a>'));
        row.append(td);
        row.append($('<td></td>', {'text': HtmlEncode(value.profileDetails.text1)}));
        row.append($('<td></td>', {'text': value.viewCount}));
        row.append($('<td></td>', {'text': value.uic}));
        row.append($('<td></td>', {'text': value.lastStatus}));

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
