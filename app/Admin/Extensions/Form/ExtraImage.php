<?php

namespace App\Admin\Extensions\Form;

use Encore\Admin\Form\Field\Image;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ExtraImage extends Image
{
    protected $isDeletable = false;
    //设置文件夹
    protected $qiniuDirectory = 'image';

    /**
     * Upload file and delete original file.
     * @param UploadedFile $file
     * @return mixed
     */
    protected function uploadAndDeleteOriginal(UploadedFile $file)
    {
        $disk = Storage::disk('qiniu');
        $path = $disk->put($this->qiniuDirectory, $file);

        if (!$this->isDeletable) {
            $this->destroy();
        }
        $path = config('filesystems.disks.qiniu.domain') . '/' . $path;
        return $path;
    }

    public function deletable($bool = false)
    {
        $this->isDeletable = $bool;
        return $this;
    }

    public function setQiniuDirectory($path = '')
    {
        $this->qiniuDirectory = $path;
        return $this;
    }
}