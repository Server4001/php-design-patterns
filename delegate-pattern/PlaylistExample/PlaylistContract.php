<?php

interface PlaylistContract
{
    /**
     * @abstract
     * @param array $songs
     * @return string
     */
    public function getPlaylist(array $songs);
}
