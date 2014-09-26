Feature: Http responses
  In order have accurate server responses
  As a developer
  I want to have an app that properly handles my requets

  Background:
    Given I have these files
      | file        |
      | tin-tan.jpg |
      | tin-tan.png |
      | tin-tan.gif |
      | tin-tan.txt |
 

  Scenario Outline: Status for requested images
    When I request <image> uri
    Then I should get <status> code

    Examples:
      | image              | status |
      | '/img/tin-tan.png' | 200    |
      | '/img/tin-tan.jpg' | 200    |
      | '/img/tin-tan.gif' | 200    |
      | '/img/tin-tan.txt' | 404    |
      | '/hat.jpg'         | 404    |


  Scenario Outline: ContentTypes for images
    When I request <image> uri
    Then I should get <type> content type header

    Examples:
      | image              | type        |
      | '/img/tin-tan.png' | 'image/png' |
      | '/img/tin-tan.jpg' | 'image/jpg' |
      | '/img/tin-tan.gif' | 'image/gif' |


  Scenario Outline: Image Content 
    When I request <image> uri
    Then I should get an image

    Examples:
      | image              |
      | '/img/tin-tan.png' |
      | '/img/tin-tan.jpg' |
      | '/img/tin-tan.gif' |
