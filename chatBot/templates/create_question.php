<style>
    .question-form {
        max-width: 400px;
        margin: 0 auto;
    }
    
    h1 {
        text-align: center;
        margin-bottom: 20px;
    }
    
    label {
        font-weight: bold;
    }
    
    input[type="text"],
    select {
        width: 100%;
        padding: 10px;
        margin-bottom: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }
    
    .form__error {
        color: red;
    }
    
    .submit-button {
        display: block;
        width: 100%;
        padding: 10px;
        background-color: #4caf50;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 16px;
    }
</style>


<main>
    <h1>Форма для создания вопроса с ответом</h1>
    <!-- Форма для создания записи в базе данных -->
    <form action="create_question.php" method="post">
        <label for="name">Вопрос<sup>*</sup></label><br>
        <input type="text" name="name" placeholder="Введите вопрос" value="<?= $_POST['name'] ?? '' ?>"><br>
        <span class="form__error"><?= $errors['name'] ?></span><br>

        <label for="answer">Ответ <sup>*</sup></label><br>
        <input type="text" name="answer" placeholder="Введите ответ" value="<?= $_POST['answer'] ?? '' ?>"><br>
        <span class="form__error"><?= $errors['answer'] ?></span><br>

        <label for="category_id">Категория <sup>*</sup></label><br>
        <select id="category_id" name="category_id">
            <option>Выберите категорию</option>
            <?php foreach ($categories as $category): ?>
                <option value="<?= $category['id'] ?>" <?= $category['id'] == ($_POST['category_id'] ?? '') ? 'selected' : '' ?>>
                    <?= $category["name"] ?>
                </option>
            <?php endforeach; ?>
        </select><br>
        <span class="form__error"><?= $errors['category_id'] ?></span>

        <!-- Добавьте другие поля по необходимости -->

        <input type="submit" name="submit_button" value="Создать вопрос">
    </form>
</main>