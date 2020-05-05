<?php
/*
Plugin Name: CyrLatConverter
Description: A plugin that is used for my javascript
Author: ME
version: 1.001
*/
include_once 'inc/plugin_page.php';
add_action( 'wp_enqueue_scripts', 'plugin_scripts_init' );

function plugin_scripts_init() {
	wp_enqueue_script( 'cyrlatconverter', plugins_url( '/inc/cyrlatconverter.min.js', __FILE__ ) );
}

function CyrLatConverter_init() {
	$cyrlatconverter_options     = get_option( 'cyrlatconverter_option_name' );
	$button_selector_for_cyr     = $cyrlatconverter_options['button_selector_for_cyr_0'];
	$button_selector_for_lat     = $cyrlatconverter_options['button_selector_for_lat_1'];
	$button_selector_for_default = $cyrlatconverter_options['button_selector_for_default_2'];
	$permalink_hash              = ( $cyrlatconverter_options['permalink_hash_3'] === 'permalink_hash_3' ) ? 'true' : 'false';
	$ignore_classes              = $cyrlatconverter_options['ignore_classes_4'];
	$enable_header               = ( $cyrlatconverter_options['enable_header'] === 'enable_header' ) ? false : true;
//	var_dump( $enable_header );
//	if ( $enable_header ) {
//		add_action( 'wp_head', 'hook_header' );
//	}

	?>
    <script>
        console.log("<?php echo $button_selector_for_cyr ?>");
        console.log("<?php echo $button_selector_for_lat ?>");
        console.log("<?php echo $button_selector_for_default ?>");
        console.log("<?php echo $permalink_hash ?>");
        console.log("<?php echo $ignore_classes ?>");
        console.log("<?php echo $enable_header ?>");


        let CyrLat = new CyrLatConverter('body').init({
            onClickCyr: '<?php echo $button_selector_for_cyr ?>',
            onClickLat: '<?php echo $button_selector_for_lat ?>',
            onClickDefault: '<?php echo $button_selector_for_default ?>',
            cookieDuration: 7,
            usePermalinkHash:<?php echo $permalink_hash ?> ,
            ignoreClasses: ['ignore'],
            benchmark: true,
            benchmarkEval: "document.getElementById('exctime').innerHTML = '%s%';"
        });

        CyrLat.C2L();

        // console.log("Primer C2L: " + CyrLat.getC2L("Било је то у некој земљи сељака"));
        // console.log("Primer L2C: " + CyrLat.getL2C("na brdovitom Balkanu"));

    </script>
	<?php
}

add_action( 'wp_footer', 'CyrLatConverter_init' );


function hook_header() {
	$cyrlatconverter_options = get_option( 'cyrlatconverter_option_name' );

	$enable_header = ( $cyrlatconverter_options['enable_header'] === 'enable_header' ) ? true : false;
	?>
    <div style="display: <?php echo ( $enable_header ) ? '' : 'none' ?>" class="header" id="myHeader">
        <div style="width: 100%; float:left; text-align: center;">
            <button id="cirilica">Prikaži na ćirilici</button>
            <button id="latinica">Prikaži na latinici</button>
            <button id="default">Prikaži na default</button>
        </div>
    </div>

    <style>
        .header {
            padding: 10px 16px;
        }

        .content {
            padding: 16px;
        }

        .sticky {
            position: fixed;
            top: 0;
            width: 100%
        }

    </style>

    <script>
        window.onscroll = function () {
            myFunction()
        };

        var header = document.getElementById("myHeader");

        var sticky = header.offsetTop;

        function myFunction() {
            if (window.pageYOffset > sticky) {
                header.classList.add("sticky");
            } else {
                header.classList.remove("sticky");
            }
        }
    </script>
	<?php
}

add_action( 'wp_head', 'hook_header' );