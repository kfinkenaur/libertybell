<?php


class SupsysticSliderPro_Tumblr_Module extends Rsc_Mvc_Module
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
        $config->add('tumblr_key', 'fJMYzwTrbjinrWbSiy73rYeGIcaT4h2CH6nEaoElvHe8xMFlur');

        // Client Secret
        $config->add('tumblr_secret', '5N7TL5mintj7dQ9IYyxL09mAgM8BWt8PXSS81r6WFvo2ycCCny');

        // Authenticator's Instagram URL
        $config->add('tumblr_redirect', 'http://supsystic.com/authenticator/index.php/authenticator/tumblr');

        // Authenticator redirect uri
        $config->add(
            'tumblr_state',
            $environment->generateUrl('tumblr', 'complete')
        );
    }

    /**
     * Returns Tumblr client.
     *
     * @return SupsysticSliderPro_Tumblr_Client
     */
    public function getClient()
    {
        if (!$this->client) {
            $config = $this->getEnvironment()->getConfig();
            $client = new SupsysticSliderPro_Tumblr_Client();

            $client->setClientKey($config->get('tumblr_key'));
            $client->setClientSecret($config->get('tumblr_secret'));
            $client->setRedirectUri($config->get('tumblr_redirect'));
            $client->setState($config->get('tumblr_state'));

            $this->client = $client;
        }

        return $this->client;
    }
} 