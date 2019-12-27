# Homem vs Orc
Serviço web REST que simula uma batalha medieval de um jogo RPG em turnos.

## Dependências
- php 7.2
- Laravel 6.0
- Docker
- Docker Compose

## Utilização da API via docker
Com o docker e docker composer instalado, na pasta do projeto, executar:
```shell script
$ docker-compose build
$ docker-compose up -d
```

No browser: http://localhost:8000/api/v1/batalha (não houve tempo para desenvolver o front-end)

## Endpoint
O endpoint de conexão com a API REST JSON é: http://localhost:8000/api/v1/batalha/

## Recursos disponíveis
O sistema automatiza todas as interações, apenas sendo necessário o verbo GET para consumir a API.
- Criar batalha
- Exibir batalha
- Rolar dados

## Tratamento de dados
Todos os dados enviados e recebidos pela API estão e deverão ser em formato JSON.

## Autenticação
Não se aplica. O sistema envia um token quando gerada a batalha ao acessar o link acima.

## Criar Batalha
- Método: GET
- URL: http://localhost:8000/api/v1/batalha/
- Exemplo de retorno
```json
{
    "data": {
        "token": "1011ba421cab508da75be2a51414037f",
        "Humano": [
            {
                "id": 1,
                "nome": "Humano",
                "vida": "12",
                "forca": "1",
                "agilidade": "2",
                "arma": {
                    "id": 1,
                    "nome": "Espada Longa",
                    "ataque": "2",
                    "defesa": "1",
                    "qnt_lados_dado": "6",
                    "personagem_id": "1"
                }
            }
        ],
        "Orc": [
            {
                "id": 2,
                "nome": "Orc",
                "vida": "20",
                "forca": "2",
                "agilidade": "0",
                "arma": {
                    "id": 2,
                    "nome": "Clava",
                    "ataque": "1",
                    "defesa": "0",
                    "qnt_lados_dado": "8",
                    "personagem_id": "2"
                }
            }
        ],
        "vida_restante": {
            "Humano": -1,
            "Orc": 7
        },
        "rodadas": []
    }
}
```
## Exibir batalha
- Metodo: GET
- URL: http://localhost:8000/api/v1/batalha/{token}
- Exemplo de retorno:
```json
{
    "data": {
        "token": "1011ba421cab508da75be2a51414037f",
        "Humano": [
            {
                "id": 1,
                "nome": "Humano",
                "vida": "12",
                "forca": "1",
                "agilidade": "2",
                "arma": {
                    "id": 1,
                    "nome": "Espada Longa",
                    "ataque": "2",
                    "defesa": "1",
                    "qnt_lados_dado": "6",
                    "personagem_id": "1"
                }
            }
        ],
        "Orc": [
            {
                "id": 2,
                "nome": "Orc",
                "vida": "20",
                "forca": "2",
                "agilidade": "0",
                "arma": {
                    "id": 2,
                    "nome": "Clava",
                    "ataque": "1",
                    "defesa": "0",
                    "qnt_lados_dado": "8",
                    "personagem_id": "2"
                }
            }
        ],
        "vida_restante": {
            "Humano": -1,
            "Orc": 7
        },
        "rodadas": [
            {
                "id": 74,
                "batalha_id": "16",
                "num_rodada": "1",
                "acao": "iniciativa",
                "valor_dado_p1": "11",
                "valor_dado_p2": "8",
                "atacante": null
            },
        ]
    }
}
```
## Rolar dados
- Metodo: GET
- URL: http://localhost:8000/api/v1/batalha/roll/{token}
- Exemplo de retorno:
```json
{
    "data": {
        "token": "1011ba421cab508da75be2a51414037f",
        "Humano": [
            {
                "id": 1,
                "nome": "Humano",
                "vida": "12",
                "forca": "1",
                "agilidade": "2",
                "arma": {
                    "id": 1,
                    "nome": "Espada Longa",
                    "ataque": "2",
                    "defesa": "1",
                    "qnt_lados_dado": "6",
                    "personagem_id": "1"
                }
            }
        ],
        "Orc": [
            {
                "id": 2,
                "nome": "Orc",
                "vida": "20",
                "forca": "2",
                "agilidade": "0",
                "arma": {
                    "id": 2,
                    "nome": "Clava",
                    "ataque": "1",
                    "defesa": "0",
                    "qnt_lados_dado": "8",
                    "personagem_id": "2"
                }
            }
        ],
        "vida_restante": {
            "Humano": -1,
            "Orc": 7
        },
        "rodadas": [
            {
                "id": 74,
                "batalha_id": "16",
                "num_rodada": "1",
                "acao": "iniciativa",
                "valor_dado_p1": "11",
                "valor_dado_p2": "8",
                "atacante": null
            },
        ]
    }
}
```
