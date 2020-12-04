<?php

class td_module_mx1 extends td_module {

    function __construct($post, $module_atts = array()) {
        //run the parrent constructor
        parent::__construct($post, $module_atts);
    }

    function render() {
        ob_start();

        $title_length = $this->get_shortcode_att('mx1_tl');
        $modified_date = $this->get_shortcode_att('show_modified_date');

        if (empty($image_size)) {
            $image_size = 'td_341x220';
        }

        ?>

    <div class="<?php echo $this->get_module_classes();?>">
        <div class="td-block14-border"></div>
        <?php  echo $this->get_image($image_size, false); ?>
        <?php echo $this->get_video_duration(); ?>


        <div class="meta-info">
            <?php echo $this->get_title($title_length);?>
            <div class="td-editor-date">
                <?php if (td_util::get_option('tds_category_module_mx1') == 'yes') { echo $this->get_category(); }?>
                <?php echo $this->get_author();?>
                <?php echo $this->get_date($modified_date);?>
            </div>
        </div>

    </div>

    <?php return ob_get_clean();
}
}