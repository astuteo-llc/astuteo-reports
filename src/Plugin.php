<?php

namespace astuteo\reports;

use astuteo\reports\assetbundles\cptweaks\AstuteoCPAsset;

use astuteo\reports\models\SettingsModel;
use astuteo\reports\variables\AstuteoReportsVariable;
use craft\web\twig\variables\CraftVariable;

use yii\base\Event;
use craft\events\TemplateEvent;
use Craft;
use craft\web\View;

/**
 * Class Plugin
 * @package astuteo\reports
 */

class Plugin extends \craft\base\Plugin
{

    public static $plugin;

    public $hasCpSection = true;
    public $hasCpSettings = true;

    public function init()
    {
        parent::init();
        self::$plugin = $this;

        // Plugin Nav


        // Load our AssetBundle
        if (Craft::$app->getRequest()->getIsCpRequest()) {
            Event::on(
                View::class,
                View::EVENT_BEFORE_RENDER_TEMPLATE,
                function (TemplateEvent $event) {
                    try {
                        Craft::$app->getView()->registerAssetBundle(AstuteoCPAsset::class);
                    } catch (InvalidConfigException $e) {
                        Craft::error(
                            'Error registering AssetBundle - '.$e->getMessage(),
                            __METHOD__
                        );
                    }
                }
            );
        }


        // Register variables
        Event::on(
            CraftVariable::class,
            CraftVariable::EVENT_INIT,
            function (Event $event) {
                $variable = $event->sender;
                $variable->set('astuteoReports', AstuteoReportsVariable::class);
            }
        );
    }


    protected function createSettingsModel()
    {
        return new SettingsModel();
    }

    public function getCpNavItem()
    {
        $item = parent::getCpNavItem();
        if($this->getSettings()->cpLabel) {
            $item['label'] = $this->getSettings()->cpLabel;
        }

        $subnav = [];
        // Merge nav array based on settings
        if( $this->getSettings()->loadSeoAudit ) {
            $subnav = array_merge($subnav, ['seo'=>['label' => 'SEO', 'url' => 'astuteo-reports']]);
        }
        if($this->getSettings()->showGitReporter) {
            $subnav = array_merge($subnav, ['updates'=>['label' => 'Updates', 'url' => 'astuteo-reports/updates']]);
        }

        $item['subnav'] = $subnav;
        return $item;
    }



    protected function settingsHtml()
    {
        return \Craft::$app->getView()->renderTemplate('astuteo-reports/_settings', [
           'settings' => $this->getSettings()
        ]);
    }


}