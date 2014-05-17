<h1>
<?php
if ($this->blank('paste')) {
    echo 'Dat pasta iz no existingz';
}
else {
    echo $this->values['paste']['title'];
}
?>
</h1>
<div class="readbox">
<?php
if (!$this->blank('paste')) {
    echo $this->values['paste']['content'];
} 
?>
</div>

