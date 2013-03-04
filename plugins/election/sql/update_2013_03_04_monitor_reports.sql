ALTER TABLE `monitor` CHANGE `location_id` `boundary_id` INT(4)  NOT NULL  COMMENT 'location_id of the monitor';
ALTER TABLE `monitor_report` ADD `monitor_id` INT(11)  UNSIGNED  NOT NULL;

ALTER TABLE `monitor_report` ADD UNIQUE INDEX `idx_incident_monitor_id` (`incident_id`, `monitor_id`);

