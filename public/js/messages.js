function filterChats() {
    const input = document.getElementById('searchInput').value.toLowerCase();

    // recorremos todos los elementos de chat
    document.querySelectorAll('.chat-item').forEach(item => {
        // busca el nombre del chat en el elemento 
        const nameElement = item.querySelector('strong') || item.querySelector('a');
        const name = nameElement?.textContent?.toLowerCase() || '';

        // muestra u ocultamos el chat 
        item.style.display = name.includes(input) ? '' : 'none';
    });
}
