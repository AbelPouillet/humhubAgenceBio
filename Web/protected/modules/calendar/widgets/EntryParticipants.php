<?php

namespace humhub\modules\calendar\widgets;

use humhub\components\Widget;
use humhub\modules\calendar\helpers\Url;
use humhub\widgets\Button;
use humhub\modules\calendar\models\CalendarEntry;
use humhub\modules\calendar\models\CalendarEntryParticipant;
use Yii;

/**
 * Description of EntryParticipants
 *
 * @author luke
 */
class EntryParticipants extends Widget
{

    /**
     * @var CalendarEntry
     */
    public $calendarEntry;

    public function run()
    {
        if($this->calendarEntry->closed) {
            return;
        }

        $countAttending = $this->getParticipantStateCount(CalendarEntryParticipant::PARTICIPATION_STATE_ACCEPTED, true);
        $countMaybe = $this->getParticipantStateCount(CalendarEntryParticipant::PARTICIPATION_STATE_MAYBE, $this->calendarEntry->allow_maybe);
        $countDeclined = $this->getParticipantStateCount(CalendarEntryParticipant::PARTICIPATION_STATE_DECLINED, $this->calendarEntry->allow_decline);

        return $this->render('participants', [
            'calendarEntry' => $this->calendarEntry,
            'countAttending' => $countAttending,
            'countMaybe' => $countMaybe,
            'countDeclined' => $countDeclined,
        ]);
    }

    private function getParticipantStateCount($state, $condition)
    {
        if(!$condition) {
            return null;
        }

        return  $this->calendarEntry->getParticipantCount($state);
    }

    public static function participateButton(CalendarEntry $calendarEntry, $state, $label)
    {
        if($state == CalendarEntryParticipant::PARTICIPATION_STATE_MAYBE && !$calendarEntry->allow_maybe) {
            return null;
        }
        if($state == CalendarEntryParticipant::PARTICIPATION_STATE_DECLINED && !$calendarEntry->allow_decline) {
            return null;
        }

        $participantSate = $calendarEntry->getParticipationStatus(Yii::$app->user->identity);

        $button = Button::info($label)->sm()
            ->icon($participantSate === $state ? 'fa-check' : null);
        if ($calendarEntry->isPast()) {
            $button->cssClass('disabled')->loader(false);
        } else {
            $button->action('calendar.respond', Url::toEntryRespond($calendarEntry, $state));
        }

        return $button;
    }
}
