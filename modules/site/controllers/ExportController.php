<?php

namespace modules\site\controllers;

use Craft;
use craft\elements\Entry;
use craft\helpers\StringHelper;
use craft\web\Controller;
use modules\site\elements\exporters\Project;
use yii\base\InvalidValueException;
use yii\web\Response;

/**
 * Export controller
 */
class ExportController extends Controller
{
    public $defaultAction = 'index';
    protected array|int|bool $allowAnonymous = true;

    /**
     * site/export action
     */
    public function actionIndex(): Response
    {
        $query = Entry::find()
            ->section('projects')
            ->status('live');

        $exporter = new Project();
        $exporter->setElementType(Entry::class);

        $filename = $exporter->getFilename();

        if ($exporter::isFormattable()) {
            $this->response->format = $this->request->getBodyParam('format', 'csv');
            $filename .= '.' . $this->response->format;
        }
        $this->response->setDownloadHeaders($filename);

        $export = $exporter->export($query);

        if ($exporter::isFormattable()) {
            // Handle being passed in a generator function or other callable
            if (is_callable($export)) {
                $export = $export();
            }
            if (!is_iterable($export)) {
                throw new InvalidValueException(get_class($exporter) . '::export() must return an array or generator function since isFormattable() returns true.');
            }

            $this->response->data = $export;

            switch ($this->response->format) {
                case Response::FORMAT_JSON:
                    $this->response->formatters[Response::FORMAT_JSON]['prettyPrint'] = true;
                    break;
                case Response::FORMAT_XML:
                    Craft::$app->language = 'en-US';
                    $this->response->formatters[Response::FORMAT_XML]['rootTag'] = StringHelper::toCamelCase($this->elementType::pluralLowerDisplayName());
                    break;
            }
        } elseif (
            is_callable($export) ||
            is_resource($export) ||
            (is_array($export) && isset($export[0]) && is_resource($export[0]))
        ) {
            $this->response->stream = $export;
        } else {
            $this->response->data = $export;
            $this->response->format = Response::FORMAT_RAW;
        }

        $this->response->getHeaders()
            ->set('Cache-Control', 'no-store, private')
            ->set('X-Robots-Tag', 'noindex');

        return $this->response;
    }
}
