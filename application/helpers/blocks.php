<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Blocks helper class.
 *
 * @package    Admin
 * @author     Ushahidi Team
 * @copyright  (c) 2011 Ushahidi Team
 * @license    http://www.ushahidi.com/license.html
 */
class blocks_Core {
	
	/**
	 * Open A Block
	 *
	 * @return string
	 */
	public static function open($id = NULL)
	{
		if ($id)
		{
			echo "<div class=\"reports-".$id."\">";
		}
		else
		{
		  echo "<div class=\"reports-block\">";
		}
		
	}
	
	/**
	 * Close A Block
	 *
	 * @return string
	 */
	public static function close()
	{
		echo "</div>";
	}
	
	/**
	 * Block Title
	 *
	 * @return string
	 */
	public static function title($title = NULL)
	{
		if ($title)
		{
			echo "<h3 class=\"sub-category\">$title</h3>";
		}
	}
	
	/**
	 * Register A Block
	 *
	 * @param array $block an array with classname, name and description
	 */
	public static function register($block = array())
	{
		// global variable that contains all the blocks
		$blocks = Kohana::config("settings.blocks");
		if ( ! is_array($blocks) )
		{
			$blocks = array();
		}
		
		if ( is_array($block) AND 
			array_key_exists("classname", $block) AND 
			array_key_exists("name", $block) AND 
			array_key_exists("description", $block) )
		{
			if ( ! array_key_exists($block["classname"], $blocks))
			{
				$blocks[$block["classname"]] = array(
					"name" => $block["name"],
					"description" => $block["description"]
				);
			}
		}
		asort($blocks);
		Kohana::config_set("settings.blocks", $blocks);
	}
	
	/**
	 * @TODO find a better way to render different blocks
	 * Render news block
	 *
	 * @return string block html
	 */	
	public static function render_news()
	{
		// Get Active Blocks
		$active_blocks = Settings_Model::get_setting('blocks');
		$active_blocks = array_filter(explode("|", $active_blocks));
		$news_block = $active_blocks[0];
		$block = new $news_block();
		$block->block();
		
	}
	
	/**
	 * @TODO find a better way to render different blocks
	 * Render reports block
	 *
	 * @return string block html
	 */	
	public static function render_reports()
	{
		// Get Active Blocks
		$active_blocks = Settings_Model::get_setting('blocks');
		$active_blocks = array_filter(explode("|", $active_blocks));
		$reports_block = $active_blocks[1];
		$block = new $reports_block();
		$block->block();
		
	}

	/**
	 * Render all the active blocks
	 *
	 * @return string block html
	 */	
	public static function render()
	{
		// Get Active Blocks
		$active_blocks = Settings_Model::get_setting('blocks');
		$active_blocks = array_filter(explode("|", $active_blocks));
		foreach ($active_blocks as $block)
		{
			if (class_exists($block))
			{
				$block = new $block();
				$block->block();
			}
		}
	}

	/**
	 * Sort Active and Non-Active Blocks
	 * 
	 * @param array $active array of active blocks
	 * @param array $registered array of all blocks
	 * @return array merged and sorted array of active and inactive blocks
	 */
	public static function sort($active = array(), $registered = array())
	{
		// Remove Empty Keys
		$active = array_filter($active);
		$registered = array_filter($registered);
		
		$sorted_array = array();
		$sorted_array = array_intersect($active, $registered);
		return array_merge($sorted_array, array_diff($registered, $sorted_array));
	}
}
