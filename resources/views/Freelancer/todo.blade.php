<x-app-layout>
    <div class="container mx-auto py-16">
        <h1 class="text-4xl font-bold mb-8 text-center text-gray-800">To-Do List</h1>

        <!-- To-Do List Form -->
        <div class="mb-6">
            <form id="todo-form" class="flex items-center space-x-4">
                <input type="text" id="todo-input"
                    class="border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Add a new task">
                <button type="submit" class="bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-blue-600">Add
                    Task</button>
            </form>
        </div>

        <!-- To-Do List Table -->
        <div class="overflow-x-auto shadow-md rounded-lg">
            <table class="min-w-full bg-white border border-gray-200">
                <thead class="bg-purple-600 text-white">
                    <tr>
                        <th class="py-3 px-6 text-left">Task</th>
                        <th class="py-3 px-6 text-left">Status</th>
                        <th class="py-3 px-6 text-center">Priority</th>
                        <th class="py-3 px-6 text-center">Due Date</th>
                        <th class="py-3 px-6 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody id="todo-table-body">
                    @foreach ($tasks as $task)
                        <tr data-id="{{ $task->id }}">
                            <td class="py-4 px-6 border-b border-gray-200 task-title">{{ $task->title }}</td>
                            <td class="py-4 px-6 border-b border-gray-200">
                                <select class="status-select border border-gray-300 rounded-lg p-2">
                                    <option value="Pending" {{ $task->status === 'Pending' ? 'selected' : '' }}>Pending
                                    </option>
                                    <option value="In Progress" {{ $task->status === 'In Progress' ? 'selected' : '' }}>
                                        In Progress</option>
                                    <option value="Completed" {{ $task->status === 'Completed' ? 'selected' : '' }}>
                                        Completed</option>
                                </select>
                            </td>
                            <td class="py-4 px-6 border-b border-gray-200 text-center">
                                <select class="priority-select border border-gray-300 rounded-lg p-2">
                                    <option value="Low" {{ $task->priority === 'Low' ? 'selected' : '' }}>Low
                                    </option>
                                    <option value="Medium" {{ $task->priority === 'Medium' ? 'selected' : '' }}>Medium
                                    </option>
                                    <option value="High" {{ $task->priority === 'High' ? 'selected' : '' }}>High
                                    </option>
                                </select>
                            </td>
                            <td class="py-4 px-6 border-b border-gray-200 text-center">
                                <input type="date" class="due-date border border-gray-300 rounded-lg p-2"
                                    value="{{ $task->due_date ? $task->due_date->format('Y-m-d') : '' }}">
                            </td>
                            <td class="py-4 px-6 border-b border-gray-200 text-center">
                                <button class="text-green-500 hover:text-green-700 mr-2" onclick="editTask(this)"
                                    title="Edit">
                                    <i class="fas fa-edit"></i>
                                    <span class="sr-only">Edit</span>
                                </button>
                                <button class="text-red-500 hover:text-red-700" onclick="deleteTask(this)"
                                    title="Delete">
                                    <i class="fas fa-trash-alt"></i>
                                    <span class="sr-only">Delete</span>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-4">
                <label for="progress-bar" class="block text-sm font-medium text-gray-700">Progress</label>
                <div class="w-full bg-gray-200 rounded-full">
                    <div id="progress-bar"
                        class="bg-purple-600 text-xs font-medium text-blue-100 text-center p-0.5 leading-none rounded-full"
                        style="width: 0%">0%</div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            // Define functions globally
            async function updateStatus(select) {
                const taskId = select.closest('tr').dataset.id;
                const status = select.value;
                console.log(`Updating status for task ${taskId} to ${status}`);
                try {
                    const response = await fetch(`/tasks/${taskId}`, {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ status: status })
                    });
                    const updatedTask = await response.json();
                    console.log('Server response:', updatedTask);
                    select.value = updatedTask.status;
                    updateProgress();
                } catch (error) {
                    console.error('Error updating status:', error);
                    alert('Failed to update status. Please try again.');
                }
            }

            async function updatePriority(select) {
                const taskId = select.closest('tr').dataset.id;
                const priority = select.value;
                console.log(`Updating priority for task ${taskId} to ${priority}`);
                try {
                    const response = await fetch(`/tasks/${taskId}`, {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ priority: priority })
                    });
                    const updatedTask = await response.json();
                    console.log('Server response:', updatedTask);
                    select.value = updatedTask.priority;
                } catch (error) {
                    console.error('Error updating priority:', error);
                    alert('Failed to update priority. Please try again.');
                }
            }

            async function updateDueDate(input) {
                const taskId = input.closest('tr').dataset.id;
                const dueDate = input.value;
                console.log(`Updating due date for task ${taskId} to ${dueDate}`);
                try {
                    const response = await fetch(`/tasks/${taskId}`, {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ due_date: dueDate })
                    });
                    const updatedTask = await response.json();
                    console.log('Server response:', updatedTask);
                    input.value = updatedTask.due_date ? new Date(updatedTask.due_date).toISOString().split('T')[0] : '';
                } catch (error) {
                    console.error('Error updating due date:', error);
                    alert('Failed to update due date. Please try again.');
                }
            }

            function updateProgress() {
                const todoTableBody = document.getElementById('todo-table-body');
                const tasks = todoTableBody.querySelectorAll('tr');
                const completedTasks = Array.from(tasks).filter(task => task.querySelector('.status-select').value === 'Completed');
                const progress = tasks.length ? (completedTasks.length / tasks.length) * 100 : 0;
                const progressBar = document.getElementById('progress-bar');
                progressBar.style.width = `${progress}%`;
                progressBar.textContent = `${Math.round(progress)}%`;
            }

            document.addEventListener('DOMContentLoaded', function() {
                const todoForm = document.getElementById('todo-form');
                const todoInput = document.getElementById('todo-input');
                const todoTableBody = document.getElementById('todo-table-body');

                // Function to attach event listeners to elements
                function attachEventListeners() {
                    document.querySelectorAll('.status-select').forEach(select => {
                        select.addEventListener('change', () => updateStatus(select));
                    });
                    document.querySelectorAll('.priority-select').forEach(select => {
                        select.addEventListener('change', () => updatePriority(select));
                    });
                    document.querySelectorAll('.due-date').forEach(input => {
                        input.addEventListener('change', () => updateDueDate(input));
                    });
                }

                // Attach listeners to existing tasks
                attachEventListeners();

                todoForm.addEventListener('submit', async function(event) {
                    event.preventDefault();
                    const task = todoInput.value.trim();
                    if (task) {
                        const response = await fetch('/tasks', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({ title: task })
                        });
                        const newTask = await response.json();

                        const dueDate = newTask.due_date ? new Date(newTask.due_date).toISOString().split('T')[0] : '';

                        const row = document.createElement('tr');
                        row.dataset.id = newTask.id;
                        row.innerHTML = `
                            <td class="py-4 px-6 border-b border-gray-200 task-title">${newTask.title}</td>
                            <td class="py-4 px-6 border-b border-gray-200">
                                <select class="status-select border border-gray-300 rounded-lg p-2">
                                    <option value="Pending" ${newTask.status === 'Pending' ? 'selected' : ''}>Pending</option>
                                    <option value="In Progress" ${newTask.status === 'In Progress' ? 'selected' : ''}>In Progress</option>
                                    <option value="Completed" ${newTask.status === 'Completed' ? 'selected' : ''}>Completed</option>
                                </select>
                            </td>
                            <td class="py-4 px-6 border-b border-gray-200 text-center">
                                <select class="priority-select border border-gray-300 rounded-lg p-2">
                                    <option value="Low" ${newTask.priority === 'Low' ? 'selected' : ''}>Low</option>
                                    <option value="Medium" ${newTask.priority === 'Medium' ? 'selected' : ''}>Medium</option>
                                    <option value="High" ${newTask.priority === 'High' ? 'selected' : ''}>High</option>
                                </select>
                            </td>
                            <td class="py-4 px-6 border-b border-gray-200 text-center">
                                <input type="date" class="due-date border border-gray-300 rounded-lg p-2" value="${dueDate}">
                            </td>
                            <td class="py-4 px-6 border-b border-gray-200 text-center">
                                <button class="text-green-500 hover:text-green-700 mr-2" onclick="editTask(this)" title="Edit">
                                    <i class="fas fa-edit"></i>
                                    <span class="sr-only">Edit</span>
                                </button>
                                <button class="text-red-500 hover:text-red-700" onclick="deleteTask(this)" title="Delete">
                                    <i class="fas fa-trash-alt"></i>
                                    <span class="sr-only">Delete</span>
                                </button>
                            </td>
                        `;
                        todoTableBody.appendChild(row);
                        todoInput.value = '';
                        attachEventListeners(); // Re-attach listeners to new elements
                        updateProgress();
                    }
                });

                window.editTask = function(button) {
                    console.log('Edit button clicked');
                    const row = button.closest('tr');
                    const taskCell = row.querySelector('.task-title');
                    const currentTask = taskCell.textContent;
                    const newTask = prompt('Edit task:', currentTask);
                    if (newTask !== null) {
                        taskCell.textContent = newTask.trim();
                        fetch(`/tasks/${row.dataset.id}`, {
                            method: 'PUT',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({ title: newTask.trim() })
                        }).then(response => {
                            console.log('Task updated:', response);
                        }).catch(error => {
                            console.error('Error updating task:', error);
                        });
                    }
                };

                window.deleteTask = async function(button) {
                    console.log('Delete button clicked');
                    if (!confirm('Are you sure you want to delete this task?')) {
                        return;
                    }
                    const row = button.closest('tr');
                    try {
                        const response = await fetch(`/tasks/${row.dataset.id}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                        });
                        console.log('Task deleted:', response);
                        row.remove();
                        updateProgress();
                    } catch (error) {
                        console.error('Error deleting task:', error);
                    }
                };

                // Initial progress update
                updateProgress();
            });
        </script>
    @endpush
</x-app-layout>
