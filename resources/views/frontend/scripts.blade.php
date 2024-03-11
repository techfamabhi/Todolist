<script>
    function editTask(taskId) {
        var taskTitle = document.getElementById('task_title_' + taskId).innerText;
        var titleInput = document.querySelector('input[name="title"]');
        titleInput.value = taskTitle;
        document.getElementById('add-btn').style.display = 'none';
        document.getElementById('update-btn').style.display = 'inline-block';
        document.getElementById('update-btn').setAttribute('data-task-id', taskId);
    }

    function updateTask() {
    var taskId = $('#update-btn').data('task-id'); 
    var taskTitle = $('#taskTitle').val(); 
    $.ajax({
        url: '/api/tasks/' + taskId, 
        type: 'PUT', 
        data: { title: taskTitle },
        success: function(response) {
            fetchTasks(); 
            $('#taskTitle').val(''); 
            $('#add-btn').show(); 
            $('#update-btn').hide(); 
            location.reload(); 
            window.location.href = "{{ route('tasks.index') }}";

        },
        error: function(xhr, status, error) {
            console.error(error); 
        }
    });
}


function confirmDeleteAll() {
      if (confirm("Are you sure you want to delete all tasks?")) {
          document.getElementById('delete-all-form').submit();
      }
  }

  function validateForm() {
      var taskTitle = document.getElementById('taskTitle').value;
      if (!taskTitle.trim()) {
          alert("Please enter a task title.");
          return false;
      }
      return true; 
  }
</script>
