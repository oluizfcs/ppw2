document.getElementById('container-paginar').addEventListener('click', function (e) {
    const link = e.target.closest('.page-link');

    if (link && link.getAttribute('href')) {
        e.preventDefault(); // impede a página de recarregar

        const url = link.getAttribute('href');
        fetchPage(url);
    }
});

async function fetchPage(url) {
    try {
        const response = await fetch(url, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        });

        if (response.ok) {
            const html = await response.text();
            document.getElementById('container-paginar').innerHTML = html;

            // atualiza a URL do navegador sem recarregar a página
            window.history.pushState({}, '', url);
        }
    } catch (error) {
        console.error('Erro ao paginar:', error);
    }
}

