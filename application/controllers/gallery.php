<?php defined('SYSPATH') or die('No direct script access.');

/**
 * This controller is used to list/ view and edit medias
 *
 * PHP version 5
 * LICENSE: This source file is subject to LGPL license
 * that is available through the world-wide-web at the following URI:
 * http://www.gnu.org/copyleft/lesser.html
 * @author     Ushahidi Team <team@ushahidi.com>
 * @package    Ushahidi - http://source.ushahididev.com
 * @copyright  Ushahidi - http://www.ushahidi.com
 * @license    http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License (LGPL)
 */

class Gallery_Controller extends Main_Controller {
    /**
     * Maintains the list of parameters used for fetching incidents
     * in the fetch_incidents method
     * @var array
     */
    public static $params = array();

    /**
     * Whether an admin console user is logged in
     * @var bool
     */

    /**
     * Displays media.
     */
    public function index()
    {
        // Cacheable Controller
        $this->is_cachable = TRUE;

        $this->template->header->this_page = 'media';
        $this->template->content = new View('media/main');
        $this->themes->js = new View('media/media_js');

        $this->template->header->page_title .= Kohana::lang('uchaguzi.media').Kohana::config('settings.title_delimiter');

        // Get the media listing view
        $media_listing_view = $this->_get_media_listing_view();

        // Set the view
        $this->template->content->media_listing_view = $media_listing_view;

        // Store any exisitng URL parameters
        $this->themes->js->url_params = json_encode($_GET);
        
        $this->template->header->header_block = $this->themes->header_block();
        $this->template->footer->footer_block = $this->themes->footer_block();
    }

    /**
     * Helper method to load the media listing view
     */
    private function _get_media_listing_view()
    {
        // Load the media listing view
        $media_listing = new View('media/list');


        //fetch media
        $media = ORM::factory('media')->find_all();

        // Set the view content
        $media_listing->media = $media;

        // Return
        return $media_listing;

    }

    public function fetch_media()
    {
        $this->template = "";
        $this->auto_render = FALSE;
        
        $media_listing_view = $this->_get_media_listing_view();
        print $media_listing_view;
    }
}
