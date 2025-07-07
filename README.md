# FoodHero API

API desenvolvida em Laravel para gerenciar produtos e permitir que usuários autenticados marquem produtos como favoritos. Inclui autenticação com Sanctum, documentação via Swagger e arquitetura baseada em DTOs e Services.

---

## 🚀 Tecnologias

- PHP 8.4+
- Laravel 12
- Laravel Sanctum (autenticação)
- L5-Swagger (documentação)
- SQLite
---

## 🛠️ Requisitos

- PHP 8.4+
- Composer
- SQLite
- Laravel CLI (`laravel` ou `php artisan`)
---

## 🔧 Como rodar localmente

```bash
# Clone o repositório
git clone https://github.com/TonyGuerra122/FoodHero.git
cd FoodHero

# Instale as dependências PHP
composer install

# Copie o arquivo .env de exemplo
cp .env.example .env

# Rode as migrations
php artisan migrate

# Rode o servidor local
php artisan serve
```
---

## ✅ Executando os testes
```bash
php artisan test
```
---

## 📘 Documentação da API (Swagger)
A documentação é gerada automaticamente usando L5-Swagger.
```bash
php artisan l5-swagger:generate
```
Acesse: http://localhost:8000/api/documentation

---
## 🧱 Decisões Arquiteturais

-   **DTOs (Data Transfer Objects):** Utilizados para garantir a tipagem e organização dos dados recebidos de APIs externas,           facilitando testes e manutenção.

-   **Services:** Separação da lógica de negócio das controllers. Ex: ProductService cuida da comunicação com APIs externas.
    Controllers finos: Controllers se limitam a orquestrar chamadas, delegando regras para os services.

-   **Autenticação via Sanctum:** Simples e segura para SPAs e aplicações mobile.

-   **Documentação com Swagger:** Todas as rotas estão documentadas com anotações @OA para fácil integração e entendimento da API.
