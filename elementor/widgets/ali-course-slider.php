<?php

use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;
use Elementor\Plugin;
use Elementor\Widget_Base;

if (!defined('ABSPATH')) {
    // Exit if accessed directly.
    exit;
}

class ali_course_slider extends Widget_Base
{

    /**
     * Get the widget's name.
     *
     * @return string
     */
    public function get_name(): string
    {
        return 'ali_course_slider';
    }

    /**
     * Get the widget's title.
     *
     * @return string
     */
    public function get_title(): string
    {
        return esc_html__('ali course slider', PE_PLUGIN_DOMAIN);
    }

    /**
     * Get the widget's icon.
     *
     * @return string
     */
    public function get_icon(): string
    {
        return 'fa fa-sliders';
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
                'label' => esc_html__('Dynamic Course Assign', PE_PLUGIN_DOMAIN),
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
            'quantity',
            [
                'label' => esc_html__('Quantity', PE_PLUGIN_DOMAIN),
                'type' => Controls_Manager::NUMBER,
                'default' => '3',
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();

        $course_ids = $settings['course_ids'];
        $quantity = $settings['quantity'];



?>
        <div class="owl-carousel owl-theme owl-ali">
            <?php
            $course_ID = explode(",", $course_ids);
            $args = array(
                'post_type' => 'course',
                'post_status' => 'publish',
                'posts_per_page' =>  $quantity,
                'post__in' => $course_ID,
                'orderby'        => 'post__in'
            );

            $loop = new WP_Query($args);

            while ($loop->have_posts()) : $loop->the_post();
            ?>
                <div class="single-card-ali">
                    <div class="before-hover">
                        <?php bp_course_avatar(); ?>
                        <div class="card-cats">
                            <?php

                            $terms = get_the_terms(get_the_ID(), 'course-tag');

                            // var_dump($terms);
                            $x = 0;
                            if (!empty($terms) && !is_wp_error($terms)) {
                                echo '<ul class="">';
                                foreach ($terms as $term) {
                                    if ($x < 2) {
                                        $term_link = get_term_link($term);
                                        echo '<li><a href="' . esc_url($term_link) . '">' . $term->name . '</a></li>';
                                        $x++;
                                    } else {
                                        break;
                                    }
                                }
                                echo '</ul>';
                            }
                            ?>
                        </div>
                        <div class="card-title">
                            <h5><?php echo get_the_title(); ?></h5>
                        </div>
                        <div class="card-btn">
                            <a href="#">Enrol Now</a>
                        </div>
                    </div>
                    <div class="hover-card-content">
                        <div class="card-socials">
                            <a href="https://www.facebook.com/sharer/sharer.php?u=<?php the_permalink(); ?>" target="_blank"><i class="fa fa-facebook-f"></i></a>
                            <a href="https://www.instagram.com/share?url=<?php the_permalink(); ?>" target="_blank"><i class="fa fa-instagram"></i></a>
                            <a href="https://twitter.com/intent/tweet?text=<?php the_title(); ?>&url=<?php the_permalink(); ?>" target="_blank"><i class="fa fa-twitter"></i>
                                </i></a>
                        </div>
                        <div class="card-hover-title">
                            <h5><?php echo get_the_title(); ?></h5>
                        </div>
                        <?php $author_id = get_the_author_meta('ID');
                        $author_name = get_the_author_meta('display_name', $author_id);
                        $author_link = get_author_posts_url($author_id);
                        ?>
                        <div class="card-author">
                            <i class="fa fa-university" aria-hidden="true"></i>
                            <h6><?php echo '<a href="' . $author_link . '">' . $author_name . '</a>'; ?></h6>
                        </div>
                        <div class="card-short-des">
                            <p><?php echo the_excerpt() ?></p>
                        </div>
                        <div class="hover-card-btn">
                            <!-- <a href="#">More Informantion <i class="fa fa-question-circle-o" aria-hidden="true"></i></a> -->
                            <div class="hoverd-side-info-btn"><a href="<?php echo get_the_permalink(); ?>">More Informantion <i class="fa fa-question-circle-o" aria-hidden="true"></i></a></div>
                            <div class="hoverd-side-start-btn"><a href="#"><?php the_course_button(); ?></a></div>
                        </div>
                    </div>
                </div>

            <?php
            endwhile;
            wp_reset_postdata();

            ?>
        </div>

<?php

    }
}

Plugin::instance()->widgets_manager->register_widget_type(new ali_course_slider());
