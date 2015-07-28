<?php

$block_type = 'hwr-features';

$elements = array(
	'block-container',
	'block-before',
	'block-before-h1',
	'block-before-h1-alt',
	'block-before-h2',
	'block-before-h2-alt',
	'block-before-p',
	'block-title',
	'block-title-alt',
	'block-description',
	'block-footer',
	'block-after',
	'feature-list-item',
	'feature-title',
	'feature-title-alt',
	'feature-description',
	'feature-description-h2',
	'feature-description-h3',
	'feature-description-h4',
	'feature-description-h5',
	'feature-description-a',
	'feature-description-p',
	'feature-description-strong',
	'feature-description-em',
	'feature-description-ul',
	'feature-description-ol',
	'feature-readon-link',
	'feature-image'
);

if ( version_compare(HEADWAY_VERSION, '3.4.5', '>=') && !get_option('headway-' . $block_type . '-block-345-upgrade') ) {
    
    /* we get all the blocks for this block type */
    $blocks = HeadwayBlocksData::get_blocks_by_type($block_type);
    
    $block_instance_elements = array();
    
    /* we build the array with all the elements registered with the ID */
    foreach ( $blocks as $block_id => $layout )
    	foreach ( $elements as $element_id )
    		$block_instance_elements[] = 'block-' . $block_type . '-' . $element_id . '-' . $block_id;
    		
	/* we loop trough all the elements registered with the ID */
	foreach ( $block_instance_elements as $element ) {
		
		/* we get the element properties which we will use further down to set the new instances */
	    $instance_element_properties = HeadwayElementsData::get_element_properties($element);
	    
	    $instance_id = end(explode('-', $element));
	    
	    $element_with_no_instance = str_replace('-' . $instance_id, '', $element);

	    $instance_to_register = $element_with_no_instance . '-block-' . $instance_id;
		
		/* we loop trough each property */
	    foreach ( $instance_element_properties as $property => $property_value ) {
	    	
	    	/* we stop here if the element doesn't have property set */
	    	if ( !isset($property) )
	    		continue;
	
	        /* we remove the all element from the db unless the user wants to keep it */
	        // -- THIS HAS TO BE REVIEWED AS I DIDN'T FIND THIS FUNCTION DOES EXIST IN HEADWAY. IF IT REALLY DOSEN'T EXIST, WE WILL USET THE OLD INSTANCES AND SAVE ONLY THE NEW ONCE --
	        //HeadwayElementsData::delete_property($instance_element_id, $property);
			
			/* we register the elements in the proper way */
	        HeadwayElementsData::set_special_element_property( 'blocks', $element_with_no_instance, 'instance', $instance_to_register, $property, $property_value);
	
	    }
	
	}
    
    /* we set a flag in the db to say that the block instances mapping is done for this block type */
    set_option('headway-' . $block_type . '-block-345-upgrade', true);

}