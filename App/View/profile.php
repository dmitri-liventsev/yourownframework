<?php
/**
 * @author Dmitri Liventsev <dmitri@credy.eu>
 *
 * @var array $profileVersions
 */
?>


<script type="text/javascript">
    $("versions").profileVersions({
        versions: <?php echo json_encode($profileVersions)?>,
form_div: $('#form_div')
});
</script>