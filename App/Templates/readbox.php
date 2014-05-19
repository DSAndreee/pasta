<?php
if ($this->blank('paste')) {
    echo '<h1>Dat pasta iz no existingz.</h1>';
}
else {
    //echo '<div class="readbox">' . $this->values['paste']['content'] . '</div>';
    echo '<form method="post" name="paste">
    <textarea id="pastecontent" name="content">'.$this->values['paste']['content'].'</textarea>
    <input type="submit" value="Paste">
    </form>';

}
?>
