<?php

namespace modules\site;

use Craft;
use craft\base\Element;
use craft\ckeditor\helpers\CkeditorConfig;
use craft\elements\Entry;
use craft\events\DefineBehaviorsEvent;
use craft\events\RegisterElementExportersEvent;
use craft\helpers\ElementHelper;
use modules\site\behaviors\Project as ProjectBehavior;
use modules\site\elements\exporters\Project;
use yii\base\Event;
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

        $this->_attachEventHandlers();
    }

    private function _attachEventHandlers(): void
    {
        Event::on(
            Entry::class,
            Element::EVENT_REGISTER_EXPORTERS,
            function (RegisterElementExportersEvent $event) {
                $source = ElementHelper::findSource(Entry::class, $event->source);

                if (!isset($source['data']['handle']) || $source['data']['handle'] !== 'projects') {
                    return;
                }

                $event->exporters[] = Project::class;
            }
        );


        Event::on(Entry::class, Entry::EVENT_DEFINE_BEHAVIORS, function (DefineBehaviorsEvent $event) {
            /** @var Entry $entry */
            $entry = $event->sender;

            if ($entry->getSection()?->handle === 'projects') {
                $event->behaviors[] = ProjectBehavior::class;
            }
        });
    }
}
