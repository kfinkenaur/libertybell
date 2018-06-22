<?php


class SupsysticSliderPro_Slider_Model_Resources extends SupsysticSlider_Slider_Model_Resources
{
    const TYPE_VIDEO = 'video';

    /**
     * Adds video to the slider.
     *
     * @param int $sliderId Slider Id.
     * @param int $videoId Video Id.
     * @return bool
     */
    public function addVideo($sliderId, $videoId)
    {
        return $this->add($sliderId, self::TYPE_VIDEO, $videoId);
    }

    /**
     * {@inheritdoc}
     */
    public function addArray($sliderId, array $items)
    {
//        Debug::wipe();
//
//        $log = function ($type, $rid, $sid) {
//            $pattern = 'Adding [%s %d] to the [%d]';
//            Debug::log(sprintf($pattern, $type, $rid, $sid), true);
//        };
//
//        $result = function ($x) {
//            Debug::log(sprintf('Result: %s', $x ? 'Success':'Fail'), true);
//        };

        foreach ($items as $type => $identifiers) {
            if (count($identifiers) > 0) {
                foreach ($identifiers as $id) {
                    if ($type === self::TYPE_FOLDER) {
                        $this->addFolder($sliderId, $id);
                    } elseif ($type === self::TYPE_IMAGE) {
                        $this->addImage($sliderId, $id);
                    } elseif ($type === self::TYPE_VIDEO) {
                        $this->addVideo($sliderId, $id);
                    }
                }
            }
        }
    }

} 