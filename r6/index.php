<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Tactical Report Point - Rainbow Six Siege</title>
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
        <div class="text-center mb-10">
            <h1 class="text-5xl font-bold text-yellow-400">Tactical Report Point</h1>
            <h2 class="text-3xl text-gray-400">Rainbow Six Siege</h2>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            <?php
	     function formatMapNameIndex($name) {
    	      // Remplace _D_ par D'
    	      $name = str_replace('_D_', " D'", $name);

    	      // Remplace les underscores restants par des espaces
    	      $name = str_replace('_', ' ', $name);

    	      // Optionnel : majuscule première lettre
    	      return ucfirst($name);
	     }

            $root = __DIR__;
            $items = scandir($root);
            $maps = [];

            foreach ($items as $item) {
                if ($item === '.' || $item === '..') {
                    continue;
                }

                $fullPath = $root . DIRECTORY_SEPARATOR . $item;

                if (is_dir($fullPath)) {
                    $mapName = $item;
                    $thumb = null;

                    // Thumb à la racine, extensions image possibles
                    foreach (glob($root . DIRECTORY_SEPARATOR . $mapName . '.*') as $candidate) {
                        if (is_file($candidate) && preg_match('/\.(jpg|jpeg|png|webp|gif)$/i', $candidate)) {
                            $thumb = basename($candidate);
                            break;
                        }
                    }

                    $maps[] = [
                        'name' => $mapName,
                        'thumb' => $thumb
                    ];
                }
            }

            usort($maps, function ($a, $b) {
                return strcasecmp($a['name'], $b['name']);
            });

            if (empty($maps)) {
                echo '<p class="col-span-full text-center text-gray-400 text-xl">Aucune map trouvée.</p>';
            } else {
                foreach ($maps as $map) {
                    $safeName = htmlspecialchars($map['name'], ENT_QUOTES, 'UTF-8');
                    $displayName = htmlspecialchars(formatMapNameIndex($map['name']), ENT_QUOTES, 'UTF-8');
                    $mapUrl = 'map.php?map=' . urlencode($map['name']);

                    echo '<a href="' . $mapUrl . '" class="relative rounded-lg overflow-hidden shadow-lg transform hover:scale-105 transition-transform duration-300 bg-gray-800 block">';

                    if ($map['thumb']) {
                        $thumbSrc = htmlspecialchars($map['thumb'], ENT_QUOTES, 'UTF-8');
                        echo '<img src="' . $thumbSrc . '" alt="' . $safeName . '-thumbnail" class="w-full h-64 object-cover">';
                    } else {
                        echo '<div class="w-full h-64 bg-gray-700 flex items-center justify-center text-gray-300 text-lg">Aucun thumb</div>';
                    }

                    echo '<span class="absolute bottom-0 left-0 bg-black bg-opacity-70 text-white p-3 w-full text-center text-lg font-bold">'
                        . $displayName .
                        '</span>';

                    echo '</a>';
                }
            }
            ?>
        </div>
    </div>
</body>
</html>
