<?php

namespace astuteo\reports\assetbundles\seo;

use Craft;
use craft\web\AssetBundle;
use craft\web\assets\cp\CpAsset;


class AstuteoReportsAsset extends AssetBundle
{
    // Public Methods
    // =========================================================================
    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->sourcePath = "@astuteo/reports/assetbundles/seo/dist";
        $this->depends = [
            CpAsset::class,
        ];
        //$this->js = [
        //    'js/reports.js',
        //];
        $this->css = [
            'css/astuteo-seo-reports.css',
        ];
        parent::init();
    }
}