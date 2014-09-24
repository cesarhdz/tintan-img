Feature: App server
  In order have images delivered
  As a developer
  I want to have an app that properly handles my requets


  Scenario Outline: Asking for an image return the right http status
  	Given I have the dir "tin-tan" with these files
  		| file       		|
  		| pachuco.jpg 	|
      | pachuco.png   |
      | pachuco.gif   |
  		| pachuco.txt 	|

    When I request for <image>
    Then I should get <status> status

    Examples:
    	| image 		              | status |
      | tin-tan/pachuco.png     | 200    |
      | tin-tan/pachuco.jpg     | 200    |
      | tin-tan/pachuco.gif     | 200    |
    	| tin-tan/pachuco.txt     | 404 	 |
      | pachuco.jpg             | 404    |
