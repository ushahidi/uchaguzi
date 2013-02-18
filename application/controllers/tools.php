<?php defined('SYSPATH') or die('No direct script access.');
/**
 * This controller handles the administrator Navigation bar (tools)
 *
 * PHP version 5
 * LICENSE: This source file is subject to LGPL license
 * that is available through the world-wide-web at the following URI:
 * http://www.gnu.org/copyleft/lesser.html
 * @author     Ushahidi Team <team@ushahidi.com>
 * @package    Ushahidi - http://source.ushahididev.com
 * @subpackage Controllers
 * @copyright  Ushahidi - http://www.ushahidi.com
 * @license    http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License (LGPL)
*/

class Tools_Controller extends Main_Controller {
	/**
	 * Automatically display the views
	 * @var bool
	 */
	public $auto_render = TRUE;

	/**
	 * Path to the parent view for the pages in the admin console
	 * @var string
	 */
	public $template = 'layout';

	/**
	 * Cache instance
	 * @var Cache
	 */
	protected $cache;

	/**
	 * Whether authentication is required
	 * @var bool
	 */
	protected $auth_required = FALSE;

	/**
	 * ORM reference for the currently logged in user
	 * @var object
	 */
	protected $user;

	/**
	 * Configured table prefix in the database config file
	 * @var string
	 */
	protected $table_prefix;

	/**
	 * Release name of the platform
	 * @var string
	 */
	protected $release;

	/**
	 * No. of items to display per page - to be used for paginating lists
	 * @var int
	 */
	protected $items_per_page;

	/**
	 * Auth instance for the admin controllers
	 * @var Auth
	 */
	protected $auth;


	public function __construct()
	{
		parent::__construct();

		// Load cache
		$this->cache = new Cache;

		// Load session
		$this->session = new Session;

		// Load database
		$this->db = new Database();

		$this->session = Session::instance();

		$this->auth = Auth::instance();

		// Themes Helper
		$this->themes = new Themes();

		// Admin is not logged in, or this is a member (not admin)
		if ( ! $this->auth->logged_in('login'))
		{
			url::redirect('login');
		}

		// Check if user has the right to see the admin panel
		if( ! $this->auth->admin_access())
		{
			// This user isn't allowed in the admin panel
			url::redirect('/');
		}

		// Get the authenticated user
		$this->user = $this->auth->get_user();

		// Set Table Prefix
		$this->table_prefix = Kohana::config('database.default.table_prefix');

		// Get the no. of items to display setting
		$this->items_per_page = (int) Kohana::config('settings.items_per_page_admin');


	}

	public function index()
	{
		// Send them to the right page
		if (Kohana::config('config.enable_mhi') == TRUE && Kohana::config('settings.subdomain') == '')
		{
			url::redirect('admin/mhi');
		}
		else
		{
			url::redirect('admin/dashboard');
		}


	}	

	
}




?>
