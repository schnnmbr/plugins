<?php

/**
 * Class: PDFGenerator
 * Plugin: Gravity Forms PDF Extended
 * Usage: assign options from user configuration file, automatically attach PDFs to specified Gravity Forms, and view PDF from admin area.
 */
 
 class PDFGenerator
 {
	
	/*
	 * Set default values for forms not assigned a PDF 
	 */
	public static $default = array(
		'template' 		=> 'default-template.php',
		'pdf_size' 		=> 'a4',
		'orientation' 	=> 'portrait',
		'rtf'			=> false,
		'security' 		=> false
	);
	
	public static $allowed_privileges = array('copy', 'print', 'modify', 'annot-forms', 'fill-forms', 'extract', 'assemble', 'print-highres');
	
	public $configuration = array();
	
	/*
	 * Switch to verify if configuration file exists.
	 * If not, user is using old functions.php method and we 
	 * don't want to interfere with it.
	 */ 
	public $disabled = false;	
	
	/*
	 * The index holds the form_id and configuration key in $this->configuration 
	 * so each form knows 
	 */
	public $index = array();
	
	public function __construct()
	{
		 
		 /* 
		  * Do configuration pre-processing
		  */
		  
		  /*
		   * Check if user configuration file exists
		   * If not disable $configuration and $index.
		   */ 		   
		  if(!file_exists(PDF_TEMPLATE_LOCATION.'configuration.php'))
		  {
			  $this->disabled = true;
			  return;
		  }
		  else
		  {
				/*
				 * Include the configuration file and set up the configuration variable.
				 */  
				 require(PDF_TEMPLATE_LOCATION.'configuration.php');				
				 /*
				  * $gf_pdf_config included from configuration.php file
				  */				 
				 $this->configuration = (isset($gf_pdf_config)) ? $gf_pdf_config : array();
		  }
		  
		  $this->pdf_config();
	}
	
	/*
	 * Run through user configuration and set PDF options
	 */		
	private function pdf_config()
	{
		if(sizeof($this->configuration) == 0)
		{
			return;
		}
		
		$this->set_form_pdfs();		
	}
	
	
	/*
	 * Set the configuration index so it's faster to access template configuration information
	 */			
	private function set_form_pdfs()
	{
		foreach($this->configuration as $key => $config)
		{			
			if(!is_array($config['form_id']))
			{
				$this->assign_index($config['form_id'], $key);
			}
			else
			{
				foreach($config['form_id'] as $id)
				{
					$this->assign_index($id, $key);
				}
			}
			
		}
	}	
	
	/*
	 * Check to see if ID is valid
	 * If so, assign ID => key to index 
	 */	
	public function assign_index($id, $key)
	{
		$id = (int) $id;
		if($id !== 0)
		{
			/*
			 * Assign the outter array with the form ID and the value as the configuration key
			 */
			$this->index[$id][] = $key;
		}		
	}
	
	/*
	 * Searches the index for the configuration key
	 * Return: form PDF configuration
	 */ 
	public function get_config($id)
	{	
		return (isset($this->index[$id])) ? $this->index[$id] : false;
	}
	
	/*
	 * Searches the index for the configuration key and once found return the real configuration
	 * Return: form PDF configuration
	 */ 
	public function get_config_data($form_id, $return_all = false)
	{
		if(!isset($this->index[$form_id]))
		{
			return false;	
		}

		$index = $this->index[$form_id];
		/* 
		 * Because we now allow multiple PDF templates per form we need a way to get the correct PDF settings
		 * To do this we use the $_GET variable 'aid'
		 * If 'aid' is not found we will pull the first entry
		 * Note: 'aid' has been incremented by 1 so 'aid' === 0 is never found
		 */
		 if(isset($_GET['aid']) && (int) $_GET['aid'] > 0)
		 {
			$aid = (int) $_GET['aid'] - 1;
			return $this->configuration[$index[$aid]]; 
		 }
		 
		 /*
		  * No valid configuration file found so pull the default
		  */
		 return $this->configuration[$index[0]];
	}	
	
	/*
	 * Search for the template from a given form id
	 * Return: the first template found for the form
	 */ 
	public function get_template($form_id, $return_all = false)
	{
		$template = '';
		
		if(isset($this->index[$form_id]))
		{
			/* 
			 * Show all PDF nodes
			 */	
			 if($return_all === true && sizeof($this->index[$form_id]) > 1)
			 {

				$templates = array();
				foreach($this->index[$form_id] as $id)
				{					
					$templates[$id] =	array(
											'template' => (isset($this->configuration[$id]['template'])) ? $this->configuration[$id]['template'] : self::$default['template'],
											'filename' => (isset($this->configuration[$id]['filename'])) ? $this->configuration[$id]['filename'] : PDF_Common::get_pdf_filename($form_id, '{entry_id}')
										);
				}
				return $templates;
			 }			
			
			/*
			 * Check if PDF template is avaliable
			 */ 
			 if(isset($this->configuration[$this->index[$form_id][0]]['template']))
			 {
					$user_template = (isset($_GET['template'])) ? $_GET['template'] : '';
					$match = false;

					foreach($this->index[$form_id] as $index)
					{
						if($this->configuration[$index]['template'] === $user_template)
						{
							$match = true;			
						}
					}
					
					$template = ($match === true) ? $user_template : $this->configuration[$this->index[$form_id][0]]['template'];
			 }
			
			 if(strlen($template) == 0)
			 {
				$template = PDFGenerator::$default['template'];
			 }
			 return $template;
		}
		
		if( (strlen($template) == 0) && (GFPDF_SET_DEFAULT_TEMPLATE === true))
		{			
			/*
			 * If no PDF template exists then we will use $gf_pdf_default_configuration if it exists.
			 * If not, we will set the default			 
			 */ 
			 global $gf_pdf_default_configuration;
			 
			/*
			 * Check if a default configuration is defined
			 */			
			 
			 if(is_array($gf_pdf_default_configuration) && sizeof($gf_pdf_default_configuration) > 0 && isset($gf_pdf_default_configuration['template']))			 
			 {
				return $gf_pdf_default_configuration['template'];	 
			 }
			 else
			 {			 
				return PDFGenerator::$default['template'];
			 }
		}			
		else
		{
			return false;	
		}

	}	
	
	public function get_pdf_name($index, $form_id = false, $lead_id = false)
	{
		if(isset($this->configuration[$index]['filename']))
		{
			return PDF_Common::validate_pdf_name($this->configuration[$index]['filename'], $form_id, $lead_id);		
		}
		else
		{
			return PDF_Common::validate_pdf_name(PDF_Common::get_pdf_filename($form_id, $lead_id), $form_id, $lead_id);		
		}
	}
	
	public function validate_privileges($privs)
	{ 
		if(!is_array($privs))
		{
			return array();
		}

		$new_privs = array_filter($privs, array($this, 'array_filter_privilages'));
		
		return $new_privs;
	}
	
	private function array_filter_privilages($i)
	{
		if(in_array($i, PDFGenerator::$allowed_privileges))
		{
			return true;
		}
		return false;		
	}
	 
 }
