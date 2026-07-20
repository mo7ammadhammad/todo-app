<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Advanced Todo App</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
        }

        body{
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #4a3f7a, #2b2254);
            min-height:100vh;
            display:flex;
            justify-content:center;
            align-items:center;
            padding:20px;
        }

        .container{
            width:100%;
            max-width:550px;
            background:#f0f2f5;
            border-radius:35px;
            padding:35px;
            box-shadow:0 25px 50px rgba(0,0,0,0.3);
            border: 1px solid rgba(255,255,255,0.1);
            position: relative;
        }

        .logout-wrapper {
            display: flex;
            justify-content: flex-start;
            margin-bottom: 15px;
        }

        .logout-link {
            color: #f87171;
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            transition: 0.3s;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .logout-link:hover {
            color: #f44336;
        }

        .header-title {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            margin-bottom: 30px;
        }

        h1{
            text-align:center;
            color:#1e293b;
            font-size: 32px;
            font-weight: 800;
        }

        /* ===== Search Bar ===== */
        .search-form {
            display: flex;
            align-items: center;
            background: #e2e8f0;
            border-radius: 50px;
            padding: 6px 6px 6px 16px;
            margin-bottom: 20px;
            box-shadow: inset 0 2px 4px rgba(0,0,0,0.06);
        }

        .search-form input {
            flex: 1;
            background: transparent;
            border: none;
            outline: none;
            padding: 8px;
            font-size: 14px;
            color: #475569;
        }

        .search-form i {
            color: #94a3b8;
            margin-left: 8px;
        }

        .search-btn {
            background: #4a3f7a;
            color: white;
            border: none;
            padding: 8px 18px;
            border-radius: 50px;
            cursor: pointer;
            font-size: 13px;
            font-weight: 600;
            transition: 0.3s;
        }

        .search-btn:hover {
            background: #3b3263;
        }

        /* ===== Add Form ===== */
        .add-form{
            display:flex;
            background: white;
            border-radius: 50px;
            padding: 6px 6px 6px 16px;
            margin-bottom: 25px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
            border: 1px solid #e2e8f0;
            align-items: center;
        }

        .add-form input{
            flex:1;
            padding: 8px;
            border: none;
            font-size:15px;
            outline:none;
            background: transparent;
            color: #333;
        }

        .add-btn{
            background:#e2e8f0;
            color:#1e293b;
            border:none;
            padding:10px 24px;
            border-radius:50px;
            cursor:pointer;
            font-weight: 700;
            font-size: 14px;
            transition:0.3s;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }

        .add-btn:hover{
            background: #cbd5e1;
        }

        /* ===== Tasks Box (Dark UI) ===== */
        .tasks-wrapper {
            background: #1e2538;
            border-radius: 25px;
            padding: 20px;
            box-shadow: inset 0 2px 8px rgba(0,0,0,0.2);
        }

        ul{
            list-style:none;
        }

        li{
            background:#283149;
            padding:16px;
            border-radius:16px;
            margin-bottom:12px;
            display:flex;
            justify-content:space-between;
            align-items:center;
            cursor:grab;
            transition: 0.2s ease;
            border: 1px solid rgba(255, 255, 255, 0.03);
        }

        li:last-child {
            margin-bottom: 0;
        }

        li:hover{
            background: #2d3752;
            border-color: rgba(255,255,255,0.08);
        }

        li.dragging{
            opacity:0.4;
            transform:scale(0.98);
            background: #1a2030;
        }

        .task{
            font-size:15px;
            color:#f1f5f9;
            font-weight:500;
            letter-spacing: 0.5px;
        }

        .actions{
            display:flex;
            gap:8px;
        }

        .edit-btn,
        .delete-btn{
            border:none;
            padding:8px 16px;
            border-radius:10px;
            cursor:pointer;
            color:white;
            text-decoration:none;
            font-size:12px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 6px;
            transition:0.3s;
        }

        .edit-btn{
            background: rgba(33, 150, 243, 0.15);
            color: #60a5fa;
        }

        .edit-btn:hover{
            background:#2196F3;
            color: white;
        }

        .delete-btn{
            background: rgba(244, 67, 54, 0.15);
            color: #f87171;
        }

        .delete-btn:hover{
            background:#f44336;
            color: white;
        }

        .drag-icon{
            color:#64748b;
            font-size:16px;
            cursor: move;
            transition: 0.2s;
        }
        
        li:hover .drag-icon {
            color: #94a3b8;
        }

        /* ===== Modal ===== */
        .modal{
            position:fixed;
            inset:0;
            background:rgba(15, 23, 42, 0.6);
            backdrop-filter: blur(4px);
            display:none;
            justify-content:center;
            align-items:center;
            animation:fadeIn 0.3s ease;
            z-index: 999;
        }

        .modal-content{
            background:white;
            width:100%;
            max-width:400px;
            padding:30px;
            border-radius:24px;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
            animation:slideDown 0.3s ease;
        }

        .modal-content h2{
            margin-bottom:20px;
            color: #1e293b;
            font-size: 20px;
            font-weight: 700;
        }

        .modal-content input{
            width:100%;
            padding:14px;
            border:1px solid #cbd5e1;
            border-radius:12px;
            margin-bottom:20px;
            font-size: 15px;
            outline: none;
        }
        
        .modal-content input:focus {
            border-color: #4a3f7a;
        }

        .modal-buttons{
            display:flex;
            justify-content:flex-end;
            gap:10px;
        }

        .update-btn{
            background:#4a3f7a;
            color:white;
            border:none;
            padding:10px 20px;
            border-radius:10px;
            font-weight: 600;
            cursor:pointer;
            transition: 0.2s;
        }

        .update-btn:hover {
            background: #3b3263;
        }

        .cancel-btn{
            background:#e2e8f0;
            color: #475569;
            border:none;
            padding:10px 20px;
            border-radius:10px;
            font-weight: 600;
            cursor:pointer;
            transition: 0.2s;
        }
        
        .cancel-btn:hover {
            background: #cbd5e1;
        }

        @keyframes fadeIn{
            from{opacity:0;}
            to{opacity:1;}
        }

        @keyframes slideDown{
            from{
                transform:translateY(-30px);
                opacity:0;
            }
            to{
                transform:translateY(0);
                opacity:1;
            }
        }
    </style>
</head>

<body>
 
<div class="container">
    
    <div class="logout-wrapper">
        <a href="/logout" class="logout-link">
            <i class="fa-solid fa-right-from-bracket"></i> تسجيل الخروج
        </a>
    </div>

    <!-- Search Task -->
    <form action="/" method="GET" class="search-form">
        <i class="fa-solid fa-magnifying-glass"></i>
        <input
            type="text"
            name="search"
            placeholder="Search task..."
            value="{{ request('search') }}"
        >
        <button class="search-btn" type="submit">
            Search
        </button>
    </form>

    <!-- Header Title -->
    <div class="header-title">
        <span style="font-size: 32px;">🚀</span>
        <h1>Advanced Todo</h1>
    </div>

    <!-- Add Task Form -->
    <form class="add-form" action="/store" method="POST">
        @csrf
        <input
            type="text"
            name="task"
            placeholder="Enter task..."
            required
        >
        <button class="add-btn" type="submit">
            Add
        </button>
    </form>
    
    <div class="tasks-wrapper">
        <ul id="taskList">
            @if(empty($tasks))
                <div style="text-align: center; color: #94a3b8; padding: 20px 0; font-style: italic; font-size: 14px;">
                    ✨ لا توجد ملاحظات حالياً. أضف مهمتك الأولى!
                </div>
            @else
                @foreach($tasks as $id => $task)
                    @if(is_array($task) && isset($task['task']))
                        <li draggable="true">
                            <div style="display:flex; align-items:center; gap:12px;">
                                <span class="drag-icon"><i class="fa-solid fa-bars"></i></span>
                                <span class="task">
                                    {{ $task['task'] }}
                                </span>
                            </div>

                            <div class="actions">
                                <button
                                    class="edit-btn"
                                    onclick="openModal('{{ $id }}', this)"
                                >
                                    <i class="fa-regular fa-pen-to-square"></i> Edit
                                </button>

                                <a
                                    class="delete-btn"
                                    href="/delete/{{ $id }}"
                                >
                                    <i class="fa-regular fa-trash-can"></i> Delete
                                </a>
                            </div>
                        </li>
                    @endif
                @endforeach
            @endif
        </ul>
    </div>
</div>

<!-- ===== Modal ===== -->
<div class="modal" id="modal">
    <div class="modal-content">
        <h2>✏️ Edit Task</h2>
        <form id="editForm" method="POST">
            @csrf
            @method('PATCH')
            <input
                type="text"
                name="task"
                id="editInput"
                required
            >
            <div class="modal-buttons">
                <button
                    type="button"
                    class="cancel-btn"
                    onclick="closeModal()"
                >
                    Cancel
                </button>
                <button
                    type="submit"
                    class="update-btn"
                >
                    Update
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // ===== Modal =====
    function openModal(id, buttonElement){
        document.getElementById('modal').style.display = 'flex';
        
        const taskText = buttonElement.closest('li').querySelector('.task').innerText.trim();
        
        document.getElementById('editInput').value = taskText;
        document.getElementById('editForm').action = "/update/" + id;
    }

    function closeModal(){
        document.getElementById('modal').style.display = 'none';
    }

    // ===== Drag & Drop =====
    const taskList = document.getElementById('taskList');
    let draggedItem = null;

    function setupDragAndDrop() {
        const items = document.querySelectorAll('#taskList li');

        items.forEach(item => {
            item.addEventListener('dragstart', () => {
                draggedItem = item;
                setTimeout(() => {
                    item.classList.add('dragging');
                }, 0);
            });

            item.addEventListener('dragend', () => {
                item.classList.remove('dragging');
            });
        });
    }

    if (taskList) {
        taskList.addEventListener('dragover', (e) => {
            e.preventDefault();
            const afterElement = getDragAfterElement(taskList, e.clientY);
            if(draggedItem) {
                if(afterElement == null){
                    taskList.appendChild(draggedItem);
                }else{
                    taskList.insertBefore(draggedItem, afterElement);
                }
            }
        });
    }

    function getDragAfterElement(container, y){
        const draggableElements = [...container.querySelectorAll('li:not(.dragging)')];

        return draggableElements.reduce((closest, child) => {
            const box = child.getBoundingClientRect();
            const offset = y - box.top - box.height / 2;

            if(offset < 0 && offset > closest.offset){
                return {
                    offset: offset,
                    element: child
                };
            }else{
                return closest;
            }
        }, {
            offset: Number.NEGATIVE_INFINITY
        }).element;
    }

    setupDragAndDrop();
</script>

</body>
</html>
