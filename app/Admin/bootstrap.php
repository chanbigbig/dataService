<?php

use Encore\Admin\Form;
use App\Admin\Extensions\Form\uEditor;


Encore\Admin\Form::forget(['map', 'editor']);


Form::extend('ueditor', uEditor::class);


app('view')->prependNamespace('admin', resource_path('views/admin'));


Encore\Admin\Form::extend('chunk_file', \Encore\ChunkFileUpload\ChunkFileField::class);
