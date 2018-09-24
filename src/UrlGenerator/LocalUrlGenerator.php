<?php

namespace Spatie\MediaLibrary\UrlGenerator;

use DateTimeInterface;
use Spatie\MediaLibrary\Exceptions\UrlCannotBeDetermined;

class LocalUrlGenerator extends BaseUrlGenerator
{
    /**
     * Get the url for the profile of a media item.
     *
     * @return string
     *
     * @throws \Spatie\MediaLibrary\Exceptions\UrlCannotBeDetermined
     */
    public function getUrl(): string
    {
        $url = $this->getBaseMediaDirectoryUrl() . '/' . $this-> getUrlPathRelativeToRoot();
//        dd($this->getPathRelativeToRoot());
        $url = $this->makeCompatibleForNonUnixHosts($url);


        $url = $this->rawUrlEncodeFilename($url);


        return $url;
    }

    /**
     * @param \DateTimeInterface $expiration
     * @param array $options
     *
     * @return string
     *
     * @throws \Spatie\MediaLibrary\Exceptions\UrlCannotBeDetermined
     */
    public function getTemporaryUrl(DateTimeInterface $expiration, array $options = []): string
    {
        throw UrlCannotBeDetermined::filesystemDoesNotSupportTemporaryUrls();
    }

    /*
     * Get the path for the profile of a media item.
     */
    public function getPath(): string
    {
        return $this->getStoragePath() . '/' . $this->getPathRelativeToRoot();
    }

    protected function getBaseMediaDirectoryUrl(): string
    {
        if ($diskUrl = $this->config->get("filesystems.disks.{$this->media->disk}.url")) {
//            return $diskUrl;
            return str_replace(url('/'), '', $diskUrl);
        }

        if (!starts_with($this->getStoragePath(), public_path())) {
            throw UrlCannotBeDetermined::mediaNotPubliclyAvailable($this->getStoragePath(), public_path());
        }

        return $this->getBaseMediaDirectory();
    }

    /*
     * Get the directory where all files of the media item are stored.
     */
    protected function getBaseMediaDirectory(): string
    {
        return str_replace(public_path(), '', $this->getStoragePath());
    }

    /*
     * Get the path where the whole medialibrary is stored.
     */
    protected function getStoragePath(): string
    {
        $diskRootPath = $this->config->get("filesystems.disks.{$this->media->disk}.root");

        return realpath($diskRootPath);
    }

    protected function makeCompatibleForNonUnixHosts(string $url): string
    {
        if (DIRECTORY_SEPARATOR != '/') {
            $url = str_replace(DIRECTORY_SEPARATOR, '/', $url);
        }

        return $url;
    }

    /*
    * 读取磁盘数据时使用
    */
//    public function getPathRelativeToRoot(): string
//    {
//        if (is_null($this->conversion)) {
////            return $this->media->getKey() . '/' . $this->media->file_name;
//            return $this->pathGenerator->getPath($this->media).($this->media->file_name);
//        }
//
//        return $this->pathGenerator->getPathForConversions($this->media)
//            .  $this->pathGenerator->conversionsPath
//            . $this->conversion->getName()
//            . '.'
//            . $this->conversion->getResultExtension($this->media->extension);
//    }

    /*
* 生成 url 时使用
*/
    public function getUrlPathRelativeToRoot(): string
    {
        if (is_null($this->conversion)) {
            return $this->media->getKey() . '/' . $this->media->file_name;
//            return $this->pathGenerator->getPath($this->media).($this->media->file_name);
        }

//        return $this->pathGenerator->getPathForConversions($this->media)
        return $this->media->getKey()
                . '/'
            .  $this->pathGenerator->conversionsPath
            . $this->conversion->getName()
            . '.'
            . $this->conversion->getResultExtension($this->media->extension);
    }
}
