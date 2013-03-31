#Statamic Video Plugin

This is a plugin for Statamic to embed videos from YouTube and Vimeo. I have had some problems getting this to work on version 4.2 of Statamic but it should work fine on 1.5. If you have any questions, just ask me on Twitter [@asduner][twitter] or send me [an email][email].

##YouTube

###Usage
Either of these two would work for embedding a video from YouTube. If you use the `src` parameter, the plugin performs a Regular Expression on the url and will extract the video ID without you having to isolate it independently.

	{{ video:youtube src="http://www.youtube.com/watch?v=X5AZzOw7FwA" }}
	{{ video:youtube id="X5AZzOw7FwA" }}
	
Either of the above lines of code will output the following HTML code:
	
	<iframe class="youtube video" type="text/html" width="640" height="390" src="https://www.youtube.com/embedX5AZzOw7FwA?feature=oembed&wmode=opaque&enablejsapi=1" frameborder="0" allowfullscreen></iframe>


####Paramaters
* `src` — URL pointing to a YouTube video. 
* `id` – an 11 character code pointing to a specific YouTube video. In the example above, `X5AZzOw7FwA`
* `width` — defaults to 640
* `height` — defaults to 390

##Vimeo
Support to come. Still working on this.

[twitter]:https://twitter.com/asduner
[email]:
