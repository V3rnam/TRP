<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8"/>
  <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
  <title>
   Tactical Report Point - MW
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
            <h2 class="text-3xl text-gray-400">Call Of Duty : Modern Warfare</h2>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6" id="content">
            <?php 
            $dirmap = './';
            $mapList = opendir($dirmap);
            $fnumbmap=0;
            $regTRPimg = '/^([[:print:]]+)(\_TRP\.[[:alpha:]]{3})/m';
            $regTRPthumb = '/^([[:alpha:]]+(\-[[:alpha:]]+)*)(\.[[:alpha:]]{3})/m';
            while ( false !== ($imgList = readdir($mapList))) {
                if(preg_match_all($regTRPimg, $imgList, $mapTRPmatches, PREG_SET_ORDER, 0)){
                    $TRPimg[] = $imgList;
                    $fnumbmap++;
                }
                else if(preg_match_all($regTRPthumb, $imgList, $mapTRPmatches, PREG_SET_ORDER, 0)){
                    $TRPthumb[] = $imgList;
                }
                
            }
            sort($TRPimg);
            sort($TRPthumb);
            
            $MapCount = 0;
            $lineNumb = intdiv ($fnumbmap,4);
            if (fmod($fnumbmap,4)!=0) {
                $lineNumb +=1;
            }
            for ($i=0; $i<$lineNumb; $i++) {
                for ($j=0; $j<4; $j++) {
                    if ($MapCount<$fnumbmap){
                        
                        echo "<button class=\"mapBt relative rounded-lg overflow-hidden shadow-lg transform hover:scale-105 transition-transform duration-300\" onclick=\"window.location.href='./".$TRPimg[$MapCount]."'\">";
                        echo "<img alt=\"".substr($TRPthumb[$MapCount], 0, -4)."-map-thumbnail\" class=\"w-full h-full object-cover\" src=.\\".$TRPthumb[$MapCount].">";
                        echo "<span class=\"absolute bottom-0 left-0 bg-black bg-opacity-70 text-white p-2 w-full text-center\">".substr($TRPthumb[$MapCount], 0, -4)."</span></button>";
                        $MapCount += 1;
                    }
                }
            }
            ?>

        </div>
</body>
</html>