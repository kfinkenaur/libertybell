<?php

/**
 * Class GirdGallery_Installer_Module
 */
class SupsysticSlider_Installer_Module extends SupsysticSlider_Core_Module
{
    const LAST_REVISION = 'supsystic_slider_last_revision';
    const UPDATE_REVISION = 0;

    /**
     * @var GirdGallery_Installer_Model
     */
    protected $model;

    /**
     * {@inheritdoc}
     */
    public function onInit()
    {
        $config = $this->getEnvironment()->getConfig();
		$currentVersion = $config->get('revision');
		$lastVersion = get_option(self::LAST_REVISION);

		if ($lastVersion === false) {
			update_option(self::LAST_REVISION, $currentVersion);
		}

        if (version_compare($currentVersion, $lastVersion, '>')) {
			if (false === $config->get('plugin_db_update')) {
				return;
			}
            self::executeUpdate($lastVersion, $currentVersion);
            update_option(self::LAST_REVISION, $currentVersion);
        }
    }

    /**
     * {@inhertidoc}
     */
    public function onInstall()
    {
        parent::onInstall();

        $model   = self::getModel();
        $queries = self::getSchema();

        if (!$model->install($queries)) {
            wp_die ('Failed to update database.');
        }
    }

    public function onDeactivation()
    {
        $response = $this->getController()->askUninstallAction();

        if (!is_bool($response)) {
            exit($response);
        }

        if ($response) {
            $model   = self::getModel();
            $queries = self::getSchema();

            $model->drop($queries);
        }
    }

    protected static function executeUpdate($start, $end)
    {
		for($i = $start; $i <= $end; $i++) {
			self::getModel()->update(self::getUpdates($i));
		}
    }

    /**
     * Returns the database schema queries.
     * @return array|null
     */
    protected static function getSchema()
    {
        if (!is_file($file = dirname(__FILE__) . '/Schema.php')) {
            return null;
        }

        return include $file;
    }

    protected static function getUpdates($revision)
    {
        $filename = sprintf('/Updates/rev_%d.php', (int)$revision);

        if (!is_file($file = dirname(__FILE__) . $filename)) {
            return null;
        }

        return include $file;
    }

    protected static function getModel()
    {
        return new SupsysticSlider_Installer_Model();
    }

}
