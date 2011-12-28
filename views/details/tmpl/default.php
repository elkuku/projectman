<?php
//echo $this->id;
echo '<a class="command" href="javascript:;" onclick="ProjectMan.refreshProject(\''.$this->id.'\');">Refresh</a>';
// var_dump($this->items);

if( ! count($this->items)) : ?>
<h3 class="newProject">Nothing found - please refresh...</h3>
<?php endif; ?>

<ul>
<?php foreach($this->items as $item) : ?>
<li>
<?php switch($item->vcs) : ?>
<?php case 'git' : 
echo 'git';
 break; ?>
<?php endswitch; ?>
<a href="<?= $item->url.'/'.$item->folder ?>"><?= $item->folder ?></a></li> 
<?php endforeach; ?>
</ul>