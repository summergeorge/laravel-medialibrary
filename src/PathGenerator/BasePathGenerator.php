<?php

namespace Spatie\MediaLibrary\PathGenerator;

use Spatie\MediaLibrary\Media;

class BasePathGenerator implements PathGenerator
{
    public $conversionsPath = 'c/';


    /*
     * Get the path for the given media, relative to the root storage path.
     */
    public function getPath(Media $media): string
    {
        return $this->getProjectPath($media) . $this->getBasePath($media) . '/';
    }

    /*
     * Get the path for conversions of the given media, relative to the root storage path.
     * @return string
     */
    public function getPathForConversions(Media $media): string
    {
        return $this->getPath($media) . $this->conversionsPath;
    }

    /**
     * 获取项目文件目录（名称/回合数）
     * @return string
     */
    protected function getProjectPath(Media $media)
    {
        return $media->custom_path;
//        return $this->projectPath;
    }


//    public function setProjectPath($path){
//        $this->projectPath = str_finish($path,'/');
//    }

    /*
     * Get a (unique) base path for the given media.
     */
    protected function getBasePath(Media $media): string
    {
        return $media->getKey();
    }
}
