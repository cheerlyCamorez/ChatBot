<style>
.filter{
    font-family: 'Manrope', sans-serif;
    font-size: 28px;
    color: #173566;
    justify-content: center;
    align-items: center;
    
}
.falllist{
    display: inline-block;
    justify-content: center;
    align-items: center;
}
select#filterCategory{
    width: 300px;
    display: inline-block;
    background-color: #173566;
    color: #fff;
    -webkit-border-radius: 20px;
    -moz-border-radius: 20px;
    border-radius: 5px;
    padding-left: 15px;
    font-family: 'Manrope', sans-serif;
    font-size: 20px;
    height: 28px;
}
.listbtn{
    margin-left: 10px;
    display: inline-block;
    width:350px;
    color: fff;
    background-color: #173566;
    border-radius: 5px; 
    border: none;
    cursor: pointer;
    font-family: 'Manrope', sans-serif;
    font-size: 22px;
    text-decoration: none;
}
red{
    width: 300px;
    background-color:#173566;
    text-decoration: none;
    background: red;
}
table {
    font-family: 'Manrope', sans-serif;
    width: 100%; /* Ширина таблицы на всю доступную область */
    border-collapse: collapse; /* Склейка границ ячеек */
    text-decoration: none;
  }

th, td {
padding: 10px; /* Внутренний отступ ячеек */
text-align: left; /* Выравнивание текста по левому краю */
border-bottom: 1px solid #ccc; /* Горизонтальные линии между ячейками */
text-decoration: none;
}

th {
background-color: #f2f2f2; /* Фон заголовков столбцов */
font-weight: bold; /* Жирный текст заголовков столбцов 
text-decoration: none;
}

td a {
text-decoration: none;
color: #0000ff; /* Цвет текста ссылки в ячейке */
text-decoration: none; /* Убираем подчеркивание ссылки */
}
td button {
    text-decoration: none;
    margin: 5px;
    font-family: 'Manrope', sans-serif;
    background-color: #ff0000; /* Цвет фона кнопки в ячейке */
    color: #ffffff; /* Цвет текста кнопки в ячейке */
    border: none; /* Убираем границу кнопки */
    padding: 5px 10px; /* Внутренний отступ кнопки (верхнее/нижнее, левое/правое) */
    border-radius: 5px; /* Закругление углов кнопки */
    cursor: pointer; /* Курсор при наведении на кнопку */
  }
  td button#red{
    background-color: #173566;
    color: #fff;
    text-decoration: none;
  }
  
  td button:hover {
    text-decoration: none;
    background-color: #cc0000; /* Измененный цвет фона кнопки в ячейке при наведении */
  }

</style>

<main>


    <div class="filter">
        <form method="get">
            <label for="filterCategory">Фильтр по категории:</label>
            <div class="falllist">
                <select name="filterCategory" id="filterCategory">
                    <option value="">Все</option>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?= $category['name'] ?>" <?= ($_GET['filterCategory'] ?? '') == $category['name'] ? 'selected' : '' ?>>
                            <?= $category['name'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                    <input type="submit" value="Применить" class="listbtn">
            </div>
        </form>
    </div>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Имя</th>
                <th>Ответ</th>
                <th>ID категории</th>
                <th>Действие</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($dataquestions as $row): ?>
                <?php if (empty($_GET['filterCategory']) || $row['category'] == $_GET['filterCategory']): ?>
                    <tr>
                        <td><?= $row['id'] ?></td>
                        <td><?= $row['question'] ?></td>
                        <td><?= $row['answer'] ?></td>
                        <td><?= $row['category'] ?></td>
                        <td><a href="redact_question.php?id=<?= $row['id'] ?>"><button id="red" >Редактировать</button></a>
                        <button onclick="showConfirmationPopup()">Удалить</button></td>
                    </tr>
                <?php endif; ?>
            <?php endforeach; ?>
        </tbody>
    </table>



    <div class="overlay" id="overlay">ага</div>

<div class="confirmation-popup" id="confirmation-popup">
    <p>Вы уверены, что хотите продолжить?</p>
    <button onclick="confirmAction('delete_answered_question.php?id=<?=$row['id']?>')">Да</button>
    <button onclick="cancelAction()">Отмена</button>
</div>
</main>