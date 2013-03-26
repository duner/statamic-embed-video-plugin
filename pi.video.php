<?php
class Plugin_video extends Plugin {

  var $meta = array(
	    'name'       => 'Video',
	    'version'    => '0.0.1',
	    'author'     => 'Alex Duner',
	    'author_url' => 'http://alexduner.com'
	  );
	
	
	public function youtube() {
		$url		= $this->fetchParam('url', null); // defaults to no
		$width		= $this->fetchParam('width', 640, 'is_numeric'); // defaults to 640
		$height		= $this->fetchParam('height', 390, 'is_numeric'); // defaults to 390

		$videoid = $this->getYouTubeVideoID($url)

		if ($url ) {
			$iframe = '<iframe class="youtube video" type="text/html" width="'.$width .'" height="'.$height .'" src="http://www.youtube.com/embed/'.$videoid.'/"></iframe>';
			return $iframe;
		}
		return '';
	}
	     
	function getYouTubeVideoID($youtbe_url) {
		// http://stackoverflow.com/questions/6556559/youtube-api-extract-video-id
		$pattern =
			'%^								# Match any youtube URL
			(?:https?://)?					# Optional scheme. Either http or https
			(?:www\.)?						# Optional www subdomain
			(?:								# Group host alternatives
				youtu\.be/					# Either youtu.be,
				| youtube\.com				# or youtube.com
					(?:           			# Group path alternatives
						/embed/     		# Either /embed/
						| /v/				# or /v/
						| .*v=				# or /watch\?v=
					)						# End path alternatives.
			)								# End host alternatives.
		([\w-]{10,12})  					# Allow 10-12 for 11 char youtube id.
		($|&).*         					# if additional parameters are also in query string after video id.
		$%x';
		$result = preg_match($pattern, $youtube_url, $matches);
		if (false !== $result) {
			return $matches[1];
		}
		return false;
	}

?>
