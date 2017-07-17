<?php
/**
 * donut class
 *
 * @category	I dont know
 * @package		Donut
 * @author		Lucas Schäf <lucas.schaef@gmail.com>
 * @copyright	Copyright (c) 2014
 * @licence		http://opensource.org/licenses/gpl-3.0.html GNU Public License
 * @version		0.1 (beta)
 **/
class donut {
	/**
	 * HTML of the Chart (DIV with specific ID)
	 * Script of the Chart
	 *
	 * @var string
	 * @var string
	 **/
	private $chart, $script;
	/**
	 * Array of Chart-Data
	 *
	 * @var array
	 **/
	private $data = array();
	/**
	 * Array of colors of the chart-fields
	 *
	 * @var array
	 **/
	private $colors = array();
	
	/**
	 * __construct
	 * Save basic settings
	 *
	 * @param string $id	The chart-ID
	 **/
	public function __construct($id) {
		$this->chart = '<div id="'.$id.'"></div>';
		$this->script = "<script>new Morris.donut({ element: '".$id."',data:[";
	}
	
	/**
	 * addData
	 * Adds data to the chart
	 *
	 * @param string $label		The label of the data
	 * @param string $value		The value of the data
	 * @param string $color		Hexadecimal color code for the color of this data
	 **/
	public function addData($label, $value, $color = NULL) {
		$this->data[] = "{ label: '".$label."', value: '".$value."' }";
		$this->colors[] = $color;
	}
	
	/**
	 * write
	 * Returns HTML and Script of the Donut-Chart
	 *
	 * @return string
	 **/
	public function write() {
		$this->script .= implode(",", $this->data)."]";
		if(!isArrayEmpty($this->colors)) {
			$this->script .= ",colors:['".implode("','", $this->colors)."']";
		}
		$this->script .= "});";
		return $this->chart.$this->script;
	}
}
?>