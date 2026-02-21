<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><?= __t('nav.part5_bag_of_words_and_tf_idf'); ?></h1>
</div>

<div>
    <p>
        В предыдущих главах мы говорили о тексте как о данных и о том, что компьютер не умеет читать слова "как человек". Для него текст – это набор символов, чисел и статистик. В этой главе мы разберём два базовых, но до сих пор крайне полезных подхода к представлению текста в виде чисел: Bag of Words и TF–IDF.
    </p>

    <ul>
        <li>
            <?= create_link('part-5/hands-on-embedding-in-php-with-transformers/case-1/semantic-search-without-db', 'Простой пример TF–IDF на PHP', true); ?>
        </li>

        <!--        <li>-->
<!--            --><?php //= create_link('part-5/hands-on-embedding-in-php-with-transformers/case-1/semantic-search-without-db', __t('hands_on_embedding_in_php_with_transformers.index.case1'), true); ?>
<!--        </li>-->
<!--        <li>-->
<!--            --><?php //= create_link('part-5/hands-on-embedding-in-php-with-transformers/case-2/near-duplicates', __t('hands_on_embedding_in_php_with_transformers.index.case2'), true); ?>
<!--        </li>-->
<!--        <li>-->
<!--            --><?php //= create_link('part-5/hands-on-embedding-in-php-with-transformers/case-3/semantic-faq', __t('hands_on_embedding_in_php_with_transformers.index.case3'), true); ?>
<!--        </li>-->
<!--        <li>-->
<!--            --><?php //= create_link('part-5/hands-on-embedding-in-php-with-transformers/case-4/intelligent-timelines', __t('hands_on_embedding_in_php_with_transformers.index.case4')); ?>
<!--        </li>-->
<!--        <li>-->
<!--            --><?php //= create_link('part-5/hands-on-embedding-in-php-with-transformers/case-5/zero-shot-classification', __t('hands_on_embedding_in_php_with_transformers.index.case5'), true); ?>
<!--        </li>-->
<!--        <li>-->
<!--            --><?php //= create_link('part-5/hands-on-embedding-in-php-with-transformers/case-6/similar-articles-recommendations', __t('hands_on_embedding_in_php_with_transformers.index.case6'), true); ?>
<!--        </li>-->
    </ul>
</div>
