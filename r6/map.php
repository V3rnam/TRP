<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Détails de la map</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet"/>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
        }
    </style>
</head>
<body class="bg-gray-900 text-gray-100 min-h-screen">
    <div class="container mx-auto p-4">
        <?php
        $map = $_GET['map'] ?? '';
        $map = trim($map);

        // Sécurisation
        if (!preg_match('/^[a-zA-Z0-9_-]+$/', $map)) {
            $map = '';
        }

        $mapDir = __DIR__ . DIRECTORY_SEPARATOR . $map;
        $displayName = $map ? ucfirst(str_replace('-', ' ', $map)) : 'Map inconnue';
        ?>

        <div class="flex items-center justify-between mb-8 flex-wrap gap-4">
            <div>
                <h1 class="text-4xl font-bold text-yellow-400">
                    <?php echo htmlspecialchars($displayName, ENT_QUOTES, 'UTF-8'); ?>
                </h1>
                <h2 class="text-xl text-gray-400">Tactical Report Point</h2>
            </div>

            <a href="index.php" class="bg-yellow-400 text-gray-900 px-4 py-2 rounded-lg font-bold hover:bg-yellow-300 transition">
                ← Retour
            </a>
        </div>

        <?php
        if (empty($map) || !is_dir($mapDir)) {
            echo '<div class="text-center text-red-400 text-2xl mt-10">Map introuvable.</div>';
        } else {
            $images = [];

            // On cherche uniquement map-1.*, map-2.*, map-3.*, map-4.*
            for ($i = 1; $i <= 4; $i++) {
                $pattern = $mapDir . DIRECTORY_SEPARATOR . $map . '-' . $i . '.*';
                $matches = glob($pattern);

                if (!empty($matches)) {
                    foreach ($matches as $filePath) {
                        if (
                            is_file($filePath) &&
                            preg_match('/\.(jpg|jpeg|png|webp|gif|bmp)$/i', $filePath)
                        ) {
                            $images[$i] = basename($filePath);
                            break; // on garde le premier trouvé pour ce numéro
                        }
                    }
                }
            }

            ksort($images);
            $images = array_values($images);
            $count = count($images);

            if ($count === 0) {
                echo '<div class="text-center text-gray-400 text-3xl mt-20">Pas de plan pour cette map</div>';
            } elseif ($count === 1) {
                $src = htmlspecialchars($map . '/' . $images[0], ENT_QUOTES, 'UTF-8');

                echo '
                <div class="max-w-6xl mx-auto">
                    <img src="' . $src . '" alt="Plan de la map" class="w-full rounded-xl shadow-2xl object-contain max-h-[80vh] mx-auto">
                </div>';
            } elseif ($count === 2) {
                echo '<div class="grid grid-cols-1 md:grid-cols-2 gap-6 max-w-7xl mx-auto">';

                foreach ($images as $index => $img) {
                    $src = htmlspecialchars($map . '/' . $img, ENT_QUOTES, 'UTF-8');
                    echo '
                    <div class="bg-gray-800 p-2 rounded-xl shadow-lg">
                        <img src="' . $src . '" alt="Plan ' . ($index + 1) . '" class="w-full aspect-square object-cover rounded-lg">
                    </div>';
                }

                echo '</div>';
            } elseif ($count === 3) {
                $src1 = htmlspecialchars($map . '/' . $images[0], ENT_QUOTES, 'UTF-8');
                $src2 = htmlspecialchars($map . '/' . $images[1], ENT_QUOTES, 'UTF-8');
                $src3 = htmlspecialchars($map . '/' . $images[2], ENT_QUOTES, 'UTF-8');

                echo '
                <div class="max-w-7xl mx-auto space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="bg-gray-800 p-2 rounded-xl shadow-lg">
                            <img src="' . $src1 . '" alt="Plan 1" class="w-full aspect-square object-cover rounded-lg">
                        </div>
                        <div class="bg-gray-800 p-2 rounded-xl shadow-lg">
                            <img src="' . $src2 . '" alt="Plan 2" class="w-full aspect-square object-cover rounded-lg">
                        </div>
                    </div>

                    <div class="flex justify-center">
                        <div class="w-full md:w-1/2 bg-gray-800 p-2 rounded-xl shadow-lg">
                            <img src="' . $src3 . '" alt="Plan 3" class="w-full aspect-square object-cover rounded-lg">
                        </div>
                    </div>
                </div>';
            } else {
                echo '<div class="grid grid-cols-1 md:grid-cols-2 gap-6 max-w-7xl mx-auto">';

                for ($i = 0; $i < 4; $i++) {
                    $src = htmlspecialchars($map . '/' . $images[$i], ENT_QUOTES, 'UTF-8');
                    echo '
                    <div class="bg-gray-800 p-2 rounded-xl shadow-lg">
                        <img src="' . $src . '" alt="Plan ' . ($i + 1) . '" class="w-full aspect-square object-cover rounded-lg">
                    </div>';
                }

                echo '</div>';
            }
        }
        ?>
    </div>
</body>
</html>