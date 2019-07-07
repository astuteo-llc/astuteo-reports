<?php

namespace astuteo\reports\assetbundles\cptweaks;

use Craft;
use craft\web\AssetBundle;
use craft\web\assets\cp\CpAsset;


class AstuteoCPAsset extends AssetBundle
{
    // Public Methods
    // =========================================================================
    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->sourcePath = "@astuteo/reports/assetbundles/cptweaks/dist";
        $this->depends = [
            CpAsset::class,
        ];
        //$this->js = [
        //    'js/reports.js',
        //];
        $this->css = [
            'css/astuteo-cp-tweaks.css',
        ];
        parent::init();
    }
}