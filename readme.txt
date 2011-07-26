=== Fathom slideshows for Wordpress ===

Contributors: djcp
Donate link: 
Tags: fathom, bdd
Requires at least: 3.0.0
Tested up to: 3.2.1
Stable tag: 1.1

This plugin was used to create the Behavior Driven Development for Wordpress plugins presentation given by Dan Collis-Puro for Wordcamp Boston 2011.

=== Installation ===

Nothing too exciting if you just want to use it as a plugin. To use the BDD tests under features/ , you'll need to install cucumber, capybara and the selenium webdrivers. To do that (for linux):

First, install rvm - most likely as the user you'll be running your tests as. See: http://rvm.beginrescueend.com/

Then:

 sudo apt-get install build-essential firefox sun-java6-bin sun-java6-jdk sun-java6-jre
   libxslt1-dev libxml2-dev libxml2 libxslt1.1
 rvm gemset create cucumber #container to hold gems we need for cucumber
 rvm gemset use cucumber #switch into gemset
 cd <plugin_dir>/features
 gem install bundler #get bundler, the gem dependency manager
 bundle install

See features/support/env.rb to set the domain you're testing against.  See features/step_definitions/* to see some examples of custom "step definitions" to test against a wordpress instance.  "user_auth.rb" is where you'd tweak the username and password configs for various user types.

After you've got your domain fixed and your usernames / passwords set, run:

 cd <plugin_dir>/features
 cucumber --guess

and you should see your tests running, driving firefox. DO NOT run this against a production site!oneeleventy!

=== Future plans ===

* build out more wordpress-specific step definitions, extending the gherkin DSL to make a system that has 90% of what you need to test a wordpress plugin. 
* create a "generator" to instantiate a basic wordpress instance including a bunch of posts, pages and taxonomy elements to test against.
* docs.

=== See also ===

* http://cukes.info
* http://rvm.beginrescueend.com/



