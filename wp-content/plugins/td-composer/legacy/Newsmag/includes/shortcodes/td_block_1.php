<?php

class td_block_1 extends td_block {

    static function cssMedia( $res_ctx ) {

        // fonts
        $res_ctx->load_font_settings( 'f_header' );
        $res_ctx->load_font_settings( 'f_ajax' );
        $res_ctx->load_font_settings( 'f_more' );

        // module 4 fonts
        $res_ctx->load_font_settings( 'm4f_title' );
        $res_ctx->load_font_settings( 'm4f_cat' );
        $res_ctx->load_font_settings( 'm4f_meta' );
        $res_ctx->load_font_settings( 'm4f_ex' );
        // module 6 fonts
        $res_ctx->load_font_settings( 'm6f_title' );
        $res_ctx->load_font_settings( 'm6f_cat' );
        $res_ctx->load_font_settings( 'm6f_meta' );
        // show video duration
        $res_ctx->load_settings_raw('show_vid_t', $res_ctx->get_shortcode_att('show_vid_t'));
        
    }

    public function get_custom_css() {
        // $unique_block_class - the unique class that is on the block. use this to target the specific instance via css
        $unique_block_class = $this->block_uid;

        $compiled_css = '';

        $raw_css =
            "<style>

				/* @f_header */
				.$unique_block_class .block-title a,
				.$unique_block_class .block-title span {
					@f_header
				}
				/* @f_ajax */
				.$unique_block_class .td-pulldown-filter-link {
					@f_ajax
				}
				/* @f_more */
				.$unique_block_class .td-load-more-wrap a {
					@f_more
				}
				/* @m4f_title */
				.$unique_block_class .td_module_4 .entry-title {
					@m4f_title
				}
				/* @m4f_cat */
				.$unique_block_class .td_module_4 .td-post-category {
					@m4f_cat
				}
				/* @m4f_meta */
				.$unique_block_class .td_module_4 .meta-info,
				.$unique_block_class .td_module_4 .td-module-comments a {
					@m4f_meta
				}
				/* @m4f_ex */
				.$unique_block_class .td_module_4 .td-excerpt {
					@m4f_ex
				}
				/* @m6f_title */
				.$unique_block_class .td_module_6 .entry-title {
					@m6f_title
				}
				/* @m6f_cat */
				.$unique_block_class .td_module_6 .td-post-category {
					@m6f_cat
				}
				/* @m6f_meta */
				.$unique_block_class .td_module_6 .meta-info,
				.$unique_block_class .td_module_6 .td-module-comments a {
					@m6f_meta
				}
				/* @show_vid_t */
				.$unique_block_class .td-post-vid-time {
					display: @show_vid_t;
				}
				
				/* @f_vid_time */
				.$unique_block_class .td-post-vid-time {
					@f_vid_time
				}
			</style>";


        $td_css_res_compiler = new td_css_res_compiler( $raw_css );
        $td_css_res_compiler->load_settings( __CLASS__ . '::cssMedia', $this->get_all_atts() );

        $compiled_css .= $td_css_res_compiler->compile_css();

        return $compiled_css;
    }

    function render($atts, $content = null) {
        parent::render($atts); // sets the live atts, $this->atts, $this->block_uid, $this->td_query (it runs the query)

        $buffy = ''; //output buffer



        $buffy .= '<div class="' . $this->get_block_classes() . '" ' . $this->get_block_html_atts() . '>';

			//get the block js
		    $buffy .= $this->get_block_css();

		    //get the js for this block
		    $buffy .= $this->get_block_js();


            //get the block title
            $buffy .= $this->get_block_title();


            //get the sub category filter for this block
            $buffy .= $this->get_pull_down_filter();

            $buffy .= '<div id=' . $this->block_uid . ' class="td_block_inner">';
                    $buffy .= $this->inner($this->td_query->posts);//inner content of the block
            $buffy .= '</div>';

            //get the ajax pagination for this block
            $buffy .= $this->get_block_pagination();
        $buffy .= '</div> <!-- ./block -->';
        return $buffy;
    }

    function inner($posts, $td_column_number = '') {

        $buffy = '';

        $td_block_layout = new td_block_layout();

        if (empty($td_column_number)) {
            $td_column_number = td_global::vc_get_column_number(); // get the column width of the block from the page builder API
        }


        $td_post_count = 0; // the number of posts rendered

        if (!empty($posts)) {
            foreach ($posts as $post) {
                $td_module_4 = new td_module_4($post, $this->get_all_atts());
                $td_module_6 = new td_module_6($post, $this->get_all_atts());

                switch ($td_column_number) {

                    case '1': //one column layout
                        $buffy .= $td_block_layout->open12(); //added in 010 theme - span 12 doesn't use rows
                        if ($td_post_count == 0) { //first post
                            $buffy .= $td_module_4->render();
                        } else {
                            $buffy .= $td_module_6->render();
                        }
                        $buffy .= $td_block_layout->close12();
                        break;

                    case '2': //two column layout
                        $buffy .= $td_block_layout->open_row();
                        if ($td_post_count == 0) { //first post
                            $buffy .= $td_block_layout->open6();
                            $buffy .= $td_module_4->render();
                            $buffy .= $td_block_layout->close6();
                        } else { //the rest
                            $buffy .= $td_block_layout->open6();
                            $buffy .= $td_module_6->render();
                        }
                        break;

                    case '3': //three column layout
                        $buffy .= $td_block_layout->open_row();
                        if ($td_post_count == 0) { //first post
                            $buffy .= $td_block_layout->open4();
                            $buffy .= $td_module_4->render();
                            $buffy .= $td_block_layout->close4();
                        } else { //2-3 cols
                            $buffy .= $td_block_layout->open4();
                            $buffy .= $td_module_6->render();

                            if ($td_post_count == 4) { //make new column
                                $buffy .= $td_block_layout->close4();
                            }
                        }
                        break;
                }
                $td_post_count++;
            }

        }
        $buffy .= $td_block_layout->close_all_tags();
        return $buffy;
    }
}