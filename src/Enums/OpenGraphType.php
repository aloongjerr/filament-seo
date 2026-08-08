<?php

namespace AloongJerr\FilamentSeo\Enums;

use Filament\Support\Contracts\HasLabel;
use Illuminate\Contracts\Support\Htmlable;

enum OpenGraphType: string implements HasLabel
{
    case Website = 'website';
    case Article = 'article';
    case Book = 'book';
    case Profile = 'profile';
    case MusicSong = 'music_song';
    case MusicAlbum = 'music_album';
    case MusicPlaylist = 'music_playlist';
    case VideoMovie = 'video_movie';
    case VideoEpisode = 'video_episode';
    case VideoTvShow = 'video_tv_show';

    public function getLabel(): string | Htmlable | null
    {
        return match ($this) {
            self::Website => __('Website'),
            self::Article => __('Article'),
            self::Book => __('Book'),
            self::Profile => __('Profile'),
            self::MusicSong => __('Music: Song'),
            self::MusicAlbum => __('Music: Album'),
            self::MusicPlaylist => __('Music: Playlist'),
            self::VideoMovie => __('Video: Movie'),
            self::VideoEpisode => __('Video: Episode'),
            self::VideoTvShow => __('Video: TV Show'),
        };
    }
}
