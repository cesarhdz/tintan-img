Feature: Image Filters
  In order to use dynamically generated images
  as a developer
  I want to control how images are processed

  Background:
    Given I have these files
      | file        |
      | tin-tan.jpg |
      | tin-tan.png |
      | tin-tan.gif |
      | tin-tan.txt |

    And I register a "thumbnail" preset using "size" filter, options
      | key    | val |
      | width  | 250 |
      | height | 250 |

  Scenario Outline: Simple pattern filter
    When I request <image> uri
    Then I should get an image of <width> x <height> px

    Examples:
      | image                         | width | height |
      | '/img/tin-tan.jpg'            | 888   | 1200   |
      | '/img/tin-tan.thumbnail.jpg'  | 250   | 200    |
  
  @Pending
  Scenario: Wildcard Pattern
    Given I register a "resize" preset using "Size" filter and "{:width}x{:height}" pattern
    When I request "tin-tan/hat.300x300.jpg" uri
    Then I should get an image of "300" x "300"> px

  @Pending
  Scenario Outline: Required preset
    Given I mark "thumbnail" preset as required for "tin-tan/" images
    When I request "tin-tan/hat.jpg" uri
    Then I should get an image of "250" x "250" px

    Examples:
      | image               |
      | /tin-tan/hat.png     |
      | /tin-tan/hat.jpg     |


  @Pending
  Scenario: Multiple Filters
    Given I register a "grayscale" preset using "Grayscale" filter and "gray" pattern
    When I request "tin-tan/hat.thumbnail.watermark.png" uri
    Then I should get an image of "250" x "250" px
    And I should get an image with the text "Copyright Notice"