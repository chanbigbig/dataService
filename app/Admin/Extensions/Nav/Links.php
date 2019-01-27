<?php
/**
 * function description
 * @author: YDY TEAM
 * @created: 2018/7/13 下午2:38
 */

namespace App\Admin\Extensions\Nav;

use App\Models\Entity;
use Encore\Admin\Facades\Admin;
use Endroid\QrCode\QrCode;

class Links
{
    public function __toString()
    {
        $entity = Entity::getEntity(Admin::user()->entity_id);

        $videoUrl = config('installer.video_url');

        $installerUrl = config('installer.installer_short_url');

        $qrcode = new QrCode(encryptArray([
            'link' => config('installer.ydy_url'),
            'entity_id' => $entity->entity_id,
            'entity_name' => $entity->entity_name
        ]));

        $qrcode->setSize(250);
        $qrcode->setMargin(0);
        $qrcode->setEncoding('UTF-8');

        return <<<HTML
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" title="刷机二维码">
                        <i class="fa fa-qrcode"></i>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="bg-info">
                            <img src="{$qrcode->writeDataUri()}" style="padding: 5px;">
                        </li>
                        <li class="text-center bg-success">
                             <strong>{$entity->entity_name}</strong>：专属刷机二维码
                        </li>
                        <li class="text-center bg-info">
                            <a title="打开手机浏览器输入地址下载安装" href="http://{$installerUrl}">下载安装器：{$installerUrl}</a>
                        </li>
                        <li class="text-center bg-danger">
                             <a href="{$videoUrl}" target="_blank"><i class="fa fa-play-circle"></i><strong>刷机视频教程</strong></a>
                        </li>
                    </ul>
                </li>
HTML;
    }
}