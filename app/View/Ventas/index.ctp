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

        <?php foreach ($productos as $producto): ?>
            <div class="panel panel-default col-sm-2 col-md-offset-1">
                <!-- Default panel contents -->
                <div class="panel-heading"><?php echo $this->Html->link($producto['Producto']['nombre'], array('controller' => 'productos', 'action' => 'view', $producto['Producto']['id'])); ?></div>
                <div class="panel-body">
                     <table class="table">
                        <tr>
                            <?php
                                $path = $this->Venta->getPathLogo($producto['Producto']);
                            ?>&nbsp;
                            <img src="<?php echo $path; ?>" alt="" class="img-thumbnail img-responsive center-block" height="100" >
                        </tr>
                        <tr><br></tr>
                        <tr><?php echo "PRECIO: $".$producto['Producto']['precio']; ?>&nbsp;</tr><br>
                        <div row>
                        <tr><?php echo "Cantidad: "."<input id=producto".$producto['Producto']['id']." style='width: 20%;' value=1>"; ?>
  
                        <a href="" class="glyphicon glyphicon-shopping-cart"></a>
                        </div>
                        &nbsp;</tr>
                     </table>
                </div>
            </div>

        <?php endforeach; ?>
        </tbody>



    </div> <!-- end col md 9 -->
    <!--</div> end row -->

</div><!-- end containing of content -->