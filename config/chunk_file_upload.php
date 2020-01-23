<?php

return [
    'disks' => [

        'local' => [
            'driver' => 'local',
            'root' => storage_path('app'),
        ],

        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
        ],
        'qiniu_live' => [//七牛云
            'driver' => 'qiniu',//如果是七牛云空间，必填qiniu
            'domains' => [
                'default' => env('QINIU_BASE_URL', ''), //你的七牛域名
                'https' => env('QINIU_BASE_URL', ''), //你的HTTPS域名
                'custom' => env('QINIU_BASE_URL', ''),                //你的自定义域名
            ],
            'access_key' => env('QINIU_ACCESS_KEY', ''),  //AccessKey
            'secret_key' => env('QINIU_SECRET_KEY', ''),  //SecretKey
            'bucket' => env('QINIU_DEFUALT_BUCKET', ''),  //Bucket名字
            'url' => str_replace('http://','',env('QINIU_BASE_URL', '')),  // 填写文件访问根url
            'qn_area' => 'http://up-z2.qiniup.com',
        ]
    ],
    'default' => [
        'disk' => 'qiniu_live',//默认磁盘
        'extensions' => 'jpg,png,mp4,jpeg',//后缀
        'mimeTypes' => 'image/*,video/*',//类型
        'fileSizeLimit' => 10737418240,//上传文件限制总大小，默认10G,默认单位为b
        'fileNumLimit' => 2,//文件上传总数量
        'saveType' => 'json', //单文件默认为字符串，多文件上传存储格式，json:['a.jpg','b.jpg']
    ]


];
