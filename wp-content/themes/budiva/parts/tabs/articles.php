
    <div class="article_tab">
        <ul class="article">
            <?php foreach ($articles as $article) { ?>
                <li>
                    <a rel="noindex" href="<?php echo $article['link']; ?>">
                        <span class="article_name">
                            <?php echo  $article['name']; ?>
                        </span>
                    </a>
                </li>
            <?php }?>
        </ul>
    </div>
