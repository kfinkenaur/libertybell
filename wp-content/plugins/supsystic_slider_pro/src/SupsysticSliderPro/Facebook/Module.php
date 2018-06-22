<?php


class SupsysticSliderPro_Facebook_Module extends Rsc_Mvc_Module
{

    protected $client;

    /**
     * {@inheritdoc}
     */
    public function onInit()
    {
        $environment = $this->getEnvironment();
        $config = $environment->getConfig();

        // Client ID
        $config->add('facebook_key', '1612081092370131');

        // Client Secret
        $config->add('facebook_secret', '8addb5f886c12f229a252bc569ea0740');

        // Authenticator's Facebook URL
        $config->add('facebook_redirect', 'http://supsystic.com/authenticator/index.php/authenticator/facebook');

        // Authenticator redirect uri
        $config->add(
            'facebook_state',
            $environment->generateUrl('facebook', 'complete')
        );
    }

    /**
     * Returns Facebook client.
     *
     * @return SupsysticSliderPro_Facebook_Client
     */
    public function getClient()
    {
        if (!$this->client) {
            $config = $this->getEnvironment()->getConfig();
            $client = new SupsysticSliderPro_Facebook_Client();

            $client->setClientKey($config->get('facebook_key'));
            $client->setClientSecret($config->get('facebook_secret'));
            $client->setRedirectUri($config->get('facebook_redirect'));
            $client->setState($config->get('facebook_state'));

            $this->client = $client;
        }

        return $this->client;
    }
} 