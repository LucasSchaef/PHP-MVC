<?php
/**
 * niceList-Class
 * Generates a nice Table in Bootstrap-style, which also supports CRUD (Create, Read, Update, Delete). So it generates a list with links to
 * Details, Edit and Delete-Pages
 *
 * @category	Style
 * @package		niceList
 * @author		Lucas Schäf <lucas.schaef@gmail.com>
 * @copyright	Copyright (c) 2014
 * @licence		http://opensource.org/licenses/gpl-3.0.html GNU Public License
 * @version		0.1 (beta)
 **/
class niceList{
	/**
	 * Array containing information on the table
	 *
	 * @var array
	 **/
	private $tableInfo = array();
	/**
	 * Defines wether the CRUD-ID (see above for help on this) should be shown as own column or not
	 *
	 * @var boolean
	 **/
	public $show_crud_id = true;
	/**
	 * Additional HTML for within the <table>-Tag
	 * Should CRUD be created or not
	 * The ID, which is used for CRUD
	 * The path to whicht CRUD will link
	 *
	 * @var string
	 * @var boolean
	 * @var string
	 * @var string
	 **/
	private $addHTML, $crud, $crud_id, $crudPath;
	
	/**
	 * __construct
	 * Starts by defining basic settings for the list
	 *
	 * @param array $head		The headings for the columns. Note that the number of fields in this array have to match the number of columns for a proper view.
	 * @param boolean $crud		Defines wether CRUD should be used or not
	 * @param string $crud_id	The key of the row that the List uses for CRUD
	 * @param string $crud_path	The path to which the list will link
	 * @param string $addHTML	Additional HTML for the <table>-Tag
	 **/
	public function __construct(array $head = NULL, $crud = false, $crud_id = NULL, $crudPath = NULL, $addHTML = 'class="table table-striped table-hover"') {
		$this->tableInfo['head'] = $head;
		$this->addHTML = $addHTML;
		$this->crud = $crud;
		$this->crud_id = $crud_id;
		$this->crudPath = $crudPath;
	}
	
	/**
	 * addRows
	 * Adds a row to the list. Note: This class does not yet support rows with different amounts of columns!!
	 *
	 * @param array $row	An (in the best case associative) array of the Row
	 **/
	public function addRow(array $row) {
		$this->tableInfo['rows'][] = $row;	
	}
	
	/**
	 * addColumn
	 * Adds a column on a specific position of the List. Note: This works well only, if you provide information for every row!
	 *
	 * @param array $column		The array containing the column data
	 * @param integer $onPlace	If defined, it will be tried to add the data on this position
	 **/
	public function addColumn(array $column, $onPlace = NULL) {
		foreach($this->tableInfo['rows'] as $key => $value) {
			if(is_null($onPlace)) {
				$this->tableInfo['rows'][$key] = array_push($value, $column[$key]);
			} else {
				$helper = array_slice($this->tableInfo['rows'][$key], 0, ($onPlace-1));
				$helper[] = $column[$key];
				$this->tableInfo['rows'][$key] = $helper + array_slice($this->tableInfo['rows'][$key], ($onPlace+1));
			}
		}
	}
	
	/**
	 * write
	 * This function returns the HTML of the list
	 *
	 * @return string
	 **/
	public function write() {
		$table = '<table '.$this->addHTML.'>';
		if(!is_null($this->tableInfo['head'])) {
			$table .= '<thead><tr>';
			foreach($this->tableInfo['head'] as $value) {
				$table .= '<th>'.$value.'</th>';
			}
			if($this->crud) {
					$table .= '<th>Options</th>';	
			}
			$table .= '</tr></thead>';
		}
		$table .= '<tbody>';
		if(isset($this->tableInfo['rows'])) {
			foreach($this->tableInfo['rows'] as $row) {
				$table .= '<tr>';
				foreach($row as $key => $column) {
					if(($key != $this->crud_id) OR $this->show_crud_id) {
						$table .= '<td>'.$column.'</td>';	
					}
				}
				if($this->crud && isset($row[$this->crud_id])) {
					$table .= '<td>';
					$table .= '<a href="'.$this->crudPath.'Details/'.$row[$this->crud_id].'" title="Details"><i class="fa fa-search"></i></a> | ';
					$table .= '<a href="'.$this->crudPath.'Edit/'.$row[$this->crud_id].'" title="Edit"><i class="fa fa-wrench"></i></a> | ';
					$table .= '<a href="'.$this->crudPath.'Delete/'.$row[$this->crud_id].'" title="Delete"><i class="fa fa-trash"></i></a>';
					$table .= '</td>';
				}
				$table .= '</tr>';
			}
		} else {
			$table .= '<tr>';
			$table .= '<td>';
			$table .= 'No Data to show here.';
			$table .= '</td>';
			$table .= '</tr>';	
		}
		
		$table .= '</tbody></table>';
		return $table;
	}
}

?>