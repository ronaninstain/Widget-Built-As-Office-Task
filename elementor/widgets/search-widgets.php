<?php

use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;
use Elementor\Plugin;
use Elementor\Widget_Base;

if (!defined('ABSPATH')) {
    // Exit if accessed directly.
    exit;
}

class Search_widget extends Widget_Base
{

    /**
     * Get the widget's name.
     *
     * @return string
     */
    public function get_name(): string
    {
        return 'pe-searchs';
    }

    /**
     * Get the widget's title.
     *
     * @return string
     */
    public function get_title(): string
    {
        return esc_html__('PE Searchs', PE_PLUGIN_DOMAIN);
    }

    /**
     * Get the widget's icon.
     *
     * @return string
     */
    public function get_icon(): string
    {
        return 'fa fa-search';
    }

    /**
     * Add the widget to a category.
     * Previously setup in the class-widgets.php file.
     *
     * @return string[]
     */
    public function get_categories(): array
    {
        return ['pe-category'];
    }

    protected function _register_controls()
    {
        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__('Dynamic Search', PE_PLUGIN_DOMAIN),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'dropdown',
            [
                'label' => esc_html__('Styles', PE_PLUGIN_DOMAIN),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'Style1' => esc_html__('Style1', PE_PLUGIN_DOMAIN),
                    'Style2' => esc_html__('Style2', PE_PLUGIN_DOMAIN),
                    'Style3' => esc_html__('Style3', PE_PLUGIN_DOMAIN),
                    'Style4' => esc_html__('Style4', PE_PLUGIN_DOMAIN),
                    'Style5' => esc_html__('Style5', PE_PLUGIN_DOMAIN),
                    'Style6' => esc_html__('Style6', PE_PLUGIN_DOMAIN),
                    'Style6' => esc_html__('Style7', PE_PLUGIN_DOMAIN),
                ],
                'default' => 'Style1',
            ]
        );


        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();

        $course_ids = $settings['course_ids'];
        $quantity = $settings['quantity'];
        $student = $settings['show_students'];
        $list = $settings['list'];
        $button = $settings['show_button'];
        $style = $settings['dropdown'];



?>
        <div class="all-search-styles">
            <div class="search-style-1">
                <?php
                if ($style == 'Style1') {
                ?>
                    <div class="style-1">
                        <div class="topnav">
                            <a class="active" href="#home">Home</a>
                            <a href="#about">About</a>
                            <a href="#contact">Contact</a>
                            <input type="text" placeholder="Search..">
                        </div>
                    </div>
                <?php } ?>
            </div>
            <div class="search-style-2">
                <?php
                if ($style == 'Style2') {
                ?>
                    <div class="style-2">
                        <div class="search-box">
                            <button class="btn-search"><i class="fa fa-search"></i></button>
                            <input type="text" class="input-search" placeholder="Type to Search...">
                        </div>
                    </div>
                <?php } ?>
            </div>
            <div class="search-style-3">
                <?php
                if ($style == 'Style3') {
                ?>
                    <div class="style-3">
                        <div class="box">
                            <form name="search">
                                <input type="text" class="input" name="txt" onmouseout="this.value = ''; this.blur();">
                            </form>
                            <i class="fa fa-search"></i>

                        </div>
                    </div>
                <?php } ?>
            </div>
            <div class="search-style-4">
                <?php
                if ($style == 'Style4') {
                ?>
                    <div class="style-4">
                        <div id="wrap">
                            <form action="" autocomplete="on">
                                <input id="search" name="search" type="text" placeholder="What're we looking for ?"><input id="search_submit" value="Rechercher" type="submit">
                            </form>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <div class="search-style-5">
                <?php
                if ($style == 'Style5') {
                ?>
                    <div class="style-5">
                        <form class="search-form">
                            <input type="text" placeholder="Search for books, authors, categories and more..">
                            <input type="submit" value="Submit">
                        </form>
                    </div>
                <?php } ?>
            </div>
            <div class="search-style-6">
                <?php
                if ($style == 'Style6') {
                ?>
                    <div class="style-6">
                        <div class="search-section">
                            <div class="search-box">
                                <div class="search-input">
                                    <input type="search" placeholder="Search..." class="input-textarea">
                                    <span><i data-feather="search" class="search-icon"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <div class="search-style-7">
                <?php
                if ($style == 'Style7') {
                ?>
                    <div class="style-7">
                        <div class="search-section">
                            <div class="searchBox">

                                <input class="searchInput" type="text" name="" placeholder="Search">
                                <button class="searchButton" href="#">
                                    <i class="material-icons">
                                        search
                                    </i>
                                </button>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
<?php

    }
}

Plugin::instance()->widgets_manager->register_widget_type(new Search_widget());
