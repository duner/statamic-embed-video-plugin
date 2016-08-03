<?php

namespace Statamic\Addons\Video;

use Statamic\Extend\Tags;

class VideoTags extends Tags
{
    public function index()
    {
        $src = $this->getParam('src');

        if (strpos($src, 'youtube')) {
            return $this->youtube();
        }

        if (strpos($src, 'vimeo')) {
            return $this->vimeo();
        }
    }

    public function youtube()
    {
        $src        = $this->getParam('src');
        $videoid    = $this->getParam('id');
        $width      = $this->getParamInt('width', 640);
        $height     = $this->getParamInt('height', 390);
        $responsive = $this->getParamBool('responsive');

        //Options from YouTube's iFrame API (Booleans)
        $enableJS     = $this->getParamBool('enablejsapi', true);
        $noBranding   = $this->getParamBool('modestbranding', false);
        $dispRelVid   = $this->getParamBool('rel');
        $loopVideo    = $this->getParamBool('loop');
        $playAuto     = $this->getParamBool('autoplay');
        $dispInfo     = $this->getParamBool('showinfo', true);
        $dispControls = $this->getParamBool('controls', true);

        //Convert the Booleans to 1 or 0 as per YouTube's iFrame API
        $enablejsapi    = $enableJS     ? 1 : 0;
        $modestbranding = $noBranding   ? 1 : 0;
        $rel            = $dispRelVid   ? 1 : 0;
        $loop           = $loopVideo    ? 1 : 0;
        $autoplay       = $playAuto     ? 1 : 0;
        $showinfo       = $dispInfo     ? 1 : 0;
        $controls       = $dispControls ? 1 : 0;

        //Extract the Video ID from the URL
        if ($src && ! $videoid) {
            //http://stackoverflow.com/questions/6556559/youtube-api-extract-video-id
            //http://stackoverflow.com/questions/5830387/how-to-find-all-youtube-video-ids-in-a-string-using-a-regex/5831191#5831191
            $pattern =
                '%^                  # Match any youtube URL
                (?:https?://)?       # Optional scheme. Either http or https
                (?:www\.)?           # Optional www subdomain
                (?:                  # Group host alternatives
                    youtu\.be/       # Either youtu.be,
                    | youtube\.com   # or youtube.com
                        (?:          # Group path alternatives
                            /embed/  # Either /embed/
                            | /v/    # or /v/
                            | .*v=   # or /watch\?v=
                        )            # End path alternatives.
                )                    # End host alternatives.
                ([\w-]{10,12})       # Allow 10-12 for 11 char youtube id.
                ($|&).*              # if additional parameters are also in query string after video id.
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
                    <script>
                        var initializeFitvids = function() {
                                try {
                                    $("body").fitVids();
                                } catch (e) {
                                    window.setTimeout(initializeFitvids, 50)
                                }
                            };

                        var loadFitvids = function() {
                            if (window.$) {
                                $.getScript("/site/addons/Video/js/jquery.fitvids.min.js")
                                $(document).ready(function(){
                                    // Target your .container, .wrapper, .post, etc.
                                    initializeFitvids();
                                });
                            } else {
                                window.setTimeout(loadFitvids, 50)
                            }
                        };
                        loadFitvids();
                    </script>
                ';
            }
            return $html;
        }
        return '<code>This video is not pointed at a valid YouTube URL.</code>';
    }

