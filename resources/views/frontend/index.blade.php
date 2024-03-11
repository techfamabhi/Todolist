<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todo App JavaScript | CodingNepal</title>
    <link rel="stylesheet" href="/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" ></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


  </head>
<body>

    @if(session('status'))
        <div class="alert alert-success mb-1 mt-1">
            {{ session('status') }}
        </div>
        @endif


<div class="container">
    <h1>Todo App</h1>

    @if(session('status'))
        <div class="alert alert-success mt-3">{{ session('status') }}</div>
    @endif

    <form id="todo-form">
        <div class="form-group">
            <input type="text" class="form-control" id="taskTitle" placeholder="Add your new todo">
            <button id="add-btn" class="btn btn-primary"><i class="fas fa-plus"></i> Add</button>
            <button id="update-btn" style="display: none;" type="button" onclick="updateTask()"> <i class='fas fa-edit'></i> </button>

          </div>
    </form>

    <ul class="todoList">
        <table class="table table-bordered">
            <tbody>
                @foreach ($tasks as $task)
                    <tr>
                        <td>
                            <span id="task_title_{{ $task->id }}">{{ $task->title }}</span>
                        </td>
                        <td>
                            <button class="btn btn-primary edit-btn" data-task-id="{{ $task->id }}">
                                <i class='fas fa-edit'></i> Edit
                            </button>
                            <button class="btn btn-danger delete-btn" data-task-id="{{ $task->id }}">
                                <i class="fa fa-trash-o" style="font-size:24px"></i> Delete
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </ul>

    <div class="footer mt-3">
        <span>You have <span id="pendingTasks">{{ count($tasks) }}</span> pending tasks</span>
        <button id="clear-btn" class="btn btn-danger">Clear All</button>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>


    $(document).ready(function() {
        // Load tasks on page load
          fetchTasks();

        // Add task
        $('#add-btn').click(function(e) {
            e.preventDefault();
            var title = $('#taskTitle').val();
            if (title.trim() !== '') {
                $.ajax({
                    url: '/api/tasks',
                    type: 'POST',
                    data: { title: title },
                    success: function(response) {
                        fetchTasks();
                        $('#taskTitle').val('');
                        location.reload();
                    }
                });
            }
        });

        // Edit task
        $(document).on('click', '.edit-btn', function() {
            var taskId = $(this).data('task-id');
            var taskTitle = $('#task_title_' + taskId).text().trim();
            $('#taskTitle').val(taskTitle);
            $('#add-btn').hide();
            $('#update-btn').show().data('task-id', taskId);
        });

        // Update task
        $(document).on('click', '#update-btn', function() {
            var taskId = $(this).data('task-id');
            var newTitle = $('#taskTitle').val();
            if (newTitle.trim() !== '') {
                $.ajax({
                    url: '/api/tasks/' + taskId,
                    type: 'PUT',
                    data: { title: newTitle },
                    success: function(response) {
                        fetchTasks();
                        $('#taskTitle').val('');
                        $('#add-btn').show();
                        $('#update-btn').hide();
                    }
                });
            }
        });

        // Delete task
        $(document).on('click', '.delete-btn', function() {
    var taskId = $(this).data('task-id');
    $.ajax({
        url: '/api/tasks/' + taskId,
        type: 'DELETE',
        success: function(response) {
            fetchTasks(); // Fetch updated task list
            window.location.href = "/api/tasks"; // Redirect to /api/tasks
        }
    });
});

        // Clear all tasks
        $('#clear-btn').click(function() {
    $.ajax({
        url: '/api/tasks/deleteAll',
        type: 'DELETE',
        success: function(response) {
            fetchTasks(); // Fetch updated task list
            location.reload(); // Reload the page after successful deletion
        },
        error: function(xhr, status, error) {
            console.error(error); // Log any errors to the console
        }
    });
});



        // Function to fetch tasks
        function fetchTasks() {
            $.ajax({
                url: '/api/tasks',
                type: 'GET',
                success: function(response) {
    var tasks = response.tasks;  // This line may be causing the error
    $('#todo-list tbody').empty();
    $('#pendingTasks').text(tasks.length);  // Error occurs when trying to access tasks.length
    tasks.forEach(function(task) {
        $('#todo-list tbody').append('<tr><td><span id="task_title_' + task.id + '">' + task.title + '</span></td><td><button class="btn btn-primary edit-btn" data-task-id="' + task.id + '"><i class="fas fa-edit"></i> Edit</button><button class="btn btn-danger delete-btn" data-task-id="' + task.id + '"><i class="fa fa-trash-o" style="font-size:24px"></i> Delete</button></td></tr>');
    });
}

            });
        }
    });
</script>
@include('frontend.scripts')
</body>
</html>
