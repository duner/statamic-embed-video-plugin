<?php
class Plugin_Video extends Plugin {

	public function index() {
		$src		= $this->fetch_param('src', null); // defaults to null
		$width		= $this->fetch_param('width', '100%', 'is_numeric');
		$height		= $this->fetch_param('height', 'is_numeric');
		$id			= $this->fetch_param('videoid', null); // defaults to null

		$html = '<p>'.$id.'<br>'.$videoid.'</p>';
		return $html;
	}

	// This is the tag in the blog entry:
	// {{ video videoid="foGGSVfrOFk" }}

	// This is what I think (or want) the output to be:
	//		foGGSVfrOFk
	//		foGGSVfrOFk

	// But this is what I get:
	//		foggsvfrofk
	//		foGGSVfrOFk
	// Not the change in capitalization which makes a difference in the following code for some reason:	
	/*
			if ($videoid) {
					$html .= '<iframe type="text/html" width="'.$width.'" height="'.$height.'" src="https://www.youtube.com/embed/'.$videoid.'"></iframe>';
					return $html;
			} else {
					return '<code>This video is not pointed at a valid YouTube URL.</code>';
			}
	*/
	// Any idea why?
}
