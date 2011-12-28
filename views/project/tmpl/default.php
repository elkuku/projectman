<?php defined('_JEXEC') || die('=;)'); ?>

<h1><?= ($this->item->id) ? 'Edit project' : 'New project' ?></h1>

<form action="index.php?task=save" method="post">
	<label>Id</label>
	<input type=text name="id" readonly="readonly" size="2" value="<?= $this->item->id ?>" />

	<label for="path">Path</label>
	<input type=text name="path" id="path" size="40" value="<?= $this->item->path ?>" />

	<label for="path">URL</label>
	<input type=text name="url" id="url" size="40" value="<?= $this->item->path ?>" />

	<input type="hidden" name="task" value="save" />

	<input type="submit" value="Save" />
</form>
