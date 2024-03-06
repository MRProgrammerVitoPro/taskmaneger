// Объявляем переменную tasks в глобальной области видимости
var tasks = [];

// Функция для загрузки задач с сервера и обновления списка задач
function loadTasks() {
    axios.get('api/tasks')
        .then(function (response) {
            tasks = response.data;
            var taskTableBody = document.getElementById('taskTableBody');
            taskTableBody.innerHTML = ''; // Очищаем текущие данные в таблице

            tasks.forEach(function(task) {
                var statusText = task.status ? "выполнено" : "не выполнено";
                var row = document.createElement('tr');
                row.innerHTML = `
                    <th scope="row">${task.id}</th>
                    <td>${task.title}</td>
                    <td>${statusText}</td> 
                    <td>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#taskModal" onclick="openTaskModal(1)">
                            Просмотр задачи
                        </button>
                    </td>
                    <td><button class="btn btn-primary" onclick="openEditModal(${task.id})">Изменить</button></td>
                    <td><button class="btn btn-danger" onclick="deleteTask(${task.id})">Удалить</button></td>
                `;
                taskTableBody.appendChild(row);
            });
        })
        .catch(function (error) {
            console.error('Произошла ошибка:', error);
        });
}

document.querySelectorAll('input[name="status"]').forEach(function(radio) {
    radio.addEventListener('change', function() {
        var status = this.value;

        axios.get('/api/tasks/status/' + status)
            .then(function(response) {
                var tasks = response.data;
                var taskTableBody = document.getElementById('taskTableBody');
                taskTableBody.innerHTML = '';

                tasks.forEach(function(task) {
                    var row = document.createElement('tr');
                    row.innerHTML = `
                        <th scope="row">${task.id}</th>
                        <td>${task.title}</td>
                        <td>${task.status == 1 ? 'Выполнено' : 'Не выполнено'}</td>
                        <td>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#taskModal" onclick="openTaskModal(${task.id})">
                                Просмотр задачи
                            </button>
                        </td>
                        <td><button class="btn btn-primary" onclick="openEditModal(${task.id})">Изменить</button></td>
                        <td><button class="btn btn-danger" onclick="deleteTask(${task.id})">Удалить</button></td>
                    `;
                    taskTableBody.appendChild(row);
                });
            })
            .catch(function(error) {
                console.error('Произошла ошибка:', error);
            });
    });
});

document.addEventListener('DOMContentLoaded', function() {
    var taskModal = document.getElementById('taskModal');
    taskModal.addEventListener('hidden.bs.modal', function () {
        var backdrop = document.querySelector('.modal-backdrop');
        backdrop.parentNode.removeChild(backdrop);
    });
});

// Функция для открытия модального окна редактирования задачи с заполненными данными
function openEditModal(taskId) {
    // Находим задачу по ее ID в списке tasks
    var task = tasks.find(function(item) {
        return item.id === taskId;
    });

    // Заполняем форму данными выбранной задачи
    document.getElementById('editTaskId').value = task.id;
    document.getElementById('editTitle').value = task.title;
    document.getElementById('editDescription').value = task.description;

    // Открываем модальное окно редактирования задачи
    var editTaskModal = new bootstrap.Modal(document.getElementById('editTaskModal'));
    editTaskModal.show();
}

// Функция для удаления задачи
function deleteTask(taskId) {
    // Отправка AJAX запроса для удаления задачи
    axios.delete(`/api/tasks/${taskId}`)
        .then(function (response) {
            // Выводим сообщение об успешном удалении задачи
            console.log('Задача успешно удалена:', response.data.message);
            
            // Обновляем список задач
            loadTasks();
        })
        .catch(function (error) {
            console.error('Произошла ошибка при удалении задачи:', error);
        });
}

// Загрузка задач при загрузке страницы
document.addEventListener('DOMContentLoaded', function() {
    loadTasks();
});

// Обработка отправки формы для редактирования задачи
document.getElementById('editTaskForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Предотвращаем стандартное поведение отправки формы

    var formData = new FormData(this); // Создаем объект FormData для отправки данных формы

    // Отправка AJAX запроса для обновления задачи
    axios.put(`api/tasks/update/${formData.get('id')}`, {
        title: formData.get('title'),
        description: formData.get('description')
    })
    .then(function (response) {
        // Выводим сообщение об успешном обновлении задачи
        console.log('Задача успешно обновлена:', response.data);

        // Закрываем модальное окно редактирования задачи
        var editTaskModal = bootstrap.Modal.getInstance(document.getElementById('editTaskModal'));
        editTaskModal.hide();

        // Обновляем список задач
        loadTasks();
    })
    .catch(function (error) {
        console.error('Произошла ошибка при обновлении задачи:', error);
    });
});

// Функция для открытия модального окна и загрузки информации о задаче
function openTaskModal(taskId) {
    axios.get(`api/tasks/${taskId}`)
        .then(function (response) {
            var task = response.data;
            document.getElementById('taskTitle').innerText = task.title;
            document.getElementById('taskDescription').innerText = task.description;
            var taskModal = new bootstrap.Modal(document.getElementById('taskModal'));
            taskModal.show();
        })
        .catch(function (error) {
            console.error('Произошла ошибка при загрузке информации о задаче:', error);
        });
}

// Обработка отправки формы для добавления задачи
document.getElementById('addTaskForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Предотвращаем стандартное поведение отправки формы

    var formData = new FormData(this); // Создаем объект FormData для отправки данных формы
    var title = formData.get('title');
    var description = formData.get('description');

    // Отправка AJAX запроса для создания новой задачи
    axios.post('/api/tasks/add', {
        title: title,
        description: description
    })
    .then(function (response) {
        // Обновление списка задач после успешного создания
        // Например, перезагрузка страницы или добавление новой задачи в список без перезагрузки страницы
        console.log('Задача успешно добавлена:', response.data);
        location.reload(); // перезагрузка страницы
    })
    .catch(function (error) {
        console.error('Произошла ошибка:', error);
    });
});