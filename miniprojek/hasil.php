<?php
include 'config/koneksi.php';

if (!isset($_POST['jawaban'])) {
    header("Location: konsultasi.php");
    exit();
}

$jawaban = $_POST['jawaban'];

$ids = array_map('intval', $jawaban);
$idList = implode(',', $ids);

$query = "
SELECT
    recommendations.lens_name,
    recommendations.lens_category,
    recommendations.description,
    recommendations.reasoning,
    COUNT(rule_details.id_condition) AS total_score
FROM rule_details
JOIN rules ON rule_details.id_rule = rules.id_rule
JOIN recommendations ON rules.id_recommendation = recommendations.id_recommendation
WHERE rule_details.id_condition IN ($idList)
GROUP BY recommendations.id_recommendation
ORDER BY total_score DESC
LIMIT 1
";

$result = mysqli_query($conn, $query);
$data = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NAPNAP CARE</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="assets/style.css">
</head>

<body>

    <nav class="navbar sticky-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center text-dark text-decoration-none" href="#">
                <div class="bg-primary text-white rounded-2 d-flex align-items-center justify-content-center me-2" style="width:32px; height:32px;">N</div>
                NAPNAP<span class="text-primary">CARE</span>
            </a>
            <div class="d-flex align-items-center">
                <span class="text-dark fw-semibold" style="font-size: 0.85rem;">SISTEM PAKAR KACAMATA</span>
            </div>
        </div>
    </nav>

    <section class="hero-section container">
        <span class="badge-result">Analysis Result</span>
        <h1 class="fw-bold mt-3" style="font-size: 2.5rem; letter-spacing: -1px;">
            Solusi Lensa <br><span class="text-primary" style="font-style: italic; font-weight: 400;">Terbaik Untuk Anda.</span>
        </h1>
    </section>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-7">
                <div class="form-wrapper">
                    <div class="analysis-card shadow-sm">

                        <?php if (isset($data) && $data) : ?>
                            <div class="mb-4">
                                <label class="label-custom">Lensa Disarankan</label>
                                <h2 class="fw-bold text-primary"><?php echo htmlspecialchars($data['lens_name']); ?></h2>
                            </div>

                            <div class="result-box mb-4">
                                <label class="label-custom">Kelebihan Lensa</label>
                                <p class="mb-4"><?php echo htmlspecialchars($data['description']); ?></p>

                                <label class="label-custom">Fungsi</label>
                                <p class="mb-0 text-muted" style="font-size: 0.95rem;">
                                    <i class="fa-solid fa-circle-info text-primary me-2"></i>
                                    <?php echo htmlspecialchars($data['reasoning']); ?>
                                </p>
                            </div>

                        <?php else : ?>
                            <div class="text-center py-4">
                                <i class="fa-solid fa-circle-exclamation fa-3x text-warning mb-3"></i>
                                <h4 class="fw-bold">Rekomendasi Tidak Ditemukan</h4>
                                <p class="text-muted">Maaf, sistem tidak menemukan kecocokan aturan untuk jawaban Anda.</p>
                            </div>
                        <?php endif; ?>

                        <div class="text-center mt-4">
                            <a href="index.php" class="btn btn-primary btn-action shadow">Konsultasi Lagi</a>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>