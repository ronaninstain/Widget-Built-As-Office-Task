<?php

use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;
use Elementor\Plugin;
use Elementor\Widget_Base;

if (!defined('ABSPATH')) {
    // Exit if accessed directly.
    exit;
}

class Latest_Posts_Widget_Sliders extends Widget_Base
{

    /**
     * Get the widget's name.
     *
     * @return string
     */
    public function get_name(): string
    {
        return 'pe-latest-posts-sliders';
    }

    /**
     * Get the widget's title.
     *
     * @return string
     */
    public function get_title(): string
    {
        return esc_html__('PE Latest Posts sliders', PE_PLUGIN_DOMAIN);
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

        $this->add_control(
            'show_students',
            [
                'label' => esc_html__('Show Students', PE_PLUGIN_DOMAIN),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', PE_PLUGIN_DOMAIN),
                'label_off' => esc_html__('Hide', PE_PLUGIN_DOMAIN),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );
        $this->add_control(
            'show_button',
            [
                'label' => esc_html__('Show Button', PE_PLUGIN_DOMAIN),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', PE_PLUGIN_DOMAIN),
                'label_off' => esc_html__('Hide', PE_PLUGIN_DOMAIN),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );


        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'list_title',
            [
                'label' => esc_html__('Title', PE_PLUGIN_DOMAIN),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('List Title', PE_PLUGIN_DOMAIN),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'list_content',
            [
                'label' => esc_html__('Content', PE_PLUGIN_DOMAIN),
                'type' => \Elementor\Controls_Manager::WYSIWYG,
                'default' => esc_html__('List Content', PE_PLUGIN_DOMAIN),
                'show_label' => false,
            ]
        );

        $this->add_control(
            'list',
            [
                'label' => esc_html__('Facility List', PE_PLUGIN_DOMAIN),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'list_title' => esc_html__('Title #1', PE_PLUGIN_DOMAIN),
                        'list_content' => esc_html__('Item content. Click the edit button to change this text.', PE_PLUGIN_DOMAIN),
                    ],
                    [
                        'list_title' => esc_html__('Title #2', 'plugin-name'),
                        'list_content' => esc_html__('Item content. Click the edit button to change this text.', PE_PLUGIN_DOMAIN),
                    ],
                ],
                'title_field' => '{{{ list_title }}}',
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



?>
        <div class="Sh-bundle-area">
            <div class="container">
                <div class="owl-carousel owl-theme owl-bundle">
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
                        <div class="career-bundles-single">
                            <div class="course-img"><img src="<?php echo get_the_post_thumbnail_url(); ?>">
                            </div>
                            <div class="bundle-content">
                                <div class="bundle-course-title"><a href="<?php echo get_the_permalink(); ?>">
                                        <h2><?php echo get_the_title(); ?></h2>
                                    </a></div>
                                <ul class="bundle-course-features">
                                    <?php if ($list) {
                                        echo '<dd>';
                                        foreach ($settings['list'] as $item) {
                                            echo '<li>' . $item['list_content'] . '</li>';
                                        }
                                        echo '</dd>';
                                    } ?>
                                </ul>
                                <div class="bundle-course-price">
                                    <?php

                                    $product_id = get_post_meta(get_the_ID(), 'vibe_product', true);

                                    $currency_symble = get_woocommerce_currency_symbol();
                                    $price = get_post_meta($product_id, '_regular_price', true);
                                    $sale = get_post_meta($product_id, '_sale_price', true);

                                    if (!bp_is_my_profile()) {

                                        if (!empty($sale)) {
                                    ?>
                                            <div class="bundle-course-amm">
                                                <strong>
                                                    <del><span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol"><?php echo $currency_symble; ?></span><?php echo $price; ?></span></del>
                                                    <ins><span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol"><?php echo $currency_symble; ?></span><?php echo $sale; ?></span></ins>
                                                </strong>
                                            </div>
                                        <?php
                                        } elseif (empty($sale) && !empty($price)) {
                                        ?>
                                            <div class="bundle-course-amm">
                                                <strong>
                                                    <ins><span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol"><?php echo $currency_symble; ?></span><?php echo $price; ?></span></ins>
                                                </strong>
                                            </div>
                                        <?php
                                        } elseif (empty($sale) && empty($price)) {
                                        ?>
                                            <div class="bundle-course-amm">
                                                <strong>
                                                    <ins><span class="woocommerce-Price-amount amount">free</span></ins>
                                                </strong>
                                            </div>
                                        <?php
                                        }
                                        ?>
                                    <?php

                                    } else {
                                        the_course_button(get_the_ID());
                                    }

                                    ?>
                                    <?php
                                    if ($student) {
                                    ?>
                                        <div class="bundle-course-std"><img src="https://www.oneeducation.org.uk/wp-content/uploads/2022/07/Group-10.svg">
                                            <?php
                                            echo get_post_meta(get_the_ID(), 'vibe_students', true);
                                            ?>
                                        </div>
                                    <?php } ?>
                                    <?php
                                    if ($button) { ?>
                                        <div class="athc-buntton">
                                            <a href="https://www.oneeducation.org.uk/regulated-courses-enquiry/">Enquire Now</a>
                                        </div>
                                    <?php } ?>

                                </div>
                                <div class="bundle-course-reviews">
                                    <?php $average_rating = get_post_meta(get_the_ID(), 'average_rating', true); ?>
                                    <div class="rating_sh_content">
                                        <div class="sh_rating">
                                            <div class="sh_rating-upper" style="width:<?php echo $average_rating ? 20 * $average_rating : 0; ?>%">
                                                <span>★</span>
                                                <span>★</span>
                                                <span>★</span>
                                                <span>★</span>
                                                <span>★</span>
                                            </div>
                                            <div class="sh_rating-lower">
                                                <span>★</span>
                                                <span>★</span>
                                                <span>★</span>
                                                <span>★</span>
                                                <span>★</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div><a href="<?php echo get_site_url();  ?>/cart/?add-to-cart=<?php echo $product_id; ?>">Add to Cart</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php
                    endwhile;
                    wp_reset_postdata();

                    ?>
                </div>
            </div>
        </div>
<?php

    }
}

Plugin::instance()->widgets_manager->register_widget_type(new Latest_Posts_Widget_Sliders());
