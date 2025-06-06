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
                  'types' => ['sideHeadingText', 'textGrid', 'relatedLinkList', 'expandableText', 'relatedTimeline', 'relatedPublications', 'peopleGrid', 'steps', 'statement', 'relatedCtaBanner', 'embed', 'newsletter'],
                ],
                [
                  'label' => \Craft::t('app', 'Teasers'),
                  'types' => ['blogTeasers', 'projectTeasers', 'eventTeasers', 'genericTeasers', 'talkTeasers', 'trendTeasers'],
                ]
              ],
          ]
      ]
  ];


