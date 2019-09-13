<?php

namespace aka03\comments\assets;

use yii\web\AssetBundle;

class CommentAsset extends AssetBundle
{
    public $sourcePath = '@aka03/comments/web';
    public $css = [
        'css/comments.css',
    ];
    public $js = [
        'js/comments.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];
}
