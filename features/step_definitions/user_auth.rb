include Capybara::DSL

Given 'a logged in user of type "$user_type"' do |user_type|
  case user_type
  when 'subscriber'
    visit('/wp-login.php')
    fill_in('Username', :with => "testsubscriber")
    fill_in('Password', :with => "testsubscriber")
    click_button('Log In')
    raise Wordpress::LogInError unless page.has_content?('Howdy, testsubscriber')
  when 'editor'
    visit('/wp-login.php')
    fill_in('Username', :with => "editor")
    fill_in('Password', :with => "editor")
    click_button('Log In')
    raise Wordpress::LogInError unless page.has_content?('Howdy, editor')
  when 'administrator'
    visit('/wp-login.php')
    fill_in('Username', :with => "admin")
    fill_in('Password', :with => "admin")
    click_button('Log In')
    raise Wordpress::LogInError unless page.has_content?('Howdy, admin')
  end
end
