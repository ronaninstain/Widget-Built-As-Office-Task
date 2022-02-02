<?php

use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;
use Elementor\Plugin;
use Elementor\Widget_Base;

if (!defined('ABSPATH')) {
    // Exit if accessed directly.
    exit;
}

class Latest_Posts_Widget extends Widget_Base
{

    /**
     * Get the widget's name.
     *
     * @return string
     */
    public function get_name(): string
    {
        return 'pe-latest-posts';
    }

    /**
     * Get the widget's title.
     *
     * @return string
     */
    public function get_title(): string
    {
        return esc_html__('PE Latest Posts', PE_PLUGIN_DOMAIN);
    }

    /**
     * Get the widget's icon.
     *
     * @return string
     */
    public function get_icon(): string
    {
        return 'fa fa-clipboard';
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
                'label' => esc_html__('Latest Posts', PE_PLUGIN_DOMAIN),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );


        $this->add_control(
            'course_ids',
            [
                'label' => esc_html__('Course ID\'s', PE_PLUGIN_DOMAIN),
                'type' => Controls_Manager::TEXT,
            ]
        );


        $this->add_control(
            'show_author',
            [
                'label' => esc_html__('Show Author', PE_PLUGIN_DOMAIN),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', PE_PLUGIN_DOMAIN),
                'label_off' => esc_html__('Hide', PE_PLUGIN_DOMAIN),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'show_ratings',
            [
                'label' => esc_html__('Show Ratings', PE_PLUGIN_DOMAIN),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', PE_PLUGIN_DOMAIN),
                'label_off' => esc_html__('Hide', PE_PLUGIN_DOMAIN),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );


        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();

        $show_ratings = $settings['show_ratings'];
        $show_author = $settings['show_author'];
        $course_ids = $settings['course_ids'];

        $id = explode(",", $course_ids);
        $args = array(
            'post__in' => $id,
            'post_type' => 'course',
        );


?>

        <div class="row">

            <?php
            $loop = new WP_Query($args);
            while ($loop->have_posts()) : $loop->the_post();
            ?>
                <div class="col-md-4">
                    <div class="feature-course-item-2">
                        <a class="c-cate" href="#"><?php the_title(); ?></a>
                        <h4 class="title"><a href="#"> <?php the_title(); ?> </a></h4>
                        <div class="fcf-bottom">
                            <a class="bisy-lesson" href="#"><i class="fa fa-book"></i> 20 Lessons</a>
                            <a class="bisy-students" href="#"><i class="fa fa-user"></i> 4 </a>
                        </div>
                        <div class="fcf-thumb">
                            <img src="https://wp.quomodosoft.com/bisy/wp-content/uploads/2020/11/h2_course_image.svg" alt="Using Creative Problem Solving Ideas.">
                        </div>
                        <div class="hover-course">
                            <div class="course-price">
                                $80.00
                                <span> $120.00 </span>
                            </div>
                            <?php
                            if (!empty($show_author)) {
                            ?>
                                <div class="author">
                                    <img src="https://secure.gravatar.com/avatar/e1ad28c7da63a709b0621fc230dd6797?s=96&amp;d=mm&amp;r=g">
                                    <a href="#"><span>Dianne Ameter</span></a>
                                </div>
                            <?php
                            }
                            ?>

                            <?php
                            if (!empty($show_ratings)) {
                            ?>
                                <div class="ratings">
                                    <i class="fa fa-star-o"></i>
                                    <i class="fa fa-star-o"></i>
                                    <i class="fa fa-star-o"></i>
                                    <i class="fa fa-star-o"></i>
                                    <i class="fa fa-star-o"></i>
                                    <span>0 (0 Reviews)</span>
                                </div>
                            <?php
                            }
                            ?>

                        </div>
                    </div>
                </div>

            <?php
            endwhile;

            ?>


        </div>

<?php

    }
}

Plugin::instance()->widgets_manager->register_widget_type(new Latest_Posts_Widget());
