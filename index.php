<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8"/>
  <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
  <title>
   Tactical Report Point - Home
  </title>
  <script src="https://cdn.tailwindcss.com">
  </script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&amp;display=swap" rel="stylesheet"/>
  <style>
   body {
            font-family: 'Roboto', sans-serif;
        }
  </style>
</head>
<body class="bg-gray-900 text-gray-100">
    <div class="container mx-auto p-4">
        <div class="text-center mb-8" id="title">
            <h1 class="text-5xl font-bold text-yellow-400">Tactical Report Point</h1>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6" id="content">
            <?php 
            $dir = './';
            $items = array_diff(scandir($dir), ['.', '..']); // Exclure "." et ".."

            // Filtrer uniquement les dossiers et réindexer les clés
            $folders = array_values(array_filter($items, function ($item) use ($dir) {
                return is_dir("$dir/$item");
            }));

            $fnumbgame = count($folders);

            $GameCount = 0;

            $lineNumb = intdiv($fnumbgame, 4);
            if (fmod($fnumbgame, 4) != 0) {
                $lineNumb += 1;
            }

            for ($i = 0; $i < $lineNumb; $i++) {
                for ($j = 0; $j < 4; $j++) {
                    if ($GameCount < $fnumbgame) {
                        $folderName = htmlspecialchars($folders[$GameCount]); // Éviter les failles XSS
                        $thumbnailPath = "./$folderName.jpg"; // Modifier selon le bon chemin

                        echo "<button class=\"relative rounded-lg overflow-hidden shadow-lg transform hover:scale-105 transition-transform duration-300\" onclick=\"window.location.href='./$folderName'\">";
                        echo "<img alt=\"$folderName-map-thumbnail\" class=\"w-full h-full object-cover\" src=\"$thumbnailPath\">";
                        echo "<span class=\"absolute bottom-0 left-0 bg-black bg-opacity-70 text-white p-2 w-full text-center\">$folderName</span>";
                        echo "</button>";

                        $GameCount++;
                    }
                }
            }
            ?>

        </div>
</body>
</html>