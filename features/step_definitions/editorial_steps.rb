include Capybara::DSL
require 'digest/md5'

When /^I fill in "([^"]*)" with a random value$/ do |field|
  @random_value = Digest::MD5.hexdigest(Time.now.to_s)
  fill_in(field, :with => @random_value)
end

Then /^I should see the random value I just used$/ do
    raise Wordpress::ContentError unless page.has_content?(@random_value)
end

When /^I fill in the slideshow taxonomy field with the random value I just used$/ do
  fill_in('newtag[slideshows]', :with => @random_value)
end

