Feature: thumbnail
	In order to avoid image duplication
	As a user
	I need to get a dynamically generted thumbnail


	Scenario: 
		Given I'm using my own server
		When I request for the image "features/tin-tan/150x150"
		Then I should get an 150 x 150 image