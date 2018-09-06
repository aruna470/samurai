<?php
/**
 * Util class
 *
 * Contains various helper functions.
 *
 * @author  Aruna Attanayake <aruna@keeneye.solutions>
 */

namespace app\components;

use Yii;
use yii\base\Component;
use \DateTime;
use \DateTimeZone;

class Util extends Component
{

    /**
     * Retrieve UTC date time
     * @param string $format Date Time format
     * @return string UTC date time
     */
    public function getUtcDateTime($dateTime = null, $sourceTz = null, $format = 'Y-m-d H:i:s')
    {
        if (null != $dateTime) {
            $date = new DateTime($dateTime, new DateTimeZone($sourceTz));
            $date->setTimezone(new DateTimeZone('UTC'));
            return $date->format($format);
        } else {
            return gmdate('Y-m-d H:i:s');
        }
    }

    /**
     * Retrieve UTC date
     * @param string $format Date Time format
     * @return string UTC date
     */
    public function getUtcDate($dateTime = null, $sourceTz = null, $format = 'Y-m-d')
    {
        if (null != $dateTime) {
            $date = new DateTime($dateTime, new DateTimeZone($sourceTz));
            $date->setTimezone(new DateTimeZone('UTC'));
            return $date->format($format);
        } else {
            return gmdate('Y-m-d');
        }
    }

    /**
     * Convert specific date time to another date time based on Timezone
     * @param string $dateTime Stored datetime
     * @param string $destinationTz Date time will be converted to this timezone
     * @param string $sourceTz Currently date time stored timezone
     * @param string $format Date Time format
     * @return string converted date time
     */
    public function getLocalDateTime($dateTime, $destinationTz, $sourceTz = 'UTC', $format = 'Y-m-d H:i:s')
    {
        if ('' != $dateTime) {
            $date = new DateTime($dateTime, new DateTimeZone($sourceTz));
            $date->setTimezone(new DateTimeZone($destinationTz));
            return $date->format($format);
        }

        return '';
    }

    /**
     * Convert specific date time to another date time based on Timezone
     * @param string $dateTime Stored datetime
     * @param string $destinationTz Date time will be converted to this timezone
     * @param string $sourceTz Currently date time stored timezone
     * @param string $format Date Time format
     * @return string converted date
     */
    public function getLocalDate($dateTime, $destinationTz, $sourceTz = 'UTC', $format = 'Y-m-d')
    {
        if ('' != $dateTime) {
            $date = new DateTime($dateTime, new DateTimeZone($sourceTz));
            $date->setTimezone(new DateTimeZone($destinationTz));
            return $date->format($format);
        }

        return '';
    }

    /**
     * Convert specific date time to another date time based on Timezone
     * @param string $dateTime Stored datetime
     * @param string $destinationTz Date time will be converted to this timezone
     * @param string $sourceTz Currently date time stored timezone
     * @param string $format Date Time format
     * @return string converted date
     */
    public function getTzSpecificDateTime($dateTime, $destinationTz, $sourceTz = 'UTC', $format = 'Y-m-d H:i:s')
    {
        $date = new DateTime($dateTime, new DateTimeZone($sourceTz));
        $date->setTimezone(new DateTimeZone($destinationTz));
        return $date->format($format);
    }

    /**
     * Returns available timezone list
     */
    public function getTimeZoneList()
    {
        $tz = timezone_identifiers_list();

        return array_combine($tz, $tz);
    }

    /**
     * Checks if the given value is empty.
     * A value is considered empty if it is null, an empty array, or the trimmed result is an empty string.
     * Note that this method is different from PHP empty(). It will return false when the value is 0.
     * @param mixed $value The value to be checked
     * @param boolean $trim Whether to perform trimming before checking if the string is empty. Defaults to true.
     * @return boolean Whether the value is empty
     */
    public function isEmpty($value, $trim = true)
    {
        return $value === null || $value === array() || $value === '' || $trim && is_scalar($value) && trim($value) === '';
    }
}
