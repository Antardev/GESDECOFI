@extends('welcome')

@section('title', 'Messages reçus')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">
                            <i class="fas fa-inbox me-2"></i>Messages reçus
                        </h4>
                        <span class="badge bg-white text-primary">{{ $messages->count() }} message(s)</span>
                    </div>
                </div>
                <div class="card-body p-0">
                    @if($messages->isEmpty())
                        <div class="text-center py-5">
                            <i class="fas fa-envelope-open-text fa-4x text-muted mb-3"></i>
                            <h5 class="text-muted">Aucun message reçu</h5>
                        </div>
                    @else
                        <div class="list-group list-group-flush">
                            @foreach($messages as $message)
                                <a class="list-group-item list-group-item-action {{ $message->readed ? '' : 'bg-light' }}" id="message-{{ $message->id }}">
                                    <div class="d-flex w-100 justify-content-between">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar bg-info text-white rounded-circle d-flex align-items-center justify-content-center me-3" 
                                                 style="width: 40px; height: 40px;">
                                                {{ strtoupper(substr($message->user_name, 0, 1)) }}
                                            </div>
                                            <div>
                                                <h6 class="mb-1">{{ $message->user_name }}</h6>
                                                <p class="mb-1 text-truncate" style="max-width: 500px;" id="message-content-{{ $message->id }}">
                                                    {{ $message->content }}
                                                </p>
                                            </div>
                                        </div>
                                        <div class="text-end">
                                            <small class="text-muted">{{ $message->created_at->diffForHumans() }}</small>
                                            @if(!$message->lu)
                                                <span class="badge bg-primary ms-2">Nouveau</span>
                                            @endif
                                        </div>
                                        <div class="ms-3">
                                            <button class="btn btn-sm btn-outline-primary" 
                                                    onclick="openChat({{ $message->other_id }}, '{{ $message->user_name }}')">
                                                <i class="align-middle" data-feather="message-square"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-danger" 
                                                    onclick="deleteMessage({{ $message->id }})">
                                                <i class="align-middle" data-feather="trash-2"></i>
                                            </button>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>
                
                @if($messages->hasPages())
                <div class="card-footer bg-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <select class="form-select form-select-sm" style="width: 80px;">
                                <option>10</option>
                                <option>25</option>
                                <option>50</option>
                            </select>
                        </div>
                        {{ $messages->links() }} <!-- Pagination -->
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<div id="chat-window" style="display: none; position: fixed; bottom: 100px; right: 30px; width: 350px; height: 450px; 
                            background: white; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.2); z-index: 1000;">
    <div class="chat-header bg-primary text-white p-3 rounded-top" 
         style="display: flex; justify-content: space-between; align-items: center;">
        <h6 class="mb-0" id="user_name_field">Chat en direct</h6>
        <button class="btn btn-sm btn-light" onclick="closeChat()">
            <i class="align-middle" data-feather="x"></i>
        </button>
    </div>
    <div class="chat-body p-3" style="height: 300px; overflow-y: auto; background: #f8f9fa;">
        <button id="load-more" class="btn btn-link" onclick="loadMoreMessages()" style="display: none;">Voir messages précédents</button>
        <div id="chat-messages" class="chat-messages"></div>
        <button id="load-previous" class="btn btn-link" onclick="loadPreviousMessages()" style="display: none;">Charger plus de messages</button>
    </div>
    <div class="chat-footer p-3" style="border-top: 1px solid #eee;">
        <form id="chat-form" onsubmit="sendMessage(event)">
            <div class="input-group">
                <input type="text" id="message-input" class="form-control" placeholder="Tapez votre message..." required>
                <input type="text" id="receiver" class="form-control" value="1" hidden required>
                <button class="btn btn-primary" type="submit">
                    <i class="align-middle" data-feather="send"></i>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts_down')
