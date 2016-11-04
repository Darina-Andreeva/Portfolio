<?php
/*
*  ACF Post Type Select Field Class
*  Build from the field type template (https://github.com/elliotcondon/acf-field-type-template) using the select field for reference by Savage Brands
*  All the logic for this field type
*
*  @class 		acf_field_post_type_select
*  @extends		acf_field
*  @package		ACF
*  @subpackage	Fields
*/

if( ! class_exists('acf_field_post_type_select') ) :
class acf_field_post_type_select extends acf_field {
	/*
	*  __construct
	*
	*  This function will setup the field type data
	*
	*  @type	function
	*  @date	5/03/2014
	*  @since	5.0.0
	*
	*  @param	n/a
	*  @return	n/a
	*/
	
	function __construct() {
		
		// vars
		$this->name = 'post_type_select';
		$this->label = __("Post Type Select",'acf');
		$this->category = 'choice';
		$this->defaults = array(
			'multiple' 		=> 0,
			'allow_null' 	=> 0,
			'placeholder'	=> '',
			'disabled'		=> 0,
			'readonly'		=> 0,
		);
		
		// do not delete!
    	parent::__construct();
	}

	/*
	*  render_field()
	*
	*  Create the HTML interface for your field
	*
	*  @param	$field - an array holding all the field's data
	*
	*  @type	action
	*  @since	3.6
	*  @date	23/01/13
	*/
	
	function render_field( $field ) {
        
		// convert value to array
		$field['value'] = acf_get_array($field['value'], false);
        
		// add empty value (allows '' to be selected)
		if( empty($field['value']) ){
			$field['value'][''] = '';
		}
        
		// placeholder
		if( empty($field['placeholder']) ) {
			$field['placeholder'] = __("Select",'acf');
		}
        
		// vars
		$atts = array(
			'id'				=> $field['id'],
			'class'				=> $field['class'],
			'name'				=> $field['name'],
			'data-multiple'		=> $field['multiple'],
			'data-placeholder'	=> $field['placeholder'],
			'data-allow_null'	=> $field['allow_null']
		);
        
		// multiple
		if( $field['multiple'] ) {
			$atts['multiple'] = 'multiple';
			$atts['size'] = 5;
			$atts['name'] .= '[]';
		}
        
		// special atts
		foreach( array( 'readonly', 'disabled' ) as $k ) {
			if( !empty($field[ $k ]) ) {
				$atts[ $k ] = $k;
			}
		}
        
		// vars
		$els = array();
		$choices = array();
        
        //loop through post types and add as options
        $postTypesArgs = array(
           'public'   => true,
           //'_builtin' => false
        );
        $postTypesOutput = 'objects';
        $postTypesOperator = 'and';
        $postTypes = get_post_types( $postTypesArgs,$postTypesOutput,$postTypesOperator );
        foreach($postTypes as $k => $v){
			$name = $v->name;
			$label = $v->label;
			$els[] = array( 'type' => 'optgroup', 'label' => $name );
			$els[] = array( 'type' => 'option', 'value' => $name, 'label' => $label,'selected' => in_array($name, $field['value']));
			$choices[] = $name;
			$els[] = array( 'type' => '/optgroup' );
		}
        
		// hidden input
        if( $field['multiple'] ) {
			acf_hidden_input(array(
				'type'	=> 'hidden',
				'name'	=> $field['name'],
			));
		}
        
		// null
		if( $field['allow_null'] ) {
			array_unshift( $els, array( 'type' => 'option', 'value' => '', 'label' => '- ' . $field['placeholder'] . ' -' ) );
		}		

		// html
		echo '<select ' . acf_esc_attr( $atts ) . '>';	
		if( !empty($els) ) {
			foreach( $els as $el ) {
				// extract type
				$type = acf_extract_var($el, 'type');
				if( $type == 'option' ) {
					// get label
					$label = acf_extract_var($el, 'label');
					// validate selected
					if( acf_extract_var($el, 'selected') ) {
						$el['selected'] = 'selected';
					}
					// echo
					echo '<option ' . acf_esc_attr( $el ) . '>' . $label . '</option>';
				} else {
					// echo
					echo '<' . $type . ' ' . acf_esc_attr( $el ) . '>';
				}
			}
		}
		echo '</select>';
	}

	/*
	*  render_field_settings()
	*
	*  Create extra options for your field. This is rendered when editing a field.
	*  The value of $field['name'] can be used (like bellow) to save extra data to the $field
	*
	*  @type	action
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	$field	- an array holding all the field's data
	*/
	
	function render_field_settings( $field ) {
		
        // allow_null
		acf_render_field_setting( $field, array(
			'label'			=> __('Allow Null?','acf'),
			'instructions'	=> '',
			'type'			=> 'radio',
			'name'			=> 'allow_null',
			'choices'		=> array(
				1				=> __("Yes",'acf'),
				0				=> __("No",'acf'),
			),
			'layout'	=>	'horizontal',
		));
		
        // multiple
		acf_render_field_setting( $field, array(
			'label'			=> __('Select multiple values?','acf'),
			'instructions'	=> '',
			'type'			=> 'radio',
			'name'			=> 'multiple',
			'choices'		=> array(
				1				=> __("Yes",'acf'),
				0				=> __("No",'acf'),
			),
			'layout'	=>	'horizontal',
		));
	}

	/*
	*  load_value()
	*
	*  This filter is applied to the $value after it is loaded from the db
	*
	*  @type	filter
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	$value (mixed) the value found in the database
	*  @param	$post_id (mixed) the $post_id from which the value was loaded
	*  @param	$field (array) the field array holding all the field options
	*  @return	$value
	*/
	
	function load_value( $value, $post_id, $field ) {
		
        // ACF4 null
		if( $value === 'null' ) {
			return false;
		}
		
        // return
		return $value;
	}
	
	/*
	*  update_field()
	*
	*  This filter is appied to the $field before it is saved to the database
	*
	*  @type	filter
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	$field - the field array holding all the field options
	*  @param	$post_id - the field group ID (post_type = acf)
	*
	*  @return	$field - the modified field
	*/

	function update_field( $field ) {
		// decode choices (convert to array)
		//$field['choices'] = acf_decode_choices($field['choices']);
		// return
		return $field;
	}

	/*
	*  update_value()
	*
	*  This filter is appied to the $value before it is updated in the db
	*
	*  @type	filter
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	$value - the value which will be saved in the database
	*  @param	$post_id - the $post_id of which the value will be saved
	*  @param	$field - the field array holding all the field options
	*
	*  @return	$value - the modified value
	*/
	
	function update_value( $value, $post_id, $field ) {
		
        // validate
		if( empty($value) ) {
			return $value;
		}

		// array
		if( is_array($value) ) {
			// save value as strings, so we can clearly search for them in SQL LIKE statements
			$value = array_map('strval', $value);
		}
		
		// return
		return $value;
	}
	
}

new acf_field_post_type_select();
endif;
?>