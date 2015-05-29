
<?php 
        $this->extend('/common/header');
        $this->assign('title','List of Users');
?>

<?php echo $this->Html->link('Register new users', array('controller' => 'users', 'action' => 'add')); ?>
<table>
    <tr>        
        <th>Lastname</th>
        <th>Firstname</th>
        <th>username</th>
        <th>Password</th>
        <th>Actions</th>
    </tr> 

    <?php foreach ($users as $user): ?>    
    <tr>    
        <td>        
            <?php echo h($user['User']['last_name']);?>
        </td>
        <td>
            <?php echo h($user['User']['first_name']);?>
        </td>        
        <td>
            <?php echo $this->Html->link($user['User']['username'],
                    array('controller'=> 'Games','action' => 'view',$user['User']['id']));?>
        </td>       
        <td>
            <?php echo h($user['User']['password']);?>
        </td>       
        <td>
            <?php echo $this->Html->link('Edit', array('controller' => 'users', 'action' => 'edit',$user['User']['id'])); ?>
            <?php echo $this->Html->link('Delete', array('controller' => 'users', 'action' => 'delete',$user['User']['id']),array('confirm' => 'Are you sure to delete?')); ?>            
        </td> 
    </tr>
    <?php endforeach; ?> 
    
    <?php unset($user); ?>
</table>