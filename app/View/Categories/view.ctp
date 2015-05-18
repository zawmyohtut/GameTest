
<?php 
        $this->extend('/common/header');
        $this->assign('title','Game Category');
?>

<p>Genre : <?php echo h($category['Category']['name']);?></p>
<p>Game Length : <?php echo h($category['Category']['length_type']);?></p>

