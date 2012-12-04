Feature: User Sessions
	In order to access my account
	As a user
	I need t be able to login into the website

	@javascript 
	Scenario: Login
		Given I am on "/login"
        When I fill in the following:
        	| username | sharon@ushahidi.com |
        	| password | 123456 |
        	And I press "Login"
        Then I should be on "admin/dashboard"


    @javascript
    Scenario: Logout
    	Given I am logged in as "sharon@ushahidi.com" with password "123456"
        	And I am on "/dashboard"
    	When I follow "Logout"
    	Then I should be on "/login"
        And I should see "Login"