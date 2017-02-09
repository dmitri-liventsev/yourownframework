<?php
/**
 * @author Dmitri Liventsev <dmitri@credy.eu>
 * @var $activeProfiles \App\Model\Entity\Profile[]
 */
$activeProfilesJson = json_encode($activeProfiles);

echo <<<JS
var activeProfiles = $activeProfilesJson;

console.log(activeProfiles);

function HtmlEncode(s)
{
  var el = document.createElement("div");
  el.innerText = el.textContent = s;
  s = el.innerHTML;
  return s;
}
JS;
