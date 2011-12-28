<?php defined('_JEXEC') || die('=;)'); ?>

<h1>ProjectMan by =;)</h1>

<?php if( ! count($this->list)) :?>
<h3 class="newProject">Please create some projects..</h3>
<?php endif; ?>

<a class="command newProject" href="index.php?view=project">New project</a>

<?php foreach ($this->list as $projectLoc) : ?>
<?php //var_dump($projectLoc) ?>
	<div class="projectLoc">

	<ul class="commands">
	<li><a class="command" id="command-<?= $projectLoc->id ?>" href="javascript:;" onclick="ProjectMan.loadProject('<?= $projectLoc->id ?>');">Show</a></li>
	<li><a class="command" href="index.php?view=project&id=<?= $projectLoc->id ?>">Edit</a></li>
	<li><a class="command" href="index.php?task=delete&id=<?= $projectLoc->id ?>">Delete</a></li>
	</ul>
	<h3 class="projectLoc"><?= $projectLoc->path ?></h3>
	
	<a href="<?= $projectLoc->url ?>"><?= $projectLoc->url ?></a>
	
	<div class="projectContent" id="container-<?= $projectLoc->id ?>"></div>
	
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
	</div>
<?php endforeach;
