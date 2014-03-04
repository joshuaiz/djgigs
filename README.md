##So what's all this, then?

****Note: This plugin is still in early super beta - do not use it on a live site as it may be broken****

After looking for an events or gig plugin that I could use to manage all my dj gigs there wasn't one that had all the features I wanted. So I decided to create my own and DJ Gigs is the result of that effort. While the plugin is tailored towards djs and dj agencies, I'm sure it can be used as a gig plugin for all kinds of people who have music gigs of any kind.

###What's different about DJ Gigs?

One of the main features that was missing from most other gig plugins was having an event name and images. For dj gigs, the party name is much more important than the venue so event names are fully supported as are images you can associate with each event (e.g. flyers). Here is a list of some of the main features:

- Event names
- Event images. Add flyers or photos.
- Google Map integration
- Separate Artist & Venue creation. You can create Artists and Venues once and then reuse them in your gigs.
- Group gigs by Artist (coming soon)
- Start & End dates + times (using ACF jQuery Date Time Picker)
- Multi-Day events
- List View
- DJ Gigs widget
- Recurring events (coming soon)

This plugin is dependent on the Advanced Custom Fields and the ACF Date Time Picker WordPress plugins. I highly doubt DJ Gigs will work if you have those plugins installed separately. To get DJ Gigs to work with those plugins pre-installed you would have to remove the includes to those base plugin files in djgigs.php.

Still to do:

- Options page: rewrite slug, with or without ACF installed, load jquery/stylesheets, styling
- Calendar page (will be premium add-on)
- sanitize data
- prepare for localization
- lots of cleanup