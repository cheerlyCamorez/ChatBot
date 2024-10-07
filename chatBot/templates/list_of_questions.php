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
    select#filter{
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
    }
    red{
        background-color:#173566;
        text-decoration: none;
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
            <div class="falllist">
                <label for="filter">Фильтр по уровню образования:</label>

                <select name="filter" id="filter">
                    <option value="">все</option>
                    <?php foreach ($categories as $level): ?>
                        <option value="<?= $level['name_level_education'] ?>" <?= ($_GET['filter'] ?? '') == $level['name_level_education'] ? 'selected' : '' ?>>
                        <?= $level['name_level_education'] ?>
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
                <th>Вопрос</th>
                <th>Имя и фамилия</th>
                <th>Образование</th>
                <th>ID уровня образования</th>
                <th>Программа обучения</th>
                <th>Email</th>
                <th>Действие</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($educationLevels as $row): ?>
                <?php if (empty($_GET['filter']) || $row['name_level_education'] == $_GET['filter']): ?>
                    <tr>
                        <td><?= $row['id'] ?></td>
                        <td><?= $row['ask'] ?></td>
                        <td><?= $row['name_surname'] ?></td>
                        <td><?= $row['education'] ?></td>
                        <td><?= $row['name_level_education'] ?></td>
                        <td><?= $row['programm_of_education'] ?></td>
                        <td><?= $row['e_mail'] ?></td>
                        <td>
                    
                                <a href="create_answer.php?id=<?= $row['id'] ?>">
                                    <button id="red" >Ответить</button>
                                </a>

                        <button onclick="showConfirmationPopup()">Удалить</button></td>
                    </tr>
                <?php endif; ?>
            <?php endforeach; ?>
        </tbody>
    </table>

<div class="overlay" id="overlay"></div>

<div class="confirmation-popup" id="confirmation-popup">
    <p>Вы уверены, что хотите продолжить?</p>
    <button onclick="confirmAction('delete_asked_question.php?id=<?=$row['id']?>')">Да</button>
    <button onclick="cancelAction()">Отмена</button>
</div>

</main>