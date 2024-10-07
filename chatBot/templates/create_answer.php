<style>

</style>

<main>
<h2>Вопрос:</h2>
<?php ?>
    <ul>
        <?php foreach ($dataquestions as $row): ?>
            <li>
                <div>
                    <span>ID</span>
                    <span><?= $row['id'] ?></span><br>
                    <span>Имя и фамилия</span>
                    <span><?= $row['name_surname'] ?></span><br>
                    <span>Образование</span>
                    <span><?= $row['education'] ?></span><br>
                    <span>уровень образования</span>
                    <span><?= $row['level_of_education_id'] ?></span><br>
                    <span>Программа обучения</span>
                    <span><?= $row['programm_of_education'] ?></span><br>
                    <span>Email</span>
                    <span><?= $row['e_mail'] ?></span><br>
                    <span>Вопрос:</span>
                    <span><?= $row['ask'] ?></span><br>
                    <span>идентификатор телеграмм:</span>
                    <span><?= $row['id_user_tg'] ?></span><br>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>
<?php  ?>
    <h4>Результаты не найдены</h4>
<?php  ?>
    <h1>Ответ на вопрос</h1>
        <form action="create_answer.php" method="post">
            <label for="id">идентификатор, нужен, чтобы удалить вопрос, скопируйте выше <sup>*</sup></label><br>
            <input name="id" ><?=$_POST['id'] ?? '' ?></input><br>
            <span class="form__error<?= isset($errors['id']) ? 'invalid' : '' ?>"><?= $errors['id'] ?></span>
            <label for="id_tg">идентификатор телеграмм, нужен, чтобы удалить вопрос, скопируйте выше <sup>*</sup></label><br>
            <input name="id_tg"  value="<?=$row['id_uset_tg']?>"><?=$_POST['id_tg'] ?? '' ?></input><br>
            <span class="form__error"><?= $errors['id_tg'] ?></span>
            <label for="ask">вопрос <sup>*</sup></label><br>
            <textarea name="ask" placeholder="Вопрос. отредактируйте, если это необходимо"><?=$_POST['ask'] ?? '' ?></textarea><br>
            <span class="form__error"><?= $errors['ask'] ?></span>
            <label for="answer">Ответ <sup>*</sup></label><br>
            <textarea name="answer" placeholder="Введите ответ"><?= $_POST['answer'] ?? '' ?></textarea><br>
            <span class="form__error"><?= $errors['answer'] ?></span>
            <label for="category_id">Категория вопроса<sup>*</sup></label><br>
            <select id="category_id" name="category_id">
                <option>Выберите категорию</option>
                <?php foreach ($categories as $category): ?>
                    <option value="<?= $category['id'] ?>" <?= $category['id'] == ($_POST['category_id'] ?? '') ? 'selected' : '' ?>>
                        <?= $category["name"] ?>
                    </option>
                <?php endforeach; ?>
            </select><br>
            <span class="form__error"><?= $errors['category_id'] ?></span>
            <input type="submit" name="submit_button" value="Отправить ответ">
        </form>
</main>