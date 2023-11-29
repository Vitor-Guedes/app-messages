<?php

// TODO: Lista de implementações
// [x] Mover para controllers
// [ ] Gerenciamento das mensagens colocar em model
// [ ] Aplicar estrategia para usar arquivos, ou bancos de dados e ou filas
// [x] Abstrair Stream Response
// [x] Abstrar a obtenção dos dados do POST json
// FIXME [ ] Primeira mensagem não é exibida

use App\Messages\Controllers\MessageController;

$app->get('/', [MessageController::class, 'index']);

$app->post('/sendMessages', [MessageController::class, 'sendMessage']);

$app->get('/getAllMessages', [MessageController::class, 'getAllMessages']);

$app->get('/serverSentEvents', [MessageController::class, 'serverSentEvent']);