<?php
$host = "localhost";
$db   = "biblioteca";
$user = "root";
$pass = "";
try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro: " . $e->getMessage());
}

$mensagem = "";
if ($_POST) {
    $codigo = $_POST['codigo'];
    $titulo = $_POST['titulo'];
    $autor  = $_POST['autor'];
    $sql = "INSERT INTO Livro (codigo, titulo, autor) VALUES (?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    try {
        $stmt->execute([$codigo, $titulo, $autor]);
        $mensagem = "<div class='alert alert-success shadow-sm'>🌿 Livro <b>$titulo</b> cadastrado!</div>";
    } catch (Exception $e) {
        $mensagem = "<div class='alert alert-danger'>Falha ao salvar: " . $e->getMessage() . "</div>";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Cadastro de Livro - Biblioteca</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
<style>
    body{font-family:'Inter',sans-serif;background:#f4f5f0;margin:0}
    /* MENU EM CIMA AGORA */
    .topbar{background:#1a2e22;padding:14px 32px;display:flex;align-items:center;justify-content:space-between;position:sticky;top:0;z-index:100;box-shadow:0 4px 20px rgba(0,0,0,.15)}
    .topbar .brand{font-weight:800;color:#ecfdf5;font-size:22px;display:flex;align-items:center;gap:10px}
    .topbar .nav-links{display:flex;gap:8px;align-items:center}
    .topbar .nav-links a{padding:8px 14px;border-radius:8px;color:#a7b5a8;text-decoration:none;font-size:14px;font-weight:600;transition:.2s}
    .topbar .nav-links a:hover{background:#223a2c;color:white}
    .topbar .nav-links a.active{background:#059669;color:white;box-shadow:0 4px 12px rgba(5,150,105,.3)}
    
    .main{background:linear-gradient(180deg,#065f46 0%,#047857 220px,#f4f5f0 220px);min-height:100vh;padding:32px 32px}
    .header-title{color:#ecfdf5;margin-bottom:24px;max-width:900px;margin-left:auto;margin-right:auto}
    .content-wrapper{max-width:900px;margin:0 auto}
    .card-livro{background:#fffffe;border-radius:20px;box-shadow:0 20px 40px rgba(26,46,34,0.12);padding:32px;border:1px solid #e7e5e4}
    .form-control{border-radius:12px;padding:13px 16px;border:1px solid #d6d3d1;background:#fafaf9}
    .form-control:focus{background:white;border-color:#059669;box-shadow:0 0 0 4px rgba(5,150,105,.15)}
    label{font-weight:600;font-size:14px;margin-bottom:6px;color:#292524}
    .btn-save{background:linear-gradient(90deg,#059669,#065f46);border:none;border-radius:12px;padding:12px 28px;color:white;font-weight:700;width:100%}
    .btn-clean{border:1px solid #e7e5e4;background:#fafaf9;border-radius:12px;padding:12px 20px;font-weight:600;width:100%;color:#44403c}
</style>
</head>
<body>

<div class="topbar">
    <div class="brand">🌿 Biblioteca</div>
    <div class="nav-links">
        <a href="#">📊 Dashboard</a>
        <a href="#">📚 Acervo</a>
        <a href="#" class="active">➕ Novo Livro</a>
        <a href="#">👥 Leitores</a>
        <a href="#">🔄 Empréstimos</a>
        <a href="#">⚙️ Ajustes</a>
    </div>
</div>

<div class="main">
    <div class="header-title">
        <h2 style="font-weight:700;margin:0">Cadastro de Livro</h2>
        <p style="opacity:0.85;margin:4px 0 0">Informe os dados para incluir um novo exemplar</p>
    </div>

    <div class="content-wrapper">
        <?= $mensagem ?>

        <div class="card-livro">
            <h4 style="font-weight:700;color:#1c1917">Dados da Obra <span style="font-size:11px;border:1px solid #a7f3d0;background:#ecfdf5;color:#065f46;padding:4px 10px;border-radius:20px;margin-left:8px;font-weight:700">OBRIGATÓRIO *</span></h4>
            
            
            <form method="POST" class="mt-4">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Código *</label>
                        <input type="text" name="codigo" class="form-control"  required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Título do Livro *</label>
                        <input type="text" name="titulo" class="form-control"  required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Autor *</label>
                        <input type="text" name="autor" class="form-control"  required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Descrição (opcional)</label>
                        <input type="text" class="form-control" ">
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-6"><button type="reset" class="btn-clean">Limpar</button></div>
                    <div class="col-md-6"><button type="submit" class="btn-save">🌿 Salvar Livro</button></div>
                </div>
            </form>
            
        </div>
        <p class="text-center mt-4" style="font-size:11px;color:#a7b5a8">© 2025 Sistema Biblioteca — Menu Topo | PHP 8.2 • Bootstrap 5 • MySQL</p>
    </div>
</div>

</body>
</html>