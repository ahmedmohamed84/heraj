<x-app-layout>
    <div class="py-12 bg-gray-100">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <!-- Chat Header -->
            <div class="bg-white p-4 rounded-t-lg shadow-md border-b">
                <h1 class="text-xl font-bold text-gray-800">{{ __('Chat about') }} <a href="{{ route('services.show', $conversation->service) }}" class="text-blue-600 hover:underline">{{ $conversation->service->title }}</a></h1>
                <p class="text-sm text-gray-600">
                    @if ($conversation->buyer_id == Auth::id())
                        {{ __('With') }}: {{ $conversation->seller->name }}
                    @else
                        {{ __('With') }}: {{ $conversation->buyer->name }}
                    @endif
                </p>
            </div>

            <!-- Messages Area -->
            <div id="messages-container" class="bg-white shadow-md h-96 overflow-y-auto p-4 space-y-4">
                {{-- Messages will be loaded here by AJAX --}}
            </div>

            <!-- Reply Form -->
            <div class="bg-white p-4 rounded-b-lg shadow-md border-t">
                <form id="message-form" action="{{ route('messages.store.json', $conversation) }}" method="POST">
                    @csrf
                    <div class="flex items-center">
                        <textarea name="body" id="message-body" class="flex-grow border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" rows="1" placeholder="{{ __('Type your message...') }}" required></textarea>
                        <button type="submit" class="ml-3 inline-flex items-center justify-center px-4 py-2 bg-blue-500 text-white font-bold rounded-md hover:bg-blue-600 transition">
                            {{ __('Send') }}
                        </button>
                    </div>
                    @error('body')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const messagesContainer = document.getElementById('messages-container');
            const messageForm = document.getElementById('message-form');
            const messageBody = document.getElementById('message-body');
            const conversationId = '{{ $conversation->id }}';
            const currentUserId = '{{ Auth::id() }}';
            let lastMessageId = 0;

            // Function to render messages
            function renderMessages(messages) {
                messages.forEach(message => {
                    // Avoid rendering the same message twice
                    if (document.querySelector(`[data-message-id='${message.id}']`)) {
                        return;
                    }

                    const messageWrapper = document.createElement('div');
                    messageWrapper.className = `flex ${message.user_id == currentUserId ? 'justify-end' : 'justify-start'}`;
                    messageWrapper.setAttribute('data-message-id', message.id);


                    const messageBubble = document.createElement('div');
                    messageBubble.className = `max-w-xs lg:max-w-md px-4 py-2 rounded-lg ${message.user_id == currentUserId ? 'bg-blue-500 text-white' : 'bg-gray-200 text-gray-800'}`;
                    
                    const messageText = document.createElement('p');
                    messageText.className = 'text-sm';
                    messageText.textContent = message.body;

                    const messageTime = document.createElement('p');
                    messageTime.className = `text-xs mt-1 ${message.user_id == currentUserId ? 'text-blue-200' : 'text-gray-500'}`;
                    const date = new Date(message.created_at);
                    messageTime.textContent = date.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });

                    messageBubble.appendChild(messageText);
                    messageBubble.appendChild(messageTime);
                    messageWrapper.appendChild(messageBubble);
                    messagesContainer.appendChild(messageWrapper);

                    lastMessageId = Math.max(lastMessageId, message.id);
                });
                // Scroll to bottom only if the user is near the bottom
                if (messagesContainer.scrollHeight - messagesContainer.scrollTop < messagesContainer.clientHeight + 100) {
                    messagesContainer.scrollTop = messagesContainer.scrollHeight;
                }
            }

            // Function to fetch messages
            async function fetchMessages(isInitial = false) {
                try {
                    // Use the route() helper to generate the base URL.
                    let url = "{{ route('conversations.messages.json', $conversation) }}";

                    // For polling, we only get messages 'since' the last one we received.
                    if (!isInitial && lastMessageId > 0) {
                        url += `?since=${lastMessageId}`;
                    }

                    const response = await fetch(url);
                    if (!response.ok) {
                        throw new Error(`Network response was not ok (${response.status})`);
                    }
                    const messages = await response.json();
                    if (messages.length > 0) {
                        renderMessages(messages);
                    }
                } catch (error) {
                    console.error('Error fetching messages:', error);
                }
            }

            // Handle form submission
            messageForm.addEventListener('submit', async function (e) {
                e.preventDefault();
                const formData = new FormData(this);
                const body = formData.get('body').trim();

                if (!body) return;

                try {
                    const response = await fetch(this.action, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json',
                        },
                        body: formData
                    });

                    if (!response.ok) {
                        const errorData = await response.json();
                        console.error('Failed to send message:', errorData);
                        alert('Error: ' + (errorData.message || 'Could not send message.'));
                        return;
                    }
                    
                    // Don't re-render the message we sent. The polling will pick it up.
                    // This prevents duplicate messages if the polling interval is fast.
                    messageBody.value = '';
                    messageBody.focus();
                    
                    // We can optionally fetch immediately after sending for a faster feel
                    setTimeout(fetchMessages, 100);


                } catch (error) {
                    console.error('Error sending message:', error);
                    alert('An unexpected error occurred.');
                }
            });

            // Initial fetch and polling
            fetchMessages(true); // Fetch all messages on page load
            setInterval(fetchMessages, 10000); // Poll for new messages every 3 seconds
        });
    </script>
    @endpush
</x-app-layout>
