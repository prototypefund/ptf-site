<?php

namespace modules\site\elements\exporters;

use Craft;
use craft\base\ElementExporter;
use craft\elements\db\ElementQueryInterface;
use craft\elements\db\EntryQuery;
use craft\elements\Entry;
use craft\helpers\ArrayHelper;
use modules\site\behaviors\Project as ProjectBehavior;

/**
 * Project exporter
 */
class Project extends ElementExporter
{
    public static function displayName(): string
    {
        return 'Projects';
    }

    public function export(ElementQueryInterface $query): mixed
    {
        $data = [];

        /** @var EntryQuery $query */
        $query->with([
            'projectRounds',
            'projectTopics',
            'projectTechnologies',
            'projectLicenses',
            'projectYearGroups',
        ]);

        $columnLabels = [
            'title' => Craft::t('app', 'Title'),
            'headline' => Craft::t('site', 'Headline'),
            'teamMembers' => Craft::t('site', 'Team Members'),
            'fundingAmount' => Craft::t('site', 'Funding Amount'),
            'fundingStatus' => Craft::t('site', 'Funding status'),
            'fundingPeriod' => Craft::t('site', 'Funding Period'),
            'rounds' => Craft::t('site', 'Rounds'),
            'topics' => Craft::t('site', 'Topics'),
            'yearGroups' => Craft::t('site', 'Year Groups'),
            'technologies' => Craft::t('site', 'Technologies'),
            'licenses' => Craft::t('site', 'Licenses'),
            'url' => Craft::t('app', 'URL'),
            'lastUpdate' => Craft::t('app', 'Last Update'),
        ];


        foreach ($query->all() as $entry) {
            /** @var Entry|ProjectBehavior $entry */
            $data[] = [
                $columnLabels['title'] => $entry->title,
                $columnLabels['headline'] => $entry->headline,
                $columnLabels['teamMembers'] => $entry->projectTeamMembers,
                $columnLabels['fundingAmount'] => $entry->projectFundingAmount,
                $columnLabels['fundingStatus'] => $entry->getFundingStatus()?->label(),
                $columnLabels['fundingPeriod'] => $entry->getFundingPeriod(),
                $columnLabels['rounds'] => join(', ', ArrayHelper::getColumn($entry->projectRounds, 'title')),
                $columnLabels['topics'] => join(', ', ArrayHelper::getColumn($entry->projectTopics, 'title')),
                $columnLabels['yearGroups'] => join(', ', ArrayHelper::getColumn($entry->projectYearGroups, 'title')),
                $columnLabels['technologies'] => join(', ', ArrayHelper::getColumn($entry->projectTechnologies, 'title')),
                $columnLabels['licenses'] => join(', ', ArrayHelper::getColumn($entry->projectLicenses, 'title')),
                $columnLabels['url'] => $entry->url,
                $columnLabels['lastUpdate'] => $entry->dateUpdated?->format('Y-m-d H:i:s')
            ];
        }

        return $data;
    }

    public function getFilename(): string
    {
        return 'projects';
    }
}
