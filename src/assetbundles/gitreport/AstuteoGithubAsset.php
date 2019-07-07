<?php

namespace astuteo\reports\assetbundles\gitreport;

use Craft;
use craft\web\AssetBundle;
use craft\web\assets\cp\CpAsset;


class AstuteoGithubAsset extends AssetBundle
{
    // Public Methods
    // =========================================================================
    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->sourcePath = "@astuteo/reports/assetbundles/gitreport/dist";
        $this->depends = [
            CpAsset::class,
        ];
        //$this->js = [
        //    'js/reports.js',
        //];
        $this->css = [
            'css/astuteo-git-report.css',
        ];
        parent::init();
    }
}