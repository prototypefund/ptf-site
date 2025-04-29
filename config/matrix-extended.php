<?php
  return [
      'extraDeleteButton' => false,
      'experimentalFeatures' => false,
      'enableDragDrop' => false,
      'expandMenu' => true,
      'expandUngrouped' => true,
      'ungroupedPosition' => 'start',
      'fields' => [
          'modules' => [
              'groups' => [
                [
                  'label' => \Craft::t('app', 'Blocks'),
                  'types' => ['sideHeadingText', 'relatedLinkList', 'expandableText', 'relatedPublications', 'peopleGrid', 'steps', 'relatedCtaBanner', 'embed', 'newsletter'],
                ],
                [
                  'label' => \Craft::t('app', 'Teasers'),
                  'types' => ['blogTeasers', 'projectTeasers', 'trendTeasers'],
                ],
                [
                  'label' => \Craft::t('app', '⏳'),
                  'types' => ['genericTeasers', 'statement'],
                ],
              ],
          ]
      ]
  ];


