<?php

$playlist = new Playlist('M3U');
$playlist->addSong('/path/to/GoodLife.mp3', 'Good Life');
$playlist->addSong('/path/to/Shout.mp3', 'Shout');
$playlist->addSong('/path/to/Secrets.mp3', 'Secrets');

echo $playlist->getPlaylist();

// OR:

$pl = new Playlist("PLS");
$pl->addSong("/path/to/whatever.mp3", "whatever");
echo $pl->getPlaylist();
