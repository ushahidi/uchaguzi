<?php
/**
 * County helper. Displays counties on the front-end.
 *
 * @package    Category
 * @author     Ushahidi Team
 * @copyright  (c) 2008 Ushahidi Team
 * @license    http://www.ushahidi.com/license.html
 */
class county_Core {

	/**
	 * Generates a county tree view - recursively iterates
	 *
	 * @return string
	 */
	public static function get_county_tree_view()
	{
		// To hold the county data
		$county_data = array();
		
		// Database table prefix
		$table_prefix = Kohana::config('database.default.table_prefix');
		
		// Database instance
		$db = new Database();
		
		// Fetch the other counties
		$sql = "SELECT * from county";
		
		// Create nested array - all in one pass
		foreach ($db->query($sql) as $county)
		{
			// Add county the array
				$county_data[$county->id] = array(
					'county_name' => $county->county_name
				);

		}
		
		// Generate and return the HTML
		return self::_generate_treeview_html($county_data);
	}
	
	/**
	 * Traverses an array containing county data and returns a tree view
	 *
	 * @param array $county_data
	 * @return string
	 */
	private static function _generate_treeview_html($county_data)
	{
		// To hold the treeview HTMl
		$tree_html = "";
		
		foreach ($county_data as $id => $county)
		{
			
			$tree_html .= "<li>"
							. "<a href='#' id='county_id'><span class=\"item-title\">".strip_tags($county['county_name'])."</span>"
							. "</a></li>";
	
		}
		
		// Return
		return $tree_html;
	}
}
