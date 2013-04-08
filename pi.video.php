<?php
class Plugin_Video extends Plugin {

	var $meta = array(
		'name'       => 'Embed Videos',
		'version'    => '0.1',
		'author'     => 'Alex Duner', 
		'author_url' => 'htpp://alexduner.com'
	);

	public function youtube() {
		$src		= $this->fetchParam('src', false, false, false, false); // defaults to false
		$width		= $this->fetchParam('width', 640, 'is_numeric');
		$height		= $this->fetchParam('height', 390, 'is_numeric');
		$videoid	= $this->fetchParam('id', false, false, false, false); // defaults to false
		$responsive	= $this->fetchParam('responsive', true, null, true); // defaults to true


		$enableJS = false; //defaults to false
		$noBranding = false; //defaults to false
		$dispRelVid = false; //defaults to false
		$loopVideo = false; //defaults to false
		$playAuto = false; //defaults to false
		$dispInfo = true; //defaults to true
		$dispControls = true; //defaults to true

		if ($enableJS) { $enablejsapi = 1; } else { $enablejsapi = 0; }
		if ($noBranding) { $modestbranding = 1; } else { $modestbranding = 0; }
		if ($dispRelVid) { $rel = 1; } else { $rel = 0; }
		if ($loopVideo) { $loop = 1; } else { $loop = 0; }
		if ($playAuto) { $autoplay = 1; } else { $autoplay = 0; }
		if ($dispInfo) { $showinfo = 1; } else { $showinfo = 0; }
		if ($dispControls) { $controls = 1; } else { $controls = 0; }

		if ($src && ! $videoid) {
			//http://stackoverflow.com/questions/6556559/youtube-api-extract-video-id
			//http://stackoverflow.com/questions/5830387/how-to-find-all-youtube-video-ids-in-a-string-using-a-regex/5831191#5831191
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

			if ($result !== false) {
				$videoid = $matches[1];
			}
		}

		if ($videoid) {
			$html = '<iframe class="youtube video" type="text/html" width="'.$width.'" height="'.$height.'" src="https://www.youtube.com/embed/'.$videoid.'?autoplay='.$autoplay.'&controls='.$controls.'&enablejsapi='.$enablejsapi.'&loop='.$loop.'&modestbranding='.$modestbranding.'&rel='.$rel.'&showinfo='.$showinfo.'" frameborder="0" allowfullscreen></iframe>';
			if ($responsive) {
				//Implemented using FitVids.js
				$html .= '
				<script src="_add-ons/video/js/jquery.min.js"></script>
				<script src="_add-ons/video/js/jquery.fitvids.js"></script>
				<script>
				$(document).ready(function(){
					// Target your .container, .wrapper, .post, etc.
					$("body").fitVids();
				  });
				</script>
				';
			}
			return $html;
		}
		return '<code>This video is not pointed at a valid YouTube URL.</code>';
	}

}

