
<?php 
        $this->extend('/common/header');
        $this->assign('title','U ownded this '.$count.' games.');
?>

<?php echo $this->Html->link('Add new games', array('controller' => 'games', 'action' => 'add')); ?>
<table>
    <tr>
        <th>Id</th>
        <th>Title</th>
        <th>Year</th>
        <th>Description</th>
        <th>Developer</th>
        <th>Actions</th>
    </tr> 

    <?php foreach ($games as $game): ?>    
    <tr>
        <td><?php echo h($game['Game']['id']); ?></td>
        <td>
            <?php echo $this->Html->link($game['Game']['title'],
                    array('controller'=> 'Games','action' => 'view',$game['Game']['id']));?>
        </td>
        <td>        
            <?php echo h($game['Game']['year']);?>
        </td>
        <td>
            <?php echo h($game['Game']['description']);?>
        </td>        
        <td>
            <?php echo h($game['Game']['developer']);?>
        </td>       
        <td>
            <?php echo $this->Html->link('Edit', array('controller' => 'games', 'action' => 'edit',$game['Game']['id'])); ?>
            <?php echo $this->Html->link('Delete', array('controller' => 'games', 'action' => 'delete',$game['Game']['id']),array('confirm' => 'Are you sure to delete?')); ?>            
        </td> 
    </tr>
    <?php endforeach; ?> 
    
    <?php unset($game); ?>
</table>