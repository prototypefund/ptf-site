<?php

namespace modules\site\enums;

use Craft;

/**
 * Funding status of a project, derived from its round or year group dates.
 */
enum FundingStatus: string
{
    case InDuration = 'inDuration';
    case Completed = 'completed';
    case InDurationWithSecondStage = 'inDurationWithSecondStage';
    case CompletedWithSecondStage = 'completedWithSecondStage';

    /**
     * Whether the project is currently being funded.
     *
     * @return bool
     */
    public function isInFunding(): bool
    {
        return match ($this) {
            self::InDuration, self::InDurationWithSecondStage => true,
            self::Completed, self::CompletedWithSecondStage => false,
        };
    }

    /**
     * Returns the translated, human-readable status.
     *
     * @return string
     */
    public function label(): string
    {
        return Craft::t('site', $this->value);
    }
}
