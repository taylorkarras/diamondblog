# DiamondBlog
What is DiamondBlog you ask, well it's blogging software designed with all the features but without a sidebar. Instead a search engine takes up most of it's functions. Right now it powers one blog but it could potentially power millions across the universe.

This thing is not just a blog, it's a mobile app capable of sending push notifications, having pages in the Accelerated Mobile Project format and of course, post to social media online through the power of plugins and/or inginuity.

##Requirements
What you'll need is...

1. PHP (version 7.0 and greater).
2. A web server like nginx configured for permalinking.
3. MySQL (if you're doing a 96MB config, make sure it's running in a MyISAM format as that takes up less memory, otherwise what you have will work fine.)
4. A mailing server or Sendmail to send the emails.
5. A bit of inginuiety.

##Installation

There are two ways you can install, way one is through git in linux...

> git clone https://github.com/tpkarras/diamondblog.git

Or you can download the ZIP and install it in a root or sub directory of your web hosting server. Please note that if your web server is limited you can push Storage (FTP) and mail (SMTP) to external servers.

##FAQ
Q. Will there be a way to import from WordPress, Drupal, etc.
A. Soon.

Q. Is the console themable?
A. On it's own it's not supposed to be themable but you can change the CSS files to your liking.

Q. Why is there no way to reply to comments?
A. Deliberate design decision to make people focus on the flow of comments, plus there was no way to make it work without interfering with the design language.

Q. Any word on a 2.0 release.
A. DiamondBlog is perfect as it is; while there may be minor changes, it is a 1.0 and done type of project; fully realized from the start.

Q. I am getting errors on Google Search Console on utilizing compression, should I?
A. No, this thing is designed to work on HTTP/2 primarily and older versions of HTTP seperately; to enable compression would kill the HTTP/2 support.

Q. Can I suggest endpoints for the plugins?
A. Of course, click the issues tab.

Q. Isn't this a bit like tumblr?
A. Sort of, this is like an open source tumblr except better, faster, more reliable and less likely to eat up your data.

Q. Where are the plugins?
A. http://github.com/taylorkarras/diamondblog-plugins, anybody looking to create their own can feel free to do so and create their own git repository?

Q. Did you truly test this on a 96MB server?
A. Yes I did, it consumes almost 80% - 95% of the memory depending on which apps are loaded.
