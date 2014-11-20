<?php
App::uses('FormHelper', 'View/Helper');
/**
 * CakePHP ActionMenuHelper
 * @author esteban
 */
class ActionMenuHelper extends FormHelper {

    /**
     *
     * @var type 
     */
    public $helpers = array('Html');
    
    /**
     * List of actions to be used
     * 
     * @var array
     */
    private $actions = array();

    /**
     * Adds an action to the menu to generate
     * 
     * @param string $text texto to show to user
     * @param array|string $url array for url or string
     * @param string $icon Glyphicon to use
     */
    public function addAction( $text, $url, $icon = null, $htmlParams = array() ) {
        $item_menu = array(
          'text' => $text,
          'url' => $url,
          'icon' => $icon,
          'isPostLink' => false,
          'separator' => false,
          'header' => false,
          'htmlParams' => $htmlParams
        );
        if( empty( $item_menu['text'] ) && !is_array( $item_menu['url'] ) ) {
            $item_menu['text'] = $item_menu['url'];
        } else if( empty( $item_menu['text'] ) && is_array( $item_menu['url'] ) ) {
            $item_menu['text'] = Hash::flatten( $item_menu['url'] );
        }
        $this->actions[] = $item_menu;
    }
    
    /**
     * 
     * @param type $text
     * @param type $url
     * @param type $post_message
     * @param type $icon
     */
    public function addPostAction( $text, $url, $post_message, $icon = null ) {
        $item_menu = array(
          'text' => $text,
          'url' => $url,
          'icon' => $icon,
          'post_message' => $post_message,
          'isPostLink' => true,
          'separator' => false,
          'header' => false
        );
        if( empty( $item_menu['text'] ) && !is_array( $item_menu['url'] ) ) {
            $item_menu['text'] = $item_menu['url'];
        } else if( empty( $item_menu['text'] ) && is_array( $item_menu['url'] ) ) {
            $item_menu['text'] = Hash::flatten( $item_menu['url'] );
        }
        $this->actions[] = $item_menu;
    }

    /**
     * Adds a separator for the menu
     * 
     */
    public function addSeparator() {
        $this->actions[] = array( 'separator' => true );
    }
    
    /**
     * Adds an header for the menu
     * 
     * 
     * @param string $text Text to add to the header
     */
    public function addHeader( $text ) {
        $this->actions[] = array(
            'separator' => false,
            'header' => true,
            'text' => $text
        );
    }
    
    /**
     * Outputs the menu
     */
    public function showMenu( $text = 'Actions' ) {
        if( count( $this->actions ) > 0 ) {
            $uid = String::uuid();
            $contents = $this->Html->tag( 'button',
                $this->Html->tag( 'span', $text."&nbsp;" , array( 'class' => 'hidden-xs action-menu-text' ), array( 'escape' => false ) ) .
                $this->Html->tag( 'span', '', array( 'class' => 'caret' ), array( 'escape' => false ) ),
                array( 
                    "class" => "btn btn-primary dropdown-toggle",
                    "id" => 'dropdownMenu'.$uid,
                    "data-toggle" => "dropdown",
                    "data-disabled" => true
                ),
                array( 'escape' => false )
            );       
            $list = '';
            foreach( $this->actions as $action ) {
                if( $action['separator'] ) {
                    $list .= $this->Html->tag( 'li', '', array( 'role' => 'presentation', 'class' => 'divider' ) );
                } else if( $action['header'] ) {
                    $list .= $this->Html->tag( 'li', $action['text'], array( 'role' => 'presentation', 'class' => 'dropdown-header' ) );
                } else {
                    $link_content = '';
                    if( $action['icon'] != null ) {
                        $link_content .= $this->Html->tag( 'span', '', array( 'class' => 'glyphicon glyphicon-'.$action['icon'] ), array( 'escape' => false ) );
                    }
                    $link_content .= "&nbsp;".$action['text'];
                    if( !$action['isPostLink'] ) {
                        $link_content = $this->Html->link( $link_content, 
                                                           $action['url'], 
                                                           array_merge(array( 'role' => 'menuitem', 'tabindex' => '-1', 'escape' => false ) , $action['htmlParams']) );
                    } else {
                        $link_content = $this->getBootstrapModalConfirmation( $link_content, 
                                                                                    $action['url'], 
                                                                                    array( 'role' => 'menuitem', 'tabindex' => '-1', 'escape' => false ), 
                                                                                    $action['post_message'] );
                    }
                    
                    $list .= $this->Html->tag( 'li', $link_content, array( 'role' => 'presentation' ), array( 'escape' => false ) );
                }
            }
            $contents .= $this->Html->tag( 'ul', $list, array( 'class' => 'dropdown-menu dropdown-menu-right', 'role' => 'menu', 'aria-labelledby' => 'dropdownMenu'.$uid ) );
            echo $this->Html->tag( 'div', $contents, array( 'class' => 'dropdown d-inblock' ) );
        } else {
           echo $this->Html->tag( 'button', $text, array( 'class' => 'btn btn-default hidden' ) );
        }
        $this->actions = array();
    }
    
    /**
     * 
     * @param type $title
     * @param string $url
     * @param type $options
     * @param type $confirmMessage
     * @return type
     */
    private function getBootstrapModalConfirmation($title, $url = null, $options = array(), $confirmMessage = false) {
		$options = (array)$options + array('inline' => true, 'block' => null);
		if (!$options['inline'] && empty($options['block'])) {
			$options['block'] = __FUNCTION__;
		}
		unset($options['inline']);

		$requestMethod = 'POST';
		if (!empty($options['method'])) {
			$requestMethod = strtoupper($options['method']);
			unset($options['method']);
		}
		if (!empty($options['confirm'])) {
			$confirmMessage = $options['confirm'];
			unset($options['confirm']);
		}

		$formName = str_replace('.', '', uniqid('post_', true));
		$formUrl = $this->url($url);
		$formOptions = array(
			'name' => $formName,
			'id' => $formName,
			'style' => 'display:none;',
			'method' => 'post',
		);
		if (isset($options['target'])) {
			$formOptions['target'] = $options['target'];
			unset($options['target']);
		}

		$this->_lastAction($url);
        
       

		$out = $this->Html->useTag('form', $formUrl, $formOptions);
		$out .= $this->Html->useTag('hidden', '_method', array(
			'value' => $requestMethod
		));
        
        $out .= $this->_csrfField();

		$fields = array();
		if (isset($options['data']) && is_array($options['data'])) {
			foreach (Hash::flatten($options['data']) as $key => $value) {
				$fields[$key] = $value;
				$out .= $this->hidden($key, array('value' => $value, 'id' => false));
			}
			unset($options['data']);
		}
		$out .= $this->secure($fields);
		$out .= $this->Html->useTag('formend');

		if ($options['block']) {
			$this->_View->append($options['block'], $out);
			$out = '';
		}
		unset($options['block']);

		$url = '#';
		$onClick = 'document.' . $formName . '.submit();';
		if ($confirmMessage) {
            $message = json_encode($confirmMessage);
            $confirm = "confirm( {$message}, function() { {$onClick} } ); ";
            if (isset($options['escape']) && $options['escape'] === false) {
                $confirm = h($confirm);
            }
			$options['onclick'] = $confirm;
		} else {
			$options['onclick'] = $onClick . ' ';
		}
		$options['onclick'] .= 'event.returnValue = false; return false;';
        $options = array_merge($options, $htmlParams);

		$out .= $this->Html->link( $title, $url, $options );
		return $out;
    }

}
