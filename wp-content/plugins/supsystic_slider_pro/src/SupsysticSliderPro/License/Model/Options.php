<?php


class SupsysticSliderPro_License_Model_Options extends SupsysticSlider_Core_BaseModel
{
    private $_values = array();
    private $_valuesLoaded = false;

    /**
     * Constructor.
     */
    public function __construct(Rsc_Environment $environment = null)
    {
        parent::__construct();

        $this->environment = $environment;
    }

    public function getPrefix()
    {
        if (null === $this->environment) {
			return 'ss_';
            //throw new RuntimeException('Environment not yet injected.');
        }

        return $this->environment->getConfig()->get('hooks_prefix');
    }

    public function get($optKey) {
        $this->_loadOptValues();
        return isset($this->_values[ $optKey ]) ? $this->_values[ $optKey ]['value'] : false;
    }
    public function isEmpty($optKey) {
        $value = $this->get($optKey);
        return $value === false;
    }
    public function save($optKey, $val, $ignoreDbUpdate = false) {
        $this->_loadOptValues();
        if(!isset($this->_values[ $optKey ]) || $this->_values[ $optKey ]['value'] != $val) {
            if(isset($this->_values[ $optKey ]) || !isset($this->_values[ $optKey ]['value']))
                $this->_values[ $optKey ] = array();
            $this->_values[ $optKey ]['value'] = $val;
            $this->_values[ $optKey ]['changed_on'] = time();
            if(!$ignoreDbUpdate) {
                $this->_updateOptsInDb();
            }
        }
    }
    public function getAll() {
        $this->_loadOptValues();
        return $this->_values;
    }
    /**
     * Pass throught refferer - to not lose memory for copy of same opts array
     */
    public function fillInValues(&$options) {
        $this->_loadOptValues();
        foreach($options as $cKey => $cData) {
            foreach($cData['opts'] as $optKey => $optData) {
                $value = 0;
                $changedOn = 0;
                // Retrive value from saved options
                if(isset($this->_values[ $optKey ])) {
                    $value = $this->_values[ $optKey ]['value'];
                    $changedOn = isset($this->_values[ $optKey ]['changed_on']) ? $this->_values[ $optKey ]['changed_on'] : '';
                } elseif(isset($optData['def'])) {	// If there were no saved data - set it as default
                    $value = $optData['def'];
                }
                $options[ $cKey ]['opts'][ $optKey ]['value'] = $value;
                $options[ $cKey ]['opts'][ $optKey ]['changed_on'] = $changedOn;
                if(!isset($this->_values[ $optKey ]['value'])) {
                    $this->_values[ $optKey ]['value'] = $value;
                }
            }
        }
    }
    public function saveGroup($d = array()) {
        if(isset($d['opt_values']) && is_array($d['opt_values']) && !empty($d['opt_values'])) {
            foreach($d['opt_values'] as $code => $val) {
                $this->save($code, $val, true);
            }
            $this->_updateOptsInDb();
            return true;
        } else {
            //$this->pushError(__('Empty data to save option', PPS_LANG_CODE));
        }
        return false;
    }
    private function _updateOptsInDb() {
        //replace slider code
        update_option($this->getPrefix(). '_opts_data', $this->_values);
    }
    private function _loadOptValues() {
        if(!$this->_valuesLoaded) {
            //replace slider code here
            $this->_values = get_option($this->getPrefix() . '_opts_data');
            if(empty($this->_values))
                $this->_values = array();
            $this->_valuesLoaded = true;
        }
    }
} 