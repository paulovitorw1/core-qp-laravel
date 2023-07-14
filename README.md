# Core-qp-laravel

## Instalação

1. Clone o repositório do projeto:
     ```shell
    git clone https://github.com/paulovitorw1/core-plan-marketing.git
    ```
2. Instale as dependências do projeto:
   ```shell
    composer install
   ```
3. Copie o arquivo de configuração .env:
     ```shell
        cp .env.example .env
      ```
4. Configure o arquivo .env com as informações da API:
     ```shell
    sed -i 's/API_BASE_URL=.*/API_BASE_URL=url_api/' .env
    sed -i 's/API_USERNAME=.*/API_USERNAME=seu_usuario/' .env
    sed -i 's/API_PASSWORD=.*/API_PASSWORD=sua_senha/' .env
      ```
5. Gere a chave da aplicação:
    ```shell
    php artisan key:generate
    ```
  ## Executando o projeto
1. Inicie o servidor de desenvolvimento do Laravel na porta: 7667:
     ```shell
    php artisan serve --port=7667 
    ```
2. Acesse o projeto no navegador através do endereço http://localhost:7667:
# Documentação da API
## GET /api/cities

Este endpoint retorna uma lista de cidades.

### Parâmetros da solicitação
Nenhum.
### Exemplo de resposta

**URL**: `/api/cities`

```json
{
  "data": [
    {
      "id": "ROD_3762",
      "name": "Punta Del Este, UY",
      "url": "punta-del-este-uy",
      "type": "station"
    },
    {
      "id": "ROD_3764",
      "name": "Itaberaba",
      "url": "itaberaba-ba",
      "type": "station"
    }
  ],
  "response": {
    "success": true,
    "message": "Cidades listadas com sucesso"
  }
}
```

## Endpoint: POST /api/search/passage

Este endpoint permite pesquisar passagens com base nos critérios fornecidos.

### Parâmetros da solicitação

O corpo da solicitação deve conter os seguintes parâmetros:

- `from` (string): O nome da cidade de partida.
- `to` (string): O nome da cidade de chegada.
- `travelDate` (string): A data da viagem no formato "YYYY-MM-DD".
- `nameDepartureCity` (string): O nome da cidade de partida (opcional, usado para validação).
- `nameArrivalCity` (string): O nome da cidade de chegada (opcional, usado para validação).

### Exemplo de solicitação

**URL**: `/api/search/passage`

```json
{
  "from": "São Paulo, SP",
  "to": "Belo Horizonte, MG",
  "travelDate": "2023-08-08",
  "nameDepartureCity": "São Paulo, SP - Barra Funda",
  "nameArrivalCity": "Belo Horizonte, MG - Gov. Israel Pinto"
}
```
### Exemplo de resposta (caso de sucesso)
```json
{
  "data": [
    {
      "id": "1_8ab3b78a799a3f1356dff5138ca85cce",
      "company": {
        "id": "2",
        "name": "1001"
      },
      "from": {
        "id": "ROD_898",
        "name": "São Paulo, SP - Barra Funda"
      },
      "to": {
        "id": "ROD_61",
        "name": "Belo Horizonte, MG - Gov. Israel Pinto"
      },
      "availableSeats": 18,
      "withBPE": true,
      "departure": {
        "date": "2023-08-08",
        "time": "04:30:00"
      },
      "arrival": {
        "date": "2023-08-08",
        "time": "11:55:00"
      },
      "travelDuration": 26700,
      "seatClass": "SEMI LEITO",
      "price": {
        "seatPrice": 100,
        "taxPrice": 18,
        "price": 118
      },
      "insurance": 9.95,
      "allowCanceling": true,
      "travelCancellationLimitDate": "2023-08-08 00:30:00"
    }
  ],
  "response": {
    "success": true,
    "message": "Passagens listadas com sucesso"
  }
}
```
### Exemplo de resposta (caso de erro)
Status de resposta: 422 Unprocessable Entity
```json
{
  "response": {
    "success": false,
    "message": "Passagens disponíveis somente para as cidades de SP e PR.",
    "message_error": "Tickets available only for cities in SP and PR"
  }
}
```
## POST /api/search/seats

Este endpoint permite pesquisar assentos disponíveis para um determinado ID de viagem.

### Parâmetros da solicitação

O corpo da solicitação deve conter o seguinte parâmetro:

- `travelId` (string): O ID da viagem.

### Exemplo de solicitação

**URL**: `/api/search/seats`

```json
{
  "travelId": "1_8ab3b78a799a3f1356dff5138ca85cce"
}
```
### Exemplo de resposta 
```json
{
  "data": [
    {
      "seat": "01",
      "position": {
        "x": 1,
        "y": 0,
        "z": 0
      },
      "occupied": true,
      "type": "seat"
    }
  ],
  "response": {
    "success": true,
    "message": "Assentos listados com sucesso."
  }
}
```

