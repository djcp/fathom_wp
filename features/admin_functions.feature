Feature: Allow admins to activate the plugin, manage options and various other items.

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

@wip
Scenario: Manage options for the plugin
    Given a "Activated" plugin in the row with the id "fathom-presentations-for-wordpress"
    And a logged in user of type "administrator"
    When I visit "/wp-admin/options-general.php?page=fathom-config"
    And I fill in "fathom_height" with "650"
    And I fill in "fathom_width" with "900"
    And I check "fathom_vertical_center" 
    And I press "Update Options"
    Then I should see "Saved options."
    And I should see "Slideshow Height"
    And I should see "Slideshow Width"
    And the "fathom_height" field should contain "650"
    And the "fathom_width" field should contain "900"
    And the checkbox "fathom_vertical_center" should be checked

