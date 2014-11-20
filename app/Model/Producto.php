<?php
App::uses('AppModel', 'Model');
App::uses('Folder', 'Utility');
App::uses('File', 'Utility');

/**
 * Tag Model
 *
 * @property Company $Company
 * @property Campaign $Campaign
 */
class Producto extends AppModel {

    
    public $recursive = -1;

    /**
     * Validation rules
     *
     * @var array
     */
    public $validate = array(
        'nombre' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),
            //'message' => 'Your custom message here',
                'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            )
        ),
        'precio' => array(
            'numeric' => array(
                'rule' => array('numeric'),
            //'message' => 'Your custom message here',
                'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            )
        ),
        'cantidad' => array(
            'numeric' => array(
                'rule' => array('numeric'),
            //'message' => 'Your custom message here',
                'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            )
        ),
        'codigo_barra' => array(
            'notEmpty' => array(
             //   'rule' => array('notEmpty'),
            //'message' => 'Your custom message here',
                'allowEmpty' => true,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            )
        )
    );
public $actsAs = array(
        'Upload.Upload' => array(
            'logo' => array(
                'path' => '{ROOT}webroot{DS}files{DS}productos{DS}{field}{DS}',
                'pathMethod' => 'primaryKey',
                'nameCallback' => 'filenameHandler',
                'thumbnails' => true,
                'thumbnailMethod' => 'php',
                'thumbnailName' => 'logo',
                'thumbnailType' => 'png',
                'thumbnailQuality' => 100,
                'thumbnailPrefixStyle' => false,
                'fields' => array( // Avoid problems with the type in company
                    'type' => null
                ),
                'thumbnailSizes' => array(
                   'normal' => '150ml' /* Allow to be 100 px the longest side of the image */
                )
            )
        )
    );
     
    /**
     * belongsTo associations
     *
     * @var array
     */
    public $belongsTo = array(
    );
       //The Associations below have been created with all possible keys, those that are not needed can be removed

    /**
     * hasMany associations
     *
     * @var array
     */
    public $hasMany = array(
        'VentaProducto' => array(
            'className' => 'VentaProducto',
            'foreignKey' => 'producto_id',
        ),
    );

    /**
     * hasAndBelongsToMany associations
     *
     * @var array
     */
    public $hasAndBelongsToMany = array(
    );
    /**
     * Crops the header from the top
     * 
     * This function is called before doing any thumbnails. Crops the header and saves the untouched image
     * as 'untouched' in their corresponding dir of company
     * @param array $data Data sended to the model
     * @param int $MAX_WIDTH Final max width for the header
     * @param int $MAX_HEIGHT Final max height for the header
     */
    private function cropHeaderFromFile($data, $MAX_WIDTH = 1200, $MAX_HEIGHT = 500) {

        // 0 => width, 1 => height ||| http://php.net/manual/es/function.getimagesize.php
        $img_file = $data['Tag']['preview']['tmp_name'];
        $img_size = getimagesize($img_file);

        $img_width = $img_size[0];
        $img_height = $img_size[1];

        $img_height_after_resize = $img_height * $MAX_WIDTH / $img_width;

        // If the height is higher than a max height, we crop the extra part
        if ($img_height_after_resize > $MAX_HEIGHT) {

            $img = new Imagick($img_file);

            // If we are editing, we can save the untouched image because the ID has been already created
            if (isset($data['Tag']['id'])) {
                // Creates folder (just in case that is needed)
                $dir = new Folder(WWW_ROOT . 'files'.DS.'tag'.DS.'header'.DS.$data['Producto']['id'], true, 0755);
                $img->writeImage($dir->pwd() .DS.'untouched.' . pathinfo($data['Producto']['preview']['name'], PATHINFO_EXTENSION));
            } else {
                // We can't save the old one as untouched because we don't know the ID, so we save it using their creation date and then we move it
                $img->writeImage(WWW_ROOT . 'files'.DS.'tag'.DS.'header'.DS.$data['Producto']['header_name'].'.' . pathinfo($data['Tag']['preview']['name'], PATHINFO_EXTENSION));
            }

            // We calculte what would be the best width before croping
            $img_new_height = $MAX_HEIGHT * $img_width / $MAX_WIDTH;

            // And we crop the image from the top
            $img->cropImage( $img_width, $img_new_height, 0, 0 );

            // And then we save it
            $img->writeImage($img_file);
        }

    }
    
    /**
     * Files naming callback
     * 
     * This function will search if the name of the file coincides with the resized image name so there is no overwriting
     * @param string $field Field name to check
     * @param string $currentName Current file name with extension included
     * @param array $data Data sended to the model
     * @param array $options Options
     * @return Name of file
     */
    public function filenameHandler( $field, $currentName, $data, $options ) {
        if( $options['saveType'] === 'create' || $options['saveType'] === 'update' ) {
            // We delete the previous files stored
            $this->deleteImage($field, $data);
            $currentName = 'original.' . pathinfo($data['Producto'][$field]['name'], PATHINFO_EXTENSION);
            
            // If we are working with a header
            if (isset($data['Producto']) && 
//                isset($data['TagCompany']['preview']) && 
                isset($data['Producto']['preview']['tmp_name']) &&
                file_exists($data['Producto']['preview']['tmp_name'])) {
                
                $this->cropHeaderFromFile($data);
            }
            
        }
        return $currentName;
    }

   
    /**
     * Get image path for the logo of the tag if exists or false in
     * other case
     * 
     * @param type $tag
     * @return boolean|string
     */
    public function getLogoPath($tag) {
        $imgpath = DS.'files'.DS.'tag'.DS.'logo'.DS.$tag['id'].DS.'logo.png';
        
        //check file exist
        if (is_file(env('DOCUMENT_ROOT').DS.APP_DIR.DS.WEBROOT_DIR.$imgpath)) {
            return $imgpath;
        }
        
        return false;        
    }
    
    
        public function deleteImage($field, $data) {
        
        // If there are files in there
        if (isset($data['Tag']['id'])) {

            $dir = new Folder(WWW_ROOT . 'files' . DS . 'tag' . DS . $field . DS . $data['Tag']['id']);
            $files = $dir->find();

            foreach ($files as $file) {
                $file = new File($dir->pwd() . DS . $file);
                $file->delete();
                $file->close();
            }

        }
    }
    public function getById($productoId) {
        $productoId = intval($productoId);
        if (!$productoId) {
            throw new NotFoundException(__('Invalid Company id'));
        }        
        $producto = $this->find(
                'first', 
                array(
                    'conditions' => array(
                        'id' => $productoId,
                    )
                )
            );
        
        if (empty($producto)) {
            return false;
        } else {
            return $producto;
        }
    }
}