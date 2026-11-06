<?php
// conexao
$host = "localhost"; $db = "biblioteca"; $user = "root"; $pass = "";
try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) { die("Erro: " . $e->getMessage()); }

// acao de devolucao - atualiza dataDevolucao
if (isset($_GET['devolver'])) {
    $id = (int)$_GET['devolver'];
    $stmt = $pdo->prepare("UPDATE Emprestimo SET dataDevolucao = CURDATE() WHERE id = ?");
    $stmt->execute([$id]);
    header("Location: listar_emprestimos.php");
    exit;
}

// consultarEmprestimos() com JOIN entre Livro e Leitor
$sql = "SELECT e.id, l.titulo, l.autor, le.nome, e.dataEmprestimo, e.dataPrevista, e.dataDevolucao
        FROM Emprestimo e
        JOIN Livro l ON e.livroId = l.id
        JOIN Leitor le ON e.leitorId = le.id
        ORDER BY e.id DESC";
$emprestimos = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);

// indicadores
$total = $pdo->query("SELECT COUNT(*) FROM Emprestimo")->fetchColumn();
$em_andamento = $pdo->query("SELECT COUNT(*) FROM Emprestimo WHERE dataDevolucao IS NULL")->fetchColumn();
$atrasados = $pdo->query("SELECT COUNT(*) FROM Emprestimo WHERE dataDevolucao IS NULL AND dataPrevista < CURDATE()")->fetchColumn();
$devolvidos = $pdo->query("SELECT COUNT(*) FROM Emprestimo WHERE dataDevolucao IS NOT NULL")->fetchColumn();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<title>Empréstimos - Biblioteca</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
<style>
 body{font-family:'Inter',sans-serif;background:#f4f5f0;margin:0}
 /* TOPBAR - MENU EM CIMA - TEMA VERDE */
 .topbar{background:#1a2e22;padding:14px 32px;display:flex;align-items:center;justify-content:space-between;position:sticky;top:0;z-index:100;box-shadow:0 4px 20px rgba(0,0,0,.15)}
 .topbar .brand{font-weight:800;color:#ecfdf5;font-size:22px;display:flex;align-items:center;gap:10px}
 .topbar .nav-links{display:flex;gap:8px;align-items:center}
 .topbar .nav-links a{padding:8px 14px;border-radius:8px;color:#a7b5a8;text-decoration:none;font-size:14px;font-weight:600;transition:.2s}
 .topbar .nav-links a:hover{background:#223a2c;color:white}
 .topbar .nav-links a.active{background:#059669;color:white;box-shadow:0 4px 12px rgba(5,150,105,.3)}
 
 .main{background:linear-gradient(180deg,#065f46 0%,#047857 200px,#f4f5f0 200px);min-height:100vh;padding:28px 32px}
 .content{max-width:1200px;margin:0 auto}
 .card-stat{background:#fffffe;border-radius:16px;padding:20px;text-align:center;box-shadow:0 10px 20px rgba(26,46,34,.06);border:1px solid #e7e5e4;transition:.2s}
 .card-stat:hover{transform:translateY(-2px)}
 .card-stat h2{font-weight:800;font-size:32px;margin:8px 0;color:#1c1917}
 .badge-andamento{background:#dcfce7;color:#166534;padding:6px 12px;border-radius:20px;font-size:12px;font-weight:700;border:1px solid #bbf7d0}
 .badge-atrasado{background:#fef3c7;color:#92400e;padding:6px 12px;border-radius:20px;font-size:12px;font-weight:700;border:1px solid #fde68a}
 .table-card{background:#fffffe;border-radius:20px;box-shadow:0 20px 40px rgba(26,46,34,.08);padding:24px;border:1px solid #e7e5e4}
 .btn-new{background:linear-gradient(90deg,#059669,#065f46);color:white;border:none;border-radius:10px;padding:10px 18px;font-weight:700}
 .btn-new:hover{opacity:0.9;color:white}
</style>
</head>
<body>

<div class="topbar">
    <div class="brand">🌿 Biblioteca</div>
    <div class="nav-links">
        <a href="#" class="active">📊 Dashboard</a>
        <a href="cadastrar_livro.php">📚 Acervo</a>
        <a href="#">➕ Novo Livro</a>
        <a href="#">👥 Leitores</a>
        <a href="#">🔄 Empréstimos</a>
        <a href="#">⚙️ Ajustes</a>
    </div>
</div>

<div class="main">
<div class="content">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div><h2 style="font-weight:800;margin:0;color:#ecfdf5">Empréstimos</h2><p style="color:#a7f3d0;opacity:.9;margin:2px 0 0">Controle de livros emprestados e devoluções</p></div>
        <a href="cadastrar_emprestimo.php" class="btn-new">+ Novo Empréstimo</a>
    </div>

    <!-- Cards contadores -->
    <div class="row mb-4 g-3">
        <div class="col-md-3"><div class="card-stat"><div style="font-size:22px">🌿</div><small class="text-muted">Total Empréstimos</small><h2><?= $total ?></h2></div></div>
        <div class="col-md-3"><div class="card-stat"><div style="font-size:22px">📗</div><small class="text-muted">Emprestados</small><h2><?= $em_andamento ?></h2><small style="color:#059669;font-weight:700">Ativos agora</small></div></div>
        <div class="col-md-3"><div class="card-stat"><div style="font-size:22px">⏰</div><small class="text-muted">Atrasados</small><h2><?= $atrasados ?></h2></div></div>
        <div class="col-md-3"><div class="card-stat"><div style="font-size:22px">✅</div><small class="text-muted">Devolvidos</small><h2><?= $devolvidos ?></h2></div></div>
    </div>

    <div class="table-card">
        <div class="d-flex justify-content-between mb-3 align-items-center"><h5 style="font-weight:800;color:#1c1917;margin:0">Empréstimos Abertos</h5><input class="form-control" style="width:260px;border-radius:10px;background:#fafaf9" placeholder="Buscar livro ou leitor..."></div>
        <div class="table-responsive">
        <table class="table align-middle">
            <thead><tr style="font-size:12px;color:#57534e;text-transform:uppercase;letter-spacing:.5px"><th>ID</th><th>Livro</th><th>Leitor</th><th>Empréstimo</th><th>Prevista</th><th>Status</th><th>Ações</th></tr></thead>
            <tbody>
            <?php foreach($emprestimos as $e): 
                $isAtrasado = is_null($e['dataDevolucao']) && $e['dataPrevista'] < date('Y-m-d');
                $isAberto = is_null($e['dataDevolucao']);
            ?>
            <tr>
                <td><span style="font-weight:700;color:#44403c">#<?= $e['id'] ?></span></td>
                <td><b style="color:#1c1917"><?= $e['titulo'] ?></b><br><small class="text-muted">Autor: <?= $e['autor'] ?></small></td>
                <td style="font-weight:600"><?= $e['nome'] ?></td>
                <td><?= date('d/m/Y', strtotime($e['dataEmprestimo'])) ?></td>
                <td><?= date('d/m/Y', strtotime($e['dataPrevista'])) ?></td>
                <td>
                    <?php if(!$isAberto): ?><span class="badge bg-success">Devolvido</span>
                    <?php elseif($isAtrasado): ?><span class="badge-atrasado">● Atrasado</span>
                    <?php else: ?><span class="badge-andamento">Em andamento ●</span><?php endif; ?>
                </td>
                <td>
                    <?php if($isAberto): ?><a href="?devolver=<?= $e['id'] ?>" class="btn btn-sm" style="border-radius:8px;border:1px solid #059669;color:#065f46;font-weight:700">Devolver</a><?php else: ?><small class="text-muted"><?= $e['dataDevolucao'] ? date('d/m/Y', strtotime($e['dataDevolucao'])) : '' ?></small><?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        </div>
        <small class="text-muted">Mostrando <?= count($emprestimos) ?> de <?= $total ?> empréstimos • Verde indica em dia, Amarelo atrasado</small>
    </div>
</div>
</div>
</body>
</html>