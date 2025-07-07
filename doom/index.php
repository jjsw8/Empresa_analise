php
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crystal's Lakes - Sua Empresa</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <nav>
            <div class="logo">Crystal's Lakes</div>
            <ul>
                <li><a href="#home">Início</a></li>
                <li><a href="#about">Sobre</a></li>
                <li><a href="#services">Serviços</a></li>
                <li><a href="#contact">Contato</a></li>
            </ul>
        </nav>
    </header>


    <main>
        <section id="home" class="hero-section">
            <div class="hero-content">
                <h1>Bem-vindo à Crystal's Lakes</h1>
                <p>para todas as ocasiões.</p>
                <a href="#services" class="btn">Conheça Nossos Serviços</a>
            </div>
        </section>


        <section id="about" class="content-section">
            <h2>Sobre Nós</h2>
            <p>A Crystal's Lakes é uma perfumaria, aonde tercerizamos. Fazemos parceria com a amazon e o mercado livre, para poder entregar nosso perfume.
               Temos lojas físicos e lojas onlines.</p>
        </section>


        <section id="services" class="content-section services-grid">
            <h2>Nossos Serviços</h2>
            <div class="service-item">
                <h3>Consultoria Estratégica</h3>
                <p>Análise de mercado e desenvolvimento de planos de negócios personalizados.</p>
            </div>
            <div class="service-item">
                <h3>Desenvolvimento de Software</h3>
                <p>Criação de soluções de software sob medida para suas necessidades.</p>
            </div>
            <div class="service-item">
                <h3>Suporte Técnico</h3>
                <p>Atendimento especializado e suporte contínuo para sua infraestrutura.</p>
            </div>
        </section>


        <section id="contact" class="content-section contact-form-section">
            <h2>Contato</h2>
            <p>Entre em contato conosco para saber mais sobre como podemos ajudar sua empresa.</p>
            <div class="contact-details">
                <p>Email: contato@crystalslakes.com</p>
                <p>Telefone: (XX) XXXX-XXXX</p>
                <p>Endereço: Rua da Inovação, 123 - Cidade, Estado</p>
            </div>
        </section>
        
        <section class="login-section">
            <h2>Acesso Restrito</h2>
            <form method="POST" action="">
                <label for="usuario">Usuário: </label>
                <input type="text" id="usuario" name="usuario" placeholder="digite o usuário" required><br><br>


                <label for="senha_usuario">Senha: </label>
                <input type="password" id="senha_usuario" name="senha_usuario" placeholder="digite a senha" required><br><br>


                <input type="submit" name="Sendlogin" value="Acessar">
            </form>
            <?php
            // Configurações do banco de dados
            $host = 'localhost';
            $user = 'root'; // usuário padrão do XAMPP
            $password = ''; // senha padrão do XAMPP (vazia)
            $database = 'login'; // substitua pelo nome do seu banco de dados


            // Conectar ao banco de dados
            $conn = new mysqli($host, $user, $password, $database);


            // Verificar conexão
            if ($conn->connect_error) {
                die("Falha na conexão: " . $conn->connect_error);
            }


            // Receber dados do forms
            $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);


            // Acessar o IF quando o usuario clicar no botão de acesso do formulario
            if (!empty($dados["Sendlogin"])) {
                // Preparar a consulta SQL
                $query_usuario = "SELECT id, senha FROM usuarios WHERE usuario = ? LIMIT 1";
                $stmt = $conn->prepare($query_usuario);
                $stmt->bind_param("s", $dados["usuario"]);
                $stmt->execute();
                $resultado = $stmt->get_result();
                
                if ($resultado->num_rows == 1) {
                    // Usuário encontrado, verificar senha
                    $row_usuario = $resultado->fetch_assoc();
                    // ATENÇÃO: md5 é uma função de hash insegura para senhas.
                    // Para produção, use password_verify() com password_hash() para segurança.
                    if (md5($dados["senha_usuario"]) === $row_usuario['senha']) { // Correção: md5() deve ser aplicado apenas à senha do formulário para comparação
                        // Senha correta - iniciar sessão e redirecionar
                        session_start();
                        $_SESSION['id'] = $row_usuario['id'];
                        $_SESSION['usuario'] = $dados["usuario"];
                        
                        header("Location: dashboard.php"); // redireciona para página restrita
                        exit();
                    } else {
                        echo "<p style='color: red'>Erro: Senha incorreta!</p>";
                    }
                } else {
                    echo "<p style='color: red'>Erro: Usuário não encontrado!</p>";
                }
            }
            // Não se esqueça de fechar a conexão com o banco de dados quando não for mais necessária
            $conn->close();
            ?>
        </section>
    </main>


    <footer>
        <p>&copy; 2025 Crystal's Lakes.</p>
    </footer>
</body>
</html>
