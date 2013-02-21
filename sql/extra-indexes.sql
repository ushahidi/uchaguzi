# Location indexes
ALTER TABLE `location`
	ADD INDEX `location_latitude` (`latitude`),
	ADD INDEX `location_longitude` (`longitude`);

# category indexes
ALTER TABLE `category`
	ADD INDEX `category_parent_id` (`parent_id`);

# form_response indexes
ALTER TABLE `form_response`
	ADD FULLTEXT INDEX `form_response` (`form_response`);

# incident_category indexes
ALTER TABLE `incident_category`
	ADD INDEX `incident_category_incident_id` (`incident_id`),
	ADD INDEX `incident_category_category_id` (`category_id`);

# incident indexes
ALTER TABLE `incident`
	ADD INDEX `incident_mode` (`incident_mode`),
	ADD INDEX `incident_verified` (`incident_verified`);

