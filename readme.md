#Statamic Video Plugin
## with Vimeo thumbnail support!

This is a plugin for Statamic to embed videos from YouTube and Vimeo. It (optionally) makes use of [FitVids.js][fitvids] to create fluid video embeds for responsive web designs.

I have had some problems getting this to work on version 4.2 of Statamic but it should work fine on 1.5. If you have any questions, just ask me on Twitter [@asduner][twitter]. Special thanks to Jack McDade (@jackmcdade) for his help troubleshooting.

I hope that this documentation is usefull. It is a bit lengthy but that is more for my own sake so that I can keep track of how everything works. It is actually extremely simple to use.

##Installation
According to the Statamic documentation:

>Each plugin must extend the core Plugin class and the class name must be prefixed with Plugin_. Additionally, your class name must much your add-on's folder and file name exactly (for example: _add-ons/play/pi.play.php).

So, for this plugin make sure that you put the unzipped folder you download into the _add-ons folder and be sure to change its name to "video".

Also, make sure your site has access to jQuery if you want to enable responsive video embeds.

##Usage
Either of these two would work for embedding a video from YouTube. If you use the `src` parameter, the plugin performs a Regular Expression on the url and will extract the video ID without you having to isolate it independently.

	{{ video:youtube src="http://www.youtube.com/watch?v=X5AZzOw7FwA" }}
	{{ video:youtube id="X5AZzOw7FwA" }}
	
Either of the above lines of code will output the following HTML code:
	
	<iframe class="youtube video" type="text/html" width="640" height="390" src="https://www.youtube.com/embed/X5AZzOw7FwA?feature=oembed&wmode=opaque&enablejsapi=1" frameborder="0" allowfullscreen></iframe>

Additionally, you can return YouTube thumbnails in various sizes given a video `src` or `id`. The return value is a raw image URL.

###Paramaters
* `src` — URL pointing to a YouTube or Vimeo video. 
* `id` – an 11 character code pointing to a specific YouTube (or Vimeo) video. In the example above, `X5AZzOw7FwA`.
* `width` — defaults to 640.
* `height` — defaults to 390.
* `responsive` — enables [FitVids.js][fitvids] for fluid video embeds. Defaults to **true**.

The way I have currently set up the FitVids.js implementation makes it act on *all* videos on your site, even if you only embed one video using the plugin.

###YouTube
* `autoplay` — automatically play the initial video when the player loads. Defaults to **false**.
* `controls` — display player controls. Defaults to **true**.
* `enablejsapi` — enable the [YouTube Javascript API][jsapi]. Defaults to **false**.
* `loop` — if the player is loading a single video, play the video again and again. Defaults to **false**.
* `modestbranding` — prevent the YouTube logo from displaying in the control bar. Note that if you set this paramater to true a small YouTube text label will still display in the upper right corner of a paused video when the user's mouse hovers over the player. Defaults to **false**.
* `rel` — load related videos once playback of initial video starts and display in "genie menu" when menu button is pressed. Defaults to **true**. If you set this to false, that will also disable the player search functionality.
* `showinfo` — display information like the video title and rating before the video starts playing. Defaults to **true**.

Paramaters that I have not yet implemented are: embedding playlists, changing from the dark theme to the light theme, and allowing you to set the start time of an embedded video. If you would like any of these included in the plugin, just let me know and I will do my best to add them.

###Vimeo
* `title`—Show the title on the video. Defaults to **true**.
* `byline`—Show the user’s byline on the video. Defaults to **true**.
* `portrait`—Show the user’s portrait on the video. Defaults to **true**.
* `autoplay`—Play the video automatically on load. Defaults to **false**. Note that this won’t work on some devices.
* `loop`—Play the video again when it reaches the end. Defaults to **false**.
* `api`—Enable the Javascript API. Defaults to **false**

I have not yet implemented the `color` paramater. If you feel like this is important, let me know and I will try to implement it.

###YTThumb
* `src` — URL pointing to a YouTube or Vimeo video. 
* `id` – an 11 character code pointing to a specific YouTube (or Vimeo) video. In the example above, `X5AZzOw7FwA`.
* `size` – one of the following; normal, medium, large, larger (see [StackExchange](http://stackoverflow.com/questions/2068344/how-to-get-thumbnail-of-youtube-video-link-using-youtube-api) for details).

####vimeothumb

Works like the YTThumb example above, except I did not implement the option of stripping video ID out of the Vimeo url. This tag just has two parameters: the Vimeo ID and the desired thumbnail size (same as YTThumb - either normal, medium or large.

Typical use inside a template might be as follows (assuming you video_id is stored as a field in the page YAML).
```
{{video:vimeothumb id="{{video_id}}" size="normal"}}

```
Somebody more ambitious than I may want to add back in the ability to strip out the ID directly from a Vimeo url.

[twitter]:https://twitter.com/asduner
[adn]:https://alpha.app.net/duner
[fitvids]:https://github.com/davatron5000/FitVids.js
[jsapi]:https://developers.google.com/youtube/iframe_api_reference
[blog]:http://alexduner.com
