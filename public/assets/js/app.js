// Create the ember application
App = Ember.Application.create();

App.TweetView = Ember.View.create({
	templateName:'twitter',
});

App.ServerView = Ember.View.create({
	templateName:'servers',
});

var checkTweets = function() {
	jQuery.getJSON('tweets', function(data) {
		App.TweetView.set('tweets', data);
	});
};

var checkServers = function() {
	jQuery.getJSON('servers', function(data)
	{
		App.ServerView.set('servers', data);
	});
};

// Call the initial checks.
checkTweets();
checkServers();

// Then call them at intervals
setInterval(function() {
checkTweets();
checkServers();
}, 15000);
