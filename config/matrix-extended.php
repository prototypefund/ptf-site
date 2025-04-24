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
                  'types' => ['sideHeadingText', 'linkList', 'peopleGrid', 'relatedCtaBanner', 'embed', 'newsletter'],
                ],
                [
                  'label' => \Craft::t('app', 'Teasers'),
                  'types' => ['blogTeasers', 'projectTeasers', 'trendTeasers'],
                ],
              ],
          ]
      ]
  ];


