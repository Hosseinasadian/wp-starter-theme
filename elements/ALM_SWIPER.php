<?php

namespace ALMA\CORE;

class ALM_SWIPER extends \Elementor\Widget_Base
{
    protected $items;

    public function get_name()
    {
        return 'alm_swiper';
    }

    public function get_title()
    {
        return esc_html__('اسلایدر پایه ', 'alma');
    }

    public function get_icon()
    {
        return 'eicon-code';
    }

    public function get_categories()
    {
        return ['alma'];
    }

    public function get_keywords()
    {
        return ['alm', 'slider'];
    }

    public function get_script_depends()
    {
        return ["alma-el-init-swiper"];
    }

    public function get_style_depends()
    {
        return ['swiper'];
    }

    protected function slider_breakpoint_settings($settings)
    {
        $output = [
            'slidesPerView' => $settings['slides_per_view'] ?? 1,
            'spaceBetween' => $settings['space_between'] ?? 0,
            'loop' => $settings['loop_slider'] == 'yes',
        ];

        $output['navigation'] = [
            "nextEl" => '.swiper-button-next.swiper-button-next-' . $this->get_id(),
            "prevEl" => '.swiper-button-prev.swiper-button-prev-' . $this->get_id(),
            "enabled" => isset($settings['navigation']) && $settings['navigation'] == 'yes'
        ];

        $output['pagination'] = [
            "el" => ".swiper-pagination",
            'type' => $settings['pagination_type'],
            "enabled" => isset($settings['pagination']) && $settings['pagination'] == 'yes',
        ];


        if (is_rtl()) {
            $output['rtl'] = true;
        }

        return $output;
    }

    protected function slider_settings()
    {
        $slides_per_view = 'auto';
        if($this->get_settings_for_display('customize_slides_per_view') == 'yes'){
            $slides_per_view = $this->get_settings_for_display('slides_per_view');
        }
        $slider_settings = $this->slider_breakpoint_settings([
            'slides_per_view' => $slides_per_view,
            'space_between' => $this->get_settings_for_display('space_between'),
            'navigation' => $this->get_settings_for_display('navigation'),
            'pagination' => $this->get_settings_for_display('pagination'),
            'pagination_type' => $this->get_settings_for_display('pagination_type'),
            'loop_slider' => $this->get_settings_for_display('loop_slider'),
        ]);


        if ($breakpoints_settings = $this->get_settings_for_display('breakpoints')) {
            $breakpoints = [];
            foreach ($breakpoints_settings as $breakpoint) {
                if (isset($breakpoint['width'])) {
                    $slides_per_view = 'auto';
                    if($breakpoint['customize_slides_per_view'] == 'yes'){
                        $slides_per_view = $breakpoint['slides_per_view'];
                    }
                    $breakpoint['slides_per_view'] = $slides_per_view;
                    unset($breakpoint['customize_slides_per_view']);
                    $slider_breakpoint_settings = $this->slider_breakpoint_settings($breakpoint);
                    $breakpoints[$breakpoint['width']] = $slider_breakpoint_settings;
                }
            }
            $slider_settings['breakpoints'] = $breakpoints;
        }

        return $slider_settings;
    }

