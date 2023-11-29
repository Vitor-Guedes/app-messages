<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Index</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body class="text-bg-dark">

    <div class="container-fluid mx-auto px-3">

        <div class="row">

            <div class="col-3" id="customer_1">
                <h1>Customer 1</h1>
                <div class="mb-3">
                    <label for="message_1" class="form-label">Escreva sua mensagem</label>
                    <input type="text" class="form-control" id="message_1" placeholder="Mensagem ...">
                </div>
                <button class="btn btn-success" id="1" onclick="sendMessage(this.id)">enviar</button>
            </div>

            <div class="col-6 text-center" id="container-message">
                <h1>Mensagens</h1>
                <div class="container" id="messages"></div>
            </div>

            <div class="col-3" id="customer_2">
                <h1>Customer 2</h1>
                <div class="mb-3">
                    <label for="message_2" class="form-label">Escreva sua mensagem</label>
                    <input type="text" class="form-control" id="message_2" placeholder="Mensagem ...">
                </div>
                <button class="btn btn-success" id="2" onclick="sendMessage(this.id)">enviar</button>
            </div>

        </div>
    
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script>
        var sse = new EventSource('/sse.php');

        sse.addEventListener('new_message', function (event) {
            var container = document.querySelector('#messages');

            var messages = JSON.parse(event.data);
            Array.from(messages).forEach(message => {
                var html = baseHtmlMessage(message['user_id'], message['message']);
                container.appendChild(html.querySelector('div.row'));
            });
        });

        document.addEventListener('DOMContentLoaded', function () {
            var container = document.querySelector('#messages');
            if (container.childNodes.length == 0) {
                fetch('/getAllMessages.php', {
                    method: "GET"
                }).then(response => {
                    return response.json()
                }).then(response => {
                    Array.from(response).forEach(message => {
                        var html = baseHtmlMessage(message['user_id'], message['message']);
                        container.appendChild(html.querySelector('div.row'));
                    });
                });
            }
        });

        var sendMessage = function (id) {
            var input = document.querySelector('#message_' + id);
            fetch('/sendMessage.php', {
                method: "POST",
                body: JSON.stringify({
                    user_id: id,
                    message: input.value
                }),
                headers: {
                    "Content-Type": "application/json"
                }
            }).then(response => {
                console.log(response);
            });

            input.value = '';
        }

        var baseHtmlMessage = function (id = '1', message) {
            var sides = {
                '1': 'justify-content-start',
                '2': 'justify-content-end'
            };

            var side = sides[id];

            var html = `<div class="row d-flex :side mb-2">
                        <div class="col-8 border rounded p-2 text-bg-secondary">
                            <span>:message</span>
                        </div>
                    </div>`;

            var htmlFinal = html.replace(':side', side).replace(':message', message);
            
            var parser = new DOMParser();
            return parser.parseFromString(htmlFinal, 'text/html');
        }
    </script>
</body>
</html>