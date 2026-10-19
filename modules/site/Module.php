<?php

namespace modules\site;

use Craft;
use craft\ckeditor\helpers\CkeditorConfig;
use yii\base\Module as BaseModule;

/**
 * site module
 *
 * @method static Module getInstance()
 */
class Module extends BaseModule
{
    public function init(): void
    {
        Craft::setAlias('@modules/site', __DIR__);

        // Set the controllerNamespace based on whether this is a console or web request
        if (Craft::$app->request->isConsoleRequest) {
            $this->controllerNamespace = 'modules\\site\\console\\controllers';
        } else {
            $this->controllerNamespace = 'modules\\site\\controllers';
        }

        parent::init();

        CkeditorConfig::registerFirstPartyPackage(['ImageResize', 'Table', 'TableLayout'], ['insertTableLayout']);
    }
}
