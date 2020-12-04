<?php

class td_module_13 extends td_module {

    function __construct($post) {
        //run the parrent constructor
        parent::__construct($post);
    }

    function render() {
        ob_start();

        $modified_date = $this->get_shortcode_att('show_modified_date');

        if (empty($image_size)) {
            $image_size = 'td_640x0';
        }

        ?>

        <div class="<?php echo $this->get_module_classes();?>">
            <div class="item-details">
                <?php echo $this->get_title();?>
                <div class="meta-info">
                    <?php if (td_util::get_option('tds_category_module_13') == 'yes') { echo $this->get_category(); }?>
                    <?php echo $this->get_author();?>
                    <?php echo $this->get_date($modified_date);?>
                    <?php echo $this->get_comments();?>
                </div>

                <?php  echo $this->get_image($image_size, false); ?>
                <?php echo $this->get_video_duration(); ?>

            </div>

        </div>

        <?php return ob_get_clean();
    }
}

?>