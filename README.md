# CRJ Bikers
> "Uma solução simples para gerenciamento de estoque de motos, desenvolvida como projeto de estudo focado em arquitetura PHP e Banco de Dados em Nuvem."

![Status do Projeto](https://img.shields.io/badge/Status-Finalizado-green) ![PHP](https://img.shields.io/badge/PHP-8.0+-777BB4) ![Supabase](https://img.shields.io/badge/Database-Supabase-3ECF8E)

## Sobre o Projeto
O **CRJ Bikers** é um sistema web desenvolvido para gerenciar o estoque de uma concessionária de motos. O projeto resolve problemas reais de cadastro, visualização e venda de veículos, com um painel administrativo incluso.

Este projeto utiliza o **Supabase (PostgreSQL)** na nuvem, permitindo que os dados sejam acessados remotamente.

## Funcionalidades Principais
* **Painel Administrativo:** Acesso com login seguro.
* **Gestão de Estoque:** Cadastro contendo Marca, Modelo, Cilindrada, Preço, com upload de fotos.
* **Relatórios Financeiros:** Visualização de lucro, total de vendas e histórico detalhado.
* **Design Responsivo:** Interface amigável para Desktop e Mobile.

## Tecnologias Utilizadas
* **Back-end:** PHP.
* **Banco de Dados:** PostgreSQL (Supabase).
* **Front-end:** HTML5, CSS.
* **Servidor Local:** Apache (XAMPP).

## Como Rodar o Projeto

### Pré-requisitos
* Ter o [XAMPP](https://www.apachefriends.org/).
* Uma conta no [Supabase](https://supabase.com/).

### Passo a Passo
1.  **Clone o repositório** na sua pasta `htdocs`:
    ```bash
    git clone https://github.com/CJSabino/ESMoto.git
    ```

2.  **Configure o Banco de Dados:**
    * Renomeie o arquivo `conexao.example.php` para `conexao.php`.
    * Abra o arquivo e insira suas credenciais do Supabase (Host, User e Senha).

3.  **Inicie o Servidor:**
    * Abra o XAMPP e inicie **Apache**.
    * Acesse no navegador: `http://localhost/ESMoto/sitemoto/home.php`

4.  **Login de Admin (Padrão):**
    * Usuário: `admin` (exemplo)
    * Senha: (definiu no banco)
---
Desenvolvido por **Cauã Sabino, João Nicolau e Renan Santos**
