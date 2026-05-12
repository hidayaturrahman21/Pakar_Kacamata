<?php
include 'config/koneksi.php';
session_start();

if (!isset($_POST['jawaban'])) {
    header("Location: konsultasi.php");
    exit();
}

$jawaban = $_POST['jawaban'];
$ids = array_map('intval', $jawaban);
$idList = implode(',', $ids);


$query = "
SELECT
    recommendations.id_recommendation,
    recommendations.lens_name,
    recommendations.lens_category,
    recommendations.description,
    rules.reasoning_rule,
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


if ($data) {
    $id_rec = $data['id_recommendation'];
    $nama_user = "Guest User"; 
    $skor = $data['total_score'];
    mysqli_query($conn, "INSERT INTO history_diagnosa (nama_user, id_recommendation, hasil_skor) VALUES ('$nama_user', '$id_rec', '$skor')");
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Analisis - NAPNAP CARE</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="assets/style.css">
</head>

<body style="background-color: #f8fafc; font-family: 'Inter', sans-serif;">

    <nav class="navbar sticky-top bg-white border-bottom py-3">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center text-dark text-decoration-none" href="index.php">
                <div class="bg-primary text-white rounded-2 d-flex align-items-center justify-content-center me-2" style="width:32px; height:32px; font-weight:bold;">N</div>
                NAPNAP<span class="text-primary">CARE</span>
            </a>
            <span class="text-muted small fw-bold text-uppercase">Sistem Pakar Kacamata</span>
        </div>
    </nav>

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">

                <div class="text-center mb-5">
                    <span class="badge bg-primary-subtle text-primary px-3 py-2 rounded-pill fw-bold small mb-3">ANALYSIS RESULT</span>
                    <h1 class="fw-bold text-dark">Rekomendasi <span class="text-primary">Lensa Anda</span></h1>
                </div>

                <?php if ($data) : ?>
                    <div class="card border-0 shadow-sm rounded-4 mb-4">
                        <div class="card-body p-4 p-md-5">
                            <div class="text-center mb-4">
                                <label class="text-uppercase text-primary fw-bold small mb-2 d-block">Jenis Lensa Terbaik:</label>
                                <h2 class="fw-bold display-6"><?php echo htmlspecialchars($data['lens_name']); ?></h2>
                                <hr class="mx-auto mt-3" style="width: 50px; height: 3px; background: #0d6efd;">
                            </div>
                            
                            <div class="result-box bg-light p-4 rounded-4">
                                <h6 class="fw-bold text-dark mb-2"><i class="fa-solid fa-file-lines me-2 text-primary"></i>Deskripsi Lensa:</h6>
                                <p class="text-secondary lead-sm mb-0"><?php echo htmlspecialchars($data['description']); ?></p>
                            </div>
                        </div>
                    </div>

                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="card border-0 shadow-sm rounded-4 h-100">
                                <div class="card-body p-4">
                                    <h5 class="fw-bold mb-3"><i class="fa-solid fa-glasses text-primary me-2"></i>Bingkai Yang Cocok</h5>
                                    <?php
                                    $id_rec = $data['id_recommendation'];
                                    $q_frame = mysqli_query($conn, "SELECT * FROM frame_kacamata WHERE id_recommendation = '$id_rec'");
                                    if (mysqli_num_rows($q_frame) > 0) :
                                        while ($frame = mysqli_fetch_assoc($q_frame)) : ?>
                                            <div class="p-3 border-start border-primary border-4 bg-light rounded-2 mb-2">
                                                <div class="fw-bold text-dark"><?php echo $frame['nama_frame']; ?></div>
                                                <div class="text-muted small"><?php echo $frame['deskripsi']; ?></div>
                                            </div>
                                        <?php endwhile;
                                    else: ?>
                                        <p class="text-muted small">Bingkai standar/casual sangat cocok untuk jenis lensa ini.</p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card border-0 shadow-sm rounded-4 h-100" style="background-color: #fffbeb; border-left: 5px solid #fbbf24 !important;">
                                <div class="card-body p-4">
                                    <h5 class="fw-bold mb-3 text-warning-emphasis"><i class="fa-solid fa-heart-pulse me-2"></i>Saran Kesehatan</h5>
                                    <?php
                                    $q_tips = mysqli_query($conn, "SELECT * FROM tips_kesehatan WHERE id_recommendation = '$id_rec'");
                                    $tips = mysqli_fetch_assoc($q_tips);
                                    ?>
                                    <p class="text-dark-emphasis mb-0" style="font-size: 1rem; line-height: 1.6;">
                                        <?php echo $tips ? $tips['isi_artikel'] : "Penting untuk mengistirahatkan mata setiap 20 menit saat bekerja di depan layar untuk menjaga kesehatan mata."; ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 p-4 bg-white rounded-4 shadow-sm border-start border-primary border-4">
                        <div class="d-flex align-items-center">
                            <div class="bg-primary-subtle text-primary rounded-circle p-2 me-3">
                                <i class="fa-solid fa-robot"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-0 text-dark">Analisis Sistem Pakar</h6>
                                <p class="small text-muted mb-0">Berdasarkan keluhan, sistem mendeteksi pola: <strong><?php echo htmlspecialchars($data['reasoning_rule']); ?></strong></p>
                            </div>
                        </div>
                    </div>

                <?php else : ?>
                    <div class="card border-0 shadow-sm rounded-4 p-5 text-center">
                        <i class="fa-solid fa-face-frown fa-4x text-light-emphasis mb-3"></i>
                        <h4 class="fw-bold">Hasil Tidak Ditemukan</h4>
                        <p class="text-muted">Sistem tidak menemukan rekomendasi yang pas. Coba ulangi dengan gejala yang lebih spesifik.</p>
                        <a href="konsultasi.php" class="btn btn-primary mt-3 px-4 py-2 rounded-pill">Mulai Ulang Konsultasi</a>
                    </div>
                <?php endif; ?>

                <div class="text-center mt-5">
                    <a href="index.php" class="btn btn-link text-decoration-none text-muted fw-bold small">
                        <i class="fa-solid fa-chevron-left me-2"></i>KEMBALI KE BERANDA
                    </a>
                </div>

            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