    protected function register_slider_setting_ontrols()
    {
        $this->start_controls_section(
            'slider_settings',
            [
                'label' => esc_html__('تنظیمات اسلایدر', 'alma'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'customize_slides_per_view',
            [
                'label' => esc_html__('تعداد اسلاید سفارشی سازی شود؟', 'alma'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('بله', 'alma'),
                'label_off' => esc_html__('خیر', 'alma'),
                'return_value' => 'yes',
                'default' => 'yes',
                'frontend_available' => true,
            ]
        );

        $this->add_control(
            'slides_per_view',
            [
                'label' => esc_html__('چند اسلاید نشان داده شود؟', 'alma'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 0,
                'step' => 1,
                'default' => 4,
                'frontend_available' => true,
                'condition' => [
                      'customize_slides_per_view'=>'yes'
                ]
            ],

        );

        $this->add_control(
            'space_between',
            [
                'label' => esc_html__('فاصله بین اسلایدها', 'alma'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 0,
                'step' => 1,
                'default' => 16,
                'frontend_available' => true,
            ]
        );

        $this->add_control(
            'navigation',
            [
                'label' => esc_html__('دکمه های پیمایش نشان داده شود؟', 'alma'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('بله', 'alma'),
                'label_off' => esc_html__('خیر', 'alma'),
                'return_value' => 'yes',
                'default' => 'yes',
                'frontend_available' => true,
            ]
        );

        $this->add_control(
            'pagination',
            [
                'label' => esc_html__('صفحه بندی نشان داده شود؟', 'alma'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('بله', 'alma'),
                'label_off' => esc_html__('خیر', 'alma'),
                'return_value' => 'yes',
                'default' => 'no',
                'frontend_available' => true,
            ]
        );

        $this->add_control(
            'pagination_type',
            [
                'label' => esc_html__('نوع صفحه بندی', 'alma'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'bullets',
                'options' => [
                    'bullets' => esc_html__('گلوله', 'alma'),
                    'progressbar' => esc_html__('نوار پیشرفت', 'alma'),
                ],
                'condition' => [
                    'pagination' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'loop_slider',
            [
                'label' => esc_html__('پیوسته تکرار شود؟', 'alma'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('بله', 'alma'),
                'label_off' => esc_html__('خیر', 'alma'),
                'return_value' => 'yes',
                'default' => 'no',
                'frontend_available' => true,
            ]
        );

        $breakpoints = new \Elementor\Repeater();
        $breakpoints->add_control('width', [
            'label' => esc_html__('عرض نقطه شکست', 'alma'),
            'type' => \Elementor\Controls_Manager::NUMBER,
            'default' => 1024,
        ]);
        $breakpoints->add_control(
            'customize_slides_per_view',
            [
                'label' => esc_html__('تعداد اسلاید سفارشی سازی شود؟', 'alma'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('بله', 'alma'),
                'label_off' => esc_html__('خیر', 'alma'),
                'return_value' => 'yes',
                'default' => 'yes',
                'frontend_available' => true,
            ]
        );
        $breakpoints->add_control('slides_per_view', [
            'label' => esc_html__('چند اسلاید نشان داده شود؟', 'alma'),
            'type' => \Elementor\Controls_Manager::NUMBER,
            'min' => 0,
            'step' => 1,
            'default' => 4,
            'frontend_available' => true,
            'condition' => [
                'customize_slides_per_view'=>'yes'
            ]
        ]);
        $breakpoints->add_control('space_between', [
            'label' => esc_html__('فاصله بین اسلایدها', 'alma'),
            'type' => \Elementor\Controls_Manager::NUMBER,
            'min' => 0,
            'step' => 1,
            'default' => 16,
            'frontend_available' => true,
        ]);
        $breakpoints->add_control('navigation', [
            'name' => 'navigation',
            'label' => esc_html__('دکمه های پیمایش نشان داده شود؟', 'alma'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'label_on' => esc_html__('بله', 'alma'),
            'label_off' => esc_html__('خیر', 'alma'),
            'return_value' => 'yes',
            'default' => 'yes',
            'frontend_available' => true,
        ]);
        $breakpoints->add_control('pagination', [
            'label' => esc_html__('صفحه بندی نشان داده شود؟', 'alma'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'label_on' => esc_html__('بله', 'alma'),
            'label_off' => esc_html__('خیر', 'alma'),
            'return_value' => 'yes',
            'default' => 'no',
            'frontend_available' => true,
        ]);
        $breakpoints->add_control('pagination_type', [
            'label' => esc_html__('نوع صفحه بندی', 'alma'),
            'type' => \Elementor\Controls_Manager::SELECT,
            'default' => 'bullets',
            'options' => [
                'bullets' => esc_html__('گلوله', 'alma'),
                'progressbar' => esc_html__('نوار پیشرفت', 'alma'),
            ],
            'condition' => [
                'pagination' => 'yes'
            ]
        ]);
        $breakpoints->add_control('loop_slider', [
            'label' => esc_html__('پیوسته تکرار شود؟', 'alma'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'label_on' => esc_html__('بله', 'alma'),
            'label_off' => esc_html__('خیر', 'alma'),
            'return_value' => 'yes',
            'default' => 'no',
            'frontend_available' => true,
        ]);

        $this->add_control('breakpoints', [
            'label' => esc_html__('نقاط شکست', 'alma'),
            'type' => \Elementor\Controls_Manager::REPEATER,
            'fields' => $breakpoints->get_controls(),
            'prevent_empty' => false,
        ]);

        $this->end_controls_section();
    }

    protected function register_slider_style_controls()
    {
        $this->start_controls_section(
            'slider_style',
            [
                'label' => esc_html__('تنطیمات اسلایدر', 'alma'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'slider_wrapper_padding',
            [
                'label' => esc_html__('فاصله داخلی اسلایدر', 'alma'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .slider-wrapper.alm-visible-navigation' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'slider_wrapper_margin',
            [
                'label' => esc_html__('حاشیه خارجی اسلایدر', 'alma'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .slider-wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

		$this->add_responsive_control(
            'slider_slides_padding',
            [
                'label' => esc_html__('فاصله داخلی اسلایدها', 'alma'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .slider-wrapper .swiper-slide' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'slider_navigation_style',
            [
                'label' => esc_html__('پیمایش اسلایدر', 'alma'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'navigation_size',
            [
                'label' => esc_html__('اندازه', 'alma'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem'],
                'default' => [
                    'unit' => 'px',
                    'size' => 18,
                ],
                'selectors' => [
                    '{{WRAPPER}} .swiper-button-next::after' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .swiper-button-prev::after' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'navigation_text_color',
            [
                'label' => esc_html__('رنگ', 'alma'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .swiper-button-next::after' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .swiper-button-prev::after' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'navigation_text_hover_color',
            [
                'label' => esc_html__('رنگ هاور', 'alma'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .swiper-button-next:hover::after' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .swiper-button-prev:hover::after' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'navigation_space',
            [
                'label' => esc_html__('فاصله افقی از کناره ها', 'alma'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'default' => [
                    'unit' => 'px',
                    'size' => 0,
                ],
                'selectors' => [
                    '{{WRAPPER}} .swiper-button-next' => 'right: {{SIZE}}{{UNIT}};left: auto;margin:0;',
                    '{{WRAPPER}} .swiper-rtl .swiper-button-prev' => 'right: {{SIZE}}{{UNIT}};left: auto',
                    '{{WRAPPER}} .swiper-button-prev' => 'left: {{SIZE}}{{UNIT}};right: auto;margin:0;',
                    '{{WRAPPER}} .swiper-rtl .swiper-button-next' => 'left: {{SIZE}}{{UNIT}};right: auto',
                ],
            ]
        );

        $this->add_control(
            'nav_vertical_align',
            [
                'label' => esc_html__('مبنای عمودی', 'alma'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'top',
                'options' => [
                    'top' => esc_html__('بالا', 'alma'),
                    'bottom' => esc_html__('پایین', 'alma'),
                ],
            ]
        );
        $this->add_control(
            'nav_top_position',
            [
                'label' => esc_html__('فاصله از بالا', 'alma'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'default' => [
                    'unit' => '%',
                    'size' => 50,
                ],
                'selectors' => [
                    '{{WRAPPER}} .swiper-button-next, {{WRAPPER}} .swiper-button-prev' => 'top: {{SIZE}}{{UNIT}};bottom:auto;transform: translateY(-50%);',
                ],
                'condition' => [
                    'nav_vertical_align' => 'top',
                ]
            ]
        );
        $this->add_control(
            'nav_bottom_position',
            [
                'label' => esc_html__('فاصله از پایین', 'alma'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'default' => [
                    'unit' => '%',
                    'size' => 50,
                ],
                'selectors' => [
                    '{{WRAPPER}} .swiper-button-next, {{WRAPPER}} .swiper-button-prev' => 'bottom: {{SIZE}}{{UNIT}};top:auto;transform: translateY(50%);',
                ],
                'condition' => [
                    'nav_vertical_align' => 'bottom',
                ]
            ]
        );

        $this->add_control(
            'navigation_bg_image',
            [
                'label' => esc_html__('منحنی روی نوار پیمایش', 'alma'),
                'type' => \Elementor\Controls_Manager::ICONS,
            ]
        );
        $this->add_control('navigation_bg_image_opacity',
            [
                'label' => esc_html__('شفاقیت منحنی روی نوار پیمایش', 'alma'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['%'],
                'range' => [
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => '%',
                    'size' => 100,
                ],
                'selectors' => [
                    '{{WRAPPER}} .swiper-button-next svg,{{WRAPPER}} .swiper-button-prev svg' => 'opacity: {{SIZE}}{{UNIT}}'
                ]
            ]);
        $this->add_control(
            'navigation_width',
            [
                'label' => esc_html__('عرض', 'alma'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .swiper-button-next svg' => 'position:absolute;top:0;left:0;width:100%;height:100%;z-index:-1;',
                    '{{WRAPPER}} .swiper-button-prev svg' => 'position:absolute;top:0;left:0;width:100%;height:100%;z-index:-1;',
                    '{{WRAPPER}} .swiper-button-next' => 'width: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .swiper-button-prev' => 'width: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .swiper-button-next svg,{{WRAPPER}} .swiper-rtl .swiper-button-prev svg' => 'transform:rotateY(180deg);',
                    '{{WRAPPER}} .swiper-button-prev svg,{{WRAPPER}} .swiper-rtl .swiper-button-next svg' => 'transform:none;',
                ],
            ]
        );
        $this->add_control(
            'navigation_height',
            [
                'label' => esc_html__('ارتفاع', 'alma'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .swiper-button-next' => 'height: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .swiper-button-prev' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
		$this->add_control(
			'nav_next_bg_heading',
			[
				'label' => esc_html__('پس زمینه دکمه بعدی', 'alma'),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
				'name'=>'nav_next_bg',
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .swiper-button-next::after',
            ]
        );
		$this->add_control(
			'nav_prev_bg_heading',
			[
				'label' => esc_html__('پس زمینه دکمه قبلی', 'alma'),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
				'name'=>'nav_prev_bg',
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .swiper-button-prev::after',
            ]
        );
		$this->add_control(
			'nav_next_bg_hover_heading',
			[
				'label' => esc_html__('پس زمینه هاور دکمه بعدی', 'alma'),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
				'name'=>'nav_next_bg_hover',
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .swiper-button-next:hover::after',
            ]
        );
		$this->add_control(
			'nav_prev_bg_hover_heading',
			[
				'label' => esc_html__('پس زمینه هاور دکمه قبلی', 'alma'),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
				'name'=>'nav_prev_bg_hover',
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .swiper-button-prev:hover::after',
            ]
        );

        $this->add_control(
            'nav_nex_padding',
            [
                'label' => esc_html__('فاصله داخلی دکمه بعدی', 'alma'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .swiper-button-next::after' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'nav_prev_padding',
            [
                'label' => esc_html__('فاصله داخلی دکمه قبلی', 'alma'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .swiper-button-prev::after' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'border',
                'selector' => '{{WRAPPER}} .swiper-button-next::after, {{WRAPPER}} .swiper-button-prev::after',
            ]
        );

        $this->add_control(
            'nav_radius',
            [
                'label' => esc_html__('شعاع دکمه های پیمایش', 'alma'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .swiper-button-next::after' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .swiper-button-prev::after' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'hide_next_button',
            [
                'label' => esc_html__('دکمه بعدی رو مخفی کن', 'alma'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_off' => esc_html__('خیر', 'alma'),
                'label_on' => esc_html__('بله', 'alma'),
                'return_value' => 'yes',
                'default' => 'no',
                'frontend_available' => true,
            ]
        );
        $this->add_control(
            'hide_prev_button',
            [
                'label' => esc_html__('دکمه قبلی رو مخفی کن', 'alma'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_off' => esc_html__('Show', 'alma'),
                'label_on' => esc_html__('Hide', 'alma'),
                'return_value' => 'yes',
                'default' => 'no',
                'frontend_available' => true,
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'slider_pagination_style',
            [
                'label' => esc_html__('صفحه بندی اسلایدر', 'alma'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'pagination_progressbar',
            [
                'label' => esc_html__('نوار پیشرفت', 'alma'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $this->add_control(
            'pagination_progressbar_vertical_align',
            [
                'label' => esc_html__('جایگاه', 'alma'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'top',
                'options' => [
                    'top' => esc_html__('بالا', 'alma'),
                    'bottom' => esc_html__('پایین', 'alma'),
                ],
            ]
        );
        $this->add_control(
            'pagination_progressbar_bottom_offset',
            [
                'label' => esc_html__('فاصله از پایین', 'alma'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em', 'rem'],
                'default' => [
                    'unit' => 'px',
                    'size' => 0,
                ],
                'selectors' => [
                    '{{WRAPPER}} .swiper-horizontal>.swiper-pagination-progressbar,{{WRAPPER}} .swiper-pagination-progressbar.swiper-pagination-horizontal,{{WRAPPER}} .swiper-pagination-progressbar.swiper-pagination-vertical.swiper-pagination-progressbar-opposite,{{WRAPPER}} .swiper-vertical>.swiper-pagination-progressbar.swiper-pagination-progressbar-opposite' => 'bottom: {{SIZE}}{{UNIT}};top:auto;',
                ],
                'condition' => [
                    'pagination_progressbar_vertical_align' => 'bottom',
                ],
            ]
        );
        $this->add_control(
            'pagination_progressbar_top_offset',
            [
                'label' => esc_html__('فاصله از بالا', 'alma'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em', 'rem'],
                'default' => [
                    'unit' => 'px',
                    'size' => 0,
                ],
                'selectors' => [
                    '{{WRAPPER}} .swiper-horizontal>.swiper-pagination-progressbar,{{WRAPPER}} .swiper-pagination-progressbar.swiper-pagination-horizontal,{{WRAPPER}} .swiper-pagination-progressbar.swiper-pagination-vertical.swiper-pagination-progressbar-opposite,{{WRAPPER}} .swiper-vertical>.swiper-pagination-progressbar.swiper-pagination-progressbar-opposite' => 'top: {{SIZE}}{{UNIT}};bottom:auto;',
                ],
                'condition' => [
                    'pagination_progressbar_vertical_align' => 'top',
                ],
            ]
        );
        $this->add_control(
            'pagination_progressbar_horizontal_offset',
            [
                'label' => esc_html__('فاصله افقی', 'alma'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em', 'rem'],
                'default' => [
                    'unit' => 'px',
                    'size' => 0,
                ],
                'selectors' => [
                    '{{WRAPPER}} .swiper-horizontal>.swiper-pagination-progressbar,{{WRAPPER}} .swiper-pagination-progressbar.swiper-pagination-horizontal,{{WRAPPER}} .swiper-pagination-progressbar.swiper-pagination-vertical.swiper-pagination-progressbar-opposite,{{WRAPPER}} .swiper-vertical>.swiper-pagination-progressbar.swiper-pagination-progressbar-opposite' => 'left: {{SIZE}}{{UNIT}};right: {{SIZE}}{{UNIT}};width:auto;',
                ],
            ]
        );
        $this->add_control(
            'pagination_progressbar_bg_color',
            [
                'label' => esc_html__('پس زمینه', 'alma'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .swiper-pagination-progressbar' => 'background:{{VALUE}}'
                ]
            ]
        );
        $this->add_control(
            'pagination_progressbar_fill_color',
            [
                'label' => esc_html__('رنگ بخش تکمیل شده نوار پیشرفت', 'alma'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .swiper-pagination-progressbar .swiper-pagination-progressbar-fill' => 'background:{{VALUE}}'
                ]
            ]
        );
        $this->add_control(
            'pagination_bullets',
            [
                'label' => esc_html__('گلوله ها', 'alma'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

		$this->add_control(
            'pagination_vertical_align',
            [
                'label' => esc_html__('جایگاه', 'alma'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'top',
                'options' => [
                    'top' => esc_html__('بالا', 'alma'),
                    'bottom' => esc_html__('پایین', 'alma'),
                ],
            ]
        );
        $this->add_control(
            'pagination_bottom_offset',
            [
                'label' => esc_html__('فاصله از پایین', 'alma'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em', 'rem'],
                'default' => [
                    'unit' => 'px',
                    'size' => 0,
                ],
                'selectors' => [
                    '{{WRAPPER}} .swiper-pagination' => 'bottom: {{SIZE}}{{UNIT}};top:auto;',
                ],
                'condition' => [
                    'pagination_vertical_align' => 'bottom',
                ],
            ]
        );
        $this->add_control(
            'pagination_top_offset',
            [
                'label' => esc_html__('فاصله از بالا', 'alma'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em', 'rem'],
                'default' => [
                    'unit' => 'px',
                    'size' => 0,
                ],
                'selectors' => [
                    '{{WRAPPER}} .swiper-pagination' => 'top: {{SIZE}}{{UNIT}};bottom:auto;',
                ],
                'condition' => [
                    'pagination_vertical_align' => 'top',
                ],
            ]
        );

        $this->add_control(
            'pagination_horizontal_offset',
            [
                'label' => esc_html__('فاصله افقی', 'alma'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em', 'rem'],
                'default' => [
                    'unit' => 'px',
                    'size' => 0,
                ],
                'selectors' => [
                    '{{WRAPPER}} .swiper-pagination' => 'left: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

		$this->add_control(
			'pagination_translate_popover_toggle',
			[
				'label' => esc_html__( 'انحراف محور', 'alma' ),
				'type' => \Elementor\Controls_Manager::POPOVER_TOGGLE,
				'label_off' => esc_html__( 'Default', 'textdomain' ),
				'label_on' => esc_html__( 'Custom', 'textdomain' ),
				'return_value' => 'yes',
			]
		);

		$this->start_popover();

		$this->add_control(
			'pagination_translatex',
			[
				'label' => esc_html__( 'محور X', 'alma' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'default' => [
					'unit' => 'px',
					'size' => 0,
				],
			]
		);
		$this->add_control(
			'pagination_translatey',
			[
				'label' => esc_html__( 'محور Y', 'alma' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'default' => [
					'unit' => 'px',
					'size' => 0,
				],
			]
		);
		$this->add_control(
			'pagination_translatez',
			[
				'label' => esc_html__( 'محور Z', 'alma' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'default' => [
					'unit' => 'px',
					'size' => 0,
				],
			]
		);

		$this->end_popover();

        $this->add_control(
            'pagination_bullets_size',
            [
                'label' => esc_html__('اندازه', 'alma'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem'],
                'default' => [
                    'unit' => 'px',
                    'size' => 6,
                ],
                'selectors' => [
                    '{{WRAPPER}} .swiper-pagination-bullet' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
                ],

            ]
        );
        $this->add_control(
            'pagination_bullets_radius',
            [
                'label' => esc_html__('شعاع', 'alma'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em', 'rem'],
                'default' => [
                    'unit' => '%',
                    'size' => 50,
                ],
                'selectors' => [
                    '{{WRAPPER}} .swiper-pagination-bullet' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],

            ]
        );
		$this->add_responsive_control(
            'pagination_bullets_margin',
            [
                'label' => esc_html__('حاشیه خارجی', 'alma-core'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .swiper-pagination-bullet' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'pagination_bullets_bg_color',
            [
                'label' => esc_html__('رنگ', 'alma'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .swiper-pagination-bullet' => 'background: {{Value}};',
                ],

            ]
        );
        $this->add_control(
            'pagination_bullets_active_width',
            [
                'label' => esc_html__('عرض گلوله در حالت فعال', 'alma'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} .swiper-pagination-bullet-active' => 'width: {{SIZE}}{{UNIT}};',
                ],

            ]
        );

        $this->end_controls_section();
    }

    protected function register_controls()
    {
        $this->register_slider_setting_ontrols();

        $this->register_slider_style_controls();
    }

    protected function render_slides()
    {
        for ($i = 0; $i < 100; $i++) {
            ?>
            <div class="swiper-slide">
                <?php echo $i ?>
            </div>
            <?php
        }
    }

    public function set_items($items)
    {
        $this->items = $items;
    }

	protected function before_swiper(){

	}
	protected function after_swiper(){

	}

	protected function transform_settings($settings){
		return $settings;
	}

    protected function render()
    {
        $slider_settings = $this->slider_settings();
		$slider_settings = $this->transform_settings($slider_settings);
//        $slider_settings['wrapperClass'] = 'swiper-clip';
        $navigation_bg_image = $this->get_settings_for_display('navigation_bg_image') ?? null;
		$hide_style = "style='display:none;'";

		$pagination_translatex = $this->get_settings_for_display('pagination_translatex');
		$pagination_translatey = $this->get_settings_for_display('pagination_translatey');
		$pagination_translatez = $this->get_settings_for_display('pagination_translatez');

		$inline_style = "transform: translate3d({$pagination_translatex['size']}{$pagination_translatex['unit']}, {$pagination_translatey['size']}{$pagination_translatey['unit']}, {$pagination_translatez['size']}{$pagination_translatez['unit']})";


        ?>
        <div class="slider-wrapper" style="height:100%">
			<?php $this->before_swiper();?>
            <div class="swiper" data-settings='<?php echo json_encode($slider_settings) ?>'>
                <div class="swiper-wrapper">
                    <?php $this->render_slides(); ?>
                </div>
                <div class="swiper-pagination" style="<?php echo $inline_style;?>"></div>
				<div class="swiper-button-prev swiper-button-prev-<?php echo $this->get_id()?>" <?php echo ($this->get_settings_for_display('hide_prev_button')) == 'yes' ? $hide_style : '' ?>>
					<?php if (isset($navigation_bg_image)) \Elementor\Icons_Manager::render_icon($navigation_bg_image, ['class' => 'nav_bg']); ?>
				</div>
				<div class="swiper-button-next swiper-button-next-<?php echo $this->get_id()?>" <?php echo ($this->get_settings_for_display('hide_next_button')) == 'yes' ? $hide_style : '' ?>>
					<?php if (isset($navigation_bg_image)) \Elementor\Icons_Manager::render_icon($navigation_bg_image, ['class' => 'nav_bg']); ?>
				</div>
            </div>
			<?php $this->after_swiper();?>
        </div>

        <?php
    }

}
