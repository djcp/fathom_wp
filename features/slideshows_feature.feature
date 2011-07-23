Feature: Allow editors to manage slides and slideshows

Scenario: An editor should be able to add a slideshow to the custom taxonomy
    Given a "Activated" plugin in the row with the id "fathom-presentations-for-wordpress"
    And a logged in user of type "editor"
    When I visit "/wp-admin/edit-tags.php?taxonomy=slideshows&post_type=slide"
    And I fill in "tag-name" with a random value
    And I press "Add New Tag"
    Then I should see the random value I just used

@editors
Scenario: When an editor adds a slide it should appear in the slide.
    Given a "Activated" plugin in the row with the id "fathom-presentations-for-wordpress"
    And a logged in user of type "editor"
    When I visit "/wp-admin/edit-tags.php?taxonomy=slideshows&post_type=slide"
    And I fill in "tag-name" with a random value
    And I press "Add New Tag"
    When I visit "/wp-admin/post-new.php?post_type=slide"
    And I fill in "post_title" with "A new test slide"
    And I click "#edButtonHTML"
    And I fill in "content" with "<ul><li>Test slide content is so cool</li></ul>"
    And I fill in the slideshow taxonomy field with the random value I just used
    And I press "publish"
    And I click "#message a"
    Then I should see "A new test slide"
    And I should see "Test slide content is so cool"

