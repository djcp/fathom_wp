Feature: Allow admins to activate the plugin, manage options and various other items.

@wip
Scenario: Activate the plugin without errors.
    Given a "Deactivated" plugin in the row with the id "fathom-presentations-for-wordpress"
    And a logged in user of type "administrator"
    When I visit "/wp-admin/plugins.php"
    And I click "Activate" within the row with the id "fathom-presentations-for-wordpress"
    Then I should see "Plugin activated"

Scenario: Deactivate the plugin without errors.
    Given a "Activated" plugin in the row with the id "fathom-presentations-for-wordpress"
    And a logged in user of type "administrator"
    When I visit "/wp-admin/plugins.php"
    And I click "Deactivate" within the row with the id "fathom-presentations-for-wordpress"
    Then I should see "Plugin deactivated"

Scenario: Manage options for the plugin
    Given a "Activated" plugin in the row with the id "fathom-presentations-for-wordpress"
    And a logged in user of type "administrator"
    When I visit "/wp-admin/options-general.php?page=fathom-config"
    And I fill in "Subject line template for individual emails" with "foo test individual subject line"
    And I fill in "HTML email template for individual emails" with "html email template individual"
    And I fill in "Plain text email template for individual emails" with "individual plain text"
    And I fill in "Subject line template for daily emails" with "foo test daily subject line"
    And I press "Update Options"
    Then I should see "Configure Category Subscriptions"
    And I should see "Maximum outgoing email batch size"
    And I should see "Individual Emails"
    And the "Subject line template for individual emails" field should contain "foo test individual subject line"
    And the "Subject line template for daily emails" field should contain "foo test daily subject line"
    And the "HTML email template for individual emails" field should contain "html email template individual"
    And the "Plain text email template for individual emails" field should contain "individual plain text"

