<div class="row">
    <div class="col-md-12">
        <div class="h2 primary-header">
            <?= $name; ?> (всего найдено - <?= $this->count[$type]; ?>)
            <?php if( $this->count[$type] > $this::$per_page && !$this->is_type ) : ?>
                <a class="btn-blue" href="<?php $this->full_link( $type ); ?>">Посмотреть все</a>
            <?php endif; ?>
            <?php if( $this->is_type ) : ?>
                <a class="btn-blue" href="<?php $this->partial_link( $type ); ?>">Назад</a>
            <?php endif; ?>
        </div>
    </div>
</div>