<?php
if ($this->blank('content')) {
    echo '<h1>Dat pasta iz no existingz.</h1>';
}
else {
    echo '<form method="post" name="paste" class="hidden">
    <textarea id="pastecontent" name="content">' . $this->get('content') . '</textarea>
    <input type="submit" value="Paste">
    </form>';
}
?>
