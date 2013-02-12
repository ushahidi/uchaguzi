<?php
/**
 * Performs install/uninstall methods for the Election Plugin
 *
 * @package    Ushahidi
 * @author     Ushahidi Team
 * @copyright  (c) 2008 Ushahidi Team
 * @license    http://www.ushahidi.com/license.html
 */
class Election_Install {

	/**
	 * Constructor to load the shared database library
	 */
	public function __construct()
	{
		$this->db =  new Database();
	}

	/**
	 * Creates the required database tables for the election module
	 */
	public function run_install()
	{
		// Create the database tables
		// Include the table_prefix
		$this->db->query("
			CREATE TABLE IF NOT EXISTS `".Kohana::config('database.default.table_prefix')."monitor`
			(
				`id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
				`location_id` INT(4) NOT NULL COMMENT 'location_id of the monitor',
				`phonenumber` varchar(25) NOT NULL COMMENT 'phone number of the monitor',
				`polling_station` varchar(50) NOT NULL COMMENT 'polling station of the monitor',
				PRIMARY KEY (id)
			);");
		$this->db->query("
            CREATE TABLE IF NOT EXISTS`".Kohana::config('database.default.table_prefix')."boundary`
            (
                `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
                `boundary_name` varchar(100) NOT NULL COMMENT 'name of the boundary',
                 PRIMARY KEY (id)
            );");
		$this->db->query("
                        CREATE TABLE IF NOT EXISTS
`".Kohana::config('database.default.table_prefix')."code`
                        (
                                `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
				`code_id` INT(11) NOT NULL COMMENT 'form_code',
                                `code_description` text NOT NULL COMMENT 'form
code description',
                                PRIMARY KEY (id)
                        );");

		$this->db->query("
			CREATE TABLE IF NOT
EXISTS`".Kohana::config('database.default.table_prefix')."adminsection`
			(
			`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
			`reportsection_id` INT(4) NOT NULL COMMENT 'reportsection_id of the
adminsection',
			`adminsection_title` varchar(255) DEFAULT NULL,
			`adminsection_active` tinyint(4) NOT NULL DEFAULT '1',
			PRIMARY KEY (`id`)
		);");

		$this->db->query("CREATE TABLE IF NOT EXISTS
`".Kohana::config('database.default.table_prefix')."adminsection_users` 
			(
			`user_id` int(11) NOT NULL ,
			`adminsection_id` int(11) DEFAULT NULL,
			PRIMARY KEY (`user_id`)
			);");

		$this->db->query("CREATE TABLE IF NOT
EXISTS`".Kohana::config('database.default.table_prefix')."reportsection`
            (
                `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
                `reportsection_name` varchar(100) NOT NULL COMMENT 'name of the
section',
                 PRIMARY KEY (id)
            );");


        //Dump the reportsections names from bundled SQL dump file
		$this->db->query("TRUNCATE
TABLE`".Kohana::config('database.default.table_prefix')."reportsection`");

        $db_insert = fopen (dirname(dirname(__FILE__)).'/sql/reportsection.sql', 'r');

        $rows = fread ($db_insert, filesize
(dirname(dirname(__FILE__)).'/sql/reportsection.sql'));

        //split by ; to get the sql statement for inserting each row
        $rows = explode(';\n',$rows);

        foreach($rows as $query) {
            $this->db->query($query);
        }

		$this->db->query("CREATE TABLE IF NOT EXISTS
`".Kohana::config('database.default.table_prefix')."crowd_report`
		(
			`id` int(11) NOT NULL AUTO_INCREMENT,
			`incident_id` int(11) NOT NULL,
			PRIMARY KEY (`id`)
		);");
		
		$this->db->query("CREATE TABLE IF NOT EXISTS
`".Kohana::config('database.default.table_prefix')."monitor_report` 
		(
			`id` int(11) NOT NULL AUTO_INCREMENT,
			`incident_id` int(11) NOT NULL,
			PRIMARY KEY (`id`)
		);");
		
		$this->db->query("CREATE TABLE IF NOT EXISTS
`".Kohana::config('database.default.table_prefix')."peacenet_report` (
			`id` int(11) NOT NULL AUTO_INCREMENT,
			`incident_id` int(11) NOT NULL,
			PRIMARY KEY (`id`)
		);");

		$this->db->query("CREATE TABLE IF NOT EXISTS
`".Kohana::config('database.default.table_prefix')."report_mode` (
			`id` int(11) NOT NULL AUTO_INCREMENT,
			`incident_id` int(11) NOT NULL,
			`user_id` int(11) NOT NULL,
			PRIMARY KEY (`id`)
		);");
	    
	}

	/**
	 * Deletes the database tables for the election module
	 */
	public function uninstall()
	{
		$this->db->query("
			DROP TABLE ".Kohana::config('database.default.table_prefix')."monitor;
			");
	}
}
