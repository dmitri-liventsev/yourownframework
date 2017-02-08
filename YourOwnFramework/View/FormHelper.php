<?php
/**
 * @author Dmitri Liventsev <dmitri@credy.eu>
 * User: dmitri
 */

namespace YourOwnFramework\View;


class FormHelper
{
    const CONTAINER_KEY = 'form_helper';

    /**
     * @param string $name
     * @param string $label
     * @param string $value
     * @param array $params
     *
     * @return string
     */
    public function text(string $name, string $label = '', string $value = '', array $params = [])
    {
        return "<div class='form-group'>
                        <label for='$name'>$label:</label>
                        <input name='$name' class='form-control' value='$value'>
                      </div>";
    }

    /**
     * @param string $name
     * @param string $label
     * @param bool $isChecked
     * @param array $params
     *
     * @return string
     */
    public function checkbox(string $name, string $label = '', $isChecked = false, array $params = [])
    {
        $checked = $isChecked? 'checked="checked"' : '';

        return "<div class=\"checkbox\">
                        <label><input type=\"checkbox\" name=\"$name\" $checked> $label</label>
                      </div>";
    }

    /**
     * @param string $name
     * @param string $label
     * @param array $options
     * @param null $defaultValue
     * @param array $params
     *
     * @return string
     */
    public function radio(string $name, string $label, $options = [], $defaultValue = null, array $params = [])
    {
        $radioButtons = '';

        foreach($options as $value => $option) {
            $checked = $value == $defaultValue ? 'checked="checked"' : '';
            $radioButtons .= "<label class=\"radio-inline\"><input value=\"$value\" $checked type=\"radio\" name=\"$name\">$option</label>";
        }

        return "<div class=\"form-group\"><label for=\"$name\">$label:</label>$radioButtons</div>";
    }

    public function submit()
    {
        return '<input type="submit" class="btn btn-default" value="Submit"/>';
    }
}