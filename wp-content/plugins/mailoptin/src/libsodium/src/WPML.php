<?php

namespace MailOptin\Libsodium;


use MailOptin\Core\Admin\Customizer\CustomControls\WP_Customize_Chosen_Select_Control;
use MailOptin\Core\Admin\Customizer\OptinForm\Customizer;
use MailOptin\Core\Admin\Customizer\OptinForm\CustomizerSettings;
use MailOptin\Core\Repositories\OptinCampaignsRepository;

class WPML
{
    public $customizer_section_id = 'mo_wp_wpml_display_rule_section';

    public function __construct()
    {
        add_action('wpml_loaded', function () {
            add_filter('mo_optin_customizer_sections_ids', [$this, 'active_sections'], 10, 2);
            add_action('mo_optin_after_page_user_targeting_display_rule_section', array($this, 'section'), 10, 2);

            add_filter('mo_optin_form_customizer_output_settings', [$this, 'settings'], 10, 2);
            add_action('mo_optin_after_customizer_controls', array($this, 'controls'), 10, 4);

            add_filter('mailoptin_show_optin_form', [$this, 'display_rule'], 10, 2);
        });
    }

    public function display_rule($status, $optin_campaign_id)
    {
        $languages = OptinCampaignsRepository::get_customizer_value($optin_campaign_id, 'wpml_active_languages');

        if ( ! empty($languages) && is_array($languages)) {
            $status = false;

            if (in_array(wpml_get_current_language(), $languages)) {
                $status = true;
            }
        }

        return $status;
    }

    /**
     * @param \WP_Customize_Manager $wp_customize
     * @param Customizer $customizerClassInstance
     */
    public function section($wp_customize, $customizerClassInstance)
    {
        $wp_customize->add_section($this->customizer_section_id, array(
                'title' => __("WPML Targeting", 'mailoptin'),
                'panel' => $customizerClassInstance->display_rules_panel_id
            )
        );
    }

    public function active_sections($sections)
    {
        $sections[] = $this->customizer_section_id;

        return $sections;
    }

    /**
     * @param $settings
     * @param CustomizerSettings $customizerSettings
     *
     * @return mixed
     */
    public function settings($settings, $customizerSettings)
    {
        $settings['wpml_active_languages'] = array(
            'default'   => '',
            'type'      => 'option',
            'transport' => 'postMessage',
        );

        return $settings;
    }

    /**
     * Click Launch display rule.
     *
     * @param \WP_Customize_Manager $wp_customize
     * @param string $option_prefix
     * @param Customizer $customizerClassInstance
     */
    public function controls($instance, $wp_customize, $option_prefix, $customizerClassInstance)
    {
        $choices = array_reduce(apply_filters('wpml_active_languages', null, 'orderby=id&order=desc'), function ($carry, $item) {
            $carry[$item['code']] = $item['native_name'];

            return $carry;
        }, []);

        $device_targeting_control_args = apply_filters(
            "mo_optin_form_customizer_wpml_controls",
            array(
                'wpml_active_languages' => new WP_Customize_Chosen_Select_Control(
                    $wp_customize,
                    $option_prefix . '[wpml_active_languages]',
                    apply_filters('mo_optin_form_customizer_wpml_active_languages_args', array(
                            'label'       => __('Show only on:', 'mailoptin'),
                            'section'     => $this->customizer_section_id,
                            'settings'    => $option_prefix . '[wpml_active_languages]',
                            'description' => __('Select site languages that will show this optin.', 'mailoptin'),
                            'choices'     => $choices,
                            'priority'    => 10
                        )
                    )
                )
            ),
            $wp_customize,
            $option_prefix,
            $customizerClassInstance
        );

        foreach ($device_targeting_control_args as $id => $args) {
            if (is_object($args)) {
                $wp_customize->add_control($args);
            } else {
                $wp_customize->add_control($option_prefix . '[' . $id . ']', $args);
            }
        }
    }

    /**
     * Singleton poop.
     *
     * @return self
     */
    public static function get_instance()
    {
        static $instance = null;

        if (is_null($instance)) {
            $instance = new self();
        }

        return $instance;
    }
}