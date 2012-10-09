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
        $this->template->content = new View('media');

        //fetch all media
        $media = ORM::factory('media')->find_all();
        /*foreach($media as $media_type)
        {
            $media_type->media_type;
        }*/

        //$media_type = $media->media_type;
        
        $this->template->content->media = $media;

        $this->template->header->page_title .= Kohana::lang('uchaguzi.media').Kohana::config('settings.title_delimiter');

        $this->template->header->header_block = $this->themes->header_block();
        $this->template->footer->footer_block = $this->themes->footer_block();
    }
}
