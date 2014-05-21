<div>
<form method="post" name="paste" action="?action=paste" class="hidden">
<textarea id="pastecontent" name="content"><?php echo $this->get('content'); ?></textarea>
<input type="text" id="expire" name="expire" value="open">
<input type="text" id="syntax" name="syntax" value="<?php echo $this->get('syntax'); ?>">
<input type="submit" value="Paste">
</form>
</div>
