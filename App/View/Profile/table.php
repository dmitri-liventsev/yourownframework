<?php
/**
 * @author Dmitri Liventsev <dmitri.linvetsev@gmail.com>
 * @var $profileDetails array
 * @var $this \YourOwnFramework\View\View
 * @var $profileVersions Profile[];
 */

use App\Model\Entity\Profile;

$versionsArray = [];
$params = [0 => 'Please choose old version to compare'];
foreach($profileVersions as $oldProfileVersion) {
    $params[$oldProfileVersion->getId()] = $oldProfileVersion->getCreatedAt();
    $versionsArray[$oldProfileVersion->getId()] = json_decode($oldProfileVersion->getDetails());
}

$versionsArrayJson = json_encode($versionsArray);
?>

<h3>Profile</h3>
<div id="compare_select">
    <?php echo $this->form->select('version', 'Compare current version with old: ',$params); ?>
</div>
<table class="table" id="profile_table">
    <thead>
        <tr id="compare_table_head">
            <th>Field name</th>
            <th>Current</th>
            <th>Compare</th>
        </tr>
    </thead>
    <tbody>
        <tr data-field-name="text1">
            <th>Text1</th>
            <td class="current"><?php echo $profileDetails['text1'] ?? null; ?></td>
            <td class="compare"></td>
        </tr>
        <tr data-field-name="text2">
            <th>Text2</th>
            <td class="current"><?php echo $profileDetails['text2'] ?? null; ?></td>
            <td class="compare"></td>
        </tr>
        <tr data-field-name="text3">
            <th>Text3</th>
            <td class="current"><?php echo $profileDetails['text3'] ?? null; ?></td>
            <td class="compare"></td>
        </tr>
        <tr data-field-name="text4">
            <th>Text4</th>
            <td class="current"><?php echo $profileDetails['text4'] ?? null; ?></td>
            <td class="compare"></td>
        </tr>
        <tr data-field-name="text5">
            <th>Text5</th>
            <td class="current"><?php echo $profileDetails['text5'] ?? null; ?></td>
            <td class="compare"></td>
        </tr>
        <tr data-field-name="text6">
            <th>Text6</th>
            <td class="current"><?php echo $profileDetails['text6'] ?? null; ?></td>
            <td class="compare"></td>
        </tr>
        <tr data-field-name="text7">
            <th>Text7</th>
            <td class="current"><?php echo $profileDetails['text7'] ?? null; ?></td>
            <td class="compare"></td>
        </tr>
        <tr data-field-name="text8">
            <th>Text8</th>
            <td class="current"><?php echo $profileDetails['text8'] ?? null; ?></td>
            <td class="compare"></td>
        </tr>
        <tr data-field-name="checkbox1">
            <th>Checkbox1</th>
            <td class="current"><?php echo $profileDetails['checkbox1'] ?? 'Off'; ?></td>
            <td class="compare"></td>
        </tr>
        <tr data-field-name="checkbox2">
            <th>Checkbox2</th>
            <td class="current"><?php echo $profileDetails['checkbox2'] ?? 'Off'; ?></td>
            <td class="compare"></td>
        </tr>
        <tr data-field-name="checkbox3">
            <th>Checkbox3</th>
            <td class="current"><?php echo $profileDetails['checkbox3'] ?? 'Off'; ?></td>
            <td class="compare"></td>
        </tr>
        <tr data-field-name="radio1">
            <th>Radio1</th>
            <td class="current"><?php echo $profileDetails['radio1'] ?? null; ?></td>
            <td class="compare"></td>
        </tr>
    </tbody>
</table>

<script type="text/javascript">
    var profileMap = <?php echo $versionsArrayJson?>;
    $('#compare_select select').on('change', function() {
        var oldProfileId = $(this).val();
        var oldProfile = profileMap[oldProfileId];

        $("#profile_table tbody tr").each(function() {
            $(this).removeClass();

            var fieldName = $(this).attr('data-field-name');
            var currentFieldValue = $(this).find('.current').text();
            var oldFieldValue = oldProfile[fieldName];
            oldFieldValue = oldFieldValue == undefined? 'Off' : oldFieldValue;
            $(this).find('.compare').text(oldFieldValue);

            if (currentFieldValue != oldFieldValue) {
                $(this).addClass('danger');
            } else {
                $(this).addClass('success');
            }


        });
    });
</script>