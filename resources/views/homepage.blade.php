<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Task Meneger</title>
        <link rel="icon" type="image/x-icon" href="{{ asset('assets/favicon.ico') }}">
        <link href="{{ asset('assets/plugin/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    </head>
    <body>

        <!-- As a link -->
        <nav class="navbar bg-body-tertiary">
            <div class="container-fluid">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-6">
                            <a class="navbar-brand" href="#">TaskBar</a>
                        </div>
                        <div class="col-lg-6 d-flex flex-row-reverse">
                            <!-- Кнопка для открытия модального окна добавления задачи -->
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addTaskModal">
                                Добавить задачу
                            </button>
                            <form id="filterForm" class="my-3, px-3">
                                <div class="mb-3">
                                    <input class="form-check-input" type="radio" name="status" id="statusDone" value="1">
                                    <label class="form-check-label" for="statusDone">
                                        Выполнено
                                    </label>
                                    <input class="form-check-input" type="radio" name="status" id="statusNotDone" value="0">
                                    <label class="form-check-label" for="statusNotDone">
                                        Не выполнено
                                    </label>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <div class="container-fluid">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Задача</th>
                                    <th scope="col">Статус</th>
                                    <th scope="col">Просмотр</th>
                                    <th scope="col">Изменить</th>
                                    <th scope="col">Удалить</th>
                                </tr>
                            </thead>
                            <tbody id="taskTableBody">
                                <!-- Здесь будут отображаться данные о задачах -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Модальное окно для просмотра задачи -->
        <div class="modal fade" id="taskModal" tabindex="-1" aria-labelledby="taskModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="taskModalLabel">Информация о задаче</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <h2 id="taskTitle"></h2>
                        <p id="taskDescription"></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                    </div>
                </div>
            </div>
        </div>


        <!-- Модальное окно добавления задачи -->
        <div class="modal fade" id="addTaskModal" tabindex="-1" aria-labelledby="addTaskModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addTaskModalLabel">Добавить задачу</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Форма добавления новой задачи -->
                        <form id="addTaskForm">
                            <div class="mb-3">
                                <label for="title" class="form-label">Заголовок</label>
                                <input type="text" class="form-control" id="title" name="title" required>
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Описание</label>
                                <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Добавить задачу</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Модальное окно редактирования задачи -->
        <div class="modal fade" id="editTaskModal" tabindex="-1" aria-labelledby="editTaskModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editTaskModalLabel">Редактировать задачу</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Форма редактирования задачи -->
                        <form id="editTaskForm">
                            <input type="hidden" id="editTaskId" name="id">
                            <div class="mb-3">
                                <label for="editTitle" class="form-label">Заголовок</label>
                                <input type="text" class="form-control" id="editTitle" name="title" required>
                            </div>
                            <div class="mb-3">
                                <label for="editDescription" class="form-label">Описание</label>
                                <textarea class="form-control" id="editDescription" name="description" rows="3" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Сохранить изменения</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <script src="{{ asset('assets/plugin/bootstrap/js/popper.min.js') }}"></script>
        <script src="{{ asset('assets/plugin/bootstrap/js/bootstrap.min.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
        <script src="{{ asset('assets/js/main.js') }}"></script>
    </body>
</html>