<?php

class Arzamath_17th_Widget extends WP_Widget
{
    function Arzamath_17th_Widget()
    {
        $widget_ops = array('classname' => 'Arzamath_17th_Widget', 'description' => 'Displays a random post from Arzamath_17th plugin');
        $this->WP_Widget('Arzamath_17th_Widget', 'Arzamath 17th Widget', $widget_ops);
    }

    function form($instance)
    {
        $instance = wp_parse_args( (array) $instance, array( 'title' => '' ) );
        $title = $instance['title'];
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>">Title:
                <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>"
                       name="<?php echo $this->get_field_name('title'); ?>"
                       type="text" value="<?php echo esc_attr($title); ?>" />
            </label>
        </p>
    <?php
    }

    function update($new_instance, $old_instance)
    {
        $instance = $old_instance;
        $instance['title'] = $new_instance['title'];
        return $instance;
    }

    function widget($args, $instance)
    {
        extract($args, EXTR_SKIP);

        echo $before_widget;
        $title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);

        query_posts('post_type=post-type-template');
        ?>
        <ul>
        <?php
        if ( have_posts() ) :
            while (have_posts()) : the_post();?>
                    <li class="text-center">
                        <a class="text-success" href="<?php the_permalink(); ?>"><?php the_title() ?></a><br />
                        <?php echo the_post_thumbnail(array(100, 100), array('class' => 'img-circle') ); ?>
                        <?php echo the_excerpt();?>
                        <p>Text_field: <?php echo get_post_meta(get_the_ID(), 'meta-text', true); ?></p>
                        <a class="btn btn btn-success btn-xs" href="<?php the_permalink(); ?>">read more</a>
                    </li>
            <?php
            endwhile;
        endif;
        ?>
        </ul>
        <?php

        wp_reset_query();

        echo $after_widget;
    }
}
add_action( 'widgets_init', create_function('', 'return register_widget("Arzamath_17th_Widget");') );?>