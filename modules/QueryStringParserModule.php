<?php
namespace modules;

use Craft;
use yii\base\Module;
use craft\web\twig\variables\CraftVariable;
use yii\base\Event;

class QueryStringParserModule extends Module
{
    public function init(): void
    {
        parent::init();

        // Register as craft.customQueryStringParser in Twig
        Event::on(
            CraftVariable::class,
            CraftVariable::EVENT_INIT,
            function(Event $event) {
                $variable = $event->sender;
                $variable->set('customQueryStringParser', $this);
            }
        );
    }

    /**
     * Alias for getQueryParams()
     */
    public function parse(): array
    {
        return $this->getQueryParams();
    }

    /**
     * Returns all parsed query parameters.
     */
    public function getQueryParams(): array
    {
        return $this->_parseQueryString();
    }

    /**
     * Returns a specific parsed query parameter (array or null).
     */
    public function getQueryParam(string $name): array
    {
        $params = $this->_parseQueryString();
        return $params[$name] ?? [];
    }

    /**
     * Converts an associative array of key => [values] into a query string.
     */
    public function toQueryString(array $params): string
    {
        $parts = [];

        foreach ($params as $key => $values) {
            if (!is_array($values)) {
                $values = [$values];
            }

            foreach ($values as $value) {
                $encodedKey = urlencode($key);
                $encodedValue = urlencode($value);
                $parts[] = "{$encodedKey}={$encodedValue}";
            }
        }

        return $parts ? implode('&', $parts) : '';
    }

    /**
     * Returns all query string values as a flat array (no keys).
     *
     * Example:
     * ?round=runde16&round=runde1&filter=foo
     * → ['runde16', 'runde1', 'foo']
     */
    public function getQueryValues(): array
    {
        $params = $this->_parseQueryString();
        $values = [];

        foreach ($params as $valueList) {
            foreach ($valueList as $val) {
                $values[] = $val;
            }
        }

        return $values;
    }

    /**
     * Internal logic to parse the query string into key => [values].
     */
    private function _parseQueryString(): array
    {
        $queryString = Craft::$app->getRequest()->getQueryString();
        $params = [];

        if ($queryString) {
            $pairs = explode('&', $queryString);

            foreach ($pairs as $pair) {
                if (!$pair) {
                    continue;
                }

                $parts = explode('=', $pair, 2);
                $key = $parts[0] ?? null;
                $value = $parts[1] ?? null;

                if ($key === 'p') {
                    continue;
                }

                $key = urldecode($key);
                $value = $value !== null ? urldecode($value) : null;

                if (isset($params[$key])) {
                    $params[$key][] = $value;
                } else {
                    $params[$key] = [$value];
                }
            }
        }

        return $params;
    }
}
