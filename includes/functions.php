<?php


add_action( 'wp_enqueue_scripts', 'enqueueAssets' );

function enqueueAssets(){
    // Enqueue Admin CSS
    wp_enqueue_style('chunk-style', COLORPICKER_URL. "/static/css/main.12b01231.chunk.css", null, time());
   
    // Enqueue Admin Js
    wp_enqueue_script('chunk-js', COLORPICKER_URL. "/static/js/2.7047c04d.chunk.js", null,  time(), true);
    wp_enqueue_script('h-custom-js', COLORPICKER_URL. "/static/js/custom.js", null,  time(), true);
    wp_register_script('48cdda11-js', COLORPICKER_URL. "/static/js/main.a4346a80.chunk.js", null,  time(), true);
    wp_localize_script('48cdda11-js', 'colorpicker', [ 'siteurl' => COLORPICKER_URL ] );
    wp_enqueue_script('48cdda11-js');

}


/**
 * Gradient Color Options in single product page
 * will be used for getting Color 
 */

 // Display Color field on single product page.

 add_action( 'woocommerce_before_add_to_cart_button', 'add_hoodsly_custom_color_field', 4 );
function add_hoodsly_custom_color_field() {
    echo '<table class="variations color-position" cellspacing="0">
          <tbody
            <tr>
                <td class="value">
                    <div id="color-picker" value="#000000"></div>
                </td>
            </tr>                               
          </tbody>
      </table>';

      ?>
        
        <script>!function(e){function r(r){for(var n,l,i=r[0],c=r[1],p=r[2],a=0,s=[];a<i.length;a++)l=i[a],Object.prototype.hasOwnProperty.call(o,l)&&o[l]&&s.push(o[l][0]),o[l]=0;for(n in c)Object.prototype.hasOwnProperty.call(c,n)&&(e[n]=c[n]);for(f&&f(r);s.length;)s.shift()();return u.push.apply(u,p||[]),t()}function t(){for(var e,r=0;r<u.length;r++){for(var t=u[r],n=!0,i=1;i<t.length;i++){var c=t[i];0!==o[c]&&(n=!1)}n&&(u.splice(r--,1),e=l(l.s=t[0]))}return e}var n={},o={1:0},u=[];function l(r){if(n[r])return n[r].exports;var t=n[r]={i:r,l:!1,exports:{}};return e[r].call(t.exports,t,t.exports,l),t.l=!0,t.exports}l.m=e,l.c=n,l.d=function(e,r,t){l.o(e,r)||Object.defineProperty(e,r,{enumerable:!0,get:t})},l.r=function(e){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},l.t=function(e,r){if(1&r&&(e=l(e)),8&r)return e;if(4&r&&"object"==typeof e&&e&&e.__esModule)return e;var t=Object.create(null);if(l.r(t),Object.defineProperty(t,"default",{enumerable:!0,value:e}),2&r&&"string"!=typeof e)for(var n in e)l.d(t,n,function(r){return e[r]}.bind(null,n));return t},l.n=function(e){var r=e&&e.__esModule?function(){return e.default}:function(){return e};return l.d(r,"a",r),r},l.o=function(e,r){return Object.prototype.hasOwnProperty.call(e,r)},l.p="/";var i=this["webpackJsonpcolor-picker"]=this["webpackJsonpcolor-picker"]||[],c=i.push.bind(i);i.push=r,i=i.slice();for(var p=0;p<i.length;p++)r(i[p]);var f=c;t()}([])</script>
      <?php
}

add_action( 'woocommerce_add_cart_item_data', 'save_hood_custom_color_field', 10, 2 );
function save_hood_custom_color_field( $cart_item_data, $product_id ) {
    if( isset( $_REQUEST['hood-rgb-color'] ) ) {
        $cart_item_data[ 'hoodsly_color' ] = [
            $_REQUEST['hood-rgb-name'],
            $_REQUEST['hood-rgb-color']
        ];

        $cart_item_data['unique_key'] = md5( microtime().rand() );
    }
    return $cart_item_data;
}


add_filter( 'woocommerce_get_item_data', 'render_meta_on_cart_and_checkout', 10, 2 );
function render_meta_on_cart_and_checkout( $cart_data, $cart_item = null ) {
    $custom_items = array();

    if( !empty( $cart_data ) ) {
        $custom_items = $cart_data;
    }
    if( isset( $cart_item['hoodsly_color'] ) ) {
        $bg = $cart_item['hoodsly_color'];

        $rgbName = $bg[0];
        $rgbColor = $bg[1];

        $pattern = "/(\d{1,3})\,?\s?(\d{1,3})\,?\s?(\d{1,3})/";
           // Only if it's RGB
           if ( preg_match( $pattern, $rgbColor, $matches ) ) {
            $r = $matches[1];
            $g = $matches[2];
            $b = $matches[3];
        
            $hexcolor = sprintf("#%02x%02x%02x", $r, $g, $b);
          }

        $custom_items[] = array( "name" => 'Sherwin Williams Paint Color', "value" => "( $rgbName )"." <span style='background:$hexcolor;padding: 0px 10px;border-radius: 5px;margin-left: 5px'></span>");
    }
    return $custom_items;
}


add_action( 'woocommerce_add_order_item_meta', 'hood_order_meta_handler', 1, 3 );
function hood_order_meta_handler( $item_id, $values, $cart_item_key ) {
    $val = $values['hoodsly_color'];
    
    $rgbName = $val[0];
    $rgbColor = $val[1];

    $pattern = "/(\d{1,3})\,?\s?(\d{1,3})\,?\s?(\d{1,3})/";
       // Only if it's RGB
       if ( preg_match( $pattern, $rgbColor, $matches ) ) {
        $r = $matches[1];
        $g = $matches[2];
        $b = $matches[3];
    
        $hexcolor = sprintf("#%02x%02x%02x", $r, $g, $b);
      }

    
    $hVal = "( $rgbName )" . " <span style='background:$hexcolor;padding: 2px 10px;border-radius: 10px;margin-left: 5px'></span>";
    if( isset( $values['hoodsly_color'] ) ) {
        wc_add_order_item_meta( $item_id, "hoodsly_color", $hVal );
    }
}


?>
