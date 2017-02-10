<?php
/**
 * @var $this YourOwnFramework\View\View
 * @var $profile array
 * @var $token string
 */
use YourOwnFramework\Request\Csrf;

?>

<form method="post">
    <?php
        if (isset($profile['text1'])) {
            echo $this->form->text('text1', 'text1', htmlspecialchars($profile['text1']));
        }
    ?>
    <?php
        if (isset($profile['text2'])) {
            echo $this->form->text('text2', 'text2', htmlspecialchars($profile['text2']));
        }
    ?>
    <?php
        if (isset($profile['text3'])) {
            echo $this->form->text('text3', 'text3', htmlspecialchars($profile['text3']));
        }
    ?>
    <?php
        if (isset($profile['text4'])) {
            echo $this->form->text('text4', 'text4', htmlspecialchars($profile['text4']));
        }
    ?>
    <?php
        if (isset($profile['text5'])) {
            echo $this->form->text('text5', 'text5', htmlspecialchars($profile['text5']));
        }
    ?>
    <?php
        if (isset($profile['text6'])) {
            echo $this->form->text('text6', 'text6', htmlspecialchars($profile['text6']));
        }
    ?>
    <?php
        if (isset($profile['text7'])) {
            echo $this->form->text('text7', 'text7', htmlspecialchars($profile['text7']));
        }
    ?>
    <?php
        if (isset($profile['text8'])) {
            echo $this->form->text('text8', 'text8', htmlspecialchars($profile['text8']));
        }
    ?>
    <?php
        echo $this->form->checkbox('checkbox1', 'checkbox1', !!isset($profile['checkbox1']));
    ?>
    <?php
        echo $this->form->checkbox('checkbox2', 'checkbox2', !!isset($profile['checkbox2']));
    ?>
    <?php
        echo $this->form->checkbox('checkbox3', 'checkbox3', !!isset($profile['checkbox3']));
    ?>
    <?php
        if (isset($profile['radio1'])) {
            echo $this->form->radio(
                'radio1',
                'radio1',
                [0 => 'option0', 1 => 'option1', 2 => 'option2'],
                $profile['radio1']
            );
        }
    ?>

    <input type="hidden" name="<?php echo Csrf::CSRF_TOKEN_KEY; ?>" value="<?php echo $this->token;?>">

    <?php echo $this->form->submit()?>
</form>