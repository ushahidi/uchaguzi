Feature: Testing submit report form
	In order to be able to submit a report
	As a user
	I need to fill in the report form

	@javascript
	Scenario: Submitting a new report
		Given I am on "/reports/submit" 
		When I fill in the following:
		| incident_title | Test incident title |
		| incident_description | Testing submit report feature |
		| location_name | Ngong Road, Nairobi |
			And I check "incident_category[]"
			And I follow  "Modify Date"
			And I select "02" from "incident_hour"
			And I select "25" from "incident_minute"
			And I select "pm" from "incident_ampm"
		When I press "Submit"
		Then I should be on "/reports/thanks"
