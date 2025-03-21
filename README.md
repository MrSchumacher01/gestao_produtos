# 🛒 Sistema de Gestão de Produtos

## 📌 Sobre o Projeto
Este é um mini sistema de gestão de produtos desenvolvido como parte da disciplina **Programação para Internet**. O projeto visa aprimorar habilidades em desenvolvimento web, utilizando boas práticas de programação e armazenamento de dados.

## 🚀 Tecnologias Utilizadas
- **Backend:** PHP (com PDO para interação com MySQL)
- **Banco de Dados:** MySQL
- **Frontend:** HTML, CSS, JavaScript
- **Frameworks:** Bootstrap ou Tailwind
- **AJAX:** Para atualizações dinâmicas

## 📂 Estrutura do Projeto
```
📦 sistema-gestao-produtos
 ┣ 📂 img/                     # Imagens do projeto
 ┣ 📂 css/                     # Estilos CSS
 ┣ 📂 js/                      # Scripts JavaScript
 ┣ 📂 xampp/                   # Estrutura do XAMPP
 ┣ 📜 index.php                # Página inicial
 ┣ 📜 config.php               # Configuração do banco de dados
 ┣ 📜 login.php                # Tela de login
 ┣ 📜 dashboard.php            # Painel do usuário
 ┣ 📜 README.md                # Documentação do projeto
```

## 🔑 Funcionalidades
- 📌 **Autenticação de usuários** (com hash SHA256 para senhas)
- 🏷️ **Cadastro de produtos e fornecedores**
- 📥 **Seleção de produtos e inclusão na cesta**
- 🔄 **Atualização dinâmica com AJAX**
- 📊 **Visualização da cesta de compras com resumo total**

## 🛠️ Como Executar Localmente
### 1️⃣ Configurar o ambiente
- Baixe e instale o **XAMPP** (se ainda não tiver) [Clique aqui](https://www.apachefriends.org/pt_br/download.html)
- Inicie o Apache e o MySQL no painel do XAMPP

### 2️⃣ Clonar o repositório
```bash
git clone https://github.com/MrSchumacher01/gestao_produtos.git
```

### 3️⃣ Importar o banco de dados
- No **phpMyAdmin**, crie um banco de dados chamado `gestao_produtos`
- Importe o arquivo `banco.sql` (caso esteja incluído no projeto)

### 4️⃣ Executar o projeto
- Mova os arquivos para a pasta `C:/xampp/htdocs/gestao_produtos`
- Acesse no navegador:  
  ```
  http://localhost/gestao_produtos/
  ```

## 📜 Licença
Este projeto foi desenvolvido para fins educacionais.

---
🚀 **Desenvolvido por:** *Marcos Schumacher*
