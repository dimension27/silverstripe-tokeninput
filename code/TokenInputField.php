<?php
/**
 *  
 * 
 * @author Alex Hayes <alex.hayes@dimension27.com>
 * 
 * @package sapphire
 * @subpackage fields-formattedinput
 */
class TokenInputField extends FormField {

	/**
	 * Either a url or an array of data that is supplied as the first argument to the initialisation of tokenInput
	 * @see http://loopj.com/jquery-tokeninput/
	 * @var string|array
	 */
	public $tokenInputUrlOrData;

	/**
	 * Options that are supplied to the jquery token input field.
	 * @see http://loopj.com/jquery-tokeninput/
	 * @see TokenInputField::getTokenInputOptionsAsJson()
	 * @var array
	 */
	public $tokenInputOptions = array();
	
	/**
	 * An array of default options to be combined with $tokenInputOptions.
	 * @var array
	 */
	static $defaultTokenInputOptions = array();
	
	/**
	 * 
	 * @param $name
	 * @param $title
	 * @param $value
	 * @param $form
	 * @param $tokenInputOptions
	 *
	 * @author Alex Hayes <alex.hayes@dimension27.com>
	 */
	function __construct($name, $title = null, $tokenInputUrlOrData, array $tokenInputOptions = null, $value = "", $form = null) {
		parent::__construct($name, $title, $value, $form);
		$this->tokenInputUrlOrData = $tokenInputUrlOrData;
		if( !is_null($tokenInputOptions) ) {
			$this->tokenInputOptions = $tokenInputOptions;
		}
	}
	
	/**
	 * @return string
	 */
	function Field() {
		$tokenInputOptions = $this->getTokenInputOptions();
		if( array_key_exists('theme', $tokenInputOptions) ) {
			if( $tokenInputOptions['theme'] == 'facebook' ) {
				Requirements::css('tokeninput/css/token-input-facebook.css');
			}
			elseif( $tokenInputOptions['theme'] == 'mac' ) {
				Requirements::css('tokeninput/css/token-input-mac.css');
			}
		} else {
			Requirements::css('tokeninput/css/token-input.css');
		}

		Requirements::replace_javascript(SAPPHIRE_DIR .'/thirdparty/jquery/jquery.js', 'ss-tools/javascript/jquery-1.7.1.js');
		Requirements::javascript('tokeninput/js/jquery.tokeninput.js');
		Requirements::set_write_js_to_body(false);
		
		return '<input type="text" id="' . $this->id() . '" name="' . $this->Name() . '" />
		<script type="text/javascript">
		$(document).ready(function() {
		   $("#' . $this->id() . '").tokenInput(' . json_encode($this->tokenInputUrlOrData) . ', ' . json_encode($tokenInputOptions) . ');
		});
		</script>';
	}
	
	public function getTokenInputOptions() {
		$tokenInputOptions = array_merge(self::$defaultTokenInputOptions, $this->tokenInputOptions);
		$tokenInputOptions['prePopulate'] = $this->getPrePopulateOption();
		return $tokenInputOptions; 
	}

	/**
	 * @note Only works if you're using a flat array, implementation for id/name needs to be implemented.
	 * @author Alex Hayes <alex.hayes@dimension27.com>
	 */
	public function getPrePopulateOption() {
		$value = $this->Value();
		if( strlen($this->Value()) == 0 ) {
			return array();
		}
		$values = explode(",", $value);
		$return = array();
		foreach($values as $value) {
			$return[] = array(
				'id' => $value,
				'name' => $value
			);
		}
		return $return;
	}

	/**
	 * Convert a flat array into one which can be used as the data (first) argument to tokenInput.
	 * 
	 * @param array $data
	 *
	 * @author Alex Hayes <alex.hayes@dimension27.com>
	 */
	static public function getDataFromFlatArray(array $data) {
		$return = array();
		foreach($data as $value) {
			$return[] = array(
				'id' => $value,
				'name' => $value
			);
		}
		return $return;
	}
	
}