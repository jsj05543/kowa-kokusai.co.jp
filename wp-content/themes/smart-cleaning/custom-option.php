<?php

    $smart_cleaning_theme_css= "";

    /*--------------------------- Scroll To Top Positions -------------------*/

    $smart_cleaning_scroll_position = get_theme_mod( 'smart_cleaning_scroll_top_position','Right');
    if($smart_cleaning_scroll_position == 'Right'){
        $smart_cleaning_theme_css .='#button{';
            $smart_cleaning_theme_css .='right: 20px;';
        $smart_cleaning_theme_css .='}';
    }else if($smart_cleaning_scroll_position == 'Left'){
        $smart_cleaning_theme_css .='#button{';
            $smart_cleaning_theme_css .='left: 20px;';
        $smart_cleaning_theme_css .='}';
    }else if($smart_cleaning_scroll_position == 'Center'){
        $smart_cleaning_theme_css .='#button{';
            $smart_cleaning_theme_css .='right: 50%;left: 50%;';
        $smart_cleaning_theme_css .='}';
    }

    /*--------------------------- Slider Image Opacity -------------------*/

    $smart_cleaning_slider_img_opacity = get_theme_mod( 'smart_cleaning_slider_opacity_color','');
    if($smart_cleaning_slider_img_opacity == '0'){
        $smart_cleaning_theme_css .='#top-slider img{';
            $smart_cleaning_theme_css .='opacity:0';
        $smart_cleaning_theme_css .='}';
        }else if($smart_cleaning_slider_img_opacity == '0.1'){
        $smart_cleaning_theme_css .='#top-slider img{';
            $smart_cleaning_theme_css .='opacity:0.1';
        $smart_cleaning_theme_css .='}';
        }else if($smart_cleaning_slider_img_opacity == '0.2'){
        $smart_cleaning_theme_css .='#top-slider img{';
            $smart_cleaning_theme_css .='opacity:0.2';
        $smart_cleaning_theme_css .='}';
        }else if($smart_cleaning_slider_img_opacity == '0.3'){
        $smart_cleaning_theme_css .='#top-slider img{';
            $smart_cleaning_theme_css .='opacity:0.3';
        $smart_cleaning_theme_css .='}';
        }else if($smart_cleaning_slider_img_opacity == '0.4'){
        $smart_cleaning_theme_css .='#top-slider img{';
            $smart_cleaning_theme_css .='opacity:0.4';
        $smart_cleaning_theme_css .='}';
        }else if($smart_cleaning_slider_img_opacity == '0.5'){
        $smart_cleaning_theme_css .='#top-slider img{';
            $smart_cleaning_theme_css .='opacity:0.5';
        $smart_cleaning_theme_css .='}';
        }else if($smart_cleaning_slider_img_opacity == '0.6'){
        $smart_cleaning_theme_css .='#top-slider img{';
            $smart_cleaning_theme_css .='opacity:0.6';
        $smart_cleaning_theme_css .='}';
        }else if($smart_cleaning_slider_img_opacity == '0.7'){
        $smart_cleaning_theme_css .='#top-slider img{';
            $smart_cleaning_theme_css .='opacity:0.7';
        $smart_cleaning_theme_css .='}';
        }else if($smart_cleaning_slider_img_opacity == '0.8'){
        $smart_cleaning_theme_css .='#top-slider img{';
            $smart_cleaning_theme_css .='opacity:0.8';
        $smart_cleaning_theme_css .='}';
        }else if($smart_cleaning_slider_img_opacity == '0.9'){
        $smart_cleaning_theme_css .='#top-slider img{';
            $smart_cleaning_theme_css .='opacity:0.9';
        $smart_cleaning_theme_css .='}';
        }