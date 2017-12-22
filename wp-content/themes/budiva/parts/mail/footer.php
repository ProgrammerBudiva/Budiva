<?php global $smof_data; ?>
<div style="margin-left:10px;">
    <div style="width:340px; border-top:1px solid black; margin-bottom:15px;">
        С наилучшими пожеланиями, команда
        <a style="color: #0077cc; text-decoration: none;" href='<?= get_home_url(); ?>'>budiva.ua</a>
    </div>

    <table border="0" cellpadding="2" cellspacing="0" style="width:100%; margin-bottom:20px; max-width: 850px;">
        <tr>
            <th style="text-align:left;"></th>
            <th class="hide" style="text-align:left;">пн.-пт. с 09:00-18:00</th>
            <th style="text-align:left;" colspan='2'>0(800)300-506</th>
            <th class="hide" style="text-align:left;">
                <a style="color:#000!important; text-decoration:none" href="mailto:info@budiva.ua">info@budiva.ua</a>
            </th>
        </tr>

        <?php
        $query_args = array(
            "posts_per_page" => -1,
            'post_type' => 'bgmp',
            'orderby' => 'meta_value_num',
            'meta_key' => 'priority'
        );

        $the_query = new WP_Query( $query_args );

        while( $the_query->have_posts() ) {
            $the_query->the_post();
            $meta = get_post_meta( $post->ID, '', true );
            preg_match("/(.+); (.+)/", $meta['bgmp_phone'][0], $meta['bgmp_phone']);
            ?>

            <tr>
                <th style="padding-top:10px; padding-right:5px; text-align:left;"><?= $meta['bgmp_city'][0]; ?></th>
                <td class="hide" style="padding-top:10px; "><?= $meta['bgmp_address'][0]; ?></td>
                <td style="padding-top:10px;">
                    <a style="color:#000!important; text-decoration:none" href="tel:<?= $meta['bgmp_phone'][1]; ?>">
                        <?= $meta['bgmp_phone'][2]; ?>
                    </a>
                </td>
                <td style="padding-top:10px;">
                </td>
                <td class="hide" style="padding-top:10px;">
                    <a style="color:#000!important; text-decoration:none" href="mailto:<?= $meta['bgmp_email'][0]; ?>">
                        <?= $meta['bgmp_email'][0]; ?>
                    </a>
                </td>
            </tr>

            <?php
        }
        wp_reset_query();

        ?>
    </table>

    <div style="width:340px; color: #177ca3; font-weight:bold; margin-bottom:15px;">
        Акции, скидки и актуальная информация - получайте выгоду от социальных сетей!
    </div>

    <div>
        <?php /* <a href="<?= $smof_data['vk_link']; ?>" style="display:block; height:39px; width:40px; margin-right:10px; float:left;">
            <img src="<?= THEME_URI ?>/img/mail/vk_mail.png" style="display:block; height:39px; width:40px;" />
        </a> */ ?>
        <a href="<?= $smof_data['fb_link']; ?>" style="display:block; height:39px; width:40px; margin-right:10px; float:left;">
            <img src="<?= THEME_URI ?>/img/mail/fb_mail.png" style="display:block; height:39px; width:40px;"/>
        </a>
        <a href="<?= $smof_data['gp_link']; ?>" style="display:block; height:39px; width:40px; margin-right:10px; float:left;">
            <img src="<?= THEME_URI ?>/img/mail/yt_mail.png" style="display:block; height:39px; width:40px;"/>
        </a>

        <div style="display:block; content:''; clear:both;"></div>
    </div>
</div>
</body>
</html>