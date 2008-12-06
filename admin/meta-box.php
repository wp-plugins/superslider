<?php

// This function tells WP to add a new "meta box"

function add_show_box() {

    add_meta_box(

        'ss-show', // id of the <div> we'll add

        'SuperSlider-Show', //title

        'in_the_show_box', // callback function that will echo the box content

        'post' // where to add the box: on "post", "page", or "link" page

    );

}

 

// This function echoes the content of our meta box

function in_the_show_box() {

    echo "I'm living in a box";

}
 

?>