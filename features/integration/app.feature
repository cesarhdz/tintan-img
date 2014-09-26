Feature: Http responses
  In order have accurate server responses
  As a developer
  I want to have an app that properly handles my requets

  Background:
    Given I have the dir "tin-tan" with these files
      | file      |
      | 'hat.jpg' |
      | 'hat.png' |
      | 'hat.gif' |
      | 'hat.txt' |
 

  Scenario Outline: Status for requested images
    When I request <image> uri
    Then I should get <status> code

    Examples:
      | image             | status |
      | 'tin-tan/hat.png' | 200    |
      | 'tin-tan/hat.jpg' | 200    |
      | 'tin-tan/hat.gif' | 200    |
      | 'tin-tan/hat.txt' | 404    |
      | 'hat.jpg'         | 404    |


  Scenario Outline: ContentTypes for images
    When I request <image> uri
    Then I should get <type> content type header

    Examples:
      | image             | status      |
      | 'tin-tan/hat.png' | 'image/png' |
      | 'tin-tan/hat.jpg' | 'image/jpg' |
      | 'tin-tan/hat.gif' | 'image/gif' |