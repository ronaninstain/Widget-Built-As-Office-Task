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
            'dropdown',
            [
                'label' => esc_html__('Styles', PE_PLUGIN_DOMAIN),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'Style1' => esc_html__('Style1', PE_PLUGIN_DOMAIN),
                    'Style2' => esc_html__('Style2', PE_PLUGIN_DOMAIN),
                ],
                'default' => 'Style1',
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

        $this->add_control(
            'timer',
            [
                'label' => esc_html__('Timer', PE_PLUGIN_DOMAIN),
                'type' => Controls_Manager::TEXT,
                'default' => '',
            ]
        );


        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();

        $course_ids = $settings['course_ids'];
        $styles = $settings['dropdown'];
        $quantity = $settings['quantity'];
        $timer = $settings['timer'];


?>

        <div class="row">

            <?php
            $course_ID = explode(",", $course_ids);
            $args = array(
                'post_type' => 'course',
                'post_status' => 'publish',
                'posts_per_page' => $quantity,
                'post__in' => $course_ID,
                'orderby'        => 'post__in'
            );

            $loop = new WP_Query($args);

            while ($loop->have_posts()) : $loop->the_post();

            ?>
                <div class="col-md-3">
                    <div class="course-cart1">

                        <div class="course-img">
                            <img src="<?php echo get_the_post_thumbnail_url(); ?>" alt="">
                            <div class="view-more-link">
                                <a href="<?php echo get_the_permalink(); ?>"><i class="fa fa-eye" aria-hidden="true"></i>View More</a>
                            </div>
                        </div>
                        <div class="course-content">
                            <h3 class="title"> <a href="<?php echo get_the_permalink(); ?>"><?php echo get_the_title(); ?></a></h3>
                            <div class="students">
                                <img src="https://www.oneeducation.org.uk/wp-content/uploads/2022/05/Group-10-2-1.png" alt="" class="img-icon">
                                <span><?php bp_course_count_students_pursuing(get_the_ID()); ?>4857</span>
                                <img src="https://www.oneeducation.org.uk/wp-content/uploads/2022/05/Star-Ratings.png" alt="" class="rating">
                                <div class="oneEduTimer">

                                    <?php if ($timer) {
                                    ?>
                                        <img src="<?php echo $timer; ?>" alt="timer" style="display: block;" />
                                    <?php
                                    }
                                    ?>
                                </div>
                                <div class="course-btn-div">
                                    <?php

                                    $product_id = get_post_meta(get_the_ID(), 'vibe_product', true);

                                    $currency_symble = get_woocommerce_currency_symbol();
                                    $price = get_post_meta($product_id, '_regular_price', true);
                                    $sale = get_post_meta($product_id, '_sale_price', true);

                                    if (!bp_is_my_profile()) {

                                        if (!empty($sale)) {
                                    ?>
                                            <div class="offer-bg">
                                                <img src="https://www.oneeducation.org.uk/wp-content/uploads/2022/05/Group-9547-1.png" alt="">
                                                <strong>
                                                    <del><span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol"><?php echo $currency_symble; ?></span><?php echo $price; ?></span></del>
                                                    <ins><span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol"><?php echo $currency_symble; ?></span><?php echo $sale; ?></span></ins>
                                                </strong>
                                            </div>
                                        <?php
                                        } elseif (empty($sale) && !empty($price)) {
                                        ?>
                                            <div class="offer-bg">
                                                <img src="https://www.oneeducation.org.uk/wp-content/uploads/2022/05/Group-9547-1.png" alt="">
                                                <strong>
                                                    <ins><span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol"><?php echo $currency_symble; ?></span><?php echo $price; ?></span></ins>
                                                </strong>
                                            </div>
                                        <?php
                                        } elseif (empty($sale) && empty($price)) {
                                        ?>
                                            <div class="offer-bg">
                                                <img src="https://www.oneeducation.org.uk/wp-content/uploads/2022/05/Group-9547-1.png" alt="">
                                                <strong>
                                                    <ins><span class="woocommerce-Price-amount amount">free</span></ins>
                                                </strong>
                                            </div>
                                        <?php
                                        }
                                        ?>
                                        <a class="view-details" href="<?php echo get_site_url();  ?>/cart/?add-to-cart=<?php echo $product_id; ?>">Add to Cart</a>
                                        <br>
                                        <!-- <a class="sa-more-info" href="<?php echo get_the_permalink(get_the_ID());  ?>">More Info</a> -->
                                    <?php

                                    } else {
                                        the_course_button(get_the_ID());
                                    }

                                    ?>
                                </div>
                            </div>
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

Plugin::instance()->widgets_manager->register_widget_type(new Latest_Posts_Widget());