    // Return a youtube thumbnail image
    public function ytthumb()
    {
        $src     = $this->getParam('src');
        $videoid = $this->getParam('id');
        $size    = $this->getParam('size', 'normal');

        $size      = strtolower($size);
        $size_name = "";

        $html = "";

        switch ($size) {
            case "0":
                $size_name = "0";
                break;
            case "1":
                $size_name = "1";
                break;
            case "2":
                $size_name = "2";
                break;
            case "3":
                $size_name = "3";
                break;
            case "medium":
                $size_name = "mqdefault";
                break;
            case "large":
                $size_name = "hqdefault";
                break;
            case "larger":
                $size_name = "sddefault";
                break;
            default:
                $size_name = "default";
                break;
        }

        //Extract the Video ID from the URL
        if ($src && ! $videoid) {
            //http://stackoverflow.com/questions/6556559/youtube-api-extract-video-id
            //http://stackoverflow.com/questions/5830387/how-to-find-all-youtube-video-ids-in-a-string-using-a-regex/5831191#5831191
            $pattern =
                '%^                 # Match any youtube URL
                (?:https?://)?      # Optional scheme. Either http or https
                (?:www\.)?          # Optional www subdomain
                (?:                 # Group host alternatives
                    youtu\.be/      # Either youtu.be,
                    | youtube\.com  # or youtube.com
                        (?:         # Group path alternatives
                            /embed/ # Either /embed/
                            | /v/   # or /v/
                            | .*v=  # or /watch\?v=
                        )           # End path alternatives.
                )                   # End host alternatives.
                ([\w-]{10,12})      # Allow 10-12 for 11 char youtube id.
                ($|&).*             # if additional parameters are also in query string after video id.
                $%x';

            $result = preg_match($pattern, $src, $matches);

            if ($result !== false) {
                $videoid = $matches[1];
            }
        }

        if ($videoid) {
            return '//i1.ytimg.com/vi/' . $videoid . '/' . $size_name . '.jpg';
        }

        return 'Something went wrong...';
    }

    public function vimeo()
    {
        $src        = $this->getParam('src');
        $videoid    = $this->getParam('id');
        $width      = $this->getParamInt('width', 640);
        $height     = $this->getParamInt('height', 390);
        $responsive = $this->getParamBool('responsive');

        //Options from YouTube's iFrame API (Booleans)
        $showTitle    = $this->getParamBool('title', true);
        $showByline   = $this->getParamBool('byline', true);
        $showPortrait = $this->getParamBool('portrait', true);
        $enableAuto   = $this->getParamBool('autoplay', false);
        $enableAPI    = $this->getParamBool('api', false);
        $loopVideo    = $this->getParamBool('loop', false);

        //Convert the Booleans to 1 or 0 as per Vimeo's iFrame API
        $title    = $showTitle    ? 1 : 0;
        $byline   = $showByline   ? 1 : 0;
        $portrait = $showPortrait ? 1 : 0;
        $autoplay = $enableAuto   ? 1 : 0;
        $api      = $enableAPI    ? 1 : 0;
        $loop     = $loopVideo    ? 1 : 0;

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
                    <script>
                        var initializeFitvids = function() {
                            try {
                                $("body").fitVids();
                            } catch (e) {
                                window.setTimeout(initializeFitvids, 50)
                            }
                        };

                        var loadFitvids = function() {
                            if (window.$) {
                                $.getScript("/site/addons/Video/js/jquery.fitvids.min.js")
                                $(document).ready(function(){
                                    // Target your .container, .wrapper, .post, etc.
                                    initializeFitvids();
                                });
                            } else {
                                window.setTimeout(loadFitvids, 50)
                            }
                        };
                        loadFitvids();
                    </script>
                ';
            }
            return $html;
        }
        return '<code>This video is not pointed at a valid Vimeo URL.</code>';
    }

    // Return a vimeo thumbnail image
    public function vimeothumb()
    {
        $videoid = $this->getParam('id');
        $size    = $this->getParam('size', 'thumbnail_small');

        $size      = strtolower($size);
        $size_name = "";

        $html = "";

        switch ($size) {
            case "normal":
                $size_name = "thumbnail_small";
                break;
            case "medium":
                $size_name = "thumbnail_medium";
                break;
            case "large":
                $size_name = "thumbnail_large";
                break;
            default:
                $size_name = "thumbnail_small";
                break;
        }

        $response = $this->vimeo_thumb_curl($videoid);

        if ($response) {
            return $response[0]->$size_name;
        }

        return false;
    }

    public function vimeoThumbCurl($id)
    {
        $url_string = 'vimeo.com/api/v2/video/'."{$id}".'.json';
        $request    = curl_init($url_string);

        curl_setopt($request, CURLOPT_RETURNTRANSFER, true);

        if ($contents = curl_exec($request)) {
            return json_decode($contents);
        }

        echo "video requires the CURL library to be installed.";
    }
}