<script>
    const my_id = <?php echo json_encode($my_id); ?>;
    let currentPage = 1;

    function openChat(user_id, user_name) {
        document.getElementById('chat-window').style.display = 'block';
        document.getElementById('user_name_field').textContent = user_name;
        document.getElementById('receiver').value = user_id;
        loadMessages(user_id);
    }

    function closeChat() {
        document.getElementById('chat-window').style.display = 'none';
    }

    function loadMessages(id) {
        fetch(`http://192.168.100.146:8001/chat/messages/${id}?page=${currentPage}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Erreur réseau : ' + response.statusText);
                }
                return response.json();
            })
            .then(messages => {
                const container = document.getElementById('chat-messages');
                container.innerHTML = ''; // Vider le conteneur avant d'ajouter les nouveaux messages

                messages.data.reverse().forEach(msg => {
                    const isSender = msg.sender_id === {{ auth()->id() }};
                    container.innerHTML += `
                        <div class="mb-2 ${isSender ? 'text-end' : ''}">
                            <div class="d-inline-block p-2 rounded ${isSender ? 'bg-primary text-white' : 'bg-light'}">
                                ${msg.content}
                            </div>
                            <small class="d-block text-muted">${new Date(msg.created_at).toLocaleTimeString()}</small>
                        </div>
                    `;
                });

                // Afficher les boutons de navigation
                document.getElementById('load-previous').style.display = messages.prev_page_url ? 'block' : 'none';
                document.getElementById('load-more').style.display = messages.next_page_url ? 'block' : 'none';

                container.scrollTop = container.scrollHeight; // Faire défiler vers le bas
            })
            .catch(error => console.error('Erreur lors du chargement des messages:', error));
    }

    function loadPreviousMessages() {
        if (currentPage > 1) {
            currentPage--;
            loadMessages(document.getElementById('receiver').value);
        }
    }

    function loadMoreMessages() {
        currentPage++;
        loadMessages(document.getElementById('receiver').value);
    }

    function sendMessage(e) {
        e.preventDefault();
        const input = document.getElementById('message-input');
        const input2 = document.getElementById('receiver');

        const message = input.value;
        const recipientId = input2.value;

        fetch('http://192.168.100.146:8001/chat/send', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ message: message, receiver_id: recipientId })
        })
        .then(() => {
            input.value = '';
            loadMessages(recipientId); 
        });
    }

    // Pour les notifications en temps réel (si vous utilisez Laravel Echo)
    @auth
    window.Echo.private(`chat.{{ auth()->id() }}`)
        .listen('MessageSent', (e) => {
            const unreadBadge = document.getElementById('unread-count');
            unreadBadge.style.display = 'block';
            unreadBadge.textContent = parseInt(unreadBadge.textContent || 0) + 1;

            // Mettre à jour le contenu du message
            const messageId = e.message.id; 
            const messageContent = e.message.content; 

            // Vérifiez si le message existe déjà
            const messageElement = document.getElementById(`message-${messageId}`);
            if (messageElement) {
                document.getElementById(`message-content-${messageId}`).innerText = messageContent;
            } else {
                // Optionnel : Ajouter le message à la liste si ce n'est pas déjà présent
                // Vous pouvez charger à nouveau la liste des messages si nécessaire
                loadMessages(my_id);
            }

            // Si le chat est ouvert, afficher le message
            if (document.getElementById('chat-window').style.display === 'block') {
                loadMessages(my_id);
            }
        });
    @endauth
</script>
@endsection

@section('styles')
<style>
    .avatar {
        font-weight: 600;
    }
    .list-group-item:hover {
        background-color: #f8f9fa;
    }
    .text-truncate {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .card-header {
        border-radius: 0.375rem 0.375rem 0 0 !important;
    }
    #chat-button:hover {
        transform: scale(1.1);
        transition: transform 0.3s;
    }
    .chat-body {
        scrollbar-width: thin;
        scrollbar-color: #007bff #f8f9fa;
    }
    .chat-body::-webkit-scrollbar {
        width: 8px;
    }
    .chat-body::-webkit-scrollbar-thumb {
        background-color: #007bff;
        border-radius: 4px;
    }
    #chat-messages {
        display: flex;
        flex-direction: column;
        gap: 10px;
        padding: 15px;
    }
    .message {
        max-width: 70%;
        padding: 8px 12px;
        border-radius: 12px;
        position: relative;
    }
    .message.sent {
        align-self: flex-start;
        background: #007bff;
        color: white;
        border-bottom-left-radius: 0;
    }
    .message.received {
        align-self: flex-end;
        background: #f1f1f1;
        color: #333;
        border-bottom-right-radius: 0;
    }
    .sender-name {
        display: block;
        font-weight: bold;
        font-size: 0.8em;
        margin-bottom: 4px;
        color: #555;
    }
    .message-time {
        display: block;
        font-size: 0.7em;
        text-align: right;
        margin-top: 4px;
        opacity: 0.8;
    }
    .message-content {
        margin: 5px 0;
    }
</style>
@endsection