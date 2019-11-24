/*
* first function extract youtube id form vide link
* second function take extracted id as parameter and get live views via youtube data api (that require an api key, find more over here: https://developers.google.com/youtube/v3/getting-started)
*/
function youtube_video_id( $url )
{
	preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match);
  return $match[1];
}

function youtube_view_count_shortcode( $videoID, $apiKEY )
{
 $json = file_get_contents("https://www.googleapis.com/youtube/v3/videos?part=statistics&id=" . $videoID . "&key=" . $apikey);
 $jsonData = json_decode($json);
 $views = $jsonData->items[0]->statistics->viewCount;
 return number_format($views);
}
