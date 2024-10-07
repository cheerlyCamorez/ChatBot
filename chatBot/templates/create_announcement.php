<style>
    .announcement-form {
        max-width: 400px;
        margin: 0 auto;
    }
    
    h2 {
        text-align: center;
        margin-bottom: 20px;
    }
    
    label {
        font-weight: bold;
    }
    
    textarea,
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
    <h2>Создание Записи</h2>
    <form action="create_announcement.php" method="post">
        <label for="text">Текст:</label><br>
        <textarea name="text" placeholder="Введите текст"><?= $_POST['text'] ?? '' ?></textarea><br>
        <span class="form__error"><?= $errors['text'] ?></span>

        <label for="category_id">Категория:</label><br>
        <select id="category_id" name="category_id">
            <option>Выберите категорию</option>
            <?php foreach ($categories as $category): ?>
                <option value="<?= $category['id'] ?>" <?= $category['id'] == ($_POST['category_id'] ?? '') ? 'selected' : '' ?>>
                    <?= $category["name"] ?>
                </option>
            <?php endforeach; ?>
        </select><br>
        <span class="form__error"><?= $errors['category_id'] ?></span><br>
        <input type="submit" name="submit_button" value="Создать запись">
    </form>
</main>