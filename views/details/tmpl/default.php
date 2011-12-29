<?php
//echo $this->id;
echo '<a class="command" href="javascript:;" onclick="ProjectMan.refreshProject(\''.$this->id.'\');">Refresh</a>';
// var_dump($this->items);

if( ! count($this->items)) : ?>
<h3 class="newProject">Nothing found - please refresh...</h3>
<?php endif; ?>

<ul>
<?php foreach($this->items as $item) :
    $icons = array();
    if($item->isjoomla) $icons[] = 'joomla';
    if('git' == $item->vcs) $icons[] = 'git';
    ?>
<li>
    <?php
foreach($icons as $icon) :
    echo '<div class="icon ico-'.$icon.'" />';
endforeach;

    switch($item->vcs) : ?>
<?php case 'git' :
echo '<a class="command" href="javascript:;" onclick="ProjectMan.toggle(\'branches-'.$this->id.'-'.$item->id.'\');">Branches</a>';
echo '<a class="command" href="javascript:;" onclick="ProjectMan.toggle(\'status-'.$this->id.'-'.$item->id.'\');">Status</a>';
 break; ?>
<?php endswitch; ?>
<a href="<?= $item->url.'/'.$item->folder ?>"><?= $item->folder ?></a>
    <?php
    echo '<pre class="git" id="branches-'.$this->id.'-'.$item->id.'">'.$item->branches.'</pre>';
    echo '<pre class="git" id="status-'.$this->id.'-'.$item->id.'">'.$item->status.'</pre>';
//var_dump($item);
?>
</li>
<?php endforeach; ?>
</ul>
