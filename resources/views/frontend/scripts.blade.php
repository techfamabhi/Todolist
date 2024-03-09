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
    var taskId = document.getElementById('update-btn').getAttribute('data-task-id');
    var taskTitle = document.querySelector('input[name="title"]').value;

    fetch("{{ route('tasks.update', '') }}/" + taskId, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ title: taskTitle })
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
            window.location.href = "{{ route('tasks.index') }}";

        }
        // Redirect to the same page
        window.location.href = "{{ route('tasks.index') }}";
    })
    .catch(error => {
        console.error('Error:', error);
        window.location.href = "{{ route('tasks.index') }}";

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
