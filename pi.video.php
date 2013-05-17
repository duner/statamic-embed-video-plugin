<?php
class Plugin_Video extends Plugin {

	var $meta = array(
		'name'       => 'Embed Videos',
		'version'    => '0.2',
		'author'     => 'Alex Duner', 
		'author_url' => 'htpp://alexduner.com'
	);

	public function youtube() {
		$src		= $this->fetchParam('src', false, false, false, false); // defaults to false
		$videoid	= $this->fetchParam('id', false, false, false, false); // defaults to false
		$width		= $this->fetchParam('width', 640, 'is_numeric');
		$height		= $this->fetchParam('height', 390, 'is_numeric');
		$responsive	= $this->fetchParam('responsive', 'true', false, true); // defaults to true

		//Options from YouTube's iFrame API (Booleans)
		$enableJS 	= $this->fetchParam('enablejsapi', true, false, true); // defaults to true
		$noBranding 	= $this->fetchParam('modestbranding', false, false, true); // defaults to false;
		$dispRelVid 	= $this->fetchParam('rel', false, false, true); // defaults to false;
		$loopVideo 	= $this->fetchParam('loop', false, false, true); // defaults to false;
		$playAuto	= $this->fetchParam('autoplay', false, false, true); //defaults to false
		$dispInfo 	= $this->fetchParam('showinfo', true, false, true); // defaults to true
		$dispControls 	= $this->fetchParam('controls', true, false, true); // defaults to true
		//Convert the Booleans to 1 or 0 as per YouTube's iFrame API
		if ($enableJS) { $enablejsapi = 1; } else { $enablejsapi = 0; }
		if ($noBranding) { $modestbranding = 1; } else { $modestbranding = 0; }
		if ($dispRelVid) { $rel = 1; } else { $rel = 0; }
		if ($loopVideo) { $loop = 1; } else { $loop = 0; }
		if ($playAuto) { $autoplay = 1; } else { $autoplay = 0; }
		if ($dispInfo) { $showinfo = 1; } else { $showinfo = 0; }
		if ($dispControls) { $controls = 1; } else { $controls = 0; }

		//Extract the Video ID from the URL
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

		//Return iFrame embed code and (if enabled) the FitVids.js scripts
		if ($videoid) {
			$html = '<iframe class="youtube video" type="text/html" width="'.$width.'" height="'.$height.'" src="https://www.youtube.com/embed/'.$videoid.'?autoplay='.$autoplay.'&controls='.$controls.'&enablejsapi='.$enablejsapi.'&loop='.$loop.'&modestbranding='.$modestbranding.'&rel='.$rel.'&showinfo='.$showinfo.'" frameborder="0" allowfullscreen></iframe>';
			if ($responsive) {
				//Implemented using FitVids.js
				$html .= '
				<script src="_add-ons/video/js/jquery.min.js"></script>
				<script src="_add-ons/video/js/jquery.fitvids.min.js"></script>
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

	public function vimeo() {
		$src		= $this->fetchParam('src', false, false, false, false); // defaults to false
		$videoid	= $this->fetchParam('id', false, false, false, false); // defaults to false
		$width		= $this->fetchParam('width', 640, 'is_numeric');
		$height		= $this->fetchParam('height', 390, 'is_numeric');
		$responsive	= $this->fetchParam('responsive', 'true', false, true); // defaults to true

		//Options from YouTube's iFrame API (Booleans)
		$showTitle 	= $this->fetchParam('title', true, false, true); // defaults to true
		$showByline 	= $this->fetchParam('byline', true, false, true); // defaults to true;
		$showPortrait 	= $this->fetchParam('portrait', true, false, true); // defaults to true;
		$enableAuto 	= $this->fetchParam('autoplay', false, false, true); // defaults to false
		$enableAPI 	= $this->fetchParam('api', false, false, true); // defaults to false
		$loopVideo 	= $this->fetchParam('loop', false, false, true); // defaults to false
		
		//Convert the Booleans to 1 or 0 as per Vimeo's iFrame API
		if ($showTitle) { $title = 1; } else { $title = 0; }
		if ($showByline) { $byline = 1; } else { $byline = 0; }
		if ($showPortrait) { $portrait = 1; } else { $portrait = 0; }
		if ($enableAuto) { $autoplay = 1; } else { $autoplay = 0; }
		if ($enableAPI) { $api = 1; } else { $api = 0; }
		if ($loopVideo) { $loop = 1; } else { $loop = 0; }

		//Extract the Video ID from the URL
		if ($src && ! $videoid) {
			//via http://stackoverflow.com/a/10489007
			$videoid = substr(parse_url($src, PHP_URL_PATH), 1);
		}

		//Return iFrame embed code and (if enabled) the FitVids.js scripts
		if ($videoid) {
			$html = '<iframe class="vimeo video" type="text/html" width="'.$width.'" height="'.$height.'" src="https://player.vimeo.com/video/'.$videoid.'?autoplay='.$autoplay.'&title='.$title.'&api='.$api.'&loop='.$loop.'&byline='.$byline.'&portrait='.$portrait.'" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>';
			if ($responsive) {
				//Implemented using FitVids.js
				$html .= '
				<script src="_add-ons/video/js/jquery.min.js"></script>
				<script src="_add-ons/video/js/jquery.fitvids.min.js"></script>
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
		return '<code>This video is not pointed at a valid Vimeo URL.</code>';
	}

}

