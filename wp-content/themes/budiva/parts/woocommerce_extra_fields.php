<fieldset>
    <legend>Дополнительно</legend>

    <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
        <label for="user_telephone">Телефон</label>
        <input type="text" class="woocommerce-Input input-text" name="user_telephone" id="user_telephone" value="<?= esc_attr( $user_telephone ); ?>">
    </p>

    <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
        <label for="user_get_news">
            <input type="checkbox" class="woocommerce-Input input-checkbox" name="user_get_news" id="user_get_news"<?php checked( $user_get_news ); ?>>
            Получать новости
        </label>
    </p>

    <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
        <label for="user_get_news_add_suggestions">
            <input type="checkbox" class="woocommerce-Input input-checkbox" name="user_get_news_add_suggestions" id="user_get_news_add_suggestions"<?php checked( $user_get_news_add_suggestions ); ?>>
            Получать новости и предложения
        </label>
    </p>

    <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
        <label for="user_get_articles">
            <input type="checkbox" class="woocommerce-Input input-checkbox" name="user_get_articles" id="user_get_articles"<?php checked( $user_get_articles ); ?>>
            Получать статьи
        </label>
    </p>
</fieldset>