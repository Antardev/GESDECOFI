@extends('welcome')

@section('content')
    @if (auth()->check())
        <div id="chat-button" style="position: fixed; bottom: 30px; right: 30px; z-index: 1000;">
            <button class="btn btn-primary rounded-circle p-3" style="box-shadow: 0 4px 8px rgba(0,0,0,0.2);"
                onclick="openChat()">
                <i class="align-middle" data-feather="message-circle" style="font-size: 2rem;"></i>
            </button>
            @php $unreadCount = auth()->user()->unreadNotifications->count(); @endphp
            @if ($unreadCount > 0)
                <span id="unread-count" class="badge bg-danger rounded-pill position-absolute top-0 start-100 translate-middle"
                    style="display: block;">{{ $unreadCount }}</span>
            @else
                <span id="unread-count" class="badge bg-danger rounded-pill position-absolute top-0 start-100 translate-middle"
                    style="display: none;"></span>
            @endif
            {{-- <span id="unread-count"
                class="badge bg-danger rounded-pill position-absolute top-0 start-100 translate-middle">0</span> --}}
        </div>

        <!-- Fenêtre de chat -->
        <div id="chat-window"
            style="display: none; position: fixed; bottom: 100px; right: 30px; width: 350px; height: 450px; 
                                    background: white; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.2); z-index: 1000;">
            <div class="chat-header bg-primary text-white p-3 rounded-top"
                style="display: flex; justify-content: space-between; align-items: center;">
                <h6 class="mb-0">Chat en direct</h6>
                <button class="btn btn-sm btn-light" onclick="closeChat()">
                    <i class="align-middle" data-feather="x"></i>
                </button>
            </div>
            <div class="chat-body p-3" style="height: 300px; overflow-y: auto; background: #f8f9fa;">
                <button id="load-more" class="btn btn-link" onclick="loadMoreMessages()" style="display: none;">Voir messages
                    précédents</button>
                <div id="chat-messages" class="chat-messages"></div>
                <button id="load-previous" class="btn btn-link" onclick="loadPreviousMessages()" style="display: none;">Charger
                    plus de messages</button>
            </div>
            <div class="chat-footer p-3" style="border-top: 1px solid #eee;">
                <form id="chat-form" onsubmit="sendMessage(event)">
                    <div class="input-group">
                        <input type="text" id="message-input" class="form-control" placeholder="Tapez votre message..."
                            required>
                        <input type="text" id="receiver" class="form-control" value="1" hidden required>
                        <button class="btn btn-primary" type="submit">
                            <i class="align-middle" data-feather="send"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <div class="hero-section" style="position: relative; text-align: center; height: calc(100vh - 60px); overflow: hidden;">
        <img src="{{ asset('assets/img/1.png') }}" alt="Bienvenue"
            style="width: 100%; height: 100%; max-height: 600px; object-fit: cover;">
        <div
            style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); color: white; background-color: rgba(0, 0, 0, 0.5); padding: 20px; border-radius: 10px;">
            <h1 style="font-size: 2.5rem; margin-bottom: 1rem; color: white;">{{__('message.welcome_to_platform')}}</h1>
            <p style="font-size: 1.2rem; color: grey">{{__('message.discover_services')}}</p>
            <button class="btn btn-primary" style="margin-top: 20px;"> <a href="{{ route('register') }}"
                    style="color: white; text-decoration: none;">{{__('message.discover')}}</a></button>
            <button class="btn btn-primary" style="margin-top: 20px;"> <a href="{{route('Liste_stagiaire_acceuil')}}"
                    style="color: white; text-decoration: none;">Liste des stagiaires </a></button>
        </div>
    </div>

    @foreach (['not_found', 'access'] as $errorType)
        @if($errors->has($errorType))
            <div class="toast align-items-center text-white bg-danger bg-opacity-75 border-0 position-fixed top-50 start-50 translate-middle fade show"
                role="alert" style="z-index: 1000; backdrop-filter: blur(2px);">
                <div class="d-flex">
                    <div class="toast-body">
                        {{ $errors->first($errorType) }}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                        aria-label="Close"></button>
                </div>
            </div>
        @endif
    @endforeach

    @if(session('success'))
        <div class="toast-container position-fixed top-50 start-50 translate-middle p-3">
            <div class="toast show" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header">
                    <strong class="me-auto">Succès</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">
                    {{ session('success') }}
                </div>
            </div>
        </div>
    @endif
    <style>
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

    <script>
        let currentPage = 0;

    //     function openChat() {
    //         fetch('/mark-notifications-as-read', {
    //     method: 'POST',
    //     headers: {
    //         'Content-Type': 'application/json',
    //         'X-CSRF-TOKEN': '{{ csrf_token() }}'
    //     },
    //     body: JSON.stringify({
    //         user_id: {{ auth()->id() }}
    //     })
    // })
    // .then(response => response.json())
    // .then(data => {
    //     // 2. Masquer le badge après la requête réussie
    //     document.getElementById('unread-count').style.display = 'none';
    //     document.getElementById('unread-count').textContent = '0';
        
    //     // 3. Ouvrir le chat (votre fonction existante)
    //     // ... votre code existant pour ouvrir le chat ...
    // })
    // .catch(error => {
    //     console.error('Error:', error);
    // });

    //         document.getElementById('chat-window').style.display = 'block';
    //         loadMessages();
    //     }
    function openChat() {
    // Marquer les notifications comme lues (sans attendre la réponse)
    fetch('/mark-notifications-as-read', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ user_id: {{ auth()->id() }} })
    })
    .then(() => {
        const badge = document.getElementById('unread-count');
        if (badge) {
            badge.style.display = 'none';
            badge.textContent = '0';
        }
    })
    .catch(console.error);

    // Ouvrir immédiatement le chat
    const chatWindow = document.getElementById('chat-window');
    if (chatWindow) {
        chatWindow.style.display = 'block';
    }
    loadMessages().catch(console.error);
}

        function closeChat() {
            document.getElementById('chat-window').style.display = 'none';
        }

        function loadMessages() {
            fetch(`http://192.168.100.146:8001/chat/messages?page=${currentPage}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Erreur réseau : ' + response.statusText);
                    }
                    return response.json();
                })
                .then(messages => {
                    const container = document.getElementById('chat-messages');
                    container.innerHTML = '';

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

                    // Afficher le bouton "Voir messages précédents" si plus de messages sont disponibles
                    document.getElementById('load-previous').style.display = messages.prev_page_url ? 'block' : 'none';
                    // Afficher le bouton "Charger plus de messages" si plus de messages récents sont disponibles
                    document.getElementById('load-more').style.display = messages.next_page_url ? 'block' : 'none';

                    container.scrollTop = container.scrollHeight;
                })
                .catch(error => console.error('Erreur lors du chargement des messages:', error));
        }

        function loadPreviousMessages() {
            if (currentPage > 1) {
                currentPage--;
                loadMessages();
            }
        }

        function loadMoreMessages() {
            currentPage++;
            loadMessages();
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
                    loadMessages(); // Recharger les messages
                });
        }

        // Pour les notifications en temps réel (si vous utilisez Laravel Echo)
        @auth
            window.Echo.private(`chat.{{ auth()->id() }}`)
                .listen('MessageSent', (e) => {
                    const unreadBadge = document.getElementById('unread-count');
                    unreadBadge.style.display = 'block';
                    unreadBadge.textContent = parseInt(unreadBadge.textContent || 0) + 1;

                    // Si le chat est ouvert, afficher le message
                    if (document.getElementById('chat-window').style.display === 'block') {
                        loadMessages();
                    }
                });
        @endauth

    </script>

@endsection