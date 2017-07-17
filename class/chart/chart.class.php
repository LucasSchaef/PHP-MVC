<?php
/**
 * chart class
 * Class to generate a morris-chart
 *
 * @category 	I dont know
 * @package		Chart
 * @author		Lucas Schäf <lucas.schaef@gmail.com>
 * @copyright	Copyright (c) 2014
 * @licence		http://opensource.org/licenses/gpl-3.0.html GNU Public License
 * @version		0.1 (beta)
 **/
class chart {
	/**
	 * HTML of the Chart (basically a DIV with a specific ID)
	 * HTML and JavaScript to generate the Chart
	 *
	 * @var string
	 * @var string
	 **/
	public $chart, $script;
	/**
	 * Array of Chart-Data
	 *
	 * @var array
	 **/
	public $data = array();
	/**
	 * The name of the x-Axis-Data
	 * The name of the y-Axis-Data
	 * Labels
	 *
	 * @var string
	 * @var string
	 * @var string
	 **/
	private $xname, $yname, $labels;
	
	/**
	 * __construct
	 * Method to define several settings
	 *
	 * @param string $id		The ID of the chart
	 * @param string $xname		The Name of the x-axis-data
	 * @param string $yname		The name of the y-axis-data
	 * @param string $type		So far only "Line" and "Area" are supported
	 * @param string $height	The height of the chart
	 * @param string $width		The width of the chart (if false, it will not be added to the HTML)
	 * @param string $labels	The labels that will be displayed within the chart when hovering data points
	 **/
	public function __construct($id, $xname, $yname, $type = "Line", $height = 250, $width = false, $labels = "Value") {
		$this->chart = '<div id="'.$id.'" style="height:'.$height.'px;'.($width ? 'width:'.$width.'px' : '').'"></div>';
		$this->script = "<script>new Morris.".$type."({ element: '".$id."',data:[";
		$this->xname = $xname;
		$this->yname = $yname;
		$this->labels = $labels;
	}
	
	/**
	 * addData
	 * Adds Data to the chart
	 *
	 * @param mixed $x	The x-value
	 * @param mixed $y	The y-value
	 **/
	public function addData($x, $y) {
		$this->data[$x] = "{".$this->xname.":'".$x."',";
		if(is_array($y)) {
			$ys = array();
			foreach($this->yname as $ykey) {
				$ys[] = $this->ykey.":'".$y[$this->ykey]."'";
			}
			$this->data[$x] .= implode(",", $ys)."}";
		} else {
			$this->data[$x] .= $this->yname.":'".$y."'}";
		}
	}
	
	/**
	 * write
	 * This returns the HTML and the script of the chart
	 *
	 * @return string
	 **/
	public function write() {
		$this->script .= implode(",", $this->data)."],";
		$this->script .= "xkey:'".$this->xname."',ykeys:['".$this->yname."'],labels:['".$this->labels."'], smooth:false});</script>";
		return $this->chart.$this->script;
	}
}

?>