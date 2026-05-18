# Instruções para rodar este projeto
> **Atenção (Usuários Windows)**
> Antes de começar, certifique-se de que o arquivo `docker/php/start-container.sh` está configurado para usar quebras de linha **LF** (e não CRLF). Caso contrário, o container PHP não vai iniciar.
1. **Arquivo .env**
```bash
cp .env.example .env
```
2. **Subir os containers:**
```bash
docker compose up --build -d
```
3. **Acessar a aplicação:**
http://localhost:8080
## Vite / Hot Reload
Para trabalhar editando os arquivos de CSS (Sass), fontes ou JavaScript e ver as alterações atualizarem na hora no navegador, mantenha este comando rodando em um terminal separado:
```bash
docker compose exec php npm run dev
```
