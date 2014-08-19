Feature: Contact us
  In order to see use the contact us page
  As a website user
  I need to be able to view and submit a message with the contact us page

  @javascript
  Scenario: Sending message with contact us page
    Given I am on "/mohamed"
     When I go to "/contact"
     Then I should see "Contact Form"
      And I fill in the following:
        | Name    | John Doe             |
        | Email   | satrun77@hotmail.com |
        | Subject | Hello website        |
        | Message | Hi, my name is John  |
      And I press "Send"
      And I should see "Your message have successfully sent to us."

