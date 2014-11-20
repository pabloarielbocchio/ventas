<?php
// We set the configuration for the form
$form_configs = array();
$form_configs['id'] = 'producto-index-form';
$form_configs['inputDefaults'] = array(
    'class' => 'form-horizontal',
    'div' => array('class' => 'form-group'),
    //validation error messages configuration
    'error' => array('attributes' => array('wrap' => 'span', 'class' => 'label label-danger')),
);

$form_configs['type'] = 'get';
$form_configs['role'] = 'form';
//deactivate HTML5 validation
$form_configs[] = 'novalidate';
?>
<div class="page-header">
<div class="panel panel-default">
                <div class="panel-heading"><?php echo __('Buscar'); ?></div>
<div class="panel-body">
    <?php
    // Search form
    echo $this->Form->create( 'Producto', $form_configs );
    echo $this->Form->input('search-field', array('label' => 'Busqueda', 'class' => 'form-control', 'placeholder' => __('Producto'), 'required' => false));

    ?>
    <div class="pull-right">
        <?php echo $this->Html->link('Reset', array('controller' => 'productos', 'action' => 'index'), array('class' => 'btn btn-default', 'escape' => false, 'title' => 'Click para limpiar el filtro')); ?>
        <?php echo $this->Form->end( array( 'label' => __('Search'), 'class' => 'btn btn-primary', 'div' => false ) ); ?>
    </div>
</div><!-- end body -->
</div>
</div>