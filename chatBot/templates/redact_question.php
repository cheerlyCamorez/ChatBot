<style>
    main {
        font-family: Arial, sans-serif;
        margin: 20px;
    }
    
    section {
        padding: 20px;
        background-color: #f8f8f8;
        border-radius: 5px;
        margin-bottom: 20px;
    }
    
    h2 {
        font-size: 20px;
        color: #333;
        margin-bottom: 10px;
    }
    
    ul {
        list-style-type: none;
        padding: 0;
    }
    
    li {
        margin-bottom: 10px;
    }
    
    span {
        margin-right: 5px;
    }
    
    h4 {
        font-size: 16px;
        color: #888;
        margin-top: 0;
    }
    
    form {
        margin-top: 20px;
    }
    
    label {
        display: block;
        margin-bottom: 5px;
        font-weight: bold;
    }
    
    input[type="text"],
    textarea {
        width: 100%;
        padding: 5px;
        border: 1px solid #ccc;
        border-radius: 4px;
        margin-bottom: 10px;
    }
    input#answer[type="text"],
    textarea {
        width: 100%;
        height: 150px;
        padding: 5px;
        border: 1px solid #ccc;
        border-radius: 4px;
        margin-bottom: 10px;
    }
    
    select {
        width: 100%;
        padding: 5px;
        border: 1px solid #ccc;
        border-radius: 4px;
        margin-bottom: 10px;
    }
    
    .form__error {
        color: red;
        font-size: 14px;
        margin-top: 5px;
        display: block;
    }
    
    input[type="submit"] {
        background-color: #173566;
        color: white;
        border: none;
        padding: 10px 20px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 14px;
        border-radius: 4px;
        cursor: pointer;
    }
</style>    


<main>
    <section>
    <h2>Результаты поиска по запросу «<span><??></span>»</h2>
          <? if(count($questions) > 0): ?>
            <ul>
                <?php foreach ($questions as $adv): ?>
                  <li>
                      <div>
                          <span>ID</span>
                          <span><?= $_GET['id'] ?></span>
                          <span>Вопрос:</span>
                          <span><?= $adv['question'] ?></span><br>
                          <span>Ответ:</span>
                          <span><?= $adv['answer'] ?></span><br>
                          <span>Категория вопроса:</span>
                          <span><?= $adv['category_name'] ?></span>
                      </div>
                  </li>
              <?php endforeach; ?>
            </ul>
        <? else: ?>
          <h4> Лоты не найдены</h4>
        <? endif ?> 
      </section>
        <h2>Редактирование записи</h2>
        <?php if(count($questions) > 0): ?>
            <?php foreach ($questions as $adv): ?>
                <form action="redact_question.php?id=<?= $adv['id'] ?>" method="post">
                    <label for="id">ID:</label><br>
                    <input type="text" name="id" value="<?= $adv['id'] ?>" readonly><br>

                    <label for="name">Вопрос:</label><br>
                    <input type="text" name="name" placeholder="Название" value="<?= $_POST['question'] ?>"><br>

                    <label for="answer">Ответ:</label><br>
                    <textarea name="answer" placeholder="Описание"><?= $_POST['answer'] ?></textarea><br>

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

                    <input type="submit" name="submit_button">
                </form>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Запись не найдена</p>
        <?php endif; ?>
    </section>
</main>