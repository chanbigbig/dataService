<?php

use Encore\Admin\Form;
use App\Admin\Extensions\Form\uEditor;
use App\Admin\Extensions\Form\ExtraImage;


Encore\Admin\Form::forget(['map', 'editor']);


Form::extend('ueditor', uEditor::class);

Encore\Admin\Form::forget([ 'image']); // 删除原有注册的 Image 组件
Encore\Admin\Form::extend('image', ExtraImage::class); // 重新注册新的 Image 组件


app('view')->prependNamespace('admin', resource_path('views/admin'));


//Encore\Admin\Form::extend('chunk_file', \Encore\ChunkFileUpload\ChunkFileField::class);
