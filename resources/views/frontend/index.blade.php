  <!DOCTYPE html>
  <html lang="en">
  <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Todo App JavaScript | CodingNepal</title>
      <link rel="stylesheet" href="style.css">
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



        
    <div class="wrapper">
    

      <header>Todo App</header>
      
      @if ($message = Session::get('success'))
      <div class="alert alert-success alert-dismissible fade show" role="alert">
          <p>{{ $message }}</p>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
      @endif
      
      <form id="todo-form" action="{{ route('tasks.store') }}" method="POST" enctype="multipart/form-data" onsubmit="return validateForm()">
        @csrf
        <div class="inputField">
            <input type="text" name="title" id="taskTitle" placeholder="Add your new todo">
            <button id="add-btn" onclick="return validateForm()"><i class="fas fa-plus"></i></button>
            <button id="update-btn" style="display: none;" type="button" onclick="updateTask()"> <i class='fas fa-edit'></i> </button>
            @error('title')
            <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
            @enderror
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
                    <button class="btn btn-primary" onclick="editTask({{ $task->id }})">
                        <i class='fas fa-edit'></i> Edit
                    </button>
            
                    <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" style="display: inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="fa fa-trash-o" style="font-size:24px"></i> Delete
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
            
            
          </tbody>
      </table>
      </ul>
      <div class="footer">
        <span>You have <span class="pendingTasks">{{ $count }}</span> pending tasks</span>
        <form id="delete-all-form" action="{{ URL('deleteAll') }}" method="POST">
            @csrf
            <button type="button" onclick="confirmDeleteAll()" class="btn btn-danger">Clear All</button>
        </form>
    </div>
    
   
    @include('frontend.scripts')

    {{-- <script src="script.js"></script> --}}
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity></script>

  </body>
  </html>
