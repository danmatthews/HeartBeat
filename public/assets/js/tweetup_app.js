// Create the ember application
App = Ember.Application.create();

App.SlideInterval;

App.TweetupView = Ember.View.create({
	templateName:'tweetup_twitter',
});

var checkTweets = function() {
	jQuery.getJSON('tweetuptweets', function(data) {
		App.TweetupView.set('tweets', data);
	});
};

// Call the initial checks.
checkTweets();

var interval = 30000;
// Then call them at intervals
setInterval(function() {
	checkTweets();
}, interval);
