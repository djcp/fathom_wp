require 'rubygems'
require 'capybara'
require 'capybara/dsl'

module Wordpress 
  class LogInError < StandardError; end
  class ContentError < StandardError; end
  class CheckboxNotChecked < StandardError; end
  class CheckboxChecked < StandardError; end
  class FieldDoesntContain < StandardError; end
end

Capybara.default_selector = :css

Capybara.default_driver = :selenium
Capybara.app_host = "http://fathomdev.org"
Capybara.run_server = false

#Capybara.register_driver :selenium do |app|
#  Capybara::Selenium::Driver.new(app, :browser => :chrome)
#end

World(Capybara)
