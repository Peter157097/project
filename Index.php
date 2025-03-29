<?php
function calcularTDEE($peso, $altura, $idade, $sexo, $atividade) {
    if ($sexo == 'masculino') {
        $tmb = 10 * $peso + 6.25 * $altura - 5 * $idade + 5;
    } else {
        $tmb = 10 * $peso + 6.25 * $altura - 5 * $idade - 161;
    }

    $fatoresAtividade = [
        'sedentario' => 1.2,
        'leve' => 1.375,
        'moderado' => 1.55,
        'ativo' => 1.725,
        'muito_ativo' => 1.9
    ];
    
    return $tmb * $fatoresAtividade[$atividade];
}

function sugerirDieta($tdee) {
    $alimentos = [
        'Proteínas' => ['Frango', 'Peixe', 'Ovos', 'Tofu'],
        'Carboidratos' => ['Arroz', 'Batata-doce', 'Aveia', 'Pão integral'],
        'Gorduras' => ['Abacate', 'Azeite', 'Nozes', 'Amêndoas']
    ];
    
    $meta_calorica = round($tdee / 3);
    return [
        'meta_calorica' => $tdee,
        'refeicoes' => [
            'Café da manhã' => [$alimentos['Proteínas'][0], $alimentos['Carboidratos'][0], $alimentos['Gorduras'][0]],
            'Almoço' => [$alimentos['Proteínas'][1], $alimentos['Carboidratos'][1], $alimentos['Gorduras'][1]],
            'Jantar' => [$alimentos['Proteínas'][2], $alimentos['Carboidratos'][2], $alimentos['Gorduras'][2]]
        ]
    ];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $peso = $_POST['peso'];
    $altura = $_POST['altura'];
    $idade = $_POST['idade'];
    $sexo = $_POST['sexo'];
    $atividade = $_POST['atividade'];
    
    $tdee = calcularTDEE($peso, $altura, $idade, $sexo, $atividade);
    $dieta = sugerirDieta($tdee);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Calculadora de Dieta</title>
</head>
<body>
    <form method="post">
        Peso (kg): <input type="number" name="peso" required><br>
        Altura (cm): <input type="number" name="altura" required><br>
        Idade: <input type="number" name="idade" required><br>
        Sexo: <select name="sexo">
            <option value="masculino">Masculino</option>
            <option value="feminino">Feminino</option>
        </select><br>
        Atividade Física: <select name="atividade">
            <option value="sedentario">Sedentário</option>
            <option value="leve">Leve</option>
            <option value="moderado">Moderado</option>
            <option value="ativo">Ativo</option>
            <option value="muito_ativo">Muito Ativo</option>
        </select><br>
        <button type="submit">Calcular</button>
    </form>
    
    <?php if (isset($dieta)): ?>
        <h2>Resultado</h2>
        <p>Meta calórica diária: <?= round($dieta['meta_calorica']) ?> kcal</p>
        <h3>Plano de Refeições</h3>
        <?php foreach ($dieta['refeicoes'] as $refeicao => $itens): ?>
            <p><strong><?= $refeicao ?>:</strong> <?= implode(', ', $itens) ?></p>
        <?php endforeach; ?>
    <?php endif; ?>
</body>
</html>
