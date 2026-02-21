<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><?= __t('nav.part5_bag_of_words_and_tf_idf'); ?></h1>
</div>

<div>
    <p>
        В предыдущих главах мы говорили о тексте как о данных и о том, что компьютер не умеет читать слова "как человек". Для него текст – это набор символов, чисел и статистик. В этой главе мы разберём два базовых, но до сих пор крайне полезных подхода к представлению текста в виде чисел: Bag of Words и TF–IDF.
    </p>

    <ul>
        <li>
            <?= create_link('part-5/bag-of-words-and-tf-idf/simple-tf-idf-example', 'Простой пример TF–IDF на PHP'); ?>
        </li>

        <li>
            <?= create_link('part-5/bag-of-words-and-tf-idf/case-1/...', 'Кейс 1. Поиск похожих документов', true); ?>
        </li>
        <li>
            <?= create_link('part-5/bag-of-words-and-tf-idf/case-2/...', 'Кейс 2. Классификация отзывов: "положительный / отрицательный"', true); ?>
        </li>
        <li>
            <?= create_link('part-5/bag-of-words-and-tf-idf/case-3/...', 'Кейс 3. Автоматическая категоризация статей', true); ?>
        </li>
        <li>
            <?= create_link('part-5/bag-of-words-and-tf-idf/case-4/...', 'Кейс 4. Детектор "спама" в формах обратной связи', true); ?>
        </li>
        <li>
            <?= create_link('part-5/bag-of-words-and-tf-idf/case-5/...', 'Кейс 5. Объяснимый поиск "почему этот документ?"', true); ?>
        </li>
        <li>
            <?= create_link('part-5/bag-of-words-and-tf-idf/case-6/...', 'Кейс 6. Сравнение: Bag of Words vs TF–IDF на одном примере', true); ?>
        </li>
    </ul>
</div>
