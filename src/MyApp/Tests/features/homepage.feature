Feature: Homepage
  In order to see the homepage
  As a website user
  I need to be able to view the homepage with hello user

  Scenario: View the homepage to display hello user
    Given I am on "/mohamed"
     When the response status code should be 200
     Then I should see "Hello, mohamed."
