<?php
/**
 * @author Dmitri Liventsev <dmitri@credy.eu>
 * User: dmitri
 */

namespace YourOwnFramework;


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
        return printf('<div class="form-group">
                        <label for="%s">%s:</label>
                        <input type="%s" class="form-control" value="%s">
                      </div>', $name, $label, $name, $value);
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

        return printf('<div class="checkbox">
                        <label><input type="checkbox" name="%s" %s> %s</label>
                      </div>', $name, $checked, $label);
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
            $radioButtons .= printf('<label class="radio-inline"><input value="%s" %s type="radio" name="%s">%s</label>', $value, $checked, $name, $option);
        }

        return printf('<div class="form-group"><label for="%s">%s:</label>%s</div>', $name, $label, $radioButtons);
    }

    public function submit()
    {
        return printf('<input type="submit" class="btn btn-default" value="Submit"/>');
    }
}