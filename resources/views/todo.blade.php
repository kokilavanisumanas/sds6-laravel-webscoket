<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-Do List</title>

    <!-- Include Pusher and Laravel Echo JS from CDN -->
    <script src="https://cdn.jsdelivr.net/npm/pusher-js@7.0.3/dist/web/pusher.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/laravel-echo@1.10.0/dist/echo.iife.js"></script>

    <style>
        body {
            font-family: Arial, sans-serif;
        }
        #todo-list {
            margin-top: 20px;
        }
        .todo-item {
            padding: 8px;
            background-color: #f1f1f1;
            margin: 5px 0;
            border-radius: 5px;
        }
        #todo-content {
            padding: 8px;
            width: 300px;
        }
        #add-todo {
            padding: 8px 12px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div id="app">
        <h1>To-Do List</h1>

        <!-- Input field and button to add new todo -->
        <input type="text" id="todo-content" placeholder="Enter your to-do here" />
        <button id="add-todo">Add To-Do</button>

        <!-- Display list of todos here -->
        <div id="todo-list">
            <!-- To-do items will be dynamically appended here -->
        </div>
    </div>

    <script>
        // Initialize Laravel Echo with Pusher (No need for require)
        window.Pusher = Pusher;  // Assign the Pusher object globally
        window.Echo = new Echo({
 broadcaster: 'pusher',
    key: "c1cd5aa79bd5acc2e762",
    cluster: "ap2",
    encrypted: true,
        });

        // Listen for real-time updates using Laravel Echo and Pusher
        Echo.channel('todos')
            .listen('TodoCreated', (event) => {
                const todo = event.todo;
                const todoList = document.getElementById('todo-list');
                
                // Create a new list item
                const li = document.createElement('div');
                li.classList.add('todo-item');
                li.textContent = todo.content;
                
                // Append the new to-do item to the list
                todoList.appendChild(li);
            });

        // Add a new to-do item via AJAX when the button is clicked
        document.getElementById('add-todo').addEventListener('click', function() {
    const content = document.getElementById('todo-content').value;
    
    if (content.trim() !== '') {
        // Send the new to-do item to the server
        fetch('/todos', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
            },
            body: JSON.stringify({ content: content })
        })
        .then(response => {
            if (!response.ok) {
                // Handle non-successful response (e.g., 4xx or 5xx)
                throw new Error('Something went wrong with the request');
            }
            return response.json();
        })
        .then(data => {
            // Handle successful response
            console.log('To-do added:', data);
            document.getElementById('todo-content').value = ''; // Clear input field
        })
        .catch(error => {
            // Handle any error that occurred during fetch
            console.error('Error:', error);
        });
    } else {
        console.log('To-do content cannot be empty');
    }
});

    </script>
</body>
</html>
