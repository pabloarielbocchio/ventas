<div class='popover-logo-header'>
    <?php
    echo $this->Producto->getLogo($producto['Producto'], array('class' => 'popover-logo', 'alt' => $producto['Producto']['nombre']));
    ?>
</div>