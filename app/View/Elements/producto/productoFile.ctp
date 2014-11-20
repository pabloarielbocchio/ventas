<?php
$class_responsive_12 = 'col-xs-12 col-sm-12 col-md-12 col-lg-12';

// If the image is showed when the same name after being replaced, 
// browsers are not going to reload them right away (because of staying in cache)
// So we add a time_stamp after each image file after a post
$time_stamp = '?' . time();

// If we are in an action or edit view
//if ($action == 'edit' || $action == )
//'col-xs-9 col-sm-10'
?>

<?php if ($action == 'edit'): ?>
    <div class="alert alert-warning" role="alert">
        <strong><?php echo __('Cuidado!'); ?></strong>&nbsp;<?php echo __("Si cargas una nueva imagen sobreescribirás la anterior"); ?>
    </div>
<?php endif; ?>

<?php if (isset($preview) && ($preview == true)): ?>
<div class="form-group">
    <label><?php echo __('Logo'); ?></label>
    
    <div class="row ">
        <div class="center <?php echo $class_responsive_12 ?>">
            <?php
            echo $this->Producto->getLogo(array('id' => $producto['Producto']['id']), array('class' => 'img-responsive img-thumbnail', 'height' => 150, 'alt' => $producto['Producto']['nombre']), $time_stamp);
            ?>
        </div>
    </div>
    <div class="form-control">    
        <?php
        echo $this->Form->input('logo', array('type' => 'file', 'div' => false, 'label' => false, 'required' => false,  'error' => false));
        ?>
    </div>
</div>
<?php else: ?>
<?php 
    $options_logo = array(
        'type' => 'file',
        'between' => '<div class="form-control">', 
        'after' => '</div>',
       // 'class' => 'w100p'
    );

    if (isset($tag['Tag']['id'])) {
        if ($this->Tag->getLogo($tag['Tag']) == '') {
          //  $options_logo['class'] = 'w100p';
            $options_logo['required'] = false;
            $options_logo['error'] = true;
        }
    } else if ($action == 'add') {
        $options_logo['class'] = 'validate[required]';
        $options_logo['required'] = false;
        $options_logo['error'] = true;
    }
    echo $this->Form->input('logo', $options_logo); 
?>
<?php endif; ?>

<?php $this->start( 'script_blocks_from_views' ); ?>
<script type="text/javascript">    
    $( document ).ready(function() {
        /*form javascript validation*/
        instanceFormValidateWithAddStyle();
    });
</script>
<?php $this->end( 'script_blocks_from_views' );  ?>