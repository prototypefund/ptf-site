<?php

namespace modules\site\behaviors;

use Craft;
use craft\elements\Category;
use craft\elements\db\ElementQueryInterface;
use craft\elements\Entry;
use craft\helpers\DateTimeHelper;
use DateTimeImmutable;
use DateTimeInterface;
use modules\site\enums\FundingStatus;
use yii\base\Behavior;

/**
 * Funding status and period for entries in the projects section.
 *
 * @property Entry $owner
 * @property-read Category|null $fundingCategory
 * @property-read FundingStatus|null $fundingStatus
 * @property-read bool $isInFunding
 * @property-read string|null $fundingPeriod
 */
class Project extends Behavior
{
    // Const Properties
    // =========================================================================

    private const DATE_FORMAT = 'd/m/Y';

    // Private Properties
    // =========================================================================

    /**
     * @var Category|false|null Memoized funding category; `false` until resolved.
     */
    private Category|false|null $_fundingCategory = false;

    // Public Methods
    // =========================================================================

    /**
     * Returns the category holding the funding dates: the project round, or the year group as fallback.
     *
     * @return Category|null
     */
    public function getFundingCategory(): ?Category
    {
        if ($this->_fundingCategory === false) {
            $this->_fundingCategory = $this->_firstRelated('projectRounds') ?? $this->_firstRelated('projectYearGroups');
        }

        return $this->_fundingCategory;
    }

    /**
     * Returns the current funding status, or `null` if the funding dates are incomplete.
     *
     * @return FundingStatus|null
     */
    public function getFundingStatus(): ?FundingStatus
    {
        $category = $this->getFundingCategory();

        if (!$category?->startDate || !$category->endDateRegular) {
            return null;
        }

        $now = DateTimeHelper::now();

        if ($now < $this->_startOfNextDay($category->endDateRegular)) {
            return FundingStatus::InDuration;
        }

        if (!$this->owner->secondStage) {
            return FundingStatus::Completed;
        }

        if (!$category->endDateSecondStage) {
            return null;
        }

        if ($now < $this->_startOfNextDay($category->endDateSecondStage)) {
            return FundingStatus::InDurationWithSecondStage;
        }

        return FundingStatus::CompletedWithSecondStage;
    }

    /**
     * Returns whether the project is currently being funded.
     *
     * @return bool
     */
    public function getIsInFunding(): bool
    {
        return $this->getFundingStatus()?->isInFunding() ?? false;
    }

    /**
     * Returns the human-readable funding period, or `null` if there is no funding status.
     *
     * @return string|null
     */
    public function getFundingPeriod(): ?string
    {
        $status = $this->getFundingStatus();

        if ($status === null) {
            return null;
        }

        $category = $this->getFundingCategory();
        $startDate = $category->startDate->format(self::DATE_FORMAT);

        return match ($status) {
            FundingStatus::InDuration => Craft::t('site', 'In funding since {startDate}', [
                'startDate' => $startDate,
            ]),
            FundingStatus::Completed => sprintf('%s – %s', $startDate, $category->endDateRegular->format(self::DATE_FORMAT)),
            FundingStatus::InDurationWithSecondStage => Craft::t('site', 'In funding since {startDate}, currently in Second Stage', [
                'startDate' => $startDate,
            ]),
            FundingStatus::CompletedWithSecondStage => Craft::t('site', '{startDate} – {endDateSecondStage} (incl. Second Stage)', [
                'startDate' => $startDate,
                'endDateSecondStage' => $category->endDateSecondStage->format(self::DATE_FORMAT),
            ]),
        };
    }

    // Private Methods
    // =========================================================================

    /**
     * Returns the first related category of a relation field, whether it was eager-loaded or not.
     *
     * @param string $handle
     * @return Category|null
     */
    private function _firstRelated(string $handle): ?Category
    {
        $value = $this->owner->getFieldValue($handle);

        if ($value instanceof ElementQueryInterface) {
            return $value->eagerly()->one();
        }

        return $value?->first();
    }

    /**
     * Date fields without time are stored as midnight, so the funding runs through the whole end day.
     *
     * @param DateTimeInterface $date
     * @return DateTimeInterface
     */
    private function _startOfNextDay(DateTimeInterface $date): DateTimeInterface
    {
        return DateTimeImmutable::createFromInterface($date)->modify('+1 day');
    }
}
