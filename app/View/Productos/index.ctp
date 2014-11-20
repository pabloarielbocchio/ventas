<div class="row">
    <div class="col-sm-3" >
        <div class="page-header">
            <div class="panel panel-default">
                <div class="panel-heading">Acciones</div>
                <div class="panel-body">
                    <ul class="nav nav-pills nav-stacked">
                        <li><?php echo $this->Html->link('<span class="glyphicon glyphicon-plus"></span>&nbsp;&nbsp;' . __('Nuevo Producto'), array('action' => 'add'), array('escape' => false)); ?></li>
                    </ul>
                </div>
            </div>
        </div>
        <?php echo $this->element("producto/view/filter"); ?>
    </div><!-- end col md 3 -->
    <div class="col-sm-9">
        <div class="page-header">
            <h1><?php echo __('Productos'); ?></h1>
        </div>
        <table cellpadding="0" cellspacing="0" class="table table-hover">
            <thead>
                <tr>
                    <th><?php echo $this->Paginator->sort('id'); ?></th>
                    <th><?php echo $this->Paginator->sort('nombre'); ?></th>
                    <th><?php echo $this->Paginator->sort('logo'); ?></th>
                    <th><?php echo $this->Paginator->sort('cantidad'); ?></th>
                    <th><?php echo $this->Paginator->sort('precio'); ?></th>
                    <th><?php echo $this->Paginator->sort('descripcion'); ?></th>
                    <th class="actions"></th>

                </tr>
            </thead>
            <tbody>
                <?php foreach ($productos as $producto): ?>
                    <tr>
                        <td><?php echo $this->Html->link($producto['Producto']['id'], array('controller' => 'productos', 'action' => 'view', $producto['Producto']['id'])); ?>&nbsp;</td>
                        <td><?php echo $producto['Producto']['nombre']; ?>&nbsp;</td>
                        <?php
                        // $headerPath = $this->Producto->getHeader($producto['Producto'], array('class' => 'popover-header', 'alt' => $producto['Producto']['nombre']));
                        ?>

                        <?php // If there is only the logo, we change the way that the CSS is showed ?>
                        <td class='singleLogo'>
                            <?php
                            //if ($headerPath == '') {
                            $attributes_buttonPopOver['title'] = 'Logo';
                            //} else {
                            //    $attributes_buttonPopOver['title'] = 'Logo and Header';
                            //}

                            $attributes_logoInButton = array(
                                'height' => 50,
                                'alt' => $producto['Producto']['nombre']
                            );
                            // We join the logo and the header, and remove the " to avoid problems in html
                            $attributes_buttonPopOver['data-content'] = str_replace('"', "'", $this->element('producto/view/popover', array('producto' => $producto)));

                            echo $this->Form->button($this->Producto->getLogo($producto['Producto'], $attributes_logoInButton), $attributes_buttonPopOver);
                            ?>&nbsp;
                        </td>
                        <td><?php echo $producto['Producto']['cantidad']; ?>&nbsp;</td>
                        <td><?php echo $producto['Producto']['precio']; ?>&nbsp;</td>
                        <td><?php echo $producto['Producto']['descripcion']; ?>&nbsp;</td>
                        <td>
                            <div class="btn-group">
                                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                    Acción <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu" role="menu">
                                    <li><?php echo $this->Html->link("Ver", array('action' => 'view', $producto['Producto']['id'])); ?></li>
                                    <li><?php echo $this->Html->link("Editar", array('action' => 'edit', $producto['Producto']['id'])); ?></li>
                                </ul>
                            </div>
                        </td>

                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <p>
            <small><?php echo $this->Paginator->counter(array('format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}'))); ?></small>
        </p>

        <?php
        $params = $this->Paginator->params();
        if ($params['pageCount'] > 1) {
            ?>
            <ul class="pagination pagination-sm pull-right">
                <?php
                echo $this->Paginator->prev('&larr; Previous', array('class' => 'prev', 'tag' => 'li', 'escape' => false), '<a onclick="return false;">&larr; Previous</a>', array('class' => 'prev disabled', 'tag' => 'li', 'escape' => false));
                echo $this->Paginator->numbers(array('separator' => '', 'tag' => 'li', 'currentClass' => 'active', 'currentTag' => 'a'));
                echo $this->Paginator->next('Next &rarr;', array('class' => 'next', 'tag' => 'li', 'escape' => false), '<a onclick="return false;">Next &rarr;</a>', array('class' => 'next disabled', 'tag' => 'li', 'escape' => false));
                ?>
            </ul>
        <?php } ?>

    </div> <!-- end col md 9 -->
    <!--</div> end row -->

</div><!-- end containing of content -->