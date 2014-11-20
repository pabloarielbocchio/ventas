<div class="row">        
    <div class="col-sm-3" >
        <div class="page-header">
            <div class="panel panel-default">
                <div class="panel-heading">Acciones</div>
                <div class="panel-body">
                    <ul class="nav">
                        <li><?php echo $this->Html->link('<span class="glyphicon glyphicon-plus"></span>&nbsp;&nbsp;' . __('Nuevo Producto'), array('action' => 'add'), array('escape' => false)); ?></li>
                        <li><?php echo $this->Html->link('<span class="glyphicon glyphicon-pencil"></span>&nbsp;&nbsp;' . __('Editar Producto'), array('action' => 'edit', $producto['Producto']['id']), array('escape' => false)); ?></li>
                        <li><?php echo $this->Html->link('<span class="glyphicon glyphicon-list"></span>&nbsp;&nbsp;' . __('Listar Productos'), array('action' => 'index'), array('escape' => false)); ?></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-9 form">


        <table cellpadding="0" cellspacing="0" class="table table-striped">
            <tbody>
            <h1><?php echo __(h($producto['Producto']['nombre'])); ?></h1>
            <h4><?php echo __('Description: %s', h($producto['Producto']['descripcion'])); ?>
                &nbsp;
            </h4>
            <h4><?php echo __('Cantidad: %s', h($producto['Producto']['cantidad'])); ?>
                &nbsp;
            </h4>
            <h4>
                <?php echo __('Precio: %s', $producto['Producto']['precio']); ?>
                &nbsp;
            </h4>
            </tbody>
        </table>


        <div class="panel panel-default">
            <div class="panel-heading"><?php echo __('Archivo'); ?></div>
            <div class="panel-body">
                <?php echo $this->Form->create('Producto', array('role' => 'form', 'novalidate' => true, 'type' => 'file')); ?>

                <?php echo $this->Form->error('logo', null, array('class' => 'alert alert-danger alert-dismissible error-message')); ?>

                <div class="form-group hidden">
                    <?php echo $this->Form->input('id', array('class' => 'form-control')); ?>
                </div>

                <?php echo $this->Element('/producto/productoFile', array('producto' => $producto, 'preview' => true, 'action' => 'view')); ?>

                <div class="pull-right">
                    <?php echo $this->Form->submit(__('Update'), array('class' => 'btn btn-primary', 'div' => false)); ?>
                </div>

                <?php echo $this->Form->end() ?>
            </div><!-- end body -->
        </div><!-- end panel -->
    </div><!-- end col md 9 -->

</div>




