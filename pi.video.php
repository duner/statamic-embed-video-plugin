<?php
class Plugin_Video extends Plugin {

	public function index() {
		$src		= $this->fetch_param('src', null, false, false, false); // defaults to null
		$width		= $this->fetch_param('width', '100%', 'is_numeric');
		$height		= $this->fetch_param('height', 'is_numeric');
		$videoid	= $this->fetch_param('id', null, false, false, false); // defaults to null

		if ($src && $videoid==null ) {
			//http://stackoverflow.com/questions/6556559/youtube-api-extract-video-id
			$pattern =
				'%^						# Match any youtube URL
				(?:https?://)?			# Optional scheme. Either http or https
				(?:www\.)?				# Optional www subdomain
				(?:						# Group host alternatives
					youtu\.be/			# Either youtu.be,
					| youtube\.com		# or youtube.com
						(?:           	# Group path alternatives
							/embed/     # Either /embed/
							| /v/		# or /v/
							| .*v=		# or /watch\?v=
						)				# End path alternatives.
				)						# End host alternatives.
			([\w-]{10,12})  # Allow 10-12 for 11 char youtube id.
			($|&).*         # if additional parameters are also in query string after video id.
			$%x';
			$result = preg_match($pattern, $src, $matches);
			if (false !== $result) {
				$videoid = $matches[1];
			}
		}
	
		if ($videoid) {
			$html = '<iframe class="youtube video" type="text/html" width="'.$width.'" height="'.$height.'" src="https://www.youtube.com/embed/'.$videoid.'?feature=oembed&wmode=opaque&enablejsapi=1" frameborder="0" allowfullscreen></iframe>';
			return $html;
		} else {
			return '<code>This video is not pointed at a valid YouTube URL.</code>';
		}
	}

}

