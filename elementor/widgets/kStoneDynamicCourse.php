<?php

use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;
use Elementor\Plugin;
use Elementor\Widget_Base;

if (!defined('ABSPATH')) {
    // Exit if accessed directly.
    exit;
}

class kStone_Dynamic_Course extends Widget_Base
{

    /**
     * Get the widget's name.
     *
     * @return string
     */
    public function get_name(): string
    {
        return 'kStone_Dynamic_Course';
    }

    /**
     * Get the widget's title.
     *
     * @return string
     */
    public function get_title(): string
    {
        return esc_html__('kStone_Dynamic_Course', PE_PLUGIN_DOMAIN);
    }

    /**
     * Get the widget's icon.
     *
     * @return string
     */
    public function get_icon(): string
    {
        return 'fa fa-course';
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
        $styles = $settings['dropdown'];
        $quantity = $settings['quantity'];
        $timer = $settings['timer'];
        $student = $settings['show_students'];



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
                <div class="sh-if-dy-ks-needs-flexing">
                    <div class="for-flexing-inner-section-sh-dy-course-ks">
                        <div class="sh-ks-image-dy-c">
                            <img src="<?php echo get_the_post_thumbnail_url(); ?>" alt="">
                        </div>
                        <div class="sh-ks-dy-course-content">
                            <div class="sh-ks-title-dynamic-course"> <a href="<?php echo get_the_permalink(); ?>">
                                    <?php echo get_the_title(); ?></a>
                            </div>

                            <div class="sh-dynamic-course-ks-content-price">
                                <?php

                                $product_id = get_post_meta(get_the_ID(), 'vibe_product', true);

                                $currency_symble = get_woocommerce_currency_symbol();
                                $price = get_post_meta($product_id, '_regular_price', true);
                                $sale = get_post_meta($product_id, '_sale_price', true);

                                if (!bp_is_my_profile()) {

                                    if (!empty($sale)) {
                                ?>
                                        <strong>
                                            <del><span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol"><?php echo $currency_symble; ?></span><?php echo $price; ?></span></del>
                                            <ins><span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol"><?php echo $currency_symble; ?></span><?php echo $sale; ?></span></ins>
                                        </strong>
                                    <?php
                                    } elseif (empty($sale) && !empty($price)) {
                                    ?>
                                        <strong>
                                            <ins><span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol"><?php echo $currency_symble; ?></span><?php echo $price; ?></span></ins>
                                        </strong>
                                    <?php
                                    } elseif (empty($sale) && empty($price)) {
                                    ?>
                                        <strong>
                                            <ins><span class="woocommerce-Price-amount amount">free</span></ins>
                                        </strong>

                                    <?php
                                    }
                                    ?>
                                    <!-- <a class="view-details" href="<?php echo get_site_url();  ?>/cart/?add-to-cart=<?php echo $product_id; ?>">Add to Cart</a> -->
                                    <br>
                                    <!-- <a class="sa-more-info" href="<?php echo get_the_permalink(get_the_ID());  ?>">More Info</a> -->
                                <?php

                                } else {
                                    the_course_button(get_the_ID());
                                }

                                ?>
                                <!-- <span><del>£409</del>£219</span> -->
                            </div>
                            <div class="sh-units-students-ks">
                                <span><i class="fa fa-file-text" aria-hidden="true"></i>
                                    <?php
                                    $unit = bp_course_get_curriculum_units(get_the_ID());
                                    echo count($unit);
                                    ?></span>
                                <span><i class="fa fa-users" aria-hidden="true"></i>
                                    <?php
                                    echo get_post_meta(get_the_ID(), 'vibe_students', true);
                                    ?></span>
                            </div>
                        </div>
                        <div class="sh-for-flexing-units-and-ctas">

                            <div class="sh-kstone-ctas">
                                <div class="view-details">
                                    <a href="<?php echo get_the_permalink(get_the_ID());  ?>">view details</a>
                                </div>
                                <div class="add-to-cart">
                                    <a href="<?php echo get_site_url();  ?>/cart/?add-to-cart=<?php echo $product_id; ?>">add to cart</a>
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

Plugin::instance()->widgets_manager->register_widget_type(new kStone_Dynamic_Course());
