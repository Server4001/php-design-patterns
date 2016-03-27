<?php

class Playlist
{
    /**
     * @var PlaylistContract
     */
    protected $playlist;

    /**
     * @var array
     */
    protected $songs = array();

    /**
     * Create a new playlist, specifying the playlist type e.g. M3U or PLS.
     * This is where delegation happens. A concrete playlist object is created
     * based on the $type parameter.
     *
     * @param string $type the output format type
     */
    public function __construct($type)
    {
        $class = sprintf('%s\\Formats\\%sPlaylist', __NAMESPACE__, $type);
        $this->playlist = new $class;
    }

    /**
     * Add a song to the playlist
     *
     * @param string $location
     * @param string $title
     */
    public function addSong($location, $title)
    {
        $this->songs[] = array(
            'location' => $location,
            'title'    => $title,
        );
    }

    /**
     * @return string
     */
    public function getPlaylist()
    {
        return $this->playlist->getPlaylist($this->songs);
    }
}
