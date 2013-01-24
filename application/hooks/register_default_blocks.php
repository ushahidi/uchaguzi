<?php defined('SYSPATH') or die('No direct script access.');

class latest_news {
	public function __construct()
	{
		$block = array(
			"classname" => "latest",
			"name" => "Latest News",
			"description" => "Displays the most recent news story from the feeds"
		);

		blocks::register($block);
	}

	public function block()
	{
		$content = new View('blocks/main_news');
		// Get RSS News Feeds
		$content->feeds = ORM::factory('feed_item')
			->limit('1')
			->orderby('item_date', 'desc')
			->find_all();

		echo $content;
	}
}
new latest_news;


class highlights {
	public function __construct()
	{
		$block = array(
			"classname" => "highlights",
			"name" => "Highlights",
			"description" => "List the three most recent, flagged reports"
		);

		blocks::register($block);
	}

	public function block()
	{
		$content = new View('blocks/main_highlights');
		$content->total_items = ORM::factory('incident')
			->where('incident_active', '1')
			->limit('3')->count_all();
		$content->incidents = ORM::factory('incident')
			->with('location')
			->where('incident_active', '1')
			->limit('3')
			->orderby('incident_date', 'desc')
			->find_all();

		echo $content;
	}
}
new highlights;