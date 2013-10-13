<?php

return array(

    /**
     * Set the term to search twitter for.
     */
    'twitter_search_term' => '@danmatthews',

    /**
     * Set the email address to receive email alerts.
     */
    'alert_email_to' => 'mail@example.com', // Could be a group email address or just one person.
    'alert_email_from' => 'mail@example.com', // Use a real email address for this!

    /**
     * Drop your twitter API credentials in here.
     * To get some, go to dev.twitter.com and create an application.
     */
    'twitter' => array(
        'CONSUMER_KEY' => '',
        'CONSUMER_SECRET' => '',
        'ACCESS_TOKEN' => '',
        'ACCESS_TOKEN_SECRET' => '',
    ),
);
