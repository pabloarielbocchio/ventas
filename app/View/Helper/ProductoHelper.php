<?php
/**
 * TagHelper
 * 
 * Gets the path for logo and header from the tag
 * @author esteban
 */
class ProductoHelper extends AppHelper {

    public $helpers = array( 'Html' );
    
    /**
     * Returns html element for image of tag
     * 
     * Returns an HTML image element with options defined on parameters  conatining the tag logo with correct path
     * @param type $tag Data from tag ( must have id field )
     * @param type $options Options for the HTML element
     * @param string $time_stamp Useful for reloading cache after an image has changed (i.e, echo ... ( '.../logo.png?' . time() )
     * @return string element to echo to view
     */
    public function getLogo( $producto = array(), $options = array(), $time_stamp = '' ) {
        $imgpath = '/files/productos/logo/'.$producto['id'].'/logo.png';
        $path = env('DOCUMENT_ROOT').DS.APP_DIR.DS.WEBROOT_DIR.$imgpath;
        $path = ".".str_replace("/", "/", $imgpath);

        //check file exist
        if (file_exists($path)) 
            return $this->Html->image($imgpath.$time_stamp, $options);
        else 
            return $this->Html->image('/files/productos/logo/default.jpg', $options);
        
        return '';
    }
    
    
    
}
