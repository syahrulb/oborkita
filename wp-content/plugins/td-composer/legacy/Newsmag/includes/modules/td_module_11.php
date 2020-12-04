<?php


class td_module_11 extends td_module {

    function __construct($post, $module_atts = array()) {
        //run the parrent constructor
        parent::__construct($post, $module_atts);
    }

    function render() {
        ob_start();

        $title_length = $this->get_shortcode_att('m11_tl');
        $excerpt_length = $this->get_shortcode_att('m11_el');
        $modified_date = $this->get_shortcode_att('show_modified_date');

        if (empty($image_size)) {
            $image_size = 'td_238x178';
        }
        
        ?>

        <div class="<?php echo $this->get_module_classes();?>">
            <?php  echo $this->get_image($image_size, false); ?>
            <?php echo $this->get_video_duration(); ?>

            <div class="item-details">
                <?php echo $this->get_title($title_length);?>
                <div class="meta-info">
                    <?php if (td_util::get_option('tds_category_module_11') == 'yes') { echo $this->get_category(); }?>
                    <?php echo $this->get_author();?>
                    <?php echo $this->get_date($modified_date);?>
                    <?php echo $this->get_comments();?>
                </div>

                <div class="td-excerpt">
                    <?php echo $this->get_excerpt($excerpt_length);?>
                </div>

                <div class="td-read-more">
                    <a href="<?php echo $this->href;?>"><?php echo __td('Read more', TD_THEME_NAME);?></a>
                </div>
            </div>

        </div>

        <?php return ob_get_clean();
    }
}