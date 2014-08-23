Feature: thumbnail
	In order to avoid image duplication
	As a user
	I need to get a dynamically generted thumbnail


	Scenario: 
		Given I have an image named "tin-tan"
		When I request for its thumbnail
		Then I should get an 150 x 150 image