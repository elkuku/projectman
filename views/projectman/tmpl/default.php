<?php defined('_JEXEC') || die('=;)'); ?>

<h1>ProjectMan by =;)</h1>

<a href="index.php?view=project">New project</a>

<?php if( ! count($this->list)) :?>
<h3 class="newProject">Please create some projects..</h3>
<?php endif; ?>

<?php foreach ($this->list as $projectLoc) : ?>
<?php //var_dump($projectLoc) ?>
	<h3 class="projectLoc"><?= $projectLoc->path ?></h3>
	<a href="<?= $projectLoc->url ?>"><?= $projectLoc->url ?></a>
	<a href="index.php?view=project&id=<?= $projectLoc->id ?>">Edit</a>
<?php
/*
	<ul>
	<?php foreach ($projectLoc->projects as $project) : ?>
	<li>
	<a href="<?= $projectLoc->url.'/'.$project->folder ?>"><?= $project->folder ?></a>
	<?php
	echo $project->folder;
		var_dump($project); ?>
	</li>
	<?php endforeach; ?>
	</ul>
	*/
?>
<?php endforeach;
