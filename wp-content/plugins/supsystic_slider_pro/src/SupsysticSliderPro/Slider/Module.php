<?php


class SupsysticSliderPro_Slider_Module extends SupsysticSlider_Slider_Module
{
    /**
     * {@inheritdoc}
     */
    public function loadExtensions()
    {
        parent::loadExtensions();

        $twig = $this->getEnvironment()->getTwig();
        $twig->addExtension(new SupsysticSliderPro_Slider_Twig_Video());
    }

    public function render($attributes)
    {
		if (!isset($attributes['id'])) {
			// @TODO: Maybe we need to show error message here.
			return;
		}

		$slider = $this->getCurrentSlider($attributes['id']);

		if (!$slider) {
			// @TODO: Maybe we need to show error message here.
			return;
		}

		$this->extendedAttachmentOptions = array_merge($this->extendedAttachmentOptions, array(
			'_slider_link' => 'external_link',
			'target' => 'target',
			'_wp_attachment_image_alt' => 'seo',
		));

		if(!isset($attributes['image-list'])) {
			if (isset($slider->settings['autoposts']) && $slider->settings['autoposts']['enabled'] == 'true') {
				$categories = '';

				if (isset($slider->settings['autoposts']['categories'])) {
					$categories = $slider->settings['autoposts']['categories'];
				}
				if (is_array($categories)) {
					$categories = implode(',', $categories);
				}
				if (strpos($categories, 'all') !== false) {
					$categories = '';
				}
				$rawPosts = get_posts(array(
					'numberposts' => $slider->settings['autoposts']['quantity'],
					'category' => $categories,
					'orderby' => 'date'
				));
				foreach ($rawPosts as $post) {
					$thumbnailId = get_post_thumbnail_id($post->ID);
					$image['attachment'] = wp_prepare_attachment_for_js($thumbnailId);
					$imageUrl = wp_get_attachment_image_src($thumbnailId, 'full');
					if($imageUrl) {
						$imageUrl = current($imageUrl);
					}
					$excerpt = $this->getEnvironment()->getModule('Slider')->getController()->getModel('settings')->getTheExcerpt($post);

					array_push($this->posts, array(
						'id' => $post->ID,
						'title' => $post->post_title,
						'date' => date('F j, Y', strtotime($post->post_date)),
						'excerpt' => $excerpt,
						'url' => get_permalink($post->ID),
						'image' => $image,
						'imageUrl' => $imageUrl
					));
				}
			}
		}

		//Add videos services names
		foreach($slider->entities as $entity) {
			if($entity && $entity->type == 'video') {
				$service = $this->getEnvironment()->getModule('Photos')->getController()->getServiceName($entity->url);
				$entity->attachment['service'] = $service;
			}
		}
		$attributes['slider'] = $slider;

		return parent::render($attributes);
    }
} 