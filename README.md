#Statamic Video Plugin

This is a plugin for Statamic to embed videos from YouTube and Vimeo. I have had some problems getting this to work on version 4.2 of Statamic but it should work fine on 1.5. 

##YouTube

###Usage
Either of these two would work for embedding a video from YouTube. If you use the `src` parameter, the plugin performs a Regular Expression on the url and will extract the video ID without you having to extract it independently.

	{{ video:youtube src="http://www.youtube.com/watch?v=X5AZzOw7FwA" }}
	{{ video:youtube id="X5AZzOw7FwA" }}

####Paramaters
* `src` — URL pointing to a YouTube video. 
* `id` – an 11 character code pointing to a specific YouTube video. In the example above, `X5AZzOw7FwA`
* `width` — defaults to 640
* `height` — defaults to 390

##Vimeo
Support to come. Still working on this.
