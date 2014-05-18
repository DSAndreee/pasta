<?php
if ($this->blank('paste')) {
    echo '<h1>Dat pasta iz no existingz.</h1>';
}
else {
    echo '<div class="readbox">' . $this->values['paste']['content'] . '</div>';
}
?>
