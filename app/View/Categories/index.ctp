
<?php 
        $this->extend('/common/header');
        $this->assign('title','List of Categories');
?>

<table>
    <tr>
        <th>Id</th>
        <th>Name</th>
        <th>Length_type</th>
        <th>Actions</th>
    </tr> 
    <?php echo $this->Html->link('Add new Category',array('controller'=>'categories','action'=>'add'));?>
    
    <?php foreach ($categories as $category): ?>    
    <tr>
        <td><?php echo h($category['Category']['id']); ?></td>
        <td>
            <?php echo $this->Html->link($category['Category']['name'],
                    array('controller'=> 'categories','action' => 'view',$category['Category']['id']));?>
        </td>
        <td>        
            <?php echo h($category['Category']['length_type']);?>
        </td>

        <td>
            <?php echo $this->Html->link('Edit', array('controller' => 'categories', 'action' => 'edit',$category['Category']['id'])); ?>
            <?php echo $this->Html->link('Delete', array('controller' => 'categories', 'action' => 'delete',$category['Category']['id']),array('confirm' => 'Are you sure to delete?')); ?>            
        </td> 
    </tr>
    <?php endforeach; ?> 
    
    <?php unset($category); ?>
</table>