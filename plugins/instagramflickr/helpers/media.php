<?php
class media_Core {

	public static function get_media($mesage_id)
	{
		return ORM::factory('media')->where('message_id',$mesage_id)->
		find_all();
	}
}