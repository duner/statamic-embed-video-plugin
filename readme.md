#Statamic Video Plugin

This is a plugin for Statamic to embed videos from YouTube and Vimeo. I have had some problems getting this to work on version 4.2 of Statamic but it should work fine on 1.5. If you have any questions, just ask me on Twitter [@asduner][twitter], [App.net][adn], or via email at <asduner@gmail.com>.

Special thanks to Jack McDade (@jackmcdade) for his help troubleshooting the plugin.

##YouTube

###Usage
Either of these two would work for embedding a video from YouTube. If you use the `src` parameter, the plugin performs a Regular Expression on the url and will extract the video ID without you having to isolate it independently.

	{{ video:youtube src="http://www.youtube.com/watch?v=X5AZzOw7FwA" }}
	{{ video:youtube id="X5AZzOw7FwA" }}
	
Either of the above lines of code will output the following HTML code:
	
	<iframe class="youtube video" type="text/html" width="640" height="390" src="https://www.youtube.com/embed/X5AZzOw7FwA?feature=oembed&wmode=opaque&enablejsapi=1" frameborder="0" allowfullscreen></iframe>

####Paramaters
* `src` — URL pointing to a YouTube video. 
* `id` – an 11 character code pointing to a specific YouTube video. In the example above, `X5AZzOw7FwA`.
* `width` — defaults to 640.
* `height` — defaults to 390.
* `responsive` — enables [FitVids.js][fitvids] for fluid video embeds. Defaults to **true**.
* `autoplay` — automatically play the initial video when the player loads. Defaults to **false**.
* `controls` — display player controls. Defaults to **true**.
* `enablejsapi` — enable the [YouTube Javascript API][jsapi]. Defaults to **false**.
* `loop` — if the player is loading a single video, play the video again and again. Defaults to **false**.
* `modestbranding` — prevent the YouTube logo from displaying in the control bar. Note that if you set this paramater to true a small YouTube text label will still display in the upper right corner of a paused video when the user's mouse hovers over the player. Defaults to **false**.
* `rel` — load related videos once playback of initial video starts and display in "genie menu" when menu button is pressed. Defaults to **true**. If you set this to false, that will also disable the player search functionality.
* `showinfo` — display information like the video title and rating before the video starts playing. Defaults to **true**.

##Vimeo
Support to come. Still working on this.

[twitter]:https://twitter.com/asduner
[adn]:https://alpha.app.net/duner
[fitvids]:https://github.com/davatron5000/FitVids.js
[jsapi]:https://developers.google.com/youtube/iframe_api_reference

